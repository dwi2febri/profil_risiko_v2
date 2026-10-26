
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
$s_kor = $frame['status_korwil'];
$s_mr = $frame['status_skmr'];

if ($s_kor ==1) {
    $status_korwil = 'V';
} else{
    $status_korwil = 'X';
}
if ($s_mr ==1) {
    $status_mr = 'V';
} else{
    $status_mr = 'X';
}

$kancab = $frame['kantor_cabang'];
$kacab = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE lokasi_kerja = '$kancab'"));



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

$trs = $inheren1['hasil_peringkat'];
$matrik_ojk_kre = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM matrik_ojk_kredit WHERE tingkat_risiko = '$trs'"));

$trs2 = $inheren2['hasil_peringkat'];
$matrik_ojk_kre2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM matrik_ojk_operasional WHERE tingkat_risiko = '$trs2'"));

$trs3 = $inheren3['hasil_peringkat'];
$matrik_ojk_kre3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM matrik_ojk_kepatuhan WHERE tingkat_risiko = '$trs3'"));

$trs4 = $inheren4['hasil_peringkat'];
$matrik_ojk_kre4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM matrik_ojk_likuiditas WHERE tingkat_risiko = '$trs4'"));

$trs5 = $inheren5['hasil_peringkat'];
$matrik_ojk_kre5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM matrik_ojk_reputasi WHERE tingkat_risiko = '$trs5'"));

$trs6 = $inheren6['hasil_peringkat'];
$matrik_ojk_kre6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM matrik_ojk_stratejik WHERE tingkat_risiko = '$trs6'"));




$terbesar_pilar_kre = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pil1_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil1_tingkat_risiko'
    WHEN pil2_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil2_tingkat_risiko'
    WHEN pil3_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil3_tingkat_risiko'
    WHEN pil4_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil4_tingkat_risiko'
    WHEN pil5_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil5_tingkat_risiko'
END AS val
FROM hasil_inheren_kredit
WHERE id_profil_risiko = '$id'"));

$que_pilar_kre = $terbesar_pilar_kre['val'];

$terbesar_nilai_pilar_kre = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) AS nilai_tertinggi_pilar
FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));


$terbesar_pilar_kre1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par1'
    WHEN hasil_pil1_par2 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par2'
    WHEN hasil_pil1_par3 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par3'
    WHEN hasil_pil1_par4 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par4'
    
END AS val
FROM inheren_kredit_pilar1
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kre1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) AS nilai_tertinggi_pilar1
FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));

$que_pilar_kre1 = $terbesar_pilar_kre1['val'];

$terbesar_pilar_kre2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil2_par1 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par1'
    WHEN hasil_pil2_par2 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par2'
    WHEN hasil_pil2_par3 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par3'
    
END AS val
FROM inheren_kredit_pilar2
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kre2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) AS nilai_tertinggi_pilar2
FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));

$que_pilar_kre2 = $terbesar_pilar_kre2['val'];


$terbesar_pilar_kre3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil3_par1a = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1a'
    WHEN hasil_pil3_par1b = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1b'
    WHEN hasil_pil3_par1c = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1c'
    WHEN hasil_pil3_par1d = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1d'
    WHEN hasil_pil3_par1e = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1e'
    
END AS val
FROM inheren_kredit_pilar3
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kre3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) AS nilai_tertinggi_pilar3
FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$id'"));

$que_pilar_kre3 = $terbesar_pilar_kre3['val'];

$terbesar_pilar_kre4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil4_par1a = greatest(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) THEN 'hasil_pil4_par1a'
    WHEN hasil_pil4_par1b = greatest(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) THEN 'hasil_pil4_par1b'
    WHEN hasil_pil4_par1c = greatest(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) THEN 'hasil_pil4_par1c'
    WHEN hasil_pil4_par1d = greatest(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) THEN 'hasil_pil4_par1d'
END AS val
FROM inheren_kredit_pilar4
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kre4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) AS nilai_tertinggi_pilar4
FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$id'"));


$que_pilar_kre4 = $terbesar_pilar_kre4['val'];

$terbesar_pilar_kre5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil5_par1a = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1a'
    WHEN hasil_pil5_par1b = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1b'
    WHEN hasil_pil5_par1c = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1c'
    WHEN hasil_pil5_par1d = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1d'
    WHEN hasil_pil5_par1e = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1e'
    WHEN hasil_pil5_par1f = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1f'
    WHEN hasil_pil5_par1g = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1g'
    WHEN hasil_pil5_par1h = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1h'
    WHEN hasil_pil5_par1i = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1i'
    WHEN hasil_pil5_par1j = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1j'
    WHEN hasil_pil5_par1k = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1k'
    
END AS val
FROM inheren_kredit_lainnya
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kre5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) AS nilai_tertinggi_pilar5
FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$id'"));

$que_pilar_kre5 = $terbesar_pilar_kre5['val'];

//hasil bolo



$hasil_a_pilar_kre = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre'"));

$hasil_par_pilar_kre1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre1'"));

$hasil_par_pilar_kre2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre2'"));

$hasil_par_pilar_kre3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre3'"));

$hasil_par_pilar_kre4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre4'"));

$hasil_par_pilar_kre5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre5'"));

$que_pilar_kre1_sub = $hasil_par_pilar_kre1['kode_pil'];
$que_pilar_kre2_sub = $hasil_par_pilar_kre2['kode_pil'];



if ($que_pilar_kre1_sub == 1) {
$terbesar_pilar_kre1_sub1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1a = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1a'
    WHEN hasil_pil1_par1b = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1b'
    WHEN hasil_pil1_par1c = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1c'
    WHEN hasil_pil1_par1d = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1d'
    WHEN hasil_pil1_par1e = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1e'
    WHEN hasil_pil1_par1f = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1f'
    WHEN hasil_pil1_par1g = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1g'
    WHEN hasil_pil1_par1h = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1h'
END AS val
FROM inheren_kredit_pilar1
WHERE id_profil_risiko = '$id'"));
$que_pilar_kre1_sub1 = $terbesar_pilar_kre1_sub1['val'];

$terbesar_nilai_pilar_kre1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1a,hasil_pil1_par1b,hasil_pil1_par1c,hasil_pil1_par1d,hasil_pil1_par1e,hasil_pil1_par1f,hasil_pil1_par1g,hasil_pil1_par1h) AS nilai_tertinggi_pilar1_sub
FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_kre1 = $terbesar_nilai_pilar_kre1_sub['nilai_tertinggi_pilar1_sub'];

$query_subpar_pilar_kre1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre1_sub1'"));
$hasil_subpar_pilar_kre1 = $query_subpar_pilar_kre1['parameter'];
}
else if ($que_pilar_kre1_sub == 2) {
    $terbesar_pilar_kre1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN hasil_pil1_par2a = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2a'
    WHEN hasil_pil1_par2b = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2b'
    WHEN hasil_pil1_par2c = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2c'
    WHEN hasil_pil1_par2d = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2d'
    WHEN hasil_pil1_par2e = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2e'
    WHEN hasil_pil1_par2f = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2f'
    WHEN hasil_pil1_par2g = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2g'
    WHEN hasil_pil1_par2h = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2h'
    WHEN hasil_pil1_par2i = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2i'
    WHEN hasil_pil1_par2j = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2j'
    WHEN hasil_pil1_par2k = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2k'
    END AS val
    FROM inheren_kredit_pilar1
    WHERE id_profil_risiko = '$id'"));
    
    
$que_pilar_kre1_sub1 = $terbesar_pilar_kre1_sub2['val'];

$terbesar_nilai_pilar_kre1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par2a,hasil_pil1_par2b,hasil_pil1_par2c,hasil_pil1_par2d,hasil_pil1_par2e,hasil_pil1_par2f,hasil_pil1_par2g,hasil_pil1_par2h,hasil_pil1_par2i,hasil_pil1_par2j,hasil_pil1_par2k) AS nilai_tertinggi_pilar1_sub
FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_kre1 = $terbesar_nilai_pilar_kre1_sub['nilai_tertinggi_pilar1_sub'];

$query_subpar_pilar_kre1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre1_sub1'"));
$hasil_subpar_pilar_kre1 = $query_subpar_pilar_kre1['parameter'];
}
else if ($que_pilar_kre1_sub == 3) {
    
    $hasil_subpar_pilar_kre1 = '-';
    $maxsub_kre1 = ' 0';
}
else if ($que_pilar_kre1_sub == 4) {
    
    $hasil_subpar_pilar_kre1 = '-';
    $maxsub_kre1 = ' 0';
}
else {
    $hasil_subpar_pilar_kre11 = '-';
    $maxsub_kre1 = ' 0';
}


if ($que_pilar_kre2_sub == 5) {
    $hasil_subpar_pilar_kre2 = '-';
    $maxsub_kre2 = ' 0';
}
else if ($que_pilar_kre2_sub == 6) {
    $terbesar_pilar_kre2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN hasil_pil2_par2a = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2a'
    WHEN hasil_pil2_par2b = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2b'
    WHEN hasil_pil2_par2c = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2c'
    WHEN hasil_pil2_par2d = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2d'
    WHEN hasil_pil2_par2e = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2e'
    WHEN hasil_pil2_par2f = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2f'
    END AS val
    FROM inheren_kredit_pilar2
    WHERE id_profil_risiko = '$id'"));
    
    
$que_pilar_kre2_sub1 = $terbesar_pilar_kre2_sub2['val'];

$terbesar_nilai_pilar_kre2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par2a,hasil_pil2_par2b,hasil_pil2_par2c,hasil_pil2_par2d,hasil_pil2_par2e,hasil_pil2_par2f,hasil_pil2_par2g,hasil_pil2_par2h,hasil_pil2_par2i,hasil_pil2_par2j,hasil_pil2_par2k) AS nilai_tertinggi_pilar2_sub
FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_kre2 = $terbesar_nilai_pilar_kre2_sub['nilai_tertinggi_pilar2_sub'];


$query_subpar_pilar_kre2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre2_sub1'"));
$hasil_subpar_pilar_kre2 = $query_subpar_pilar_kre2['parameter'];
}
else if ($que_pilar_kre2_sub == 7) {
    $terbesar_pilar_kre2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN hasil_pil2_par3a = greatest(hasil_pil2_par3a, hasil_pil2_par3b, hasil_pil2_par3c, hasil_pil2_par3d) THEN 'hasil_pil2_par3a'
    WHEN hasil_pil2_par3b = greatest(hasil_pil2_par3a, hasil_pil2_par3b, hasil_pil2_par3c, hasil_pil2_par3d) THEN 'hasil_pil2_par3b'
    WHEN hasil_pil2_par3c = greatest(hasil_pil2_par3a, hasil_pil2_par3b, hasil_pil2_par3c, hasil_pil2_par3d) THEN 'hasil_pil2_par3c'
    WHEN hasil_pil2_par3d = greatest(hasil_pil2_par3a, hasil_pil2_par3b, hasil_pil2_par3c, hasil_pil2_par3d) THEN 'hasil_pil2_par3d'
   
    END AS val
    FROM inheren_kredit_pilar2
    WHERE id_profil_risiko = '$id'"));
    
    $terbesar_nilai_pilar_kre2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    GREATEST(hasil_pil2_par3a,hasil_pil2_par3b,hasil_pil2_par3c,hasil_pil2_par3d) AS nilai_tertinggi_pilar2_sub
    FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
    $maxsub_kre2 = $terbesar_nilai_pilar_kre2_sub['nilai_tertinggi_pilar2_sub'];

    
$que_pilar_kre2_sub1 = $terbesar_pilar_kre2_sub2['val'];

$query_subpar_pilar_kre2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kredit
WHERE kode_parameter = '$que_pilar_kre2_sub1'"));
$hasil_subpar_pilar_kre2 = $query_subpar_pilar_kre2['parameter'];
}
else {
    $hasil_subpar_pilar_kre2 = '-';
    $maxsub_kre2 = ' 0';
}



//OPERASIONAL
$terbesar_pilar_ops = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pil1_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko, pil6_tingkat_risiko) THEN 'pil1_tingkat_risiko'
    WHEN pil2_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko, pil6_tingkat_risiko) THEN 'pil2_tingkat_risiko'
    WHEN pil3_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko, pil6_tingkat_risiko) THEN 'pil3_tingkat_risiko'
    WHEN pil4_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko, pil6_tingkat_risiko) THEN 'pil4_tingkat_risiko'
    WHEN pil5_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko, pil6_tingkat_risiko) THEN 'pil5_tingkat_risiko'
    WHEN pil6_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko, pil6_tingkat_risiko) THEN 'pil6_tingkat_risiko'
END AS val
FROM hasil_inheren_operasional
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_ops = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko, pil6_tingkat_risiko) AS nilai_tertinggi_pilar
FROM hasil_inheren_operasional WHERE id_profil_risiko = '$id'"));


$que_pilar_ops = $terbesar_pilar_ops['val'];


$terbesar_pilar_ops1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par1'
    WHEN hasil_pil1_par2 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par2'
    WHEN hasil_pil1_par3 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par3'
    WHEN hasil_pil1_par4 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par4'
    
END AS val
FROM inheren_operasional_pilar1
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_ops1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) AS nilai_tertinggi_pilar1
FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));



$que_pilar_ops1 = $terbesar_pilar_ops1['val'];

$terbesar_pilar_ops2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil2_par1 = greatest(hasil_pil2_par1, hasil_pil2_par2) THEN 'hasil_pil2_par1'
    WHEN hasil_pil2_par2 = greatest(hasil_pil2_par1, hasil_pil2_par2) THEN 'hasil_pil2_par2'
    END AS val
FROM inheren_operasional_pilar2
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_ops2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1, hasil_pil2_par2) AS nilai_tertinggi_pilar2
FROM inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));


$que_pilar_ops2 = $terbesar_pilar_ops2['val'];


$terbesar_pilar_ops3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar4_1 = greatest(pilar4_1, pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1'
    WHEN pilar4_1a = greatest(pilar4_1, pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1a'
    WHEN pilar4_1b = greatest(pilar4_1, pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1b'
    WHEN pilar4_1c = greatest(pilar4_1, pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1c'
    WHEN pilar4_1d = greatest(pilar4_1, pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1d'
    
END AS val
FROM inheren_operasional_pilar4
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_ops3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST( pilar4_1,  pilar4_1a,  pilar4_1b,  pilar4_1c,  pilar4_1d) AS nilai_tertinggi_pilar3
FROM inheren_operasional_pilar4 WHERE id_profil_risiko = '$id'"));



$que_pilar_ops3 = $terbesar_pilar_ops3['val'];

$terbesar_pilar_ops4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar5_1 = greatest(pilar5_1, pilar5_1a, pilar5_1b, pilar5_1c, pilar5_1d, pilar5_1e, pilar5_1f) THEN 'pilar5_1'
    WHEN pilar5_1a = greatest(pilar5_1, pilar5_1a, pilar5_1b, pilar5_1c, pilar5_1d, pilar5_1e, pilar5_1f) THEN 'pilar5_1a'
    WHEN pilar5_1b = greatest(pilar5_1, pilar5_1a, pilar5_1b, pilar5_1c, pilar5_1d, pilar5_1e, pilar5_1f) THEN 'pilar5_1b'
    WHEN pilar5_1c = greatest(pilar5_1, pilar5_1a, pilar5_1b, pilar5_1c, pilar5_1d, pilar5_1e, pilar5_1f) THEN 'pilar5_1c'
    WHEN pilar5_1d = greatest(pilar5_1, pilar5_1a, pilar5_1b, pilar5_1c, pilar5_1d, pilar5_1e, pilar5_1f) THEN 'pilar5_1d'
    WHEN pilar5_1e = greatest(pilar5_1, pilar5_1a, pilar5_1b, pilar5_1c, pilar5_1d, pilar5_1e, pilar5_1f) THEN 'pilar5_1e'
    WHEN pilar5_1f = greatest(pilar5_1, pilar5_1a, pilar5_1b, pilar5_1c, pilar5_1d, pilar5_1e, pilar5_1f) THEN 'pilar5_1f'
END AS val
FROM inheren_operasional_pilar5
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_ops4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST( pilar5_1,  pilar5_1a,  pilar5_1b,  pilar5_1c,  pilar5_1d, pilar5_1e, pilar5_1f) AS nilai_tertinggi_pilar4
FROM inheren_operasional_pilar5 WHERE id_profil_risiko = '$id'"));


$que_pilar_ops4 = $terbesar_pilar_ops4['val'];

$terbesar_pilar_ops5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar6_1a = greatest(pilar6_1a, pilar6_1b, pilar6_1c, pilar6_1d, pilar6_1e, pilar6_1f) THEN 'pilar6_1a'
    WHEN pilar6_1b = greatest(pilar6_1a, pilar6_1b, pilar6_1c, pilar6_1d, pilar6_1e, pilar6_1f) THEN 'pilar6_1b'
    WHEN pilar6_1c = greatest(pilar6_1a, pilar6_1b, pilar6_1c, pilar6_1d, pilar6_1e, pilar6_1f) THEN 'pilar6_1c'
    WHEN pilar6_1d = greatest(pilar6_1a, pilar6_1b, pilar6_1c, pilar6_1d, pilar6_1e, pilar6_1f) THEN 'pilar6_1d'
    WHEN pilar6_1e = greatest(pilar6_1a, pilar6_1b, pilar6_1c, pilar6_1d, pilar6_1e, pilar6_1f) THEN 'pilar6_1e'
    WHEN pilar6_1f = greatest(pilar6_1a, pilar6_1b, pilar6_1c, pilar6_1d, pilar6_1e, pilar6_1f) THEN 'pilar6_1f'

END AS val
FROM inheren_operasional_lainnya
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_ops5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar6_1a,  pilar6_1b,  pilar6_1c,  pilar6_1d, pilar6_1e, pilar6_1f) AS nilai_tertinggi_pilar5
FROM inheren_operasional_lainnya WHERE id_profil_risiko = '$id'"));

$que_pilar_ops5 = $terbesar_pilar_ops5['val'];

//hasil bolo



$hasil_a_pilar_ops = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops'"));

$hasil_par_pilar_ops1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops1'"));

$hasil_par_pilar_ops2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops2'"));

$hasil_par_pilar_ops3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops3'"));

$hasil_par_pilar_ops4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops4'"));

$hasil_par_pilar_ops5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops5'"));

$que_pilar_ops1_sub = $hasil_par_pilar_ops1['kode_pil'];
$que_pilar_ops2_sub = $hasil_par_pilar_ops2['kode_pil'];



if ($que_pilar_ops1_sub == 1) {
    $hasil_subpar_pilar_ops1 = '-';
    $maxsub_ops1 = ' 0';
}
else if ($que_pilar_ops1_sub == 2) {
    $terbesar_pilar_ops1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_2 = greatest(pilar1_2, pilar1_2a, pilar1_2b) THEN 'pilar1_2'
    WHEN pilar1_2a = greatest(pilar1_2, pilar1_2a, pilar1_2b) THEN 'pilar1_2a'
    WHEN pilar1_2b = greatest(pilar1_2, pilar1_2a, pilar1_2b) THEN 'pilar1_2b'
    END AS val
    FROM inheren_operasional_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_ops1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_2,  pilar1_2a,  pilar1_2b) AS nilai_tertinggi_pilar1_sub
FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_ops1 = $terbesar_nilai_pilar_ops1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_ops1_sub1 = $terbesar_pilar_ops1_sub2['val'];

$query_subpar_pilar_ops1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops1_sub1'"));
$hasil_subpar_pilar_ops1 = $query_subpar_pilar_ops1['parameter'];
}

else if ($que_pilar_ops1_sub == 3) {
    $terbesar_pilar_ops1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_3 = greatest(pilar1_3, pilar1_3a, pilar1_3b) THEN 'pilar1_3'
    WHEN pilar1_3a = greatest(pilar1_3, pilar1_3a, pilar1_3b) THEN 'pilar1_3a'
    WHEN pilar1_3b = greatest(pilar1_3, pilar1_3a, pilar1_3b) THEN 'pilar1_3b'
    END AS val
    FROM inheren_operasional_pilar1
    WHERE id_profil_risiko = '$id'"));

$que_pilar_ops1_sub1 = $terbesar_pilar_ops1_sub2['val'];

$terbesar_nilai_pilar_ops1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_3,  pilar1_3a,  pilar1_3b) AS nilai_tertinggi_pilar1_sub
FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_ops1 = $terbesar_nilai_pilar_ops1_sub['nilai_tertinggi_pilar1_sub'];

$query_subpar_pilar_ops1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops1_sub1'"));
$hasil_subpar_pilar_ops1 = $query_subpar_pilar_ops1['parameter'];
}
else if ($que_pilar_ops1_sub == 4) {
    $terbesar_pilar_ops1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_4 = greatest(pilar1_4, pilar1_4a) THEN 'pilar1_4'
    WHEN pilar1_4a = greatest(pilar1_4, pilar1_4a) THEN 'pilar1_4a'
    
    END AS val
    FROM inheren_operasional_pilar1
    WHERE id_profil_risiko = '$id'"));


$terbesar_nilai_pilar_ops1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_4,  pilar1_4a) AS nilai_tertinggi_pilar1_sub
FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_ops1 = $terbesar_nilai_pilar_ops1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_ops1_sub1 = $terbesar_pilar_ops1_sub2['val'];

$query_subpar_pilar_ops1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops1_sub1'"));
$hasil_subpar_pilar_ops1 = $query_subpar_pilar_ops1['parameter'];
}
else {
    $hasil_subpar_pilar_ops11 = '-';
    $maxsub_ops1 = ' 0';
}


if ($que_pilar_ops2_sub == 5) {
    $terbesar_pilar_ops2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE
    WHEN pilar2_1 = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1' 
    WHEN pilar2_1a = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1a'
    WHEN pilar2_1b = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1b'
    WHEN pilar2_1c = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1c'
    WHEN pilar2_1d = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1d'
    WHEN pilar2_1e = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1e'
    WHEN pilar2_1f = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1f'
    WHEN pilar2_1g = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1g'
    WHEN pilar2_1h = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1h'
    WHEN pilar2_1i = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1i'
    WHEN pilar2_1j = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1j'
    WHEN pilar2_1k = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1k'
    WHEN pilar2_1l = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1l'
    WHEN pilar2_1m = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1m'
    WHEN pilar2_1n = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) THEN 'pilar2_1n'
    
    END AS val
    FROM inheren_operasional_pilar2
    WHERE id_profil_risiko = '$id'"));
    
$terbesar_nilai_pilar_ops2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i, pilar2_1j, pilar2_1k, pilar2_1l, pilar2_1m, pilar2_1n) AS nilai_tertinggi_pilar2_sub
FROM inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_ops2 = $terbesar_nilai_pilar_ops2_sub['nilai_tertinggi_pilar2_sub'];
    
$que_pilar_ops2_sub1 = $terbesar_pilar_ops2_sub2['val'];

$query_subpar_pilar_ops2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_operasional
WHERE kode_parameter = '$que_pilar_ops2_sub1'"));
$hasil_subpar_pilar_ops2 = $query_subpar_pilar_ops2['parameter'];
}
else if ($que_pilar_ops2_sub == 6) {
    $hasil_subpar_pilar_ops2 = '-';
    $maxsub_ops2 = ' 0';
}
else if ($que_pilar_ops2_sub == 7) {
    $hasil_subpar_pilar_ops2 = '-';
    $maxsub_ops2 = ' 0';
}
else if ($que_pilar_ops2_sub == 8) {
    $hasil_subpar_pilar_ops2 = '-';
    $maxsub_ops2 = ' 0';
}
else if ($que_pilar_ops2_sub == 9) {
    $hasil_subpar_pilar_ops2 = '-';
    $maxsub_ops2 = ' 0';
}
else {
    $hasil_subpar_pilar_ops2 = '-';
    $maxsub_ops2 = ' 0';
}




//KEPATUHAN


$terbesar_pilar_kep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pil1_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil1_tingkat_risiko'
    WHEN pil2_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil2_tingkat_risiko'
    WHEN pil3_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil3_tingkat_risiko'
END AS val
FROM hasil_inheren_kepatuhan
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) AS nilai_tertinggi_pilar
FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$id'"));


$que_pilar_kep = $terbesar_pilar_kep['val'];


$terbesar_pilar_kep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1 = greatest(hasil_pil1_par1, hasil_pil1_par2) THEN 'hasil_pil1_par1'
    WHEN hasil_pil1_par2 = greatest(hasil_pil1_par1, hasil_pil1_par2) THEN 'hasil_pil1_par2'
END AS val
FROM inheren_kepatuhan_pilar1
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1, hasil_pil1_par2) AS nilai_tertinggi_pilar1
FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));



$que_pilar_kep1 = $terbesar_pilar_kep1['val'];

$terbesar_pilar_kep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil2_par1 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par1'
    WHEN hasil_pil2_par2 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par2'
    WHEN hasil_pil2_par3 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par3'
    END AS val
FROM inheren_kepatuhan_pilar2
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) AS nilai_tertinggi_pilar2
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));


$que_pilar_kep2 = $terbesar_pilar_kep2['val'];


$terbesar_pilar_kep5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar3_1a = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1a'
    WHEN pilar3_1b = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1b'
    WHEN pilar3_1c = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1c'
    WHEN pilar3_1d = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1d'
    WHEN pilar3_1e = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1e'
    WHEN pilar3_1f = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1f'
    WHEN pilar3_1g = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1g'

END AS val
FROM inheren_kepatuhan_lainnya
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kep5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar3_1a,  pilar3_1b,  pilar3_1c,  pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) AS nilai_tertinggi_pilar5
FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = '$id'"));

$que_pilar_kep5 = $terbesar_pilar_kep5['val'];

//hasil bolo



$hasil_a_pilar_kep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep'"));

$hasil_par_pilar_kep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep1'"));

$hasil_par_pilar_kep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep2'"));

$hasil_par_pilar_kep5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep5'"));

$que_pilar_kep1_sub = $hasil_par_pilar_kep1['kode_pil'];
$que_pilar_kep2_sub = $hasil_par_pilar_kep2['kode_pil'];



if ($que_pilar_kep1_sub == 1) {
    $terbesar_pilar_kep1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_1 = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1' 
    WHEN pilar1_1a = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1a'
    WHEN pilar1_1b = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1b'
    WHEN pilar1_1c = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1c'
    WHEN pilar1_1d = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1d'
    WHEN pilar1_1e = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1e'
    WHEN pilar1_1f = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1f'
    WHEN pilar1_1g = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1g'

    END AS val
    FROM inheren_kepatuhan_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kep1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) AS nilai_tertinggi_pilar1_sub
FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_kep1 = $terbesar_nilai_pilar_kep1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_kep1_sub1 = $terbesar_pilar_kep1_sub2['val'];

$query_subpar_pilar_kep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep1_sub1'"));
$hasil_subpar_pilar_kep1 = $query_subpar_pilar_kep1['parameter'];
}
else if ($que_pilar_kep1_sub == 2) {
    $terbesar_pilar_kep1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_2 = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2' 
    WHEN pilar1_2a = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2a'
    WHEN pilar1_2b = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2b'
    WHEN pilar1_2c = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2c'
    WHEN pilar1_2d = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2d'
    WHEN pilar1_2e = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2e'
    WHEN pilar1_2f = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2f'
    WHEN pilar1_2g = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2g'
    WHEN pilar1_2h = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2h'
    
    END AS val
    FROM inheren_kepatuhan_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_kep1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_2,  pilar1_2a,  pilar1_2b) AS nilai_tertinggi_pilar1_sub
FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_kep1 = $terbesar_nilai_pilar_kep1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_kep1_sub1 = $terbesar_pilar_kep1_sub2['val'];

$query_subpar_pilar_kep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep1_sub1'"));
$hasil_subpar_pilar_kep1 = $query_subpar_pilar_kep1['parameter'];
}
else {
    $hasil_subpar_pilar_kep11 = '-';
    $maxsub_kep1 = ' 0';
}


if ($que_pilar_kep2_sub == 3) {
    $terbesar_pilar_kep2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar2_1 = greatest(pilar2_1, pilar2_1a) THEN 'pilar2_1'
    WHEN pilar2_1a = greatest(pilar2_1, pilar2_1a) THEN 'pilar2_1a'
    END AS val
    FROM inheren_kepatuhan_pilar2
    WHERE id_profil_risiko = '$id'"));

$que_pilar_kep2_sub1 = $terbesar_pilar_kep2_sub2['val'];

$terbesar_nilai_pilar_kep2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_1,  pilar2_1a) AS nilai_tertinggi_pilar2_sub
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_kep2 = $terbesar_nilai_pilar_kep2_sub['nilai_tertinggi_pilar2_sub'];

$query_subpar_pilar_kep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep2_sub1'"));
$hasil_subpar_pilar_kep2 = $query_subpar_pilar_kep2['parameter'];
}
else if ($que_pilar_kep1_sub == 4) {
    $terbesar_pilar_kep1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar2_2 = greatest(pilar2_2, pilar2_2a) THEN 'pilar2_2'
    WHEN pilar2_2a = greatest(pilar2_2, pilar2_2a) THEN 'pilar2_2a'
    
    END AS val
    FROM inheren_kepatuhan_pilar2
    WHERE id_profil_risiko = '$id'"));


$terbesar_nilai_pilar_kep1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_2,  pilar2_2a) AS nilai_tertinggi_pilar2_sub
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_kep2 = $terbesar_nilai_pilar_kep2_sub['nilai_tertinggi_pilar2_sub'];

$que_pilar_kep2_sub1 = $terbesar_pilar_kep2_sub2['val'];

$query_subpar_pilar_kep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep2_sub1'"));
$hasil_subpar_pilar_kep2 = $query_subpar_pilar_kep2['parameter'];
}
else if ($que_pilar_kep1_sub == 5) {
    $terbesar_pilar_kep1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar2_3 = greatest(pilar2_3, pilar2_3a) THEN 'pilar2_3'
    WHEN pilar2_3a = greatest(pilar2_3, pilar2_3a) THEN 'pilar2_3a'
    
    END AS val
    FROM inheren_kepatuhan_pilar2
    WHERE id_profil_risiko = '$id'"));


$terbesar_nilai_pilar_kep1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_3,  pilar2_3a) AS nilai_tertinggi_pilar2_sub
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_kep2 = $terbesar_nilai_pilar_kep2_sub['nilai_tertinggi_pilar2_sub'];

$que_pilar_kep2_sub1 = $terbesar_pilar_kep2_sub2['val'];

$query_subpar_pilar_kep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar_kep2_sub1'"));
$hasil_subpar_pilar_kep2 = $query_subpar_pilar_kep2['parameter'];
}
else {
    $hasil_subpar_pilar_kep2 = '-';
    $maxsub_kep2 = ' 0';
}



//LIKUIDITAS 


$terbesar_pilar_lik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pil1_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil1_tingkat_risiko'
    WHEN pil2_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil2_tingkat_risiko'
    WHEN pil3_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil3_tingkat_risiko'
END AS val
FROM hasil_inheren_likuiditas
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_lik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) AS nilai_tertinggi_pilar
FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$id'"));


$que_pilar_lik = $terbesar_pilar_lik['val'];


$terbesar_pilar_lik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4, hasil_pil1_par5) THEN 'hasil_pil1_par1'
    WHEN hasil_pil1_par2 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4, hasil_pil1_par5) THEN 'hasil_pil1_par2'
    WHEN hasil_pil1_par3 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4, hasil_pil1_par5) THEN 'hasil_pil1_par3'
    WHEN hasil_pil1_par4 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4, hasil_pil1_par5) THEN 'hasil_pil1_par4'
    WHEN hasil_pil1_par5 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4, hasil_pil1_par5) THEN 'hasil_pil1_par5'
END AS val
FROM inheren_likuiditas_pilar1
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_lik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4, hasil_pil1_par5) AS nilai_tertinggi_pilar1
FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));



$que_pilar_lik1 = $terbesar_pilar_lik1['val'];

$terbesar_pilar_lik2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil2_par1 = greatest(hasil_pil2_par1, hasil_pil2_par2) THEN 'hasil_pil2_par1'
    WHEN hasil_pil2_par2 = greatest(hasil_pil2_par1, hasil_pil2_par2) THEN 'hasil_pil2_par2'
    
    END AS val
FROM inheren_likuiditas_pilar2
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_lik2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1, hasil_pil2_par2) AS nilai_tertinggi_pilar2
FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko = '$id'"));


$que_pilar_lik2 = $terbesar_pilar_lik2['val'];


$terbesar_pilar_lik5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil3_par1a = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e, hasil_pil3_par1f) THEN 'hasil_pil3_par1a'
    WHEN hasil_pil3_par1b = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e, hasil_pil3_par1f) THEN 'hasil_pil3_par1b'
    WHEN hasil_pil3_par1c = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e, hasil_pil3_par1f) THEN 'hasil_pil3_par1c'
    WHEN hasil_pil3_par1d = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e, hasil_pil3_par1f) THEN 'hasil_pil3_par1d'
    WHEN hasil_pil3_par1e = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e, hasil_pil3_par1f) THEN 'hasil_pil3_par1e'
    WHEN hasil_pil3_par1f = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e, hasil_pil3_par1f) THEN 'hasil_pil3_par1f'
   
END AS val
FROM inheren_likuiditas_lainnya
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_lik5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil3_par1a,  hasil_pil3_par1b,  hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e, hasil_pil3_par1f) AS nilai_tertinggi_pilar5
FROM inheren_likuiditas_lainnya WHERE id_profil_risiko = '$id'"));

$que_pilar_lik5 = $terbesar_pilar_lik5['val'];

//hasil bolo



$hasil_a_pilar_lik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik'"));

$hasil_par_pilar_lik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik1'"));

$hasil_par_pilar_lik2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik2'"));

$hasil_par_pilar_lik5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik5'"));

$que_pilar_lik1_sub = $hasil_par_pilar_lik1['kode_pil'];
$que_pilar_lik2_sub = $hasil_par_pilar_lik2['kode_pil'];



if ($que_pilar_lik1_sub == 1) {
    $terbesar_pilar_lik1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN hasil_pil1_par1a = greatest(hasil_pil1_par1a) THEN 'hasil_pil1_par1a'

    END AS val
    FROM inheren_likuiditas_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_lik1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1a) AS nilai_tertinggi_pilar1_sub
FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_lik1 = $terbesar_nilai_pilar_lik1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_lik1_sub1 = $terbesar_pilar_lik1_sub2['val'];

$query_subpar_pilar_lik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik1_sub1'"));
$hasil_subpar_pilar_lik1 = $query_subpar_pilar_lik1['parameter'];
}
else if ($que_pilar_lik1_sub == 2) {
    $terbesar_pilar_lik1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    
    WHEN hasil_pil1_par2a = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2a'
    WHEN hasil_pil1_par2b = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2b'
    WHEN hasil_pil1_par2c = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2c'
    WHEN hasil_pil1_par2d = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2d'
    WHEN hasil_pil1_par2e = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2e'
    WHEN hasil_pil1_par2f = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2f'
    WHEN hasil_pil1_par2g = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2g'
    WHEN hasil_pil1_par2h = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2h'
    WHEN hasil_pil1_par2i = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i) THEN 'hasil_pil1_par2i'
    
    END AS val
    FROM inheren_likuiditas_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_lik1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST( hasil_pil1_par2a,  hasil_pil1_par2b,  hasil_pil1_par2c,  hasil_pil1_par2d,  hasil_pil1_par2e,  hasil_pil1_par2f,  hasil_pil1_par2g,  hasil_pil1_par2h, hasil_pil1_par2i) AS nilai_tertinggi_pilar1_sub
FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_lik1 = $terbesar_nilai_pilar_lik1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_lik1_sub1 = $terbesar_pilar_lik1_sub2['val'];

$query_subpar_pilar_lik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik1_sub1'"));
$hasil_subpar_pilar_lik1 = $query_subpar_pilar_lik1['parameter'];
}
else if ($que_pilar_lik1_sub == 3){
    $terbesar_pilar_lik1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    
    WHEN hasil_pil1_par3a = greatest(hasil_pil1_par3a, hasil_pil1_par3b, hasil_pil1_par3c, hasil_pil1_par3d) THEN 'hasil_pil1_par3a'
    WHEN hasil_pil1_par3b = greatest(hasil_pil1_par3a, hasil_pil1_par3b, hasil_pil1_par3c, hasil_pil1_par3d) THEN 'hasil_pil1_par3b'
    WHEN hasil_pil1_par3c = greatest(hasil_pil1_par3a, hasil_pil1_par3b, hasil_pil1_par3c, hasil_pil1_par3d) THEN 'hasil_pil1_par3c'
    WHEN hasil_pil1_par3d = greatest(hasil_pil1_par3a, hasil_pil1_par3b, hasil_pil1_par3c, hasil_pil1_par3d) THEN 'hasil_pil1_par3d'
    
    
    END AS val
    FROM inheren_likuiditas_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_lik1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST( hasil_pil1_par3a,  hasil_pil1_par3b,  hasil_pil1_par3c,  hasil_pil1_par3d) AS nilai_tertinggi_pilar1_sub
FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_lik1 = $terbesar_nilai_pilar_lik1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_lik1_sub1 = $terbesar_pilar_lik1_sub2['val'];

$query_subpar_pilar_lik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik1_sub1'"));
$hasil_subpar_pilar_lik1 = $query_subpar_pilar_lik1['parameter'];
}
else if ($que_pilar_lik1_sub == 4){
    $hasil_subpar_pilar_lik1 = '-';
    $maxsub_lik1 = '0';
}
else if ($que_pilar_lik1_sub == 5){
    $terbesar_pilar_lik1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    
    WHEN hasil_pil1_par5a = greatest(hasil_pil1_par5a, hasil_pil1_par5b, hasil_pil1_par5c) THEN 'hasil_pil1_par5a'
    WHEN hasil_pil1_par5b = greatest(hasil_pil1_par5a, hasil_pil1_par5b, hasil_pil1_par5c) THEN 'hasil_pil1_par5b'
    WHEN hasil_pil1_par5c = greatest(hasil_pil1_par5a, hasil_pil1_par5b, hasil_pil1_par5c) THEN 'hasil_pil1_par5c'
    
    END AS val
    FROM inheren_likuiditas_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_lik1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST( hasil_pil1_par5a,  hasil_pil1_par5b,  hasil_pil1_par5c) AS nilai_tertinggi_pilar1_sub
FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_lik1 = $terbesar_nilai_pilar_lik1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_lik1_sub1 = $terbesar_pilar_lik1_sub2['val'];

$query_subpar_pilar_lik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik1_sub1'"));
$hasil_subpar_pilar_lik1 = $query_subpar_pilar_lik1['parameter'];
}
else {
    $hasil_subpar_pilar_lik1 = '-';
    $maxsub_lik1 = '0';
}



if ($que_pilar_lik2_sub == 6) {
    $terbesar_pilar_lik2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN hasil_pil2_par1a = greatest(hasil_pil2_par1a, hasil_pil2_par1b, hasil_pil2_par1c) THEN 'hasil_pil2_par1a'
    WHEN hasil_pil2_par1b = greatest(hasil_pil2_par1a, hasil_pil2_par1b, hasil_pil2_par1c) THEN 'hasil_pil2_par1b'
    WHEN hasil_pil2_par1c = greatest(hasil_pil2_par1a, hasil_pil2_par1b, hasil_pil2_par1c) THEN 'hasil_pil2_par1c'
    END AS val
    FROM inheren_likuiditas_pilar2
    WHERE id_profil_risiko = '$id'"));

$que_pilar_lik2_sub1 = $terbesar_pilar_lik2_sub2['val'];

$terbesar_nilai_pilar_lik2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1a, hasil_pil2_par1b, hasil_pil2_par1c) AS nilai_tertinggi_pilar2_sub
FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_lik2 = $terbesar_nilai_pilar_lik2_sub['nilai_tertinggi_pilar2_sub'];

$query_subpar_pilar_lik2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_likuiditas
WHERE kode_parameter = '$que_pilar_lik2_sub1'"));
$hasil_subpar_pilar_lik2 = $query_subpar_pilar_lik2['parameter'];
}
else if ($que_pilar_lik1_sub == 7) {
    $hasil_subpar_pilar_lik2 = '-';
    $maxsub_lik2 = '0';
}
else {
    $hasil_subpar_pilar_lik2 = '-';
    $maxsub_lik2 = '0';
}



//REPUTASI



$terbesar_pilar_rep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pil1_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) THEN 'pil1_tingkat_risiko'
    WHEN pil2_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) THEN 'pil2_tingkat_risiko'
    WHEN pil3_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) THEN 'pil3_tingkat_risiko'
    WHEN pil4_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) THEN 'pil4_tingkat_risiko'
    
END AS val
FROM hasil_inheren_reputasi
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_rep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) AS nilai_tertinggi_pilar
FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$id'"));


$que_pilar_rep = $terbesar_pilar_rep['val'];


$terbesar_pilar_rep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1 = greatest(hasil_pil1_par1, hasil_pil1_par2) THEN 'hasil_pil1_par1'
    WHEN hasil_pil1_par2 = greatest(hasil_pil1_par1, hasil_pil1_par2) THEN 'hasil_pil1_par2'
   
END AS val
FROM inheren_reputasi_pilar1
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_rep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1, hasil_pil1_par2) AS nilai_tertinggi_pilar1
FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));



$que_pilar_rep1 = $terbesar_pilar_rep1['val'];

$terbesar_pilar_rep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil2_par1 = greatest(hasil_pil2_par1, hasil_pil2_par2) THEN 'hasil_pil2_par1'
    WHEN hasil_pil2_par2 = greatest(hasil_pil2_par1, hasil_pil2_par2) THEN 'hasil_pil2_par2'
    END AS val
FROM inheren_reputasi_pilar2
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_rep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1, hasil_pil2_par2) AS nilai_tertinggi_pilar2
FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));


$que_pilar_rep2 = $terbesar_pilar_rep2['val'];


$terbesar_pilar_rep3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar3_2a = greatest(pilar3_2a, pilar3_2b) THEN 'pilar3_2a'
    WHEN pilar3_2b = greatest(pilar3_2a, pilar3_2b) THEN 'pilar3_2b'

END AS val
FROM inheren_reputasi_pilar3
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_rep3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar3_2a, pilar3_2b) AS nilai_tertinggi_pilar3
FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));



$que_pilar_rep3 = $terbesar_pilar_rep3['val'];

$terbesar_pilar_rep4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar4_1a = greatest(pilar4_1a, pilar4_1b, pilar4_1c) THEN 'pilar4_1a'
    WHEN pilar4_1b = greatest(pilar4_1a, pilar4_1b, pilar4_1c) THEN 'pilar4_1b'
    WHEN pilar4_1c = greatest(pilar4_1a, pilar4_1b, pilar4_1c) THEN 'pilar4_1c'
  
END AS val
FROM inheren_reputasi_lainnya
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_rep4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST( pilar4_1a,  pilar4_1b,  pilar4_1c) AS nilai_tertinggi_pilar4
FROM inheren_reputasi_lainnya WHERE id_profil_risiko = '$id'"));


$que_pilar_rep4 = $terbesar_pilar_rep4['val'];


//hasil bolo



$hasil_a_pilar_rep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep'"));

$hasil_par_pilar_rep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep1'"));

$hasil_par_pilar_rep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep2'"));

$hasil_par_pilar_rep3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep3'"));

$hasil_par_pilar_rep4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep4'"));



$que_pilar_rep1_sub = $hasil_par_pilar_rep1['kode_pil'];
$que_pilar_rep2_sub = $hasil_par_pilar_rep2['kode_pil'];



if ($que_pilar_rep1_sub == 1) {
    $terbesar_pilar_rep1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_1 = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d) THEN 'pilar1_1'
    WHEN pilar1_1a = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d) THEN 'pilar1_1a'
    WHEN pilar1_1b = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d) THEN 'pilar1_1b'
    WHEN pilar1_1c = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d) THEN 'pilar1_1c'
    WHEN pilar1_1d = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d) THEN 'pilar1_1d'
    END AS val
    FROM inheren_reputasi_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_rep1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_1,  pilar1_1a,  pilar1_1b, pilar1_1c, pilar1_1d) AS nilai_tertinggi_pilar1_sub
FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_rep1 = $terbesar_nilai_pilar_rep1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_rep1_sub1 = $terbesar_pilar_rep1_sub2['val'];

$query_subpar_pilar_rep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep1_sub1'"));
$hasil_subpar_pilar_rep1 = $query_subpar_pilar_rep1['parameter'];
}

else if ($que_pilar_rep1_sub == 2) {
    $terbesar_pilar_rep1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_2 = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d) THEN 'pilar1_2'
    WHEN pilar1_2a = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d) THEN 'pilar1_2a'
    WHEN pilar1_2b = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d) THEN 'pilar1_2b'
    WHEN pilar1_2c = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d) THEN 'pilar1_2c'
    WHEN pilar1_2d = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d) THEN 'pilar1_2d'
    END AS val
    FROM inheren_reputasi_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_rep1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_2,  pilar1_2a,  pilar1_2b, pilar1_2c, pilar1_2d) AS nilai_tertinggi_pilar1_sub
FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub_rep1 = $terbesar_nilai_pilar_rep1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar_rep1_sub1 = $terbesar_pilar_rep1_sub2['val'];

$query_subpar_pilar_rep1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep1_sub1'"));
$hasil_subpar_pilar_rep1 = $query_subpar_pilar_rep1['parameter'];
}


else {
    $hasil_subpar_pilar_rep11 = '-';
    $maxsub_rep1 = '0';
}


if ($que_pilar_rep2_sub == 3) {
    $terbesar_pilar_rep2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE
    WHEN pilar2_1 = greatest(pilar2_1, pilar2_1a, pilar2_1b) THEN 'pilar2_1' 
    WHEN pilar2_1a = greatest(pilar2_1, pilar2_1a, pilar2_1b) THEN 'pilar2_1a'
    WHEN pilar2_1b = greatest(pilar2_1, pilar2_1a, pilar2_1b) THEN 'pilar2_1b'
    WHEN pilar2_1c = greatest(pilar2_1, pilar2_1a, pilar2_1b) THEN 'pilar2_1c'
    WHEN pilar2_1d = greatest(pilar2_1, pilar2_1a, pilar2_1b) THEN 'pilar2_1d'
   
    END AS val
    FROM inheren_reputasi_pilar2
    WHERE id_profil_risiko = '$id'"));
    
$terbesar_nilai_pilar_rep2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_1, pilar2_1a, pilar2_1b) AS nilai_tertinggi_pilar2_sub
FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_rep2 = $terbesar_nilai_pilar_rep2_sub['nilai_tertinggi_pilar2_sub'];
    
$que_pilar_rep2_sub1 = $terbesar_pilar_rep2_sub2['val'];

$query_subpar_pilar_rep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep2_sub1'"));
$hasil_subpar_pilar_rep2 = $query_subpar_pilar_rep2['parameter'];
}
else if ($que_pilar_rep2_sub == 4) {
    $terbesar_pilar_rep2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE
    WHEN pilar2_1 = greatest(pilar2_1, pilar2_1a, pilar2_1b) THEN 'pilar2_1' 
    WHEN pilar2_1a = greatest(pilar2_1, pilar2_1a, pilar2_1b) THEN 'pilar2_1a'
    WHEN pilar2_1b = greatest(pilar2_1, pilar2_1a, pilar2_1b) THEN 'pilar2_1b'
   
    END AS val
    FROM inheren_reputasi_pilar2
    WHERE id_profil_risiko = '$id'"));
    
$terbesar_nilai_pilar_rep2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_1, pilar2_1a, pilar2_1b) AS nilai_tertinggi_pilar2_sub
FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_rep2 = $terbesar_nilai_pilar_rep2_sub['nilai_tertinggi_pilar2_sub'];
    
$que_pilar_rep2_sub1 = $terbesar_pilar_rep2_sub2['val'];

$query_subpar_pilar_rep2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_reputasi
WHERE kode_parameter = '$que_pilar_rep2_sub1'"));
$hasil_subpar_pilar_rep2 = $query_subpar_pilar_rep2['parameter'];
}

else {
    $hasil_subpar_pilar_rep2 = '-';
    $maxsub_rep2 = '0';
}




//STRATEJIK


$terbesar_pilar_stra = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pil1_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) THEN 'pil1_tingkat_risiko'
    WHEN pil2_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) THEN 'pil2_tingkat_risiko'
    WHEN pil3_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) THEN 'pil3_tingkat_risiko'
    WHEN pil4_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) THEN 'pil4_tingkat_risiko'
    
END AS val
FROM hasil_inheren_stratejik
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_stra = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko) AS nilai_tertinggi_pilar
FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$id'"));


$que_pilar_stra = $terbesar_pilar_stra['val'];


$terbesar_pilar_stra1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar1_1 = greatest(pilar1_1,pilar1_1a,pilar1_1b,pilar1_1c,pilar1_1d,pilar1_1e,pilar1_1f) THEN 'pilar1_1'
    WHEN pilar1_1a = greatest(pilar1_1,pilar1_1a,pilar1_1b,pilar1_1c,pilar1_1d,pilar1_1e,pilar1_1f) THEN 'pilar1_1a'
    WHEN pilar1_1b = greatest(pilar1_1,pilar1_1a,pilar1_1b,pilar1_1c,pilar1_1d,pilar1_1e,pilar1_1f) THEN 'pilar1_1b'
    WHEN pilar1_1c = greatest(pilar1_1,pilar1_1a,pilar1_1b,pilar1_1c,pilar1_1d,pilar1_1e,pilar1_1f) THEN 'pilar1_1c'
    WHEN pilar1_1d = greatest(pilar1_1,pilar1_1a,pilar1_1b,pilar1_1c,pilar1_1d,pilar1_1e,pilar1_1f) THEN 'pilar1_1d'
    WHEN pilar1_1e = greatest(pilar1_1,pilar1_1a,pilar1_1b,pilar1_1c,pilar1_1d,pilar1_1e,pilar1_1f) THEN 'pilar1_1e'
    WHEN pilar1_1f = greatest(pilar1_1,pilar1_1a,pilar1_1b,pilar1_1c,pilar1_1d,pilar1_1e,pilar1_1f) THEN 'pilar1_1f'
   
END AS val
FROM inheren_stratejik_pilar1
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_stra1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_1,pilar1_1a,pilar1_1b,pilar1_1c,pilar1_1d,pilar1_1e,pilar1_1f) AS nilai_tertinggi_pilar1
FROM inheren_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));



$que_pilar_stra1 = $terbesar_pilar_stra1['val'];

$terbesar_pilar_stra2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil2_par1 = greatest(hasil_pil2_par1, hasil_pil2_par2) THEN 'hasil_pil2_par1'
    WHEN hasil_pil2_par2 = greatest(hasil_pil2_par1, hasil_pil2_par2) THEN 'hasil_pil2_par2'
    END AS val
FROM inheren_stratejik_pilar2
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_stra2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1, hasil_pil2_par2) AS nilai_tertinggi_pilar2
FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));


$que_pilar_stra2 = $terbesar_pilar_stra2['val'];


$terbesar_pilar_stra3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil3_par1 = greatest(hasil_pil3_par1, hasil_pil3_par2) THEN 'hasil_pil3_par1'
    WHEN hasil_pil3_par2 = greatest(hasil_pil3_par1, hasil_pil3_par2) THEN 'hasil_pil3_par2'

END AS val
FROM inheren_stratejik_pilar3
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_stra3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil3_par1, hasil_pil3_par2) AS nilai_tertinggi_pilar3
FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));



$que_pilar_stra3 = $terbesar_pilar_stra3['val'];

$terbesar_pilar_stra4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar4_1a = greatest(pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1a'
    WHEN pilar4_1b = greatest(pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1b'
    WHEN pilar4_1c = greatest(pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1c'
    WHEN pilar4_1d = greatest(pilar4_1a, pilar4_1b, pilar4_1c, pilar4_1d) THEN 'pilar4_1d'
  
END AS val
FROM inheren_stratejik_lainnya
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar_stra4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST( pilar4_1a,  pilar4_1b,  pilar4_1c, pilar4_1d) AS nilai_tertinggi_pilar4
FROM inheren_stratejik_lainnya WHERE id_profil_risiko = '$id'"));


$que_pilar_stra4 = $terbesar_pilar_stra4['val'];


//hasil bolo



$hasil_a_pilar_stra = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra'"));

$hasil_par_pilar_stra1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra1'"));

$hasil_par_pilar_stra2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra2'"));

$hasil_par_pilar_stra3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra3'"));

$hasil_par_pilar_stra4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra4'"));



$que_pilar_stra2_sub = $hasil_par_pilar_stra2['kode_pil'];
$que_pilar_stra3_sub = $hasil_par_pilar_stra3['kode_pil'];






if ($que_pilar_stra2_sub == 2) {
    $terbesar_pilar_stra2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE
    WHEN pilar2_1 = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1' 
    WHEN pilar2_1a = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1a'
    WHEN pilar2_1b = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1b'
    WHEN pilar2_1c = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1c'
    WHEN pilar2_1d = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1d'
    WHEN pilar2_1e = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1e'
    WHEN pilar2_1f = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1f'
    WHEN pilar2_1g = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1g'
    WHEN pilar2_1h = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1h'
    WHEN pilar2_1i = greatest(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) THEN 'pilar2_1i'
   
    END AS val
    FROM inheren_stratejik_pilar2
    WHERE id_profil_risiko = '$id'"));
    
$terbesar_nilai_pilar_stra2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_1, pilar2_1a, pilar2_1b, pilar2_1c, pilar2_1d, pilar2_1e, pilar2_1f, pilar2_1g, pilar2_1h, pilar2_1i) AS nilai_tertinggi_pilar2_sub
FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_stra2 = $terbesar_nilai_pilar_stra2_sub['nilai_tertinggi_pilar2_sub'];
    
$que_pilar_stra2_sub1 = $terbesar_pilar_stra2_sub2['val'];

$query_subpar_pilar_stra2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra2_sub1'"));
$hasil_subpar_pilar_stra2 = $query_subpar_pilar_stra2['parameter'];
}
else if ($que_pilar_stra2_sub == 3) {
    $terbesar_pilar_stra2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE
    WHEN pilar2_2 = greatest(pilar2_2, pilar2_2a, pilar2_2b, pilar2_2c) THEN 'pilar2_2' 
    WHEN pilar2_2a = greatest(pilar2_2, pilar2_2a, pilar2_2b, pilar2_2c) THEN 'pilar2_2a'
    WHEN pilar2_2b = greatest(pilar2_2, pilar2_2a, pilar2_2b, pilar2_2c) THEN 'pilar2_2b'
    WHEN pilar2_2c = greatest(pilar2_2, pilar2_2a, pilar2_2b, pilar2_2c) THEN 'pilar2_2c'
   
    END AS val
    FROM inheren_stratejik_pilar2
    WHERE id_profil_risiko = '$id'"));
    
$terbesar_nilai_pilar_stra2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_2, pilar2_2a, pilar2_2b, pilar2_2c) AS nilai_tertinggi_pilar2_sub
FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub_stra2 = $terbesar_nilai_pilar_stra2_sub['nilai_tertinggi_pilar2_sub'];
    
$que_pilar_stra2_sub1 = $terbesar_pilar_stra2_sub2['val'];

$query_subpar_pilar_stra2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra2_sub1'"));
$hasil_subpar_pilar_stra2 = $query_subpar_pilar_stra2['parameter'];
}

else {
    $hasil_subpar_pilar_stra2 = '-';
    $maxsub_stra2 = '0';
}

if ($que_pilar_stra3_sub == 4) {
    $terbesar_pilar_stra3_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE
    WHEN pilar3_1 = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1' 
    WHEN pilar3_1a = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1a'
    WHEN pilar3_1b = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1b'
    WHEN pilar3_1c = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1c'
    WHEN pilar3_1d = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1d'
    WHEN pilar3_1e = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1e'
    WHEN pilar3_1f = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1f'
    WHEN pilar3_1g = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1g'
    WHEN pilar3_1h = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1h'
    WHEN pilar3_1i = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1i'
    WHEN pilar3_1j = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1j'
    WHEN pilar3_1k = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1k'
    WHEN pilar3_1l = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1l'
    WHEN pilar3_1m = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1m'
    WHEN pilar3_1n = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1n'
    WHEN pilar3_1o = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1o'
    WHEN pilar3_1p = greatest(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) THEN 'pilar3_1p'
   
    END AS val
    FROM inheren_stratejik_pilar3
    WHERE id_profil_risiko = '$id'"));
    
$terbesar_nilai_pilar_stra3_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar3_1, pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g, pilar3_1h, pilar3_1i, pilar3_1j, pilar3_1k, pilar3_1l, pilar3_1m, pilar3_1n, pilar3_1o, pilar3_1p) AS nilai_tertinggi_pilar3_sub
FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$maxsub_stra3 = $terbesar_nilai_pilar_stra3_sub['nilai_tertinggi_pilar3_sub'];
    
$que_pilar_stra3_sub1 = $terbesar_pilar_stra3_sub2['val'];

$query_subpar_pilar_stra3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra3_sub1'"));
$hasil_subpar_pilar_stra3 = $query_subpar_pilar_stra3['parameter'];
}
else if ($que_pilar_stra3_sub == 5) {
    $terbesar_pilar_stra3_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE
    WHEN pilar3_2 = greatest(pilar3_2, pilar3_2a, pilar3_2b, pilar3_2c, pilar3_2d, pilar3_2e, pilar3_2f) THEN 'pilar3_2' 
    WHEN pilar3_2a = greatest(pilar3_2, pilar3_2a, pilar3_2b, pilar3_2c, pilar3_2d, pilar3_2e, pilar3_2f) THEN 'pilar3_2a'
    WHEN pilar3_2b = greatest(pilar3_2, pilar3_2a, pilar3_2b, pilar3_2c, pilar3_2d, pilar3_2e, pilar3_2f) THEN 'pilar3_2b'
    WHEN pilar3_2c = greatest(pilar3_2, pilar3_2a, pilar3_2b, pilar3_2c, pilar3_2d, pilar3_2e, pilar3_2f) THEN 'pilar3_2c'
    WHEN pilar3_2d = greatest(pilar3_2, pilar3_2a, pilar3_2b, pilar3_2c, pilar3_2d, pilar3_2e, pilar3_2f) THEN 'pilar3_2d'
    WHEN pilar3_2e = greatest(pilar3_2, pilar3_2a, pilar3_2b, pilar3_2c, pilar3_2d, pilar3_2e, pilar3_2f) THEN 'pilar3_2e'
    WHEN pilar3_2f = greatest(pilar3_2, pilar3_2a, pilar3_2b, pilar3_2c, pilar3_2d, pilar3_2e, pilar3_2f) THEN 'pilar3_2f'
   
    END AS val
    FROM inheren_stratejik_pilar3
    WHERE id_profil_risiko = '$id'"));
    
$terbesar_nilai_pilar_stra3_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar3_2, pilar3_2a, pilar3_2b, pilar3_2c, pilar3_2d, pilar3_2e, pilar3_2f) AS nilai_tertinggi_pilar3_sub
FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$maxsub_stra3 = $terbesar_nilai_pilar_stra3_sub['nilai_tertinggi_pilar3_sub'];
    
$que_pilar_stra3_sub1 = $terbesar_pilar_stra3_sub2['val'];

$query_subpar_pilar_stra3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_stratejik
WHERE kode_parameter = '$que_pilar_stra3_sub1'"));
$hasil_subpar_pilar_stra3 = $query_subpar_pilar_stra3['parameter'];
}

else {
    $hasil_subpar_pilar_stra3 = '-';
    $maxsub_stra2 = '0';
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
        $this->Cell(30);
        $this->Cell(45, 5, ' TINDAK LANJUT PELAPORAN PROFIL RISIKO KANTOR CABANG');
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
$pdf->Cell(50);
$pdf->Cell(10, 5, 'TINDAK LANJUT LAPORAN PROFIL RISIKO ');

$pdf->Ln(10);


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, ' ' );
$pdf->Ln(4);
$pdf->Cell(20, 5, 'Tahun Realisasi '. $tahun);
$pdf->Ln(6);
$pdf->Cell(20, 5, $periode_lap);
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

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Analisa Nilai Tinggi Risiko Kredit', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;





$pdf->Row(array('Pilar','Nilai risiko yang tertinggi ada di '.$hasil_a_pilar_kre['parameter']. ' dengan nilai ('. $terbesar_nilai_pilar_kre['nilai_tertinggi_pilar'] . ')'));
$pdf->Row(array('Parameter Pilar 1','Pada PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_kre1['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_kre1['nilai_tertinggi_pilar1'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_kre1 .' '. number_format($maxsub_kre1,2) .' '));
$pdf->Row(array('Parameter Pilar 2','Pada PILAR 2 : Kualitas Aset.
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_kre2['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_kre2['nilai_tertinggi_pilar2'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_kre2 .' '. number_format($maxsub_kre2,2) .''));
$pdf->Row(array('Parameter Pilar 3','Pada PILAR 3 : Strategi Penyediaan Dana.
sub parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_kre3['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_kre3['nilai_tertinggi_pilar3'] .')'));
$pdf->Row(array('Parameter Pilar 4','Pada PILAR 4 : Faktor Eksternal. 
sub parameter yang tertinggi ada di '. $hasil_par_pilar_kre4['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_kre4['nilai_tertinggi_pilar4'] .')'));
$pdf->Row(array('Parameter Pilar Lainnya','Pada Pilar Lainnya. 
sub parameter yang tertinggi ada di '. $hasil_par_pilar_kre5['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_kre5['nilai_tertinggi_pilar5'] .')'));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Definisi Tingkat Risiko Kredit (Matrik OJK)', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array($inheren1['hasil_peringkat'],$matrik_ojk_kre['definisi_tingkat_risiko']));


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Form Tindak Lanjut', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Usulan Perbaikan & Tindak Lanjut',$ket1['tindak_lanjut']));
$pdf->Row(array('Respon Cabang & Hasil Perbaikan',$ket1['respon']));


















//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO OPERASIONAL)');

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


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Analisa Nilai Tinggi Risiko Operasional', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Pilar','Nilai risiko yang tertinggi ada di '. $hasil_a_pilar_ops['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_ops['nilai_tertinggi_pilar'] .')'));
$pdf->Row(array('Parameter Pilar 1','Pada PILAR 1 : Kompleksitas Bisnis dan Kelembagaan
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_ops1['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_ops1['nilai_tertinggi_pilar1'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_ops1 .' '. number_format($maxsub_ops1,2) .''));
$pdf->Row(array('Parameter Pilar 2','PILAR 2 : Sumber Daya Manusia
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_ops2['parameter'] .'  dengan nilai ('.$terbesar_nilai_pilar_ops2['nilai_tertinggi_pilar2'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_ops2 .' '. number_format($maxsub_ops2,2).''));
$pdf->Row(array('Parameter Pilar 3','PILAR 3 : Penyimpangan (Fraud)
sub parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_ops3['parameter'] .'  dengan nilai ('. number_format($terbesar_nilai_pilar_ops3['nilai_tertinggi_pilar3'],2) .')'));
$pdf->Row(array('Parameter Pilar 4','PILAR 4 : Faktor Eksternal.
sub parameter yang tertinggi ada di '. $hasil_par_pilar_ops4['parameter'] .'  dengan nilai ('. number_format($terbesar_nilai_pilar_ops4['nilai_tertinggi_pilar4'],2) .')'));
$pdf->Row(array('Parameter Pilar Lainnya','Pilar Lainnya.
sub parameter yang tertinggi ada di '. $hasil_par_pilar_ops5['parameter'] .' dengan nilai ('. number_format($terbesar_nilai_pilar_ops5['nilai_tertinggi_pilar5'],2) .')'));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Definisi Tingkat Risiko Operasional (Matrik OJK)', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array($inheren2['hasil_peringkat'],$matrik_ojk_kre2['definisi_tingkat_risiko']));


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Form Tindak Lanjut', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Usulan Perbaikan & Tindak Lanjut',$ket2['tindak_lanjut']));
$pdf->Row(array('Respon Cabang & Hasil Perbaikan',$ket2['respon']));












//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO KEPATUHAN)');

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



$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Analisa Nilai Tinggi Risiko Kepatuhan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Pilar','Nilai risiko yang tertinggi ada di '. $hasil_a_pilar_kep['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_kep['nilai_tertinggi_pilar'] .')'));
$pdf->Row(array('Parameter Pilar 1','PILAR 1 : Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_kep1['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_kep1['nilai_tertinggi_pilar1'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_kep1 .' '. number_format($maxsub_kep1,2) .''));
$pdf->Row(array('Parameter Pilar 2','PILAR 2 : Faktor Kelemahan Aspek Hukum
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_kep2['parameter'] .'  dengan nilai ('.$terbesar_nilai_pilar_kep2['nilai_tertinggi_pilar2'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_kep2 .' '. number_format($maxsub_kep2,2) .''));
$pdf->Row(array('Parameter Pilar Lainnya','Pilar Lainnya.
sub parameter yang tertinggi ada di '. $hasil_par_pilar_kep5['parameter'] .' dengan nilai ('. number_format($terbesar_nilai_pilar_kep5['nilai_tertinggi_pilar5'],2) .')'));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Definisi Tingkat Risiko Kepatuhan (Matrik OJK)', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array($inheren3['hasil_peringkat'],$matrik_ojk_kre3['definisi_tingkat_risiko']));


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Form Tindak Lanjut', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Usulan Perbaikan & Tindak Lanjut',$ket3['tindak_lanjut']));
$pdf->Row(array('Respon Cabang & Hasil Perbaikan',$ket3['respon']));









$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO LIKUIDITAS)');

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



$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Analisa Nilai Tinggi Risiko Likuiditas', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Pilar','Nilai risiko yang tertinggi ada di '. $hasil_a_pilar_lik['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_lik['nilai_tertinggi_pilar'] .')'));
$pdf->Row(array('Parameter Pilar 1','PILAR 1 : Komposisi dan Konsentrasi Aset dan Kewajiban
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_lik1['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_lik1['nilai_tertinggi_pilar1'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_lik1 .' '. number_format($maxsub_lik1,2) .''));
$pdf->Row(array('Parameter Pilar 2','PILAR 2 : Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber Pendanaan
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_lik2['parameter'] .'  dengan nilai ('.$terbesar_nilai_pilar_lik2['nilai_tertinggi_pilar2'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_lik2 .' '. number_format($maxsub_lik2,2) .''));
$pdf->Row(array('Parameter Pilar Lainnya','Pilar Lainnya.
sub parameter yang tertinggi ada di '. $hasil_par_pilar_lik5['parameter'] .' dengan nilai ('. number_format($terbesar_nilai_pilar_lik5['nilai_tertinggi_pilar5'],2) .')'));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Definisi Tingkat Risiko Likuiditas (Matrik OJK)', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array($inheren4['hasil_peringkat'],$matrik_ojk_kre4['definisi_tingkat_risiko']));


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Form Tindak Lanjut', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Usulan Perbaikan & Tindak Lanjut',$ket4['tindak_lanjut']));
$pdf->Row(array('Respon Cabang & Hasil Perbaikan',$ket4['respon']));













//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO REPUTASI)');

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



$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Analisa Nilai Tinggi Risiko Reputasi', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Pilar','Nilai risiko yang tertinggi ada di '. $hasil_a_pilar_rep['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_rep['nilai_tertinggi_pilar'] .')'));
$pdf->Row(array('Parameter Pilar 1','PILAR 1 : Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_rep1['parameter'] .' dengan nilai ('.$terbesar_nilai_pilar_rep1['nilai_tertinggi_pilar1'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_rep1 .' '. number_format($maxsub_rep1,2) .''));
$pdf->Row(array('Parameter Pilar 2','PILAR 2 : Frekuensi Dan Signifikansi Pengaduan Nasabah
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_rep2['parameter'] .'  dengan nilai ('.$terbesar_nilai_pilar_rep2['nilai_tertinggi_pilar2'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_rep2 .' '. number_format($maxsub_rep2,2) .''));
$pdf->Row(array('Parameter Pilar 3','PILAR 3 : Pelanggaran Etika Bisnis
sub parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_rep3['parameter'] .'  dengan nilai ('. number_format($terbesar_nilai_pilar_rep3['nilai_tertinggi_pilar3'],2) .')'));
$pdf->Row(array('Parameter Pilar Lainnya','Pilar Lainnya.
sub parameter yang tertinggi ada di '. $hasil_par_pilar_rep4['parameter'] .' dengan nilai ('. number_format($terbesar_nilai_pilar_rep4['nilai_tertinggi_pilar4'],2) .')'));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Definisi Tingkat Risiko Reputasi (Matrik OJK)', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array($inheren5['hasil_peringkat'],$matrik_ojk_kre5['definisi_tingkat_risiko']));


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Form Tindak Lanjut', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Usulan Perbaikan & Tindak Lanjut',$ket5['tindak_lanjut']));
$pdf->Row(array('Respon Cabang & Hasil Perbaikan',$ket5['respon']));









$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO STRATEJIK)');

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


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Analisa Nilai Tinggi Risiko Stratejik', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Pilar',$ket1['ket_profil_inheren']));
$pdf->Row(array('Parameter Pilar 1','PILAR 1 : Penetapan Strategi Bisnis
sub parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_stra1['parameter'] .' dengan nilai ('. number_format ($terbesar_nilai_pilar_stra1['nilai_tertinggi_pilar1'],2) .')'));
$pdf->Row(array('Parameter Pilar 2','PILAR 2 : Penyusunan Rencana Bisnis
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_stra2['parameter'] .'  dengan nilai ('.$terbesar_nilai_pilar_stra2['nilai_tertinggi_pilar2'] .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_stra2 .' '. number_format($maxsub_stra2,2) .''));
$pdf->Row(array('Parameter Pilar 3','PILAR 3 : Pencapaian Target Bisnis
parameter dengan nilai tertinggi ada di '. $hasil_par_pilar_stra3['parameter'] .'  dengan nilai ('. number_format($terbesar_nilai_pilar_stra3['nilai_tertinggi_pilar3'],2) .'), dengan sub parameter yg tertiggi pada '. $hasil_subpar_pilar_stra3 .' '. number_format($maxsub_stra3,2) .''));
$pdf->Row(array('Parameter Pilar Lainnya','Pada Pilar Lainnya.
sub parameter yang tertinggi ada di '. $hasil_par_pilar_stra4['parameter'] .' dengan nilai ('. number_format($terbesar_nilai_pilar_stra4['nilai_tertinggi_pilar4'],2) .')'));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Definisi Tingkat Risiko Stratejik (Matrik OJK)', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array($inheren6['hasil_peringkat'],$matrik_ojk_kre6['definisi_tingkat_risiko']));


$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Tingkat Risiko', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Form Tindak Lanjut', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Usulan Perbaikan & Tindak Lanjut',$ket6['tindak_lanjut']));
$pdf->Row(array('Respon Cabang & Hasil Perbaikan',$ket6['respon']));











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






$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(10, 5, 'Dengan ini menyatakan bahwa seluruh informasi dalam pengisian profil risiko di BPR BKK Jateng adalah akurat dan sesuai');
$pdf->Ln();
$pdf->Cell(10, 5, 'dengan kondisi sebenarnya. Dengan Tindak lanjut atas profil risiko dan hasil perbaikan oleh Kantor Cabang dilakukan');
$pdf->Ln();
$pdf->Cell(10, 5, 'sebelum periode penilaian selanjutnya dan akan di evaluasi secara berkala');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60, 5, 'Status Konfirmasi (V/X)', 0, 1);
$pdf->Cell(30, 5, 'Kepala Wilayah : ' . $status_korwil , 0, 0);
$pdf->Cell(60, 5, 'Manrisk Kantor Pusat : ' . $status_mr, 0, 1);
$pdf->Ln(20);
$pdf->SetFillColor(224, 224, 23);
$pdf->Cell(190, 5, 'Semarang, ' . tgl_indo(date('Y-m-d')), 0, 1);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Kepala Cabang', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Risk Residence Area', 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(94, 40, '', 1, 0, 'C', 0);
$pdf->Cell(94, 40, '', 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(94, 5, '     Nama : '.$nama_kacab = $kacab['nama'].'', 1, 0);
$pdf->Cell(94, 5, '     Nama : '.$nama_kc = $frame['nama'].'', 1, 0);





$pdf->Output();
