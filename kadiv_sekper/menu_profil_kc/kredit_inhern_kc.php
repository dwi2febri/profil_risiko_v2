<?php
if (empty($id) || $id === null) {
  // Display modal notification on page load
  $displayModal = true;
} else {
  $displayModal = false;
}
?>
<script>
  $(document).ready(function() {
    <?php if ($displayModal) { ?>
      $('#myModal').modal('show');
    <?php } ?>
  });

  window.onclick = null;
  
</script>

<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Notifikasi</h5>
        <a href="javascript:history.back()"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
      <h5><center><b>Mohon untuk memilih laporan risiko di (menu dashboard -> laporan profil risiko -> klik (aktif)) terlebih dahulu.</b></center></h5>
      </div>
      <div class="modal-footer">
      <a href="javascript:history.back()"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></a>
      </div>
    </div>
  </div>
</div>


<?php
include "../fungsi/fungsi.php";


$id = $_GET['id'];

$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang WHERE id_profil_risiko = '$id'"));
$frame_laporan_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT user,tahun,periode,data_pembanding FROM frame_laporan_profil_risiko WHERE id_profil_risiko = '$id'"));
$jenis_pr = $frame_laporan_kredit['user'];
$tahun = $frame_laporan_kredit['tahun'];
$user_cd = $frame_laporan_kredit['user'];
$periode = $frame_laporan_kredit['periode'];
$dp = $frame_laporan_kredit['data_pembanding'];

$length = mysqli_fetch_array(mysqli_query($conn, "SELECT 
CHAR_LENGTH(ket_pil1_1) AS l1,
CHAR_LENGTH(ket_pil1_2) AS l2,
CHAR_LENGTH(ket_pil1_3) AS l3,
CHAR_LENGTH(ket_pil1_4) AS l4,
CHAR_LENGTH(ket_pil1) AS l5,
CHAR_LENGTH(ket_pil2_1) AS l6,
CHAR_LENGTH(ket_pil2_2) AS l7,
CHAR_LENGTH(ket_pil2_3) AS l8,
CHAR_LENGTH(ket_pil2) AS l9,
CHAR_LENGTH(ket_pil3_1) AS l10,
CHAR_LENGTH(ket_pil3) AS l11,
CHAR_LENGTH(ket_pil4_1) AS l12,
CHAR_LENGTH(ket_pil4) AS l13,
CHAR_LENGTH(ket_pil5_1) AS l14,
CHAR_LENGTH(ket_pil5) AS l15,
CHAR_LENGTH(ket_inheren) AS l16 FROM keterangan_inheren_kredit WHERE id_profil_risiko = '$id'"));


$master_kredit_P1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$master_kredit_P2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$master_kredit_P3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = '$id'"));

$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$id'"));
$pil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$id'"));

$pembanding_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$dp'"));

$hasil = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));


$inheren = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_inheren_kredit WHERE user = '$jenis_pr' AND tahun = '$tahun' AND periode = '$periode'"));

$ket_inhern_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren_kredit WHERE id_profil_risiko = '$id'"));


$ambang_batas_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ambang_batas_kredit WHERE tahun = '$tahun'"));
$bobot_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = '$id'"));

//pembobotan
$pembobotan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM bobot_kredit_per_parameter 
INNER JOIN frame_bobot ON bobot_kredit_per_parameter.id_bobot = frame_bobot.id_bobot WHERE frame_bobot.tahun = '$tahun' AND frame_bobot.user = '$user_cd'"));
$bobot1 = $pembobotan['sub_parameter1'];
$bobot2 = $pembobotan['sub_parameter2'];
$bobot3 = $pembobotan['sub_parameter3'];
$bobot4 = $pembobotan['sub_parameter4'];
$bobot5 = $pembobotan['sub_parameter5'];
$bobot6 = $pembobotan['sub_parameter6'];
$bobot7 = $pembobotan['sub_parameter7'];
$bobot8 = $pembobotan['sub_parameter8'];
$bobot2_1 = $pembobotan['sub_parameter2_1'];
$bobot2_2 = $pembobotan['sub_parameter2_2'];
$bobot2_3 = $pembobotan['sub_parameter2_3'];
$bobot2_4 = $pembobotan['sub_parameter2_4'];
$bobot2_5 = $pembobotan['sub_parameter2_5'];
$bobot2_6 = $pembobotan['sub_parameter2_6'];
$bobot2_7 = $pembobotan['sub_parameter2_7'];
$bobot2_8 = $pembobotan['sub_parameter2_8'];
$bobot2_9 = $pembobotan['sub_parameter2_9'];
$bobot2_10 = $pembobotan['sub_parameter2_10'];
$bobot2_11 = $pembobotan['sub_parameter2_11'];
$bobot3_1 = $pembobotan['sub_parameter3_1'];
$bobot3_2 = $pembobotan['sub_parameter3_2'];
$bobot3_3 = $pembobotan['sub_parameter3_3'];
$bobot3_4 = $pembobotan['sub_parameter3_4'];
$bobot3_5 = $pembobotan['sub_parameter3_5'];
$bobot3_6 = $pembobotan['sub_parameter3_6'];
$bobot4_1 = $pembobotan['sub_parameter4_1'];
$bobot4_2 = $pembobotan['sub_parameter4_2'];
$bobot4_3 = $pembobotan['sub_parameter4_3'];
$bobot4_4 = $pembobotan['sub_parameter4_4'];
$bobot5_1 = $pembobotan['sub_parameter5_1'];
$bobot6_1 = $pembobotan['sub_parameter6_1'];
$bobot6_2 = $pembobotan['sub_parameter6_2'];
$bobot6_3 = $pembobotan['sub_parameter6_3'];
$bobot6_4 = $pembobotan['sub_parameter6_4'];
$bobot7_1 = $pembobotan['sub_parameter7_1'];
$bobot7_2 = $pembobotan['sub_parameter7_2'];
$bobot7_3 = $pembobotan['sub_parameter7_3'];
$bobot7_4 = $pembobotan['sub_parameter7_4'];
$bobot7_5 = $pembobotan['sub_parameter7_5'];
$bobot7_6 = $pembobotan['sub_parameter7_6'];
$bobot7_7 = $pembobotan['sub_parameter7_7'];
$bobot7_8 = $pembobotan['sub_parameter7_8'];
$bobot7_9 = $pembobotan['sub_parameter7_9'];
$bobot7_10 = $pembobotan['sub_parameter7_10'];
$bobot7_11 = $pembobotan['sub_parameter7_11'];

//setingan ditetapkan
$set_pil1 = $inheren['inheren_kre_set_pil1'];
$set_pil2 = $inheren['inheren_kre_set_pil2'];
$set_pil3 = $inheren['inheren_kre_set_pil3'];
$set_tingkat_risiko = $inheren['inheren_kre_set_tingkat_risiko'];




//penamaan rasio
$apro = $master_kredit_P1['aset_produktif'];
$totas = $master_kredit_P1['total_aset'];
$aba = $master_kredit_P1['aba'];
$kyd = $master_kredit_P1['kyd'];
$kredit_spg = $master_kredit_P1['kredit_spg'];
$kredit_pbta = $master_kredit_P1['kredit_pbta'];
$kredit_jpendek = $master_kredit_P1['kredit_jpendek'];
$kredit_jmenengah = $master_kredit_P1['kredit_jmenengah'];
$kredit_jpanjang = $master_kredit_P1['kredit_jpanjang'];
$noa_kyd = $master_kredit_P1['noa_kyd'];
$kredit_agunan_tb = $master_kredit_P1['kredit_agunan_tb'];
$kredit_agunan_kb = $master_kredit_P1['kredit_agunan_kb'];
$kredit_agunan_kr2 = $master_kredit_P1['kredit_agunan_kr2'];
$kredit_kub = $master_kredit_P1['kredit_kub'];
$kredit_ta = $master_kredit_P1['kredit_ta'];
$kredit_korporasi = $master_kredit_P1['kredit_korporasi'];
$kredit_pep = $master_kredit_P1['kredit_pep'];
$kredit_lebih350 = $master_kredit_P1['kredit_lebih350'];
$debitur_inti25 = $master_kredit_P1['debitur_inti25'];
$kredit_3sektor_ekonomi_terbesar = $master_kredit_P1['kredit_3sektor_ekonomi_terbesar'];

$noa_kredit_sd150 = $master_kredit_P2['noa_kredit_sd150'];
$aset_produktif_bermasalah = $master_kredit_P2['aset_produktif_bermasalah'];
$saldo_ppap = $master_kredit_P2['saldo_ppap'];
$ayda = $master_kredit_P2['ayda'];
$kredit_bermasalah_neto = $master_kredit_P2['kredit_bermasalah_neto'];
$npl_kredit_sd150 = $master_kredit_P2['npl_kredit_sd150'];
$kyd_plafon_sd150 = $master_kredit_P2['kyd_plafon_sd150'];
$npl_kredit_diatas50 = $master_kredit_P2['npl_kredit_diatas50'];
$kyd_plafon_diatas50 = $master_kredit_P2['kyd_plafon_diatas50'];
$npl_apht = $master_kredit_P2['npl_apht'];
$npl_skmht = $master_kredit_P2['npl_skmht'];
$npl_agunan_lrd_bakidebet = $master_kredit_P2['npl_agunan_lrd_bakidebet'];
$kredit_agunan_lrd_bakidebet = $master_kredit_P2['kredit_agunan_lrd_bakidebet'];
$macet_jatuh_tempo = $master_kredit_P2['macet_jatuh_tempo'];
$kkr = $master_kredit_P2['kkr'];
$kredit_par4 = $master_kredit_P2['kredit_par4'];
$kredit_dp = $master_kredit_P2['kredit_dp'];
$noa_fpd_6bln = $master_kredit_P2['noa_fpd_6bln'];
$noa_ekspansi_6bln = $master_kredit_P2['noa_ekspansi_6bln'];
$nominal_fpd_6bln = $master_kredit_P2['nominal_fpd_6bln'];
$plafond_ekspansi_6bln = $master_kredit_P2['plafond_ekspansi_6bln'];

$aba_tinggi = $master_kredit_P3['aba_tertinggi'];
$pertumbuhan_kyd_bpr = $master_kredit_P3['pertumbuhan_kyd_bpr'];
$rasio_pertumbuhan_rata2_bpr = $master_kredit_P3['rasio_pertumbuhan_rata2_bpr'];
$td_pp_l = $master_kredit_P3['td_pp_l'];
$td_pp_dp = $master_kredit_P3['td_pp_dp'];
$td_pp_kl = $master_kredit_P3['td_pp_kl'];
$td_pp_d = $master_kredit_P3['td_pp_d'];
$td_pp_m = $master_kredit_P3['td_pp_m'];

$td_ps_l = $master_kredit_P3['td_ps_l'];
$td_ps_dp = $master_kredit_P3['td_ps_dp'];
$td_ps_kl = $master_kredit_P3['td_ps_kl'];
$td_ps_d = $master_kredit_P3['td_ps_d'];
$td_ps_m = $master_kredit_P3['td_ps_m'];


$d_pp_l = $master_kredit_P3['d_pp_l'];
$d_pp_dp = $master_kredit_P3['d_pp_dp'];
$d_pp_kl = $master_kredit_P3['d_pp_kl'];
$d_pp_d = $master_kredit_P3['d_pp_d'];
$d_pp_m = $master_kredit_P3['d_pp_m'];

$d_ps_l = $master_kredit_P3['d_ps_l'];
$d_ps_dp = $master_kredit_P3['d_ps_dp'];
$d_ps_kl = $master_kredit_P3['d_ps_kl'];
$d_ps_d = $master_kredit_P3['d_ps_d'];
$d_ps_m = $master_kredit_P3['d_ps_m'];

$osc_2bln_sebelumnya = $master_kredit_P3['osc_2bln_sebelumnya'];
$noa_2bln_sebelumnya = $master_kredit_P3['noa_2bln_sebelumnya'];

$npl_2bln_sebelumnya = $master_kredit_P3['npl_2bln_sebelumnya'];
$noa_npl_2bln_sebelumnya = $master_kredit_P3['noa_npl_2bln_sebelumnya'];

$osc_1bln_sebelumnya = $master_kredit_P3['osc_1bln_sebelumnya'];
$noa_1bln_sebelumnya = $master_kredit_P3['noa_1bln_sebelumnya'];

$npl_1bln_sebelumnya = $master_kredit_P3['npl_1bln_sebelumnya'];
$noa_npl_1bln_sebelumnya = $master_kredit_P3['noa_npl_1bln_sebelumnya'];


$osc_bln_penilaian = $master_kredit_P3['osc_bln_penilaian'];
$noa_bln_penilaian = $master_kredit_P3['noa_bln_penilaian'];

$npl_bln_penilaian = $master_kredit_P3['npl_bln_penilaian'];
$noa_npl_bln_penilaian = $master_kredit_P3['noa_npl_bln_penilaian'];


$rasio_npl_1bln_sebelumnya = $master_kredit_P3['rasio_npl_1bln_sebelumnya'];
$rasio_npl_bln_penilaian = $master_kredit_P3['rasio_npl_bln_penilaian'];

$aba = $master_kredit_P1['aba'];
$aba_tertinggi = $master_kredit_P3['aba_tertinggi'];
$aba_bank_umum = $master_kredit_P3['aba_bank_umum'];
$aba_bpr = $master_kredit_P3['aba_bpr'];




// menghitung rumus
$p1 = round(($apro / $totas) * 100, 2);
$p1a = round(($aba / $totas) * 100, 2);
$p1b = round(($aba_tinggi / $aba) * 100, 2);
$p1c = round(($aba_bpr / $aba) * 100, 2);

$p2 = round(($kyd / $apro) * 100, 2);
$p2a = round(($kredit_spg / $kyd) * 100, 2);
$p2b = round(($kredit_pbta / $kyd) * 100, 2);
$p2c = round(($kredit_jpendek / $kyd) * 100, 2);
$p2d = round(($kredit_jmenengah / $kyd) * 100, 2);
$p2e = round(($kredit_jpanjang / $kyd) * 100, 2);
$p2f = round(($noa_kredit_sd150 / $noa_kyd) * 100, 2);
$p2g = round(($kredit_agunan_tb / $kyd) * 100, 2);
$p2h = round(($kredit_agunan_kb / $kyd) * 100, 2);
$p2i = round(($kredit_agunan_kr2 / $kyd) * 100, 2);
$p2j = round(($kredit_kub / $kyd) * 100, 2);
$p2k = round(($kredit_ta / $kyd) * 100, 2);
$p2l = round(($kredit_korporasi / $kyd) * 100, 2);
$p2m = round(($kredit_pep / $kyd) * 100, 2);
$p2n = round(($kredit_lebih350 / $kyd) * 100, 2);

$p3 = round(($debitur_inti25 * 100) / $kyd, 2);

$p4 = round(($kredit_3sektor_ekonomi_terbesar * 100) / $kyd, 2);

$pilar2_p1 = round(($aset_produktif_bermasalah / $apro) * 100, 2);
$pilar2_p1a = round(($saldo_ppap / $kyd) * 100, 2);
$pilar2_p1b = round(($ayda / $kyd) * 100, 2);

$pilar2_p2 = round(($kredit_bermasalah_neto / $kyd) * 100, 2);
$pilar2_p2a = round(($npl_kredit_sd150 / $kyd_plafon_sd150) * 100, 2);
$pilar2_p2b = round(($npl_kredit_diatas50 / $kyd_plafon_diatas50) * 100, 2);
$pilar2_p2c = round(($npl_apht / $kyd) * 100, 2);
$pilar2_p2d = round(($npl_skmht / $kyd) * 100, 2);
$pilar2_p2e = round(($npl_agunan_lrd_bakidebet / $kredit_agunan_lrd_bakidebet) * 100, 2);
$pilar2_p2f = round(($macet_jatuh_tempo / $kyd) * 100, 2);

$pilar2_p3 = round(($kkr / $kyd) * 100, 2);
$pilar2_p3a = round(($kredit_par4 / $kyd) * 100, 2);
$pilar2_p3b = round(($kredit_dp / $kyd) * 100, 2);
$pilar2_p3c = round(($noa_fpd_6bln / $noa_ekspansi_6bln) * 100, 2);
$pilar2_p3d = round(($nominal_fpd_6bln / $plafond_ekspansi_6bln) * 100, 2);




$pilar3_p1 = round($pertumbuhan_kyd_bpr - $rasio_pertumbuhan_rata2_bpr, 2);
if ($pilar3_p1 == 0) {
    $hsl_pil3_par1 = 0;
} else if ($pilar3_p1 < $bobot5_1) {
    $hsl_pil3_par1 = 4;
} else if ($pilar3_p1 < 1) {
    $hsl_pil3_par1 = 3;
} elseif ($pilar3_p1 == $bobot5_1) {
    $hsl_pil3_par1 = 2;
} elseif ($pilar3_p1 > 1) {
    $hsl_pil3_par1 = 1;
} else {
    $hsl_pil3_par1 = null;
}

$pilar3_p1a_pp = $td_pp_l + $td_pp_dp + $td_pp_kl + $td_pp_d + $td_pp_m;
$pilar3_p1a_ps = $td_ps_l + $td_ps_dp + $td_ps_kl + $td_ps_d + $td_ps_m;

if ($pilar3_p1a_pp < $pilar3_p1a_ps) {
    $hsl_pil3_par1a = 3;
} else if ($pilar3_p1a_pp > $pilar3_p1a_ps) {
    $hsl_pil3_par1a = 3;
} else if ($pilar3_p1a_pp == $pilar3_p1a_ps) {
    $hsl_pil3_par1a = 2;
} else {
    $hsl_pil3_par1a = 2;
}



$pilar3_p1b_pp = $d_pp_l + $d_pp_dp + $d_pp_kl + $d_pp_d + $d_pp_m;
$pilar3_p1b_ps = $d_ps_l + $d_ps_dp + $d_ps_kl + $d_ps_d + $d_ps_m;

if ($pilar3_p1b_pp < $pilar3_p1b_ps) {
    $hsl_pil3_par1b = 3;
} else if ($pilar3_p1b_pp > $pilar3_p1b_ps) {
    $hsl_pil3_par1b = 3;
} else if ($pilar3_p1b_pp == $pilar3_p1b_ps) {
    $hsl_pil3_par1b = 2;
} else {
    $hsl_pil3_par1b = 2;
}


$pilar3_p1c_pertumbuhan_kredit = round(($osc_bln_penilaian - $osc_1bln_sebelumnya) / $osc_bln_penilaian * 100, 2);
$pilar3_p1c_pertumbuhan_noa = round(($noa_bln_penilaian - $noa_1bln_sebelumnya) / $noa_bln_penilaian * 100, 2);
$pilar3_p1c_pertumbuhan_rasio_npl = round(($rasio_npl_bln_penilaian - $rasio_npl_1bln_sebelumnya) / $rasio_npl_bln_penilaian * 100, 2);
$pilar3_p1c_pertumbuhan_noa_npl = round(($noa_npl_bln_penilaian - $noa_npl_1bln_sebelumnya) / $noa_npl_bln_penilaian * 100, 2);

if ($pilar3_p1c_pertumbuhan_kredit > 0 && $pilar3_p1c_pertumbuhan_rasio_npl < 0) {
    $hsl_pil3_par1c = 1;
} else if ($pilar3_p1c_pertumbuhan_kredit > 0 && $pilar3_p1c_pertumbuhan_rasio_npl == 0) {
    $hsl_pil3_par1c = 2;
} else if ($pilar3_p1c_pertumbuhan_kredit > 0 && $pilar3_p1c_pertumbuhan_rasio_npl > 0) {
    $hsl_pil3_par1c = 3;
} else if ($pilar3_p1c_pertumbuhan_kredit < 0 && $pilar3_p1c_pertumbuhan_rasio_npl < 0) {
    $hsl_pil3_par1c = 4;
} else {
    $hsl_pil3_par1c = 5;
}


$pilar3_p1c_pertumbuhan_rasio_npl_tambah5 =  $pilar3_p1c_pertumbuhan_rasio_npl + 5;

if ($pilar3_p1c_pertumbuhan_kredit > $pilar3_p1c_pertumbuhan_rasio_npl) {
    $hsl_pil3_par1c_rumus = 1;
} else if ($pilar3_p1c_pertumbuhan_kredit > $pilar3_p1c_pertumbuhan_rasio_npl_tambah) {
    $hsl_pil3_par1c_rumus = 3;
} else {
    $hsl_pil3_par1c_rumus = 4;
}

$nilai_pil3_par1c = round(($hsl_pil3_par1c_rumus + $hsl_pil3_par1c) / 2, 2);









$hsl_pil3_par1d = ($aba_bpr / $aba) * 100;

if ($hsl_pil3_par1d < 10) {
    $hsl_pil3_par1d_rumus = 1;
} else if ($hsl_pil3_par1d < 15) {
    $hsl_pil3_par1d_rumus = 2;
} else if ($hsl_pil3_par1d < 20) {
    $hsl_pil3_par1d_rumus = 3;
} else {
    $hsl_pil3_par1d_rumus = 5;
}

$hsl_pil3_par1e = ($aba_tertinggi / $aba) * 100;

if ($hsl_pil3_par1e <= 30) {
    $hsl_pil3_par1e_rumus = 1;
} else if ($hsl_pil3_par1e <= 40) {
    $hsl_pil3_par1e_rumus = 2;
} else if ($hsl_pil3_par1e < 50) {
    $hsl_pil3_par1e_rumus = 3;
} else {
    $hsl_pil3_par1e_rumus = 4;
}









$ab = $ambang_batas_kredit['ap_per_ta'];
if ($p1 > $ab) {
    $hsl1 = 3;
} else {
    $hsl1 = 1;
}

//par1a
$aba = $ambang_batas_kredit['pbl_per_tap'];
$ab2a = $ambang_batas_kredit['rr_pbl_per_tap'];
$ab3a = $ambang_batas_kredit['rrr_pbl_per_tap'];
$ab4a = $ambang_batas_kredit['rrrr_pbl_per_tap'];
if ($p1a <= $aba) {
    $hsl1a = 1;
} else if ($p1a > $aba && $p1a <= $ab2a) {
    $hsl1a = 2;
} else if ($p1a > $ab2a && $p1a <= $ab3a) {
    $hsl1a = 3;
} elseif ($p1a > $ab3a && $p1a <= $ab4a) {
    $hsl1a = 4;
} else {
    $hsl1a = 5;
}


$nilai1a = $hsl1a * $bobot1;

//par1b
$abb = $ambang_batas_kredit['apbt_per_pbl'];
$ab2b = $ambang_batas_kredit['rr_apbt_per_pbl'];
$ab3b = $ambang_batas_kredit['rrr_apbt_per_pbl'];
$ab4b = $ambang_batas_kredit['rrrr_apbt_per_pbl'];
if ($p1b <= $abb) {
    $hsl1b = 1;
} else if ($p1b > $abb && $p1b <= $ab2b) {
    $hsl1b = 2;
} else if ($p1b > $ab2b && $p1b <= $ab3b) {
    $hsl1b = 3;
} elseif ($p1b > $ab3b && $p1b <= $ab4b) {
    $hsl1b = 4;
} else {
    $hsl1b = 5;
}


$nilai1b = $hsl1b * $bobot2;

//par1c
$abc = $ambang_batas_kredit['abapb_per_pbl'];
$ab2c = $ambang_batas_kredit['rr_abapb_per_pbl'];
$ab3c = $ambang_batas_kredit['rrr_abapb_per_pbl'];
$ab4c = $ambang_batas_kredit['rrrr_abapb_per_pbl'];
if ($p1c <= $abc) {
    $hsl1c = 1;
} else if ($plb > $abc && $plb <= $ab2c) {
    $hsl1c = 2;
} else if ($plb > $ab2c && $plb <= $ab3c) {
    $hsl1c = 3;
} elseif ($plb > $ab3c && $plb <= $ab4c) {
    $hsl1c = 4;
} else {
    $hsl1c = 5;
}


$nilai1c = $hsl1c * $bobot3;


//par1d
$para1_abd = $ambang_batas_kredit['nkp150_per_nkyd'];
$para1_ab2d = $ambang_batas_kredit['rr_nkp150_per_nkyd'];
$para1_ab3d = $ambang_batas_kredit['rrr_nkp150_per_nkyd'];
$para1_ab4d = $ambang_batas_kredit['rrrr_nkp150_per_nkyd'];
if ($p2f >= $para1_abd) {
    $hsl2f = 1;
} else if ($p2f < $para1_abd && $p2f >= $para1_ab2d) {
    $hsl2f = 2;
} else if ($p2f < $para1_ab2d && $p2f >= $para1_ab3d) {
    $hsl2f = 3;
} elseif ($p2f < $para1_ab3d && $p2f >= $para1_ab4d) {
    $hsl2f = 4;
} else {
    $hsl2f = 5;
}

$nilai2f = $hsl2f * $bobot4;


//par1e
$para2_abm = $ambang_batas_kredit['kpep_per_tkyd'];
$para2_ab2m = $ambang_batas_kredit['rr_kpep_per_tkyd'];
$para2_ab3m = $ambang_batas_kredit['rrr_kpep_per_tkyd'];
$para2_ab4m = $ambang_batas_kredit['rrrr_kpep_per_tkyd'];
if ($p2m <= $para2_abm) {
    $hsl2m = 1;
} else if ($p2m > $para2_abm && $p2m <= $para2_ab2m) {
    $hsl2m = 2;
} else if ($p2m > $para2_ab2m && $p2m <= $para2_ab3m) {
    $hsl2m = 3;
} elseif ($p2m > $para2_ab3m && $p2m <= $para2_ab4m) {
    $hsl2m = 4;
} else {
    $hsl2m = 5;
}

$nilai2m = $hsl2m * $bobot5;



//par1f
$para2_abn = $ambang_batas_kredit['kp350_per_tkyd'];
$para2_ab2n = $ambang_batas_kredit['rr_kp350_per_tkyd'];
$para2_ab3n = $ambang_batas_kredit['rrr_kp350_per_tkyd'];
$para2_ab4n = $ambang_batas_kredit['rrrr_kp350_per_tkydd'];
if ($p2n <= $para2_abn) {
    $hsl2n = 1;
} else if ($p2n > $para2_abn && $p2n <= $para2_ab2n) {
    $hsl2n = 2;
} else if ($p2n > $para2_ab2n && $p2n <= $para2_ab3n) {
    $hsl2n = 3;
} elseif ($p2n > $para2_ab3n && $p2n <= $para2_ab4n) {
    $hsl2n = 4;
} else {
    $hsl2n = 5;
}

$nilai2n = $hsl2n * $bobot6;


//par1g
$ab_pil2_par1a = $ambang_batas_kredit['sppap_per_tk'];
$ab_pil2_par12a = $ambang_batas_kredit['rr_sppap_per_tk'];
$ab_pil2_par13a = $ambang_batas_kredit['rrr_sppap_per_tk'];
$ab_pil2_par14a = $ambang_batas_kredit['rrrr_sppap_per_tk'];
if ($pilar2_p1a <= $ab_pil2_par1a) {
    $hsl_pil2_par1a = 1;
} else if ($pilar2_p1a > $ab_pil2_par1a && $pilar2_p1a <= $ab_pil2_par12a) {
    $hsl_pil2_par1a = 2;
} else if ($pilar2_p1a > $ab_pil2_par12a && $pilar2_p1a <= $ab_pil2_par13a) {
    $hsl_pil2_par1a = 3;
} elseif ($pilar2_p1a > $ab_pil2_par13a && $pilar2_p1a <= $ab_pil2_par14a) {
    $hsl_pil2_par1a = 4;
} else {
    $hsl_pil2_par1a = 5;
}


$nilai_pil2_par1a = $hsl_pil2_par1a * $bobot7;

//par1h
$ab_pil2_par1b = $ambang_batas_kredit['ayda_per_kyd'];
$ab_pil2_par12b = $ambang_batas_kredit['rr_ayda_per_kyd'];
$ab_pil2_par13b = $ambang_batas_kredit['rrr_ayda_per_kyd'];
$ab_pil2_par14b = $ambang_batas_kredit['rrrr_ayda_per_kyd'];
if ($pilar2_p1b <= $ab_pil2_par1b) {
    $hsl_pil2_par1b = 1;
} else if ($pilar2_p1b > $ab_pil2_par1b && $pilar2_p1b <= $ab_pil2_par12b) {
    $hsl_pil2_par1b = 2;
} else if ($pilar2_p1b > $ab_pil2_par12b && $pilar2_p1b <= $ab_pil2_par13b) {
    $hsl_pil2_par1b = 3;
} elseif ($pilar2_p1b > $ab_pil2_par13b && $pilar2_p1b <= $ab_pil2_par14b) {
    $hsl_pil2_par1b = 4;
} else {
    $hsl_pil2_par1b = 5;
}


$nilai_pil2_par1b = $hsl_pil2_par1b * $bobot8;




$koreksi = $nilai1a + $nilai1b + $nilai1c + $nilai2f + $nilai2m + $nilai2n + $nilai_pil2_par1a + $nilai_pil2_par1b;


if ($hsl1 == 3) {
    $nilai = $hsl1;
} else {
    $nilai = ($hsl1 + $koreksi) / 2;
}






//pil2




$para2_ab = $ambang_batas_kredit['kyd_per_ap'];
if ($p2 <= $para2_ab) {
    $hsl2 = 1;
} else {
    $hsl2 = 0;
}

//par2a
$para2_aba = $ambang_batas_kredit['kspg_per_tk'];
$para2_ab2a = $ambang_batas_kredit['rr_kspg_per_tk'];
$para2_ab3a = $ambang_batas_kredit['rrr_kspg_per_tk'];
$para2_ab4a = $ambang_batas_kredit['rrrr_kspg_per_tk'];
if ($p2a <= $para2_aba) {
    $hsl2a = 1;
} else if ($p2a > $para2_aba && $p2a <= $para2_ab2a) {
    $hsl2a = 2;
} else if ($p2a > $para2_ab2a && $p2a <= $para2_ab3a) {
    $hsl2a = 3;
} elseif ($p2a > $para2_ab3a && $p2a <= $para2_ab4a) {
    $hsl2a = 4;
} else {
    $hsl2a = 5;
}


$nilai2a = $hsl2a * $bobot2_1;

//par2b
$para2_abb = $ambang_batas_kredit['km_per_tkyd'];
$para2_ab2b = $ambang_batas_kredit['rr_km_per_tkyd'];
$para2_ab3b = $ambang_batas_kredit['rrr_km_per_tkyd'];
$para2_ab4b = $ambang_batas_kredit['rrrr_km_per_tkyd'];
if ($p2b <= $para2_abb) {
    $hsl2b = 1;
} else if ($p2b > $para2_abb && $p2b <= $para2_ab2b) {
    $hsl2b = 2;
} else if ($p2b > $para2_ab2b && $p2b <= $para2_ab3b) {
    $hsl2b = 3;
} elseif ($p2b > $para2_ab3b && $p2b <= $para2_ab4b) {
    $hsl2b = 4;
} else {
    $hsl2b = 5;
}


$nilai2b = $hsl2b * $bobot2_2;

//par2c
$para2_abc = $ambang_batas_kredit['kjpen_per_tkyd'];
$para2_ab2c = $ambang_batas_kredit['rr_kjpen_per_tkyd'];
$para2_ab3c = $ambang_batas_kredit['rrr_kjpen_per_tkyd'];
$para2_ab4c = $ambang_batas_kredit['rrrr_kjpen_per_tkyd'];
if ($p2c >= $para2_abc) {
    $hsl2c = 1;
} else if ($p2c < $para2_abc && $p2c >= $para2_ab2c) {
    $hsl2c = 2;
} else if ($p2c < $para2_ab2c && $p2c >= $para2_ab3c) {
    $hsl2c = 3;
} elseif ($p2c < $para2_ab3c && $p2c >= $para2_ab4c) {
    $hsl2c = 4;
} else {
    $hsl2c = 5;
}


$nilai2c = $hsl2c * $bobot2_3;



//par2d
$para2_abd = $ambang_batas_kredit['kjm_per_tkyd'];
$para2_ab2d = $ambang_batas_kredit['rr_kjm_per_tkyd'];
$para2_ab3d = $ambang_batas_kredit['rrr_kjm_per_tkyd'];
$para2_ab4d = $ambang_batas_kredit['rrrr_kjm_per_tkyd'];
if ($p2d <= $para2_abd) {
    $hsl2d = 1;
} else if ($p2d > $para2_abd && $p2d <= $para2_ab2d) {
    $hsl2d = 2;
} else if ($p2d > $para2_ab2d && $p2d <= $para2_ab3d) {
    $hsl2d = 3;
} elseif ($p2d > $para2_ab3d && $p2d <= $para2_ab4d) {
    $hsl2d = 4;
} else {
    $hsl2d = 5;
}


$nilai2d = $hsl2d * $bobot2_4;


//par2e
$para2_abe = $ambang_batas_kredit['kjpan_per_tkyd'];
$para2_ab2e = $ambang_batas_kredit['rr_kjpan_per_tkyd'];
$para2_ab3e = $ambang_batas_kredit['rrr_kjpan_per_tkyd'];
$para2_ab4e = $ambang_batas_kredit['rrrr_kjpan_per_tkyd'];
if ($p2e <= $para2_abe) {
    $hsl2e = 1;
} else if ($p2e > $para2_abe && $p2e <= $para2_ab2e) {
    $hsl2e = 2;
} else if ($p2e > $para2_ab2e && $p2e <= $para2_ab3e) {
    $hsl2e = 3;
} elseif ($p2e > $para2_ab3e && $p2e <= $para2_ab4e) {
    $hsl2e = 4;
} else {
    $hsl2e = 5;
}


$nilai2e = $hsl2e * $bobot2_5;







//par2g
$para2_abg = $ambang_batas_kredit['kdatdb_per_tkyd'];
$para2_ab2g = $ambang_batas_kredit['rr_kdatdb_per_tkyd'];
$para2_ab3g = $ambang_batas_kredit['rrr_kdatdb_per_tkyd'];
$para2_ab4g = $ambang_batas_kredit['rrrr_kdatdb_per_tkyd'];
if ($p2g >= $para2_abg) {
    $hsl2g = 1;
} else if ($p2g < $para2_abg && $p2g >= $para2_ab2g) {
    $hsl2g = 2;
} else if ($p2g < $para2_ab2g && $p2g >= $para2_ab3g) {
    $hsl2g = 3;
} elseif ($p2g < $para2_ab3g && $p2g >= $para2_ab4g) {
    $hsl2g = 4;
} else {
    $hsl2g = 5;
}

$nilai2g = $hsl2g * $bobot2_6;


//par2h
$para2_abh = $ambang_batas_kredit['kak_per_tkyd'];
$para2_ab2h = $ambang_batas_kredit['rr_kak_per_tkyd'];
$para2_ab3h = $ambang_batas_kredit['rrr_kak_per_tkyd'];
$para2_ab4h = $ambang_batas_kredit['rrrr_kak_per_tkyd'];
if ($p2h <= $para2_abh) {
    $hsl2h = 1;
} else if ($p2h > $para2_abh && $p2h <= $para2_ab2h) {
    $hsl2h = 2;
} else if ($p2h > $para2_ab2h && $p2h <= $para2_ab3h) {
    $hsl2h = 3;
} elseif ($p2h > $para2_ab3h && $p2h <= $para2_ab4h) {
    $hsl2h = 4;
} else {
    $hsl2h = 5;
}

$nilai2h = $hsl2h * $bobot2_7;


//par2i
$para2_abi = $ambang_batas_kredit['kakr2_per_tkyd'];
$para2_ab2i = $ambang_batas_kredit['rr_kakr2_per_tkyd'];
$para2_ab3i = $ambang_batas_kredit['rrr_kakr2_per_tkyd'];
$para2_ab4i = $ambang_batas_kredit['rrrr_kakr2_per_tkyd'];
if ($p2i <= $para2_abi) {
    $hsl2i = 1;
} else if ($p2i > $para2_abi && $p2i <= $para2_ab2i) {
    $hsl2i = 2;
} else if ($p2i > $para2_ab2i && $p2i <= $para2_ab3i) {
    $hsl2i = 3;
} elseif ($p2i > $para2_ab3i && $p2i <= $para2_ab4i) {
    $hsl2i = 4;
} else {
    $hsl2i = 5;
}

$nilai2i = $hsl2i * $bobot2_8;


//par2j
$para2_abj = $ambang_batas_kredit['opk_per_tkyd'];
$para2_ab2j = $ambang_batas_kredit['rr_opk_per_tkyd'];
$para2_ab3j = $ambang_batas_kredit['rrr_opk_per_tkyd'];
$para2_ab4j = $ambang_batas_kredit['rrrr_opk_per_tkyd'];
if ($p2j <= $para2_abj) {
    $hsl2j = 1;
} else if ($p2j > $para2_abj && $p2j <= $para2_ab2j) {
    $hsl2j = 2;
} else if ($p2j > $para2_ab2j && $p2j <= $para2_ab3j) {
    $hsl2j = 3;
} elseif ($p2j > $para2_ab3j && $p2j <= $para2_ab4j) {
    $hsl2j = 4;
} else {
    $hsl2j = 5;
}

$nilai2j = $hsl2j * $bobot2_9;



//par2k
$para2_abk = $ambang_batas_kredit['kta_per_tkyd'];
$para2_ab2k = $ambang_batas_kredit['rr_kta_per_tkyd'];
$para2_ab3k = $ambang_batas_kredit['rrr_kta_per_tkyd'];
$para2_ab4k = $ambang_batas_kredit['rrrr_kta_per_tkyd'];
if ($p2k <= $para2_abk) {
    $hsl2k = 1;
} else if ($p2k > $para2_abk && $p2k <= $para2_ab2k) {
    $hsl2k = 2;
} else if ($p2k > $para2_ab2k && $p2k <= $para2_ab3k) {
    $hsl2k = 3;
} elseif ($p2k > $para2_ab3k && $p2k <= $para2_ab4k) {
    $hsl2k = 4;
} else {
    $hsl2k = 5;
}

$nilai2k = $hsl2k * $bobot2_10;

//par2l
$para2_abl = $ambang_batas_kredit['kknp_per_tkyd'];
$para2_ab2l = $ambang_batas_kredit['rr_kknp_per_tkyd'];
$para2_ab3l = $ambang_batas_kredit['rrr_kknp_per_tkyd'];
$para2_ab4l = $ambang_batas_kredit['rrrr_kknp_per_tkyd'];
if ($p2l <= $para2_abl) {
    $hsl2l = 1;
} else if ($p2l > $para2_abl && $p2l <= $para2_ab2l) {
    $hsl2l = 2;
} else if ($p2l > $para2_ab2l && $p2l <= $para2_ab3l) {
    $hsl2l = 3;
} elseif ($p2l > $para2_ab3l && $p2l <= $para2_ab4l) {
    $hsl2l = 4;
} else {
    $hsl2l = 5;
}

$nilai2l = $hsl2l * $bobot2_11;



$koreksi2 = $nilai2a + $nilai2b + $nilai2c + $nilai2d + $nilai2e  + $nilai2g + $nilai2h + $nilai2i + $nilai2j
    + $nilai2k + $nilai2l;


if ($hsl2 == 0) {
    $nilai2 = $koreksi2;
} else {
    $nilai2 = ($hsl2 + $koreksi2) / 2;
}






//par 3
$para3_ab = $ambang_batas_kredit['di25_per_tk'];
if ($p3 > $para3_ab) {
    $hsl3 = 0;
} else {
    $hsl3 = 1;
}

//par 4
$para4_ab = $ambang_batas_kredit['kpse_per_tk'];
if ($p4 > $para4_ab) {
    $hsl4 = 0;
} else {
    $hsl4 = 1;
}











//--Parameter 1 PILAR2





$ab_pil2_par1 = $ambang_batas_kredit['apb_per_tap'];
$ab2_pil2_par1 = $ambang_batas_kredit['rr_apb_per_tap'];
$ab3_pil2_par1 = $ambang_batas_kredit['rrr_apb_per_tap'];
$ab4_pil2_par1 = $ambang_batas_kredit['rrrr_apb_per_tap'];


if ($pilar2_p1 == 0) {
    $hsl_pil2_par1 = 0;
} else if ($pilar2_p1 <= $ab_pil2_par1) {
    $hsl_pil2_par1 = 1;
} else if ($pilar2_p1 > $ab_pil2_par1 && $pilar2_p1 <= $ab2_pil2_par1) {
    $hsl_pil2_par1 = 2;
} else if ($pilar2_p1 > $ab2_pil2_par1 && $pilar2_p1 <= $ab3_pil2_par1) {
    $hsl_pil2_par1 = 3;
} elseif ($pilar2_p1 > $ab3_pil2_par1 && $pilar2_p1 <= $ab4_pil2_par1) {
    $hsl_pil2_par1 = 4;
} else {
    $hsl_pil2_par1 = 5;
}


$nilai_pil2_par1 = $hsl_pil2_par1;














//Parameter 2 PILAR2-





$ab_pil2_par2 = $ambang_batas_kredit['kbn_per_tk'];
$ab2_pil2_par2 = $ambang_batas_kredit['rr_kbn_per_tk'];
$ab3_pil2_par2 = $ambang_batas_kredit['rrr_kbn_per_tk'];
$ab4_pil2_par2 = $ambang_batas_kredit['rrrr_kbn_per_tk'];

if ($pilar2_p2 == 0) {
    $hsl_pil2_par2 = 0;
} else if ($pilar2_p2 <= $ab_pil2_par2) {
    $hsl_pil2_par2 = 1;
} else if ($pilar2_p2 > $ab_pil2_par2 && $pilar2_p2 <= $ab2_pil2_par2) {
    $hsl_pil2_par2 = 2;
} else if ($pilar2_p2 > $ab2_pil2_par2 && $pilar2_p2 <= $ab3_pil2_par2) {
    $hsl_pil2_par2 = 3;
} elseif ($pilar2_p2 > $ab3_pil2_par2 && $pilar2_p2 <= $ab4_pil2_par2) {
    $hsl_pil2_par2 = 4;
} else {
    $hsl_pil2_par2 = 5;
}

//par2a
$ab_pil2_par2a = $ambang_batas_kredit['nkp150_per_tkp150'];
$ab_pil2_par22a = $ambang_batas_kredit['rr_nkp150_per_tkp150'];
$ab_pil2_par23a = $ambang_batas_kredit['rrr_nkp150_per_tkp150'];
$ab_pil2_par24a = $ambang_batas_kredit['rrrr_nkp150_per_tkp150'];
if ($pilar2_p2a <= $ab_pil2_par2a) {
    $hsl_pil2_par2a = 1;
} else if ($pilar2_p2a > $ab_pil2_par2a && $pilar2_p2a <= $ab_pil2_par22a) {
    $hsl_pil2_par2a = 2;
} else if ($pilar2_p2a > $ab_pil2_par22a && $pilar2_p2a <= $ab_pil2_par23a) {
    $hsl_pil2_par2a = 3;
} elseif ($pilar2_p2a > $ab_pil2_par23a && $pilar2_p2a <= $ab_pil2_par24a) {
    $hsl_pil2_par2a = 4;
} else {
    $hsl_pil2_par2a = 5;
}


$nilai_pil2_par2a = $hsl_pil2_par2a * $bobot3_1;

//par2b
$ab_pil2_par2b = $ambang_batas_kredit['nkpd50_per_tkpd50'];
$ab_pil2_par22b = $ambang_batas_kredit['rr_nkpd50_per_tkpd50'];
$ab_pil2_par23b = $ambang_batas_kredit['rrr_nkpd50_per_tkpd50'];
$ab_pil2_par24b = $ambang_batas_kredit['rrrr_nkpd50_per_tkpd50'];
if ($pilar2_p2b <= $ab_pil2_par2b) {
    $hsl_pil2_par2b = 1;
} else if ($pilar2_p2b > $ab_pil2_par2b && $pilar2_p2b <= $ab_pil2_par22b) {
    $hsl_pil2_par2b = 2;
} else if ($pilar2_p2b > $ab_pil2_par22b && $pilar2_p2b <= $ab_pil2_par23b) {
    $hsl_pil2_par2b = 3;
} elseif ($pilar2_p2b > $ab_pil2_par23b && $pilar2_p2b <= $ab_pil2_par24b) {
    $hsl_pil2_par2b = 4;
} else {
    $hsl_pil2_par2b = 5;
}


$nilai_pil2_par2b = $hsl_pil2_par2b * $bobot3_2;

//par2c
$ab_pil2_par2c = $ambang_batas_kredit['nkdpapht_prt_tkyd'];
$ab_pil2_par22c = $ambang_batas_kredit['rr_nkdpapht_prt_tkyd'];
$ab_pil2_par23c = $ambang_batas_kredit['rrr_nkdpapht_prt_tkyd'];
$ab_pil2_par24c = $ambang_batas_kredit['rrrr_nkdpapht_prt_tkyd'];
if ($pilar2_p2c <= $ab_pil2_par2c) {
    $hsl_pil2_par2c = 1;
} else if ($pilar2_p2c > $ab_pil2_par2c && $pilar2_p2c <= $ab_pil2_par22c) {
    $hsl_pil2_par2c = 2;
} else if ($pilar2_p2c > $ab_pil2_par22c && $pilar2_p2c <= $ab_pil2_par23c) {
    $hsl_pil2_par2c = 3;
} elseif ($pilar2_p2c > $ab_pil2_par23c && $pilar2_p2c <= $ab_pil2_par24c) {
    $hsl_pil2_par2c = 4;
} else {
    $hsl_pil2_par2c = 5;
}


$nilai_pil2_par2c = $hsl_pil2_par2c * $bobot3_3;




//par2d
$ab_pil2_par2d = $ambang_batas_kredit['nkdpskmht_per_tkyd'];
$ab_pil2_par22d = $ambang_batas_kredit['rr_nkdpskmht_per_tkyd'];
$ab_pil2_par23d = $ambang_batas_kredit['rrr_nkdpskmht_per_tkyd'];
$ab_pil2_par24d = $ambang_batas_kredit['rrrr_nkdpskmht_per_tkyd'];
if ($pilar2_p2d <= $ab_pil2_par2d) {
    $hsl_pil2_par2d = 1;
} else if ($pilar2_p2d > $ab_pil2_par2d && $pilar2_p2d <= $ab_pil2_par22d) {
    $hsl_pil2_par2d = 2;
} else if ($pilar2_p2d > $ab_pil2_par22d && $pilar2_p2d <= $ab_pil2_par23d) {
    $hsl_pil2_par2d = 3;
} elseif ($pilar2_p2d > $ab_pil2_par23d && $pilar2_p2d <= $ab_pil2_par24d) {
    $hsl_pil2_par2d = 4;
} else {
    $hsl_pil2_par2d = 5;
}


$nilai_pil2_par2d = $hsl_pil2_par2d * $bobot3_4;



//par2e
$ab_pil2_par2e = $ambang_batas_kredit['nalrdbd_per_tknalrdbd'];
$ab_pil2_par22e = $ambang_batas_kredit['rr_nalrdbd_per_tknalrdbd'];
$ab_pil2_par23e = $ambang_batas_kredit['rrr_nalrdbd_per_tknalrdbd'];
$ab_pil2_par24e = $ambang_batas_kredit['rrrr_nalrdbd_per_tknalrdbd'];
if ($pilar2_p2e <= $ab_pil2_par2e) {
    $hsl_pil2_par2e = 1;
} else if ($pilar2_p2e > $ab_pil2_par2e && $pilar2_p2e <= $ab_pil2_par22e) {
    $hsl_pil2_par2e = 2;
} else if ($pilar2_p2e > $ab_pil2_par22e && $pilar2_p2e <= $ab_pil2_par23e) {
    $hsl_pil2_par2e = 3;
} elseif ($pilar2_p2e > $ab_pil2_par23e && $pilar2_p2e <= $ab_pil2_par24e) {
    $hsl_pil2_par2e = 4;
} else {
    $hsl_pil2_par2e = 5;
}


$nilai_pil2_par2e = $hsl_pil2_par2e * $bobot3_5;




//par2f
$ab_pil2_par2f = $ambang_batas_kredit['kmsjt_per_tkyd'];
$ab_pil2_par22f = $ambang_batas_kredit['rr_kmsjt_per_tkyd'];
$ab_pil2_par23f = $ambang_batas_kredit['rrr_kmsjt_per_tkyd'];
$ab_pil2_par24f = $ambang_batas_kredit['rrrr_kmsjt_per_tkyd'];
if ($pilar2_p2f <= $ab_pil2_par2f) {
    $hsl_pil2_par2f = 1;
} else if ($pilar2_p2f > $ab_pil2_par2f && $pilar2_p2f <= $ab_pil2_par22f) {
    $hsl_pil2_par2f = 2;
} else if ($pilar2_p2f > $ab_pil2_par22f && $pilar2_p2f <= $ab_pil2_par23f) {
    $hsl_pil2_par2f = 3;
} elseif ($pilar2_p2f > $ab_pil2_par23f && $pilar2_p2f <= $ab_pil2_par24f) {
    $hsl_pil2_par2f = 4;
} else {
    $hsl_pil2_par2f = 5;
}


$nilai_pil2_par2f = $hsl_pil2_par2f * $bobot3_6;






$koreksi_pil2_par2 = $nilai_pil2_par2a + $nilai_pil2_par2b + $nilai_pil2_par2c + $nilai_pil2_par2d + $nilai_pil2_par2e + $nilai_pil2_par2f;


if ($hsl_pil2_par2 == 0) {
    $nilai_pil2_par2 = $koreksi_pil2_par2;
} else {
    $nilai_pil2_par2 = ($hsl_pil2_par2 + $koreksi_pil2_par2) / 2;
}












//-Parameter 3 PILAR2




$ab_pil2_par3 = $ambang_batas_kredit['kkr_per_tk'];
$ab2_pil2_par3 = $ambang_batas_kredit['rr_kkr_per_tk'];
$ab3_pil2_par3 = $ambang_batas_kredit['rrr_kkr_per_tk'];
$ab4_pil2_par3 = $ambang_batas_kredit['rrrr_kkr_per_tk'];

if ($pilar2_p3 == 0) {
    $hsl_pil2_par3 = 0;
} else if ($pilar2_p3 <= $ab_pil2_par3) {
    $hsl_pil2_par3 = 1;
} else if ($pilar2_p3 > $ab_pil2_par3 && $pilar2_p3 <= $ab2_pil2_par3) {
    $hsl_pil2_par3 = 2;
} else if ($pilar2_p3 > $ab2_pil2_par3 && $pilar2_p3 <= $ab3_pil2_par3) {
    $hsl_pil2_par3 = 3;
} elseif ($pilar2_p3 > $ab3_pil2_par3 && $pilar2_p3 <= $ab4_pil2_par3) {
    $hsl_pil2_par3 = 4;
} else {
    $hsl_pil2_par3 = 5;
}

//par3a
$ab_pil2_par3a = $ambang_batas_kredit['kp4_per_tkyd'];
$ab_pil2_par32a = $ambang_batas_kredit['rr_kp4_per_tkyd'];
$ab_pil2_par33a = $ambang_batas_kredit['rrr_kp4_per_tkyd'];
$ab_pil2_par34a = $ambang_batas_kredit['rrrr_kp4_per_tkyd'];
if ($pilar2_p3a <= $ab_pil2_par3a) {
    $hsl_pil2_par3a = 1;
} else if ($pilar2_p3a > $ab_pil2_par3a && $pilar2_p3a <= $ab_pil2_par32a) {
    $hsl_pil2_par3a = 2;
} else if ($pilar2_p3a > $ab_pil2_par32a && $pilar2_p3a <= $ab_pil2_par33a) {
    $hsl_pil2_par3a = 3;
} elseif ($pilar2_p3a > $ab_pil2_par33a && $pilar2_p3a <= $ab_pil2_par34a) {
    $hsl_pil2_par3a = 4;
} else {
    $hsl_pil2_par3a = 5;
}


$nilai_pil2_par3a = $hsl_pil2_par3a * $bobot4_1;

//par3b
$ab_pil2_par3b = $ambang_batas_kredit['kdp3p4_per_tkyd'];
$ab_pil2_par32b = $ambang_batas_kredit['rr_kdp3p4_per_tkyd'];
$ab_pil2_par33b = $ambang_batas_kredit['rrr_kdp3p4_per_tkyd'];
$ab_pil2_par34b = $ambang_batas_kredit['rrrr_kdp3p4_per_tkyd'];
if ($pilar2_p3b <= $ab_pil2_par3b) {
    $hsl_pil2_par3b = 1;
} else if ($pilar2_p3b > $ab_pil2_par3b && $pilar2_p3b <= $ab_pil2_par32b) {
    $hsl_pil2_par3b = 2;
} else if ($pilar2_p3b > $ab_pil2_par32b && $pilar2_p3b <= $ab_pil2_par33b) {
    $hsl_pil2_par3b = 3;
} elseif ($pilar2_p3b > $ab_pil2_par33b && $pilar2_p3b <= $ab_pil2_par34b) {
    $hsl_pil2_par3b = 4;
} else {
    $hsl_pil2_par3b = 5;
}


$nilai_pil2_par3b = $hsl_pil2_par3b * $bobot4_2;

//par3c
$ab_pil2_par3c = $ambang_batas_kredit['nf6bt_per_ne6bt'];
$ab_pil2_par32c = $ambang_batas_kredit['rr_nf6bt_per_ne6bt'];
$ab_pil2_par33c = $ambang_batas_kredit['rrr_nf6bt_per_ne6bt'];
$ab_pil2_par34c = $ambang_batas_kredit['rrrr_nf6bt_per_ne6bt'];
if ($pilar2_p3c <= $ab_pil2_par3c) {
    $hsl_pil2_par3c = 1;
} else if ($pilar2_p3c > $ab_pil2_par3c && $pilar2_p3c <= $ab_pil2_par32c) {
    $hsl_pil2_par3c = 2;
} else if ($pilar2_p3c > $ab_pil2_par32c && $pilar2_p3c <= $ab_pil2_par33c) {
    $hsl_pil2_par3c = 3;
} elseif ($pilar2_p3c > $ab_pil2_par33c && $pilar2_p3c <= $ab_pil2_par34c) {
    $hsl_pil2_par3c = 4;
} else {
    $hsl_pil2_par3c = 5;
}


$nilai_pil2_par3c = $hsl_pil2_par3c * $bobot4_3;




//par3d
$ab_pil2_par3d = $ambang_batas_kredit['nomf6bt_per_pe6bt'];
$ab_pil2_par32d = $ambang_batas_kredit['rr_nomf6bt_per_pe6bt'];
$ab_pil2_par33d = $ambang_batas_kredit['rrr_nomf6bt_per_pe6bt'];
$ab_pil2_par34d = $ambang_batas_kredit['rrrr_nomf6bt_per_pe6bt'];
if ($pilar2_p3d <= $ab_pil2_par3d) {
    $hsl_pil2_par3d = 1;
} else if ($pilar2_p3d > $ab_pil2_par3d && $pilar2_p3d <= $ab_pil2_par32d) {
    $hsl_pil2_par3d = 2;
} else if ($pilar2_p3d > $ab_pil2_par32d && $pilar2_p3d <= $ab_pil2_par33d) {
    $hsl_pil2_par3d = 3;
} elseif ($pilar2_p3d > $ab_pil2_par33d && $pilar2_p3d <= $ab_pil2_par34d) {
    $hsl_pil2_par3d = 4;
} else {
    $hsl_pil2_par3d = 5;
}


$nilai_pil2_par3d = $hsl_pil2_par3d * $bobot4_4;









$koreksi_pil2_par3 = $nilai_pil2_par3a + $nilai_pil2_par3b + $nilai_pil2_par3c + $nilai_pil2_par3d;


if ($hsl_pil2_par3 == 0) {
    $nilai_pil2_par3 = $koreksi_pil2_par3;
} else if ($koreksi_pil2_par3 < $hsl_pil2_par3) {
    $nilai_pil2_par3 = $hsl_pil2_par3;
} else {
    $nilai_pil2_par3 = ($hsl_pil2_par3 + $koreksi_pil2_par3) / 2;
}


//rumus hasil pilar 2
$hsl_max_pil2 = array($nilai_pil2_par1, $nilai_pil2_par2, $nilai_pil2_par3);
$pil2_tertinggi = max($hsl_max_pil2);

$hsl_min_pil2 = array($nilai_pil2_par1, $nilai_pil2_par2, $nilai_pil2_par3);
$pil2_terendah = min($hsl_min_pil2);

$hsl_avg_pil2 = array($nilai_pil2_par1, $nilai_pil2_par2, $nilai_pil2_par3);
$sum = array_sum($hsl_avg_pil2);
$pil2_rata_rata = $sum / count($hsl_avg_pil2);

if ($set_pil2 == 1) {

    $pil2_tingkat_risiko = $pil2_tertinggi ;
} else if ($set_pil2 == 2) {

    $pil2_tingkat_risiko = $pil2_terendah;
} else if ($set_pil2 == 3) {

    $pil2_tingkat_risiko = $pil2_rata_rata;
} else {
$pil2_tingkat_risiko = 0;
}











if (isset($_POST['submit'])) {
    include "../conn/conn.php";



//p1
    $hasil_pil1_par1 = $nilai;
    $hasil_pil1_par1a = $nilai1a;
    $hasil_pil1_par1b = $nilai1b;
    $hasil_pil1_par1c = $nilai1c;
    $hasil_pil1_par1d = $nilai2f;
    $hasil_pil1_par1e = $nilai2m;
    $hasil_pil1_par1f = $nilai2n;
    $hasil_pil1_par1g = $nilai_pil2_par1a;
    $hasil_pil1_par1h = $nilai_pil2_par1b;
    $hasil_pil1_par2 = $nilai2;
    $hasil_pil1_par2a = $nilai2a;
    $hasil_pil1_par2b = $nilai2b;
    $hasil_pil1_par2c = $nilai2c;
    $hasil_pil1_par2d = $nilai2d;
    $hasil_pil1_par2e = $nilai2e;
    $hasil_pil1_par2f = $nilai2g;
    $hasil_pil1_par2g = $nilai2h;
    $hasil_pil1_par2h = $nilai2i;
    $hasil_pil1_par2i = $nilai2j;
    $hasil_pil1_par2j = $nilai2k;
    $hasil_pil1_par2k = $nilai2l;
    $pilar1_3 = $_POST['target_pasar1'];
    $hasil_pil1_par3 = $_POST['nilaippl1_par3'];
    $pilar1_4 = $_POST['sektor_terbesar3'];
    $hasil_pil1_par4 = $_POST['nilaippl1_par4'];

    //p2


    //p3
    $pilar3_1 = $_POST['penyaluran_kredit'];
    $pilar3_1a = $_POST['penyaluran_kredit2'];
    $pilar3_1b = $_POST['penyaluran_kredit3'];
    $pilar3_1c = $_POST['penyaluran_kredit3_5'];
    $pilar3_1d = $_POST['penyaluran_kredit4'];
    $pilar3_1e = $_POST['penyaluran_kredit5'];
    $hasil_pil3_par1 = $_POST['nilaippl3_par1'];
    $hasil_pil3_par1a = $_POST['nilaippl3_par1a'];
    $hasil_pil3_par1b = $_POST['nilaippl3_par1b'];
    $hasil_pil3_par1c = $_POST['nilaippl3_par1c'];
    $hasil_pil3_par1d = $_POST['nilaippl3_par1d'];
    $hasil_pil3_par1e = $_POST['nilaippl3_par1e'];

    //p4
    $pilar4_1a = $_POST['pilar4_1a'];
    $pilar4_1b = $_POST['pilar4_1b'];
    $pilar4_1c = $_POST['pilar4_1c'];
    $pilar4_1d = $_POST['pilar4_1d'];
    $hasil_pil4_par1 = $_POST['risiko_pil4'];
    $hasil_pil4_par1a = $_POST['nilaippl4_par1a'];
    $hasil_pil4_par1b = $_POST['nilaippl4_par1b'];
    $hasil_pil4_par1c = $_POST['nilaippl4_par1c'];
    $hasil_pil4_par1d = $_POST['nilaippl4_par1d'];
    
    //lainnya
    $pilar5_1a = $_POST['pilar5_1a'];
    $pilar5_1b = $_POST['pilar5_1b'];
    $pilar5_1c = $_POST['pilar5_1c'];
    $pilar5_1d = $_POST['pilar5_1d'];
    $pilar5_1e = $_POST['pilar5_1e'];
    $pilar5_1f = $_POST['pilar5_1f'];
    $pilar5_1g = $_POST['pilar5_1g'];
    $pilar5_1h = $_POST['pilar5_1h'];
    $pilar5_1i = $_POST['pilar5_1i'];
    $pilar5_1j = $_POST['pilar5_1j'];
    $pilar5_1k = $_POST['pilar5_1k'];
    $hasil_pil5_par1 = $_POST['risiko_pil5'];
    $hasil_pil5_par1a = $_POST['nilaippl5_par1a'];
    $hasil_pil5_par1b = $_POST['nilaippl5_par1b'];
    $hasil_pil5_par1c = $_POST['nilaippl5_par1c'];
    $hasil_pil5_par1d = $_POST['nilaippl5_par1d'];
    $hasil_pil5_par1e = $_POST['nilaippl5_par1e'];
    $hasil_pil5_par1f = $_POST['nilaippl5_par1f'];
    $hasil_pil5_par1g = $_POST['nilaippl5_par1g'];
    $hasil_pil5_par1h = $_POST['nilaippl5_par1h'];
    $hasil_pil5_par1i = $_POST['nilaippl5_par1i'];
    $hasil_pil5_par1j = $_POST['nilaippl5_par1j'];
    $hasil_pil5_par1k = $_POST['nilaippl5_par1k'];

//hasil
    $pil1_tertinggi = $_POST['tertinggi_pil1'];
    $pil1_terendah = $_POST['terendah_pil1'];
    $pil1_rata_rata = $_POST['rata_rata_pil1'];
    $pil1_risiko_ditetapkan = $set_pil1;
    $pil1_tingkat_risiko = $_POST['risiko_pil1'];
    $pil2_tertinggi = $_POST['pilar2_max'];
    $pil2_terendah = $_POST['pilar2_min'];
    $pil2_rata_rata = $_POST['pilar2_avg'];
    $pil2_risiko_ditetapkan = $set_pil2;
    $pil2_tingkat_risiko = $_POST['pil2_tingkat_risiko'];
    $pil3_tertinggi = $_POST['tertinggi_pil3'];
    $pil3_terendah = $_POST['terendah_pil3'];
    $pil3_rata_rata = $_POST['rata_rata_pil3'];
    $pil3_risiko_ditetapkan = $set_pil3;
    $pil3_tingkat_risiko = $_POST['risiko_pil3'];
    $pil4_tertinggi = $_POST['tertinggi_pil4'];
    $pil4_terendah = $_POST['terendah_pil4'];
    $pil4_rata_rata = $_POST['rata_rata_pil4'];
    $pil4_tingkat_risiko = $_POST['risiko_pil4'];
    $pil5_tertinggi = $_POST['tertinggi_pil5'];
    $pil5_terendah = $_POST['terendah_pil5'];
    $pil5_rata_rata = $_POST['rata_rata_pil5'];
    $pil5_tingkat_risiko = $_POST['risiko_pil5'];
    $hasil_inheren_tertinggi = $_POST['tertinggi_inheren'];
    $hasil_inheren_terendah = $_POST['terendah_inheren'];
    $hasil_inheren_rata_rata = $_POST['rata_rata_inheren'];
    $hasil_risiko_ditetapkan = $set_tingkat_risiko;
    $hasil_tingkat_risiko = $_POST['risiko_inheren'];
    $hasil_peringkat = $_POST['peringkat_inheren'];

    //ket
    $ket_pil1_1 = $_POST['ket_pil1_1'];
    $ket_pil1_2 = $_POST['ket_pil1_2'];
    $ket_pil1_3 = $_POST['ket_pil1_3'];
    $ket_pil1_4 = $_POST['ket_pil1_4'];
    $ket_pil1 = $_POST['ket_pil1'];
    $ket_pil2_1 = $_POST['ket_pil2_1'];
    $ket_pil2_2 = $_POST['ket_pil2_2'];
    $ket_pil2_3 = $_POST['ket_pil2_3'];
    $ket_pil2 = $_POST['ket_pil2'];
    $ket_pil3_1 = $_POST['ket_pil3_1'];
    $ket_pil3 = $_POST['ket_pil3'];
    $ket_pil4_1 = $_POST['ket_pil4_1'];
    $ket_pil4 = $_POST['ket_pil4'];
    $ket_pil5_1 = $_POST['ket_pil5_1'];
    $ket_pil5 = $_POST['ket_pil5'];
    $ket_inheren = $_POST['ket_inheren'];




    mysqli_query($conn, "UPDATE inheren_kredit_pilar1 SET 
        hasil_pil1_par1 = '$hasil_pil1_par1',
        hasil_pil1_par1a = '$hasil_pil1_par1a',
        hasil_pil1_par1b = '$hasil_pil1_par1b',
        hasil_pil1_par1c = '$hasil_pil1_par1c',
        hasil_pil1_par1d = '$hasil_pil1_par1d',
        hasil_pil1_par1e = '$hasil_pil1_par1e',
        hasil_pil1_par1f = '$hasil_pil1_par1f',
        hasil_pil1_par1g = '$hasil_pil1_par1g',
        hasil_pil1_par1h = '$hasil_pil1_par1h',
        hasil_pil1_par2 = '$hasil_pil1_par2',
        hasil_pil1_par2a = '$hasil_pil1_par2a',
        hasil_pil1_par2b = '$hasil_pil1_par2b',
        hasil_pil1_par2c = '$hasil_pil1_par2c',
        hasil_pil1_par2d = '$hasil_pil1_par2d',
        hasil_pil1_par2e = '$hasil_pil1_par2e',
        hasil_pil1_par2f = '$hasil_pil1_par2f',
        hasil_pil1_par2g = '$hasil_pil1_par2g',
        hasil_pil1_par2h = '$hasil_pil1_par2h',
        hasil_pil1_par2i = '$hasil_pil1_par2i',
        hasil_pil1_par2j = '$hasil_pil1_par2j',
        hasil_pil1_par2k = '$hasil_pil1_par2k',
        pilar1_3 = '$pilar1_3',
        hasil_pil1_par3 = '$hasil_pil1_par3',
        pilar1_4 = '$pilar1_4',
        hasil_pil1_par4 = '$hasil_pil1_par4'
    WHERE id_profil_risiko = '$id'");



    mysqli_query($conn, "UPDATE inheren_kredit_pilar2 SET 
        hasil_pil2_par1 = '$nilai_pil2_par1',
        hasil_pil2_par2 = '$nilai_pil2_par2',
        hasil_pil2_par2a = '$nilai_pil2_par2a',
        hasil_pil2_par2b = '$nilai_pil2_par2b',
        hasil_pil2_par2c = '$nilai_pil2_par2c',
        hasil_pil2_par2d = '$nilai_pil2_par2d',
        hasil_pil2_par2e = '$nilai_pil2_par2e',
        hasil_pil2_par2f = '$nilai_pil2_par2f',
        hasil_pil2_par3 = '$nilai_pil2_par3',
        hasil_pil2_par3a = '$nilai_pil2_par3a',
        hasil_pil2_par3b = '$nilai_pil2_par3b',
        hasil_pil2_par3c = '$nilai_pil2_par3c',
        hasil_pil2_par3d = '$nilai_pil2_par3d'
    WHERE id_profil_risiko = '$id'");


    mysqli_query($conn, "UPDATE inheren_kredit_pilar3 SET 
        pilar3_1 = '$pilar3_1',
        pilar3_1a = '$pilar3_1a',
        pilar3_1b = '$pilar3_1b',
        pilar3_1c = '$pilar3_1c',
        pilar3_1d = '$pilar3_1d',
        pilar3_1e = '$pilar3_1e',
        hasil_pil3_par1 = '$hasil_pil3_par1',
        hasil_pil3_par1a = '$hasil_pil3_par1a',
        hasil_pil3_par1b = '$hasil_pil3_par1b',
        hasil_pil3_par1c = '$hasil_pil3_par1c',
        hasil_pil3_par1d = '$hasil_pil3_par1d',
        hasil_pil3_par1e = '$hasil_pil3_par1e'
    WHERE id_profil_risiko = '$id'");

    mysqli_query($conn, "UPDATE inheren_kredit_pilar4 SET 
        pilar4_1a = '$pilar4_1a',
        pilar4_1b = '$pilar4_1b',
        pilar4_1c = '$pilar4_1c',
        pilar4_1d = '$pilar4_1d',
        hasil_pil4_par1 = '$hasil_pil4_par1',
        hasil_pil4_par1a = '$hasil_pil4_par1a',
        hasil_pil4_par1b = '$hasil_pil4_par1b',
        hasil_pil4_par1c = '$hasil_pil4_par1c',
        hasil_pil4_par1d = '$hasil_pil4_par1d'
    WHERE id_profil_risiko = '$id'");


    mysqli_query($conn, "UPDATE inheren_kredit_lainnya SET 
        pilar5_1a = '$pilar5_1a',
        pilar5_1b = '$pilar5_1b',
        pilar5_1c = '$pilar5_1c',
        pilar5_1d = '$pilar5_1d',
        pilar5_1e = '$pilar5_1e',
        pilar5_1f = '$pilar5_1f',
        pilar5_1g = '$pilar5_1g',
        pilar5_1h = '$pilar5_1h',
        pilar5_1i = '$pilar5_1i',
        pilar5_1j = '$pilar5_1j',
        pilar5_1k = '$pilar5_1k',
        hasil_pil5_par1 = '$hasil_pil5_par1',
        hasil_pil5_par1a = '$hasil_pil5_par1a',
        hasil_pil5_par1b = '$hasil_pil5_par1b',
        hasil_pil5_par1c = '$hasil_pil5_par1c',
        hasil_pil5_par1d = '$hasil_pil5_par1d',
        hasil_pil5_par1e = '$hasil_pil5_par1e',
        hasil_pil5_par1f = '$hasil_pil5_par1f',
        hasil_pil5_par1g = '$hasil_pil5_par1g',
        hasil_pil5_par1h = '$hasil_pil5_par1h',
        hasil_pil5_par1i = '$hasil_pil5_par1i',
        hasil_pil5_par1j = '$hasil_pil5_par1j',
        hasil_pil5_par1k = '$hasil_pil5_par1k'
    WHERE id_profil_risiko = '$id'");


    mysqli_query($conn, "UPDATE hasil_inheren_kredit SET 
        pil1_tertinggi = '$pil1_tertinggi',
        pil1_terendah = '$pil1_terendah',
        pil1_rata_rata = '$pil1_rata_rata',
        pil1_risiko_ditetapkan = '$pil1_risiko_ditetapkan',
        pil1_tingkat_risiko = '$pil1_tingkat_risiko',
        pil2_tertinggi = '$pil2_tertinggi',
        pil2_terendah = '$pil2_terendah',
        pil2_rata_rata = '$pil2_rata_rata',
        pil2_risiko_ditetapkan = '$pil2_risiko_ditetapkan',
        pil2_tingkat_risiko = '$pil2_tingkat_risiko',
        pil3_tertinggi = '$pil3_tertinggi',
        pil3_terendah = '$pil3_terendah',
        pil3_rata_rata = '$pil3_rata_rata',
        pil3_risiko_ditetapkan = '$pil3_risiko_ditetapkan',
        pil3_tingkat_risiko = '$pil3_tingkat_risiko',
        pil4_tertinggi = '$pil4_tertinggi',
        pil4_terendah = '$pil4_terendah',
        pil4_rata_rata = '$pil4_rata_rata',
        pil4_tingkat_risiko = '$pil4_tingkat_risiko',
        pil5_tertinggi = '$pil5_tertinggi',
        pil5_terendah = '$pil5_terendah',
        pil5_rata_rata = '$pil5_rata_rata',
        pil5_tingkat_risiko = '$pil5_tingkat_risiko',
        hasil_inheren_tertinggi = '$hasil_inheren_tertinggi',
        hasil_inheren_terendah = '$hasil_inheren_terendah',
        hasil_inheren_rata_rata = '$hasil_inheren_rata_rata',
        hasil_risiko_ditetapkan = '$hasil_risiko_ditetapkan',
        hasil_tingkat_risiko = '$hasil_tingkat_risiko',
        hasil_peringkat = '$hasil_peringkat'
    WHERE id_profil_risiko = '$id'");


    mysqli_query($conn, "UPDATE keterangan_inheren_kredit SET 
        ket_pil1_1 ='$ket_pil1_1',
        ket_pil1_2 ='$ket_pil1_2',
        ket_pil1_3 ='$ket_pil1_3',
        ket_pil1_4 ='$ket_pil1_4',
        ket_pil1 ='$ket_pil1',
        ket_pil2_1 ='$ket_pil2_1',
        ket_pil2_2 ='$ket_pil2_2',
        ket_pil2_3 ='$ket_pil2_3',
        ket_pil2 ='$ket_pil2',
        ket_pil3_1 ='$ket_pil3_1',
        ket_pil3 ='$ket_pil3',
        ket_pil4_1 ='$ket_pil4_1',
        ket_pil4 ='$ket_pil4',
        ket_pil5_1 ='$ket_pil5_1',
        ket_pil5 ='$ket_pil5',
        ket_inheren ='$ket_inheren'
    WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=kre_inhern&id=$id");
    exit();
}

?>




<script>

        $(document).ready(function() {
            $('#ket_pil1_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter1').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil1_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter2').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil1_3').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter3').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil1_4').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter4').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter5').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter6').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter7').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2_3').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter8').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter9').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil3_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter10').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil3').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter11').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil4_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter12').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil4').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter13').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil5_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter14').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil5').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter15').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_inheren').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter16').text(charCount);
            });
        });
</script>





                                    <script type="text/javascript">
                                        $(document).ready(function() {

                                            $('#target_pasar1').change(function() {
                                                var val = this.value;
                                                $("#koreksippl1_par3").val(val);

                                                var hsl3 = <?php echo json_encode($hsl3); ?>;

                                                if (hsl3 == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl3) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl1_par3").val(nilai);
                                            });

                                            
                                            $('#sektor_terbesar3').change(function() {
                                                var val = this.value;
                                                $("#koreksippl1_par4").val(val);

                                                var hsl4 = <?php echo json_encode($hsl4); ?>;

                                                if (hsl4 == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl4) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl1_par4").val(nilai);
                                            });

                                            $("#target_pasar1, #sektor_terbesar3").change(function() {
                                                var pilar1_par1 = <?php echo $nilai; ?>;
                                                var pilar1_par2 = <?php echo $nilai2; ?>;
                                                var pilar1_par3 = $("#nilaippl1_par3").val();
                                                var pilar1_par4 = $("#nilaippl1_par4").val();


                                                const max = [pilar1_par1, pilar1_par2, pilar1_par3, pilar1_par4];
                                                const maxValue = Math.max(...max);
                                                tertinggi_pil1 = maxValue.toFixed(2);

                                                $("#tertinggi_pil1").val(tertinggi_pil1);
                                    

                                                const min = [pilar1_par1, pilar1_par2, pilar1_par3, pilar1_par4];
                                                const minValue = Math.min(...min);
                                                terendah_pil1 = minValue.toFixed(2);

                                                $("#terendah_pil1").val(terendah_pil1);

                                                var total_rata_rata = parseFloat(pilar1_par1) + parseFloat(pilar1_par2) + parseFloat(pilar1_par3) + parseFloat(pilar1_par4);
                                                
                                                var rata_rata_pil1 = parseFloat(total_rata_rata) / 4;
                                                rata_rata_pil1 = rata_rata_pil1.toFixed(2);

                                                rr1 = rata_rata_pil1;

                                                $("#rata_rata_pil1").val(rata_rata_pil1);
                                            });

                                            $("#target_pasar1, #sektor_terbesar3").change(function() {
                                                var set_pil1 = <?php echo $set_pil1; ?>;
                                                if (set_pil1 == 1) {
                                                    var risiko_pil1 = tertinggi_pil1;
                                                } else if (set_pil1 == 2) {
                                                    var risiko_pil1 = terendah_pil1;
                                                } else if (set_pil1 == 3) {
                                                    var risiko_pil1 = rr1;
                                                } else {
                                                    var risiko_pil1 = 0;
                                                }

                                                $("#risiko_pil1").val(risiko_pil1);
                                                $("#hasil_risiko_pil1").val(risiko_pil1);
                                            });


                                            $('#penyaluran_kredit').change(function() {
                                                var val = this.value;
                                                $("#koreksippl3_par1").val(val);
                                                var koreksippl3_par1 = $("#koreksippl3_par1").val();
                                                var hsl_pil3_par1 = <?php echo json_encode($hsl_pil3_par1); ?>;

                                                if (hsl_pil3_par1 > koreksippl3_par1) {
                                                    var nilai = hsl_pil3_par1.toFixed(2);
                                                } else if (hsl_pil3_par1 == koreksippl3_par1) {
                                                    var nilai = hsl_pil3_par1.toFixed(2);
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1) + parseFloat(koreksippl3_par1)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1").val(nilai);
                                            });

                                            
                                            $('#penyaluran_kredit2').change(function() {
                                              
                                                var val = this.value;
                                                $("#koreksippl3_par1a").val(val);
                                                var koreksippl3_par1a = $("#koreksippl3_par1a").val();
                                                var hsl_pil3_par1a = <?php echo json_encode($hsl_pil3_par1a); ?>;

                                                if (hsl_pil3_par1a > koreksippl3_par1a) {
                                                    var nilai = hsl_pil3_par1a.toFixed(2);
                                                } else if (hsl_pil3_par1a == koreksippl3_par1a) {
                                                    var nilai = hsl_pil3_par1a.toFixed(2);
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1a) + parseFloat(koreksippl3_par1a)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1a").val(nilai);
                                            });


                                            $('#penyaluran_kredit3').change(function() {
                                              
                                                var val = this.value;
                                                $("#koreksippl3_par1b").val(val);
                                                var koreksippl3_par1b = $("#koreksippl3_par1b").val();
                                                var hsl_pil3_par1b = <?php echo json_encode($hsl_pil3_par1b); ?>;

                                                if (hsl_pil3_par1b > koreksippl3_par1b) {
                                                    var nilai = hsl_pil3_par1b.toFixed(2);
                                                } else if (hsl_pil3_par1b == koreksippl3_par1b) {
                                                    var nilai = hsl_pil3_par1b.toFixed(2);
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1b) + parseFloat(koreksippl3_par1b)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1b").val(nilai);
                                            });

                                            $('#penyaluran_kredit3_5').change(function() {
                                              
                                                var val = this.value;
                                                $("#koreksippl3_par1c").val(val);
                                                var koreksippl3_par1c = $("#koreksippl3_par1c").val();
                                                var hsl_pil3_par1c = <?php echo json_encode($hsl_pil3_par1c); ?>;

                                                if (hsl_pil3_par1c > koreksippl3_par1c) {
                                                    var nilai = hsl_pil3_par1c.toFixed(2);
                                                } else if (hsl_pil3_par1c == koreksippl3_par1c) {
                                                    var nilai = hsl_pil3_par1c.toFixed(2);
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1c) + parseFloat(koreksippl3_par1c)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1c").val(nilai);
                                            });

                                            $('#penyaluran_kredit4').change(function() {
                                                var val = this.value;
                                                $("#koreksippl3_par1d").val(val);
                                          

                                                var hsl_pil3_par1d_rumus = <?php echo json_encode($hsl_pil3_par1d_rumus); ?>;

                                                if (hsl_pil3_par1d_rumus == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1d_rumus) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1d").val(nilai);
                                            });


                                            $('#penyaluran_kredit5').change(function() {
                                                var val = this.value;
                                                $("#koreksippl3_par1e").val(val);
                                          

                                                var hsl_pil3_par1e_rumus = <?php echo json_encode($hsl_pil3_par1e_rumus); ?>;

                                                if (hsl_pil3_par1e_rumus == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1e_rumus) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1e").val(nilai);
                                            });

                                            $("#penyaluran_kredit, #penyaluran_kredit2, #penyaluran_kredit3, #penyaluran_kredit3_5, #penyaluran_kredit4, #penyaluran_kredit5").change(function() {
                                                var pilar3_par1 = $("#nilaippl3_par1").val();
                                                var pilar3_par1a = $("#nilaippl3_par1a").val();
                                                var pilar3_par1b = $("#nilaippl3_par1b").val();
                                                var pilar3_par1c = $("#nilaippl3_par1c").val();
                                                var pilar3_par1d = $("#nilaippl3_par1d").val();
                                                var pilar3_par1e = $("#nilaippl3_par1e").val();


                                                const max = [pilar3_par1, pilar3_par1a, pilar3_par1b, pilar3_par1c, pilar3_par1d, pilar3_par1e];
                                                const maxValue = Math.max(...max);
                                                tertinggi_pil3 = maxValue.toFixed(2);

                                                $("#tertinggi_pil3").val(tertinggi_pil3);
                                        

                                                const min = [pilar3_par1, pilar3_par1a, pilar3_par1b, pilar3_par1c, pilar3_par1d, pilar3_par1e];
                                                const minValue = Math.min(...min);
                                                terendah_pil3 = minValue.toFixed(2);

                                                $("#terendah_pil3").val(terendah_pil3);

                                                var total_rata_rata = parseFloat(pilar3_par1) + parseFloat(pilar3_par1a) + parseFloat(pilar3_par1b) + parseFloat(pilar3_par1c) + parseFloat(pilar3_par1d) + parseFloat(pilar3_par1e);
                                                var rata_rata_pil3 = parseFloat(total_rata_rata) / 6;
                                                rata_rata_pil3 = rata_rata_pil3.toFixed(2);

                                                rr3 = rata_rata_pil3;

                                                $("#rata_rata_pil3").val(rata_rata_pil3);
                                            });

                                            $("#penyaluran_kredit, #penyaluran_kredit2, #penyaluran_kredit3, #penyaluran_kredit3_5, #penyaluran_kredit4, #penyaluran_kredit5").change(function() {
                                                var set_pil1 = <?php echo $set_pil1; ?>;
                                            
                                                if (set_pil1 == 1) {
                                                    var risiko_pil3 = tertinggi_pil3;
                                                } else if (set_pil1 == 2) {
                                                    var risiko_pil3 = terendah_pil3;
                                                } else if (set_pil1 == 3) {
                                                    var risiko_pil3 = rr3;
                                                } else {
                                                    var risiko_pil3 = 0;
                                                }

                                                $("#risiko_pil3").val(risiko_pil3);
                                                $("#hasil_risiko_pil3").val(risiko_pil3);
                                            });
                                        

                                            $('#pilar4_1a').change(function() {
                                                var pilar4_1a = $("#pilar4_1a").val();

                                                var bobot6_1 = <?php echo json_encode($bobot6_1); ?>;

                                                
                                                var nilai = parseFloat(pilar4_1a) * parseFloat(bobot6_1);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl4_par1a").val(nilai);

                                                var nilai2 = parseFloat(pilar4_1a) * parseFloat(bobot6_1);
                                                $("#nilaippl4_p1a").val(nilai2);
                                            });

                                            
                                            $('#pilar4_1b').change(function() {
                                                var pilar4_1b = $("#pilar4_1b").val();

                                                var bobot6_2 = <?php echo json_encode($bobot6_2); ?>;

                                                
                                                var nilai = parseFloat(pilar4_1b) * parseFloat(bobot6_2);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl4_par1b").val(nilai);

                                                var nilai2 = parseFloat(pilar4_1b) * parseFloat(bobot6_2);
                                                $("#nilaippl4_p1b").val(nilai2);
                                            });
                                            
                                            $('#pilar4_1c').change(function() {
                                                var pilar4_1c = $("#pilar4_1c").val();

                                                var bobot6_3 = <?php echo json_encode($bobot6_3); ?>;

                                                
                                                var nilai = parseFloat(pilar4_1c) * parseFloat(bobot6_3);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl4_par1c").val(nilai);

                                                var nilai2 = parseFloat(pilar4_1c) * parseFloat(bobot6_3);
                                                $("#nilaippl4_p1c").val(nilai2);
                                            });

                                            $('#pilar4_1d').change(function() {
                                                var pilar4_1d = $("#pilar4_1d").val();

                                                var bobot6_4 = <?php echo json_encode($bobot6_4); ?>;

                                                
                                                var nilai = parseFloat(pilar4_1d) * parseFloat(bobot6_4);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl4_par1d").val(nilai);

                                                var nilai2 = parseFloat(pilar4_1d) * parseFloat(bobot6_4);
                                                $("#nilaippl4_p1d").val(nilai2);
                                            });

                                            $("#pilar4_1a, #pilar4_1b, #pilar4_1c, #pilar4_1d").change(function() {
                                                var pilar4_1a = $("#pilar4_1a").val();
                                                var pilar4_1b = $("#pilar4_1b").val();
                                                var pilar4_1c = $("#pilar4_1c").val();
                                                var pilar4_1d = $("#pilar4_1d").val();
                                                var bobot6_1 = <?php echo json_encode($bobot6_1); ?>;
                                                var bobot6_2 = <?php echo json_encode($bobot6_2); ?>;
                                                var bobot6_3 = <?php echo json_encode($bobot6_3); ?>;
                                                var bobot6_4 = <?php echo json_encode($bobot6_4); ?>;


                                                var pilar4_par1 = parseFloat(pilar4_1a) * parseFloat(bobot6_1);
                                                pilar4_par1 = pilar4_par1.toFixed(2);

                                                var pilar4_par2 = parseFloat(pilar4_1b) * parseFloat(bobot6_2);
                                                pilar4_par2 = pilar4_par2.toFixed(2);

                                                var pilar4_par3 = parseFloat(pilar4_1c) * parseFloat(bobot6_3);
                                                pilar4_par3 = pilar4_par3.toFixed(2);

                                                var pilar4_par4 = parseFloat(pilar4_1d) * parseFloat(bobot6_4);
                                                pilar4_par4 = pilar4_par4.toFixed(2);



                                                var total_rata_rata = parseFloat(pilar4_par1) + parseFloat(pilar4_par2) + parseFloat(pilar4_par3) + parseFloat(pilar4_par4);
                                            
                                                total_rata_rata = total_rata_rata.toFixed(2);

                                                $("#risiko_pil4").val(total_rata_rata);
                                                $("#hasil_risiko_pil4").val(total_rata_rata);
                                            });


                                        



                                            $('#pilar5_1a').change(function() {
                                                var pilar5_1a = $("#pilar5_1a").val();

                                                var bobot7_1 = <?php echo json_encode($bobot7_1); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1a) * parseFloat(bobot7_1);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1a").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1a) * parseFloat(bobot7_1);
                                                $("#nilaippl5_p1a").val(nilai2);
                                            });

                                            
                                            $('#pilar5_1b').change(function() {
                                                var pilar5_1b = $("#pilar5_1b").val();

                                                var bobot7_2 = <?php echo json_encode($bobot7_2); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1b) * parseFloat(bobot7_2);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1b").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1b) * parseFloat(bobot7_2);
                                                $("#nilaippl5_p1b").val(nilai2);
                                            });
                                            
                                            $('#pilar5_1c').change(function() {
                                                var pilar5_1c = $("#pilar5_1c").val();

                                                var bobot7_3 = <?php echo json_encode($bobot7_3); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1c) * parseFloat(bobot7_3);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1c").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1c) * parseFloat(bobot7_3);
                                                $("#nilaippl5_p1c").val(nilai2);
                                            });

                                            $('#pilar5_1d').change(function() {
                                                var pilar5_1d = $("#pilar5_1d").val();

                                                var bobot7_4 = <?php echo json_encode($bobot7_4); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1d) * parseFloat(bobot7_4);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1d").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1d) * parseFloat(bobot7_4);
                                                $("#nilaippl5_p1d").val(nilai2);
                                            });

                                            $('#pilar5_1e').change(function() {
                                                var pilar5_1e = $("#pilar5_1e").val();

                                                var bobot7_5 = <?php echo json_encode($bobot7_5); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1e) * parseFloat(bobot7_5);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1e").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1e) * parseFloat(bobot7_5);
                                                $("#nilaippl5_p1e").val(nilai2);
                                            });

                                            $('#pilar5_1f').change(function() {
                                                var pilar5_1f = $("#pilar5_1f").val();

                                                var bobot7_6 = <?php echo json_encode($bobot7_6); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1f) * parseFloat(bobot7_6);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1f").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1f) * parseFloat(bobot7_6);
                                                $("#nilaippl5_p1f").val(nilai2);
                                            });


                                            $('#pilar5_1g').change(function() {
                                                var pilar5_1g = $("#pilar5_1g").val();

                                                var bobot7_7 = <?php echo json_encode($bobot7_7); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1g) * parseFloat(bobot7_7);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1g").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1g) * parseFloat(bobot7_7);
                                                $("#nilaippl5_p1g").val(nilai2);
                                            });

                                            $('#pilar5_1h').change(function() {
                                                var pilar5_1h = $("#pilar5_1h").val();

                                                var bobot7_8 = <?php echo json_encode($bobot7_8); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1h) * parseFloat(bobot7_8);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1h").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1h) * parseFloat(bobot7_8);
                                                $("#nilaippl5_p1h").val(nilai2);
                                            });



                                            $('#pilar5_1k').change(function() {
                                                var pilar5_1k = $("#pilar5_1k").val();

                                                var bobot7_11 = <?php echo json_encode($bobot7_11); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1k) * parseFloat(bobot7_11);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1k").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1k) * parseFloat(bobot7_11);
                                                $("#nilaippl5_p1k").val(nilai2);
                                            });

                                            $("#pilar5_1a, #pilar5_1b, #pilar5_1c, #pilar5_1d, #pilar5_1e, #pilar5_1f, #pilar5_1g, #pilar5_1h, #pilar5_1k").change(function() {
                                                var pilar5_1a = $("#pilar5_1a").val();
                                                var pilar5_1b = $("#pilar5_1b").val();
                                                var pilar5_1c = $("#pilar5_1c").val();
                                                var pilar5_1d = $("#pilar5_1d").val();
                                                var pilar5_1e = $("#pilar5_1e").val();
                                                var pilar5_1f = $("#pilar5_1f").val();
                                                var pilar5_1g = $("#pilar5_1g").val();
                                                var pilar5_1h = $("#pilar5_1h").val();
                                                var pilar5_1k = $("#pilar5_1k").val();

                                                var bobot7_1 = <?php echo json_encode($bobot7_1); ?>;
                                                var bobot7_2 = <?php echo json_encode($bobot7_2); ?>;
                                                var bobot7_3 = <?php echo json_encode($bobot7_3); ?>;
                                                var bobot7_4 = <?php echo json_encode($bobot7_4); ?>;
                                                var bobot7_5 = <?php echo json_encode($bobot7_5); ?>;
                                                var bobot7_6 = <?php echo json_encode($bobot7_6); ?>;
                                                var bobot7_7 = <?php echo json_encode($bobot7_7); ?>;
                                                var bobot7_8 = <?php echo json_encode($bobot7_8); ?>;
                                                var bobot7_11 = <?php echo json_encode($bobot7_11); ?>;


                                                var pilar5_par1 = parseFloat(pilar5_1a) * parseFloat(bobot7_1);
                                                pilar5_par1 = pilar5_par1.toFixed(2);
                                                var pilar5_par2 = parseFloat(pilar5_1b) * parseFloat(bobot7_2);
                                                pilar5_par2 = pilar5_par2.toFixed(2);
                                                var pilar5_par3 = parseFloat(pilar5_1c) * parseFloat(bobot7_3);
                                                pilar5_par3 = pilar5_par3.toFixed(2);
                                                var pilar5_par4 = parseFloat(pilar5_1d) * parseFloat(bobot7_4);
                                                pilar5_par4 = pilar5_par4.toFixed(2);
                                                var pilar5_par5 = parseFloat(pilar5_1e) * parseFloat(bobot7_5);
                                                pilar5_par5 = pilar5_par5.toFixed(2);
                                                var pilar5_par6 = parseFloat(pilar5_1f) * parseFloat(bobot7_6);
                                                pilar5_par6 = pilar5_par6.toFixed(2);
                                                var pilar5_par7 = parseFloat(pilar5_1g) * parseFloat(bobot7_7);
                                                pilar5_par7 = pilar5_par7.toFixed(2);
                                                var pilar5_par8 = parseFloat(pilar5_1h) * parseFloat(bobot7_8);
                                                pilar5_par8 = pilar5_par8.toFixed(2);
                                                var pilar5_par11 = parseFloat(pilar5_1k) * parseFloat(bobot7_11);
                                                pilar5_par11 = pilar5_par11.toFixed(2);



                                                var total_rata_rata = parseFloat(pilar5_par1) + parseFloat(pilar5_par2) + parseFloat(pilar5_par3) + parseFloat(pilar5_par4) + parseFloat(pilar5_par5) + parseFloat(pilar5_par6) + parseFloat(pilar5_par7) + parseFloat(pilar5_par8) + parseFloat(pilar5_par11);
                                            
                                                total_rata_rata = total_rata_rata.toFixed(2);

                                                $("#risiko_pil5").val(total_rata_rata);
                                                $("#hasil_risiko_pil5").val(total_rata_rata);
                                            });

                                            



                                    



                                            $("#target_pasar1, #sektor_terbesar3, #penyaluran_kredit, #penyaluran_kredit2, #penyaluran_kredit3, #penyaluran_kredit3_5, #penyaluran_kredit4, #penyaluran_kredit5, #pilar4_1a, #pilar4_1b, #pilar4_1c, #pilar4_1d, #pilar5_1a, #pilar5_1b, #pilar5_1c, #pilar5_1d, #pilar5_1e, #pilar5_1f, #pilar5_1g, #pilar5_1h, #pilar5_1k").change(function() {
                                                var val = this.value;
                                                var hsl_risiko_pilar1 = $("#risiko_pil1").val();
                                                var hsl_risiko_pilar2 = <?php echo json_encode($pil2_tingkat_risiko); ?>;
                                                var hsl_risiko_pilar3 = $("#risiko_pil3").val();
                                                var hsl_risiko_pilar4 = $("#risiko_pil4").val();
                                                var hsl_risiko_pilar5 = $("#risiko_pil5").val();

                                                const max = [hsl_risiko_pilar1, hsl_risiko_pilar2, hsl_risiko_pilar3, hsl_risiko_pilar4, hsl_risiko_pilar5];
                                                const maxValue = Math.max(...max);
                                                tertinggi_inheren = maxValue.toFixed(2);
                                                $("#tertinggi_inheren").val(tertinggi_inheren);
                                
                                                const min = [hsl_risiko_pilar1, hsl_risiko_pilar2, hsl_risiko_pilar3, hsl_risiko_pilar4, hsl_risiko_pilar5];
                                                const minValue = Math.min(...min);
                                                terendah_inheren = minValue.toFixed(2);
                                                $("#terendah_inheren").val(terendah_inheren);
                                        
                                                var total_rata_rata = parseFloat(hsl_risiko_pilar1) + parseFloat(hsl_risiko_pilar2) + parseFloat(hsl_risiko_pilar3) + parseFloat(hsl_risiko_pilar4) + parseFloat(hsl_risiko_pilar5);
                                                var rata_rata_inheren = parseFloat(total_rata_rata) / 5;
                                                rata_rata_inheren = rata_rata_inheren.toFixed(2);
                                                rr_inheren = rata_rata_inheren;

                                                $("#rata_rata_inheren").val(rata_rata_inheren);
                                            });
                                            $("#target_pasar1, #sektor_terbesar3, #penyaluran_kredit, #penyaluran_kredit2, #penyaluran_kredit3, #penyaluran_kredit3_5, #penyaluran_kredit4, #penyaluran_kredit5, #pilar4_1a, #pilar4_1b, #pilar4_1c, #pilar4_1d, #pilar5_1a, #pilar5_1b, #pilar5_1c, #pilar5_1d, #pilar5_1e, #pilar5_1f, #pilar5_1g, #pilar5_1h, #pilar5_1k").change(function() {
                                                var set_tingkat_risiko = <?php echo json_encode($set_tingkat_risiko); ?>;
                                                
                                            
                                                if (set_tingkat_risiko == 1) {
                                                    var risiko_inheren = tertinggi_inheren;
                                                } else if (set_tingkat_risiko == 2) {
                                                    var risiko_inheren = terendah_inheren;
                                                } else if (set_tingkat_risiko == 3) {
                                                    var risiko_inheren = rr_inheren;
                                                } else {
                                                    var risiko_inheren = 0;
                                                }

                                                $("#risiko_inheren").val(risiko_inheren);
                                                nilai_risiko_inheren = risiko_inheren;

                                                if (nilai_risiko_inheren < 1.00) {
                                                    var peringkat_inheren = " ";
                                                } else if (nilai_risiko_inheren >= 1.00 && nilai_risiko_inheren <= 1.25) {
                                                    var peringkat_inheren = "Sangat Rendah";
                                                } else if (nilai_risiko_inheren > 1.25 && nilai_risiko_inheren <= 2.25) {
                                                    var peringkat_inheren = "Rendah";
                                                } else if (nilai_risiko_inheren > 2.25 && nilai_risiko_inheren <= 3.25) {
                                                    var peringkat_inheren = "Sedang";
                                                } else if (nilai_risiko_inheren > 3.25 && nilai_risiko_inheren <= 4.25) {
                                                    var peringkat_inheren = "Tinggi";
                                                } else if (nilai_risiko_inheren > 4.25 && nilai_risiko_inheren <= 5.00) {
                                                    var peringkat_inheren = "Sangat Tinggi";
                                                } else {
                                                    var peringkat_inheren = " ";
                                                }

                                                $("#peringkat_inheren").val(peringkat_inheren);
                                            });

                                        });
                                    </script>


<input type="hidden" form="my_form" name="nilaippl4_p1a"  class="form-control" id="nilaippl4_p1a" readonly>
<input type="hidden" form="my_form" name="nilaippl4_p1b"  class="form-control" id="nilaippl4_p1b" readonly>
<input type="hidden" form="my_form" name="nilaippl4_p1c"  class="form-control" id="nilaippl4_p1c" readonly>
<input type="hidden" form="my_form" name="nilaippl4_p1d"  class="form-control" id="nilaippl4_p1d" readonly>


<input type="hidden" form="my_form" name="nilaippl5_p1a"  class="form-control" id="nilaippl5_p1a" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1b"  class="form-control" id="nilaippl5_p1b" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1c"  class="form-control" id="nilaippl5_p1c" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1d"  class="form-control" id="nilaippl5_p1d" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1e"  class="form-control" id="nilaippl5_p1e" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1f"  class="form-control" id="nilaippl5_p1f" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1g"  class="form-control" id="nilaippl5_p1g" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1h"  class="form-control" id="nilaippl5_p1h" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1i"  class="form-control" id="nilaippl5_p1i" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1j"  class="form-control" id="nilaippl5_p1j" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1k"  class="form-control" id="nilaippl5_p1k" readonly>



<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Kredit Inhern [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren Profil Risiko Kredit</h4>

                            <hr>
                            </hr>






                            </br>


                            <!-- kredit-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
                                                <h4>
                                                    <center><b>RISIKO KREDIT INHEREN</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr style="color: #050505;">
                                            <th width="2%">
                                                <center>NO</center>
                                            </th>
                                            <th class="text-center" width="20%">
                                                PARAMETER
                                            </th>

                                            <th class="text-center" width="10%">
                                                NOMINAL
                                            </th>
                                            <th class="text-center" width="13%">
                                                RASIO
                                            </th>
                                            <th class="text-center" width="10%">
                                                AMBANG BATAS
                                            </th>
                                            <th class="text-center" width="5%">
                                                RUMUS
                                            </th>
                                            <th class="text-center" width="5%">
                                                KOREKSI
                                            </th>
                                            <th class="text-center" width="10%">
                                                NILAI
                                            </th>
                                            <th class="text-center" width="25%">
                                                KETERANGAN
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th >
                                                <center>Aset Produktif</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['total_aset']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['ap_per_ta'] ?></td>

                                            <td>
                                                <center><?= $hsl1 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1_1'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length['l1'] ?></span><span> / 500</span>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a.<center>Penempatan Pada Bank Lain</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['total_aset']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['pbl_per_tap'] ?> </td>

                                            <td>
                                                <center><?= $hsl1a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1a, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b.<center>ABA Pada 1 Bank Tertinggi</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P3['aba_tertinggi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apbt_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1b, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c.<center>Aba Pada BPR</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P3['aba_bpr']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['abapb_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1c ?></center>
                                            </td>
                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1c, 2) ?></center>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                d.<center>NOA Kredit fon s/d 150 juta</center>
                                                <hr>
                                                </hr>
                                                <center>NOA KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['noa_kredit_sd150']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['noa_kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2f ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nkp150_per_nkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2f ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2f, 2) ?></center>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                e.<center>Kredit PEP</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_pep']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2m ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kpep_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2m ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2m, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                f.<center>Kredit fon > 350jt</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_lebih350']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2n ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kp350_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2n ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2n, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                g.<center>Saldo PPAP</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['saldo_ppap']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p1a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['sppap_per_tk'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par1a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot7, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par1a, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                h.<center>AYDA</center>
                                                <hr>
                                                </hr>
                                                <center>KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['ayda']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p1b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['ayda_per_kyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par1b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot8, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par1b, 2) ?></center>
                                            </td>

                                        </tr>
















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th >
                                                <center>Kredit Yang Diberikan</center>
                                                <hr>
                                                </hr>
                                                <center>Aset Produktif</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kyd_per_ap'] ?></td>

                                            <td>
                                                <center><?= $hsl2 ?></center>
                                            </td>

                                            <td>
                                                <center><?= round($koreksi2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil1_2" form="my_form" name="ket_pil1_2" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1_2'] ?></textarea>
                                            <span id="penghitung-karakter2"><?= $length['l2'] ?></span><span> / 500</span>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a.<center>Kredit Skema Potong Gaji</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_spg']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kspg_per_tk'] ?> </td>

                                            <td>
                                                <center><?= $hsl2a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b.<center>Kredit Musiman (Grace Period)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_pbta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['km_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2b, 2) ?></center>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c.<center>Kredit Jangka Pendek</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_jpendek']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kjpen_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                d.<center>Kredit Jangka Menengah</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_jmenengah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2d ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjm_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2d, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                e.<center>Kredit Jangka Panjang</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_jpanjang']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2e ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjpan_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2e ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2e, 2) ?></center>
                                            </td>

                                        </tr>


                                    


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                f.<center>Kredit Dengan Agunan Tanah dan Bangunan</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_tb']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2g ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kdatdb_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2g ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2g, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                g.<center>Kredit Agunan Kendaraan Bermotor</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_kb']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2h ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kak_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2h ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_7, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2h, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                h.<center>Kredit Agunan Kendaraan Roda 2</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_kr2']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2i ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kakr2_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2i ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_8, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2i, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                i.<center>OSC Produk KUB</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_kub']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2j ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['opk_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2j ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_9, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2j, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                j.<center>Kredit Tanpa Agunan</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_ta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2k ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kta_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2k ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_10, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2k, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                k.<center>Kredit Korporasi (Non Perorangan)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_korporasi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2l ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kknp_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2l ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_11, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2l, 2) ?></center>
                                            </td>
                                        </tr>















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th >
                                                <center>25 Debitur Inti</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['debitur_inti25']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p3 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['di25_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl3 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par3" value="<?= $pil1['pilar1_3'] ?>" class="form-control" id="koreksippl1_par3" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="number" form="my_form" name="nilaippl1_par3" value="<?= $pil1['hasil_pil1_par3'] ?>" class="form-control" id="nilaippl1_par3" readonly></center>

                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil1_3" form="my_form" name="ket_pil1_3" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1_3'] ?></textarea>
                                            <span id="penghitung-karakter3"><?= $length['l3'] ?></span><span> / 500</span>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >
                                                <label for="example-select" class="form-label">Target pasar</label>
                                                <select class="form-select" form="my_form" name="target_pasar1" id="target_pasar1">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil1['pilar1_3'] == "2" ? "selected" : "" ?>>2 = tidak berubah selama jangka waktu yang sangat lama > 4 tahun</option>
                                                    <option value="3" <?= $pil1['pilar1_3'] == "3" ? "selected" : "" ?>>3 = tidak berubah selama jangka waktu yang lama > 2 - 4 tahun</option>
                                                    <option value="4" <?= $pil1['pilar1_3'] == "4" ? "selected" : "" ?>>4 = tidak berubah selama jangka waktu yang cukup lama 2 tahun</option>
                                                    <option value="5" <?= $pil1['pilar1_3'] == "5" ? "selected" : "" ?>>5 = tidak berubah selama jangka waktu yang singkat < 2 tahun </option>
                                                </select>
                                            </th>
                                            
                                            <td>
                                            <center>Periode sebelumnya</br><?= $pembanding_pil1['pilar1_3'] ?></center>
                                            </td>
                                            <td colspan="6">
                                            </td>


                                        </tr>
















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th >
                                                <center>Kredit Per Sektor Ekonomi</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kredit_3sektor_ekonomi_terbesar']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p4 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kpse_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl4 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par4" value="<?= $pil1['pilar1_4'] ?>" class="form-control" id="koreksippl1_par4" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="text" form="my_form" name="nilaippl1_par4" value="<?= $pil1['hasil_pil1_par4'] ?>" class="form-control" id="nilaippl1_par4" readonly></center>

                                            </td>

                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil1_4" form="my_form" name="ket_pil1_4" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1_4'] ?></textarea>
                                            <span id="penghitung-karakter4"><?= $length['l4'] ?></span><span> / 500</span>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >
                                                <label for="example-select" class="form-label">Kredit yang berasal dari 3 sektor terbesar</label>
                                                <select class="form-select" form="my_form" name="sektor_terbesar3" id="sektor_terbesar3">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil1['pilar1_4'] == "2" ? "selected" : "" ?>>2 = tidak berubah selama jangka waktu yang sangat lama > 4 tahun</option>
                                                    <option value="3" <?= $pil1['pilar1_4'] == "3" ? "selected" : "" ?>>3 = tidak berubah selama jangka waktu yang lama > 2 - 4 tahun</option>
                                                    <option value="4" <?= $pil1['pilar1_4'] == "4" ? "selected" : "" ?>>4 = tidak berubah selama jangka waktu yang cukup lama 2 tahun</option>
                                                    <option value="5" <?= $pil1['pilar1_4'] == "5" ? "selected" : "" ?>>5 = tidak berubah selama jangka waktu yang singkat < 2 tahun</option>
                                                </select>
                                            </th>
                                            <td>
                                            <center>Periode sebelumnya</br><?= $pembanding_pil1['pilar1_4'] ?></center>
                                            </td>
                                            <td colspan="6">
                                            </td>

                                        </tr>





                                        <tr bgcolor="#acdbfb">

                                            <th style="font-size: 18px;" colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 1</center>
                                            </th>
                                            <th >
                                                <center>Tertinggi</center>
                                                <center><input type="number" form="my_form" name="tertinggi_pil1" value="<?= $hasil['pil1_tertinggi'] ?>" class="form-control" id="tertinggi_pil1" readonly></center>
                                            </th>
                                            <th >
                                                <center>Terendah</center>
                                                <center><input type="number" form="my_form" name="terendah_pil1" value="<?= $hasil['pil1_terendah'] ?>" class="form-control" id="terendah_pil1" readonly></center>
                                            </th>
                                            <th >
                                                <center>Rata-rata</center>
                                                <center><input type="number" form="my_form" name="rata_rata_pil1" value="<?= $hasil['pil1_rata_rata'] ?>" class="form-control" id="rata_rata_pil1" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <select class="form-select" id="set_pil1" disabled>
                                                    <option value="1" <?= $inheren['inheren_kre_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $inheren['inheren_kre_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $inheren['inheren_kre_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select>
                                            </th>
                                            <th >
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil1" value="<?= $hasil['pil1_tingkat_risiko'] ?>" class="form-control" id="risiko_pil1" readonly></center>
                                            </th>

                                            <th>
                                            <textarea class="form-control" maxlength="500" id="ket_pil1" form="my_form" name="ket_pil1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1'] ?></textarea>
                                            <span id="penghitung-karakter5"><?= $length['l5'] ?></span><span> / 500</span>
                                            </th>


                                        </tr>




































                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 2 : Kualitas Aset</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th >
                                                <center>Aset Produktif Bermasalah</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset Produktif</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['aset_produktif_bermasalah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($pilar2_p1 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apb_per_tap'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par1 ?></center>
                                            </td>

                                            <td>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par1, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil2_1'] ?></textarea>
                                            <span id="penghitung-karakter6"><?= $length['l6'] ?></span><span> / 500</span>
                                            </td>

                                        </tr>







                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th >
                                                <center>Kredit Bermasalah Neto</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['kredit_bermasalah_neto']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kbn_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par2 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi_pil2_par2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil2_2'] ?></textarea>
                                            <span id="penghitung-karakter7"><?= $length['l7'] ?></span><span> / 500</span>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a.<center>NPL Kredit plafond s/d 150 juta</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD plafond s/d 150 jt</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['npl_kredit_sd150']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kyd_plafon_sd150']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkp150_per_tkp150'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b.<center>NPL Kredit plafond diatas 50 juta</center>
                                                    <hr>
                                                    </hr>
                                                    <center>Total KYD plafond diatas 50 juta</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['npl_kredit_diatas50']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kyd_plafon_diatas50']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkpd50_per_tkpd50'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2b, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c.<center>NPL Kredit Dengan Perikatan APHT</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['npl_apht']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nkdpapht_prt_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                d.<center>NPL Kredit Dengan Perikatan SKMHT</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['npl_skmht']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2d ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkdpskmht_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2d, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                e.<center>NPL Nilai Agunan Lebih Rendah Dari Baki Debet</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['npl_agunan_lrd_bakidebet']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kredit_agunan_lrd_bakidebet']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2e ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nalrdbd_per_tknalrdbd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2e ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2e, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                f.<center>Kredit Macet sudah jatuh tempo</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['macet_jatuh_tempo']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2f ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kmsjt_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2f ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2f, 2) ?></center>
                                            </td>

                                        </tr>















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th >
                                                <center>Kredit Kualitas Rendah</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['kkr']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kkr_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par3 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi_pil2_par3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3, 2) ?></center>
                                            </td>

                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil2_3" form="my_form" name="ket_pil2_3" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil2_3'] ?></textarea>
                                            <span id="penghitung-karakter8"><?= $length['l8'] ?></span><span> / 500</span>
                                            </td>
                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a.<center>Kredit Par 4</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['kredit_par4']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kp4_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b.<center>Kredit DP (PAR 3 + PAR 4 )</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['kredit_dp']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kdp3p4_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3b, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c.<center>NOA FPD 6 Bulan Terakhir</center>
                                                <hr>
                                                </hr>
                                                <center>NOA Ekspansi 6 Bulan Terakhir</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['noa_fpd_6bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['noa_ekspansi_6bln']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nf6bt_per_ne6bt'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                d.<center>Nominal FPD 6 Bulan Terakhir</center>
                                                <hr>
                                                </hr>
                                                <center>plafond Ekspansi 6 Bulan Terakhir</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P2['nominal_fpd_6bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['plafond_ekspansi_6bln']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3d ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nomf6bt_per_pe6bt'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3d, 2) ?></center>
                                            </td>

                                        </tr>

                                        <tr bgcolor="#acdbfb">

                                            <th style="font-size: 18px;" colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 2</center>
                                            </th>
                                            <th >
                                                <center>Tertinggi</center>
                                                <center><input type="text" form="my_form" name="pilar2_max" class="form-control" value="<?= number_format($pil2_tertinggi ,2)?>" id="pilar2_max" readonly></center>
                                            </th>
                                            <th >
                                                <center>Terendah</center>
                                                <center><input type="text" form="my_form" name="pilar2_min" class="form-control"  value="<?= number_format($pil2_terendah ,2)?>" id="pilar2_min" readonly></center>
                                            </th>
                                            <th >
                                                <center>Rata-rata</center>
                                                <center><input type="text" form="my_form" name="pilar2_avg" class="form-control"  value="<?= number_format($pil2_rata_rata ,2)?>" id="pilar2_avg" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <select class="form-select" id="set_pil2" disabled>
                                                    <option value="1" <?= $inheren['inheren_kre_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $inheren['inheren_kre_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $inheren['inheren_kre_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select>
                                            </th>
                                            <th >
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="text" form="my_form" name="pil2_tingkat_risiko" class="form-control"  value="<?= number_format($pil2_tingkat_risiko ,2) ?>" id="pil2_tingkat_risiko" readonly></center>
                                            </th>

                                            <th>
                                            <textarea class="form-control" maxlength="500" id="ket_pil2" form="my_form" name="ket_pil2" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil2'] ?></textarea>
                                            <span id="penghitung-karakter9"><?= $length['l9'] ?></span><span> / 500</span>
                                            </th>


                                        </tr>














                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 3 : Strategi Penyediaan Dana</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th >
                                                Strategi Penyediaan Dana
                                            </th>
                                            <th >
                                                <center>Kyd - Rata-rata BPR</center>
                                                <center><?= number_format($master_kredit_P3['pertumbuhan_kyd_bpr'] ,2) ?> -
                                                    <?= number_format($master_kredit_P3['rasio_pertumbuhan_rata2_bpr'] ,2) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar3_p1 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apb_per_tap'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil3_par1 ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1" value="<?= $pil3['pilar3_1'] ?>" class="form-control" id="koreksippl3_par1" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1" value="<?= $pil3['hasil_pil3_par1'] ?>" class="form-control" id="nilaippl3_par1" readonly>

                                            </th>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil3_1" form="my_form" name="ket_pil3_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil3_1'] ?></textarea>
                                            <span id="penghitung-karakter10"><?= $length['l10'] ?></span><span> / 500</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >
                                                <a href="https://www.bi.go.id/SEKDA/33/33-ii07.zip" target="_blank">https://www.bi.go.id/SEKDA/33/33-ii07.zip</a></br>
                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit" id="penyaluran_kredit">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1'] == "2" ? "selected" : "" ?>>2 = seluruhnya disalurkan ke sektor ekonomi yang dikuasai</option>
                                                    <option value="3" <?= $pil3['pilar3_1'] == "3" ? "selected" : "" ?>>3 = sebagian besar disalurkan ke sektor ekonomi yang dikuasai</option>
                                                    <option value="4" <?= $pil3['pilar3_1'] == "4" ? "selected" : "" ?>>4 = sebagian kecil atau tidak sama sekali disalurkan ke sektor ekonomi yg dikuasai </option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1'] ?>
                                            </th>
                                            <th >
                                                <center>%<input type="number" form="my_form" name="aba" value="<?= $pilar3_p1 ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>SK limit <<input type="number" form="my_form" name="pil3_par1_limit_persen" value="<?= number_format($bobot5_1, 1) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <th colspan="2">
                                                <center><input type="number" form="my_form" name="pil3_par1_limit_sk" value="<?= $hsl_pil3_par1 ?>" class="form-control" id="pil3_par1_limit_sk" readonly>

                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a. Pertumbuhan sektor ekonomi yang tidak dikuasai
                                            </th>
                                            <th >
                                                <center>Periode Penilaian<input type="text" form="my_form" name="aba" value="<?= rupiah($pilar3_p1a_pp) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Penilaian Sebelumnya<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($pilar3_p1a_ps) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1a ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1a" value="<?= $pil3['pilar3_1a'] ?>" class="form-control" id="koreksippl3_par1a" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1a" value="<?= $pil3['hasil_pil3_par1a'] ?>" class="form-control" id="nilaippl3_par1a" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >

                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit2" id="penyaluran_kredit2">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1a'] == "2" ? "selected" : "" ?>>2 = Terjadi penurunan OSC pada sektor ekonomi yang tidak dikuasai dan NPL membaik</option>
                                                    <option value="3" <?= $pil3['pilar3_1a'] == "3" ? "selected" : "" ?>>3 = Terjadi penurunan OSC pada sektor ekonomi yang tidak dikuasai dan NPL stagnan</option>
                                                    <option value="4" <?= $pil3['pilar3_1a'] == "4" ? "selected" : "" ?>>4 = Terjadi kenaikan OSC pada sektor ekonomi yang tidak dikuasai dan NPL memburuk </option>

                                                </select>
                                            </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1a'] ?>
                                            </th>

                                            <th colspan="7">

                                            </th>


                                        </tr>


                                       



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b. Pertumbuhan sektor ekonomi yang dikuasai
                                            </th>
                                            <th >
                                                <center>Periode Penilaian<input type="text" form="my_form" name="aba" value="<?= rupiah($pilar3_p1b_pp) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Penilaian Sebelumnya<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($pilar3_p1b_ps) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1b ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1b" value="<?= $pil3['pilar3_1b'] ?>" class="form-control" id="koreksippl3_par1b" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1b" value="<?= $pil3['hasil_pil3_par1b'] ?>" class="form-control" id="nilaippl3_par1b" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >

                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit3" id="penyaluran_kredit3">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1b'] == "2" ? "selected" : "" ?>>2 = Terjadi kenaikan OSC pada sektor ekonomi yang dikuasai dan NPL membaik</option>
                                                    <option value="3" <?= $pil3['pilar3_1b'] == "3" ? "selected" : "" ?>>3 = Terjadi kenaikan OSC pada sektor ekonomi yang dikuasai dan NPL stagnan</option>
                                                    <option value="4" <?= $pil3['pilar3_1b'] == "4" ? "selected" : "" ?>>4 = Terjadi penurunan OSC pada sektor ekonomi yang dikuasai dan NPL memburuk</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1b'] ?>
                                            </th>

                                            <th colspan="8">

                                            </th>


                                        </tr>


                                       



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c. Pertumbuhan OSC dan NPL
                                            </th>
                                            <th >
                                                <center>Pertumbuhan Kredit<input type="text" form="my_form" name="aba" value="<?= $pilar3_p1c_pertumbuhan_kredit ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Pertumbuhan Noa<input type="text" form="my_form" name="pil3_par1c_limit_persen" value="<?= $pilar3_p1c_pertumbuhan_noa ?>" class="form-control" id="pil3_par1c_limit_persen" readonly>
                                                </center>
                                                <center>Pertumbuhan Rasio NPL<input type="text" form="my_form" name="aba" value="<?= $pilar3_p1c_pertumbuhan_rasio_npl ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Pertumbuhan NOA NPL<input type="text" form="my_form" name="pil3_par1c_limit_persen" value="<?= $pilar3_p1c_pertumbuhan_noa_npl ?>" class="form-control" id="pil3_par1c_limit_persen" readonly>
                                                </center>


                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1c_rumus ?></center>
                                            </td>


                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1c" value="<?= $pil3['pilar3_1c'] ?>" class="form-control" id="koreksippl3_par1c" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1c" value="<?= $pil3['hasil_pil3_par1c'] ?>" class="form-control" id="nilaippl3_par1c" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >

                                               
                                                <select class="form-select" form="my_form" name="penyaluran_kredit3_5" id="penyaluran_kredit3_5">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil3['pilar3_1c'] == "1" ? "selected" : "" ?>>1 = Pertumbuhan kredit positif dan NPL mengalami perbaikan</option>
                                                    <option value="2" <?= $pil3['pilar3_1c'] == "2" ? "selected" : "" ?>>2 = Pertumbuhan kredit positif dan NPL stagnan</option>
                                                    <option value="3" <?= $pil3['pilar3_1c'] == "3" ? "selected" : "" ?>>3 = Pertumbuhan Kredit positif namun NPL mengalami kenaikan</option>
                                                    <option value="4" <?= $pil3['pilar3_1c'] == "4" ? "selected" : "" ?>>4 = Pertumbuhan kredit negatif dan NPL mengalami perbaikan</option>
                                                    <option value="5" <?= $pil3['pilar3_1c'] == "5" ? "selected" : "" ?>>5 = Pertumbuhan kredit negatif dan NPL mengalami kenaikan</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1c'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                d. Penempatan dana antar bank
                                            </th>
                                            <th >
                                                <center>Aba Pada BPR<input type="text" form="my_form" name="aba" value="<?= rupiah($master_kredit_P3['aba_bpr']) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Total ABA<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($master_kredit_P1['aba']) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td>
                                                <center><input type="text" form="my_form" name="aba" value="<?= number_format($hsl_pil3_par1d ,2) ?>" class="form-control" id="rupiah" readonly></center>
                                            </td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1d_rumus ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1d" value="<?= $pil3['pilar3_1d'] ?>" class="form-control" id="koreksippl3_par1d" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1d" value="<?= $pil3['hasil_pil3_par1d'] ?>" class="form-control" id="nilaippl3_par1d" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >

                                                <label for="example-select" class="form-label">Penyaluran dana dalam bentuk penempatan ABA</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit4" id="penyaluran_kredit4">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1d'] == "2" ? "selected" : "" ?>>2 = seluruhnya ditempatkan pada Bank Umum</option>
                                                    <option value="3" <?= $pil3['pilar3_1d'] == "3" ? "selected" : "" ?>>3 = Kurang dari 20% ditempatkan pada BPR</option>
                                                    <option value="4" <?= $pil3['pilar3_1d'] == "4" ? "selected" : "" ?>>4 = Lebih dari 20% ditempatkan di BPR</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1d'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>


                                        



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                e. Konsentrasi Penempatan ABA
                                            </th>
                                            <th >
                                                <center>Aba Pada Bank Teringgi<input type="text" form="my_form" name="aba" value="<?= rupiah($master_kredit_P3['aba_tertinggi']) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Total ABA<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($master_kredit_P1['aba']) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td>
                                                <center><input type="text" form="my_form" name="aba" value="<?= round($hsl_pil3_par1e, 2) ?>" class="form-control" id="rupiah" readonly></center>
                                            </td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1e_rumus ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1e" value="<?= $pil3['pilar3_1e'] ?>" class="form-control" id="koreksippl3_par1e" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1e" value="<?= $pil3['hasil_pil3_par1e'] ?>" class="form-control" id="nilaippl3_par1e" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >

                                                <label for="example-select" class="form-label">Konsentrasi penyaluran dana dalam bentuk </br>penempatan ABA</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit5" id="penyaluran_kredit5">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1e'] == "2" ? "selected" : "" ?>>2 = seluruhnya ditempatkan pada Bank Umum</option>
                                                    <option value="3" <?= $pil3['pilar3_1e'] == "3" ? "selected" : "" ?>>3 = Kurang dari 20% ditempatkan pada BPR</option>
                                                    <option value="4" <?= $pil3['pilar3_1e'] == "4" ? "selected" : "" ?>>4 = Lebih dari 20% ditempatkan di BPR</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1e'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>


                                        

                                        <tr bgcolor="#acdbfb">

                                            <th style="font-size: 18px;" colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 3</center>
                                            </th>
                                            <th >
                                                <center>Tertinggi</center>
                                                <center><input type="number" form="my_form" name="tertinggi_pil3" value="<?= $hasil['pil3_tertinggi'] ?>" class="form-control" id="tertinggi_pil3" readonly></center>
                                            </th>
                                            <th >
                                                <center>Terendah</center>
                                                <center><input type="number" form="my_form" name="terendah_pil3" value="<?= $hasil['pil3_terendah'] ?>" class="form-control" id="terendah_pil3" readonly></center>
                                            </th>
                                            <th >
                                                <center>Rata-rata</center>
                                                <center><input type="number" form="my_form" name="rata_rata_pil3" value="<?= $hasil['pil3_rata_rata'] ?>" class="form-control" id="rata_rata_pil3" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <select class="form-select" id="set_pil3" disabled>
                                                    <option value="1" <?= $inheren['inheren_kre_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $inheren['inheren_kre_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $inheren['inheren_kre_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select>
                                            </th>
                                            <th >
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil3" value="<?= $hasil['pil3_tingkat_risiko'] ?>" class="form-control" id="risiko_pil3" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" maxlength="500" id="ket_pil3" form="my_form" name="ket_pil3" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil3'] ?></textarea>
                                            <span id="penghitung-karakter11"><?= $length['l11'] ?></span><span> / 500</span>
                                            </th>

                                        </tr>









                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 4 : Faktor Eksternal</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th >
                                                Faktor Eksternal
                                            </th>
                                            <th >
                                            </th>
                                            <td></td>
                                            <td>
                                            <td>
                                            </td>

                                            <th>
                                             
                                            </th>
                                            <th>
                                               
                                            </th>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil4_1" form="my_form" name="ket_pil4_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil4_1'] ?></textarea>
                                            <span id="penghitung-karakter12"><?= $length['l12'] ?></span><span> / 500</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >
                                        
                                            </th>
                                            <th >
                                            
                                            </th>
                                            <th colspan="2">
                                               
                                        
                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a. Layanan Digital Kompetitor
                                                <select class="form-select" form="my_form" name="pilar4_1a" id="pilar4_1a">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1a'] == "1" ? "selected" : "" ?>>1 = Tidak berdampak pada kinerja Bank</option>
                                                    <option value="2" <?= $pil4['pilar4_1a'] == "2" ? "selected" : "" ?>>2 = Berdampak namun loyalitas nasabah masih terjaga</option>
                                                    <option value="3" <?= $pil4['pilar4_1a'] == "3" ? "selected" : "" ?>>3 = Berdampak loyalitas nasabah mulai menurun</option>
                                                    <option value="4" <?= $pil4['pilar4_1a'] == "4" ? "selected" : "" ?>>4 = Terdapat Kejadian Luar Biasa Yang Berpengaruh sd 5% Terhadap Kinerja Kredit</option>
                                                    <option value="5" <?= $pil4['pilar4_1a'] == "5" ? "selected" : "" ?>>5 = Terdapat Kejadian Luar Biasa Yang Berpengaruh >5% Terhadap Kinerja Kredit</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1a'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                    

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1a" value="<?= number_format($bobot6_1 ,2) ?>" class="form-control" id="koreksippl4_par1a" readonly>
                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1a" value="<?= $pil4['hasil_pil4_par1a'] ?>" class="form-control" id="nilaippl4_par1a" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b. Kejadian luar biasa yang berpengaruh terhadap</br> kinerja Bank
                                                <select class="form-select" form="my_form" name="pilar4_1b" id="pilar4_1b">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1b'] == "1" ? "selected" : "" ?>>1 = Tidak terdapat Kejadian Luar Biasa, tidak berdampak pada usaha dan kemampuan debitur</option>
                                                    <option value="2" <?= $pil4['pilar4_1b'] == "2" ? "selected" : "" ?>>2 = Tidak terdapat Kejadian Luar Biasa</option>
                                                    <option value="3" <?= $pil4['pilar4_1b'] == "3" ? "selected" : "" ?>>3 = Terdapat Kejadian Luar Biasa Yang Berpengaruh 1% Terhadap Kinerja Kredit</option>
                                                    <option value="4" <?= $pil4['pilar4_1b'] == "4" ? "selected" : "" ?>>4 = Terdapat Kejadian Luar Biasa Yang Berpengaruh sd 5% Terhadap Kinerja Kredit</option>
                                                    <option value="5" <?= $pil4['pilar4_1b'] == "5" ? "selected" : "" ?>>5 = Terdapat Kejadian Luar Biasa Yang Berpengaruh >5% Terhadap Kinerja Kredit</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1b'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1b" value="<?= number_format($bobot6_2 ,2) ?>" class="form-control" id="koreksippl4_par1b" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1b" value="<?= $pil4['hasil_pil4_par1b'] ?>" class="form-control" id="nilaippl4_par1b" readonly>

                                            </th>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c. Persaingan Layanan antar BPR
                                                <select class="form-select" form="my_form" name="pilar4_1c" id="pilar4_1c">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1c'] == "1" ? "selected" : "" ?>>1 = tidak berdampak pada kinerja dan pelayanan Bank</option>
                                                    <option value="2" <?= $pil4['pilar4_1c'] == "2" ? "selected" : "" ?>>2 = tidak berdampak pada kinerja dan layanan namun menimbulkan keluhan nasabah</option>
                                                    <option value="3" <?= $pil4['pilar4_1c'] == "3" ? "selected" : "" ?>>3 = berdampak pada kenyamanan nasabah yang berakibat nasabah enggan datang ke kantor</option>
                                                    <option value="4" <?= $pil4['pilar4_1c'] == "4" ? "selected" : "" ?>>4 = berdampak pada kenyamanan nasabah yang berakibat putusnya hubungan kerjasama</option>
                                                    <option value="5" <?= $pil4['pilar4_1c'] == "5" ? "selected" : "" ?>> 5 = berdampak pada kinerja dan layanan Bank yang cukup signifikan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1c'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1c" value="<?= number_format($bobot6_3 ,2) ?>" class="form-control" id="koreksippl4_par1c" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1c" value="<?= $pil4['hasil_pil4_par1c'] ?>" class="form-control" id="nilaippl4_par1c" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                d. Regulasi Pemerintah
                                                <select class="form-select" form="my_form" name="pilar4_1d" id="pilar4_1d">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1d'] == "1" ? "selected" : "" ?>>1 = tidak berdampak pada volume bisnis dan capaian target NOA</option>
                                                    <option value="2" <?= $pil4['pilar4_1d'] == "2" ? "selected" : "" ?>>2 = tidak berdampak pada volume bisnis Bank namun berdampak pada capaian target</option>
                                                    <option value="3" <?= $pil4['pilar4_1d'] == "3" ? "selected" : "" ?>>3 = berdampak pada volume bisnis bank dan tidak terjadi pelepasan NOA existing</option>
                                                    <option value="4" <?= $pil4['pilar4_1d'] == "4" ? "selected" : "" ?>>4 = berdampak pada volume bisnis bank dan terjadi pelepasan NOA existing</option>
                                                    <option value="5" <?= $pil4['pilar4_1d'] == "5" ? "selected" : "" ?>>5 = berdampak pada volume bisnis dan capaian target NOA</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1d'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1d" value="<?= number_format($bobot6_4 ,2) ?>" class="form-control" id="koreksippl4_par1d" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1d" value="<?= $pil4['hasil_pil4_par1d'] ?>" class="form-control" id="nilaippl4_par1d" readonly>

                                            </th>

                                        </tr>


                                        <tr bgcolor="#acdbfb">

                                            <th style="font-size: 18px;" colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 4</center>
                                            </th>
                                            <th >
                                                
                                            </th>
                                            <th >
                                                
                                            </th>
                                            <th >
                                                
                                            </th>
                                            <th colspan="2">
                                                
                                            </th>
                                            <th >
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" value="<?= $hasil['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control" id="risiko_pil4" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" maxlength="500" id="ket_pil4" form="my_form" name="ket_pil4" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil4'] ?></textarea>
                                            <span id="penghitung-karakter13"><?= $length['l13'] ?></span><span> / 500</span>
                                            </th>

                                        </tr>



    

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>LAINNYA</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th >
                                                Faktor Lainnya
                                            </th>
                                            <th >
                                            </th>
                                            <td></td>
                                            <td>
                                            <td>
                                            </td>

                                            <th>
                                             
                                            </th>
                                            <th>
                                               
                                            </th>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil5_1" form="my_form" name="ket_pil5_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil5_1'] ?></textarea>
                                            <span id="penghitung-karakter14"><?= $length['l14'] ?></span><span> / 500</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >
                                        
                                            </th>
                                            <th >
                                            
                                            </th>
                                            <th colspan="2">
                                               
                                        
                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a. Kompetensi AO
                                                <select class="form-select" form="my_form" name="pilar5_1a" id="pilar5_1a">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1a'] == "1" ? "selected" : "" ?>>1 = AO memiliki kompetensi yang Sangat Baik</option>
                                                    <option value="2" <?= $pil5['pilar5_1a'] == "2" ? "selected" : "" ?>>2 = AO memiliki kompetensi yang Baik</option>
                                                    <option value="3" <?= $pil5['pilar5_1a'] == "3" ? "selected" : "" ?>>3 = AO memiliki kompetensi yang Cukup Baik</option>
                                                    <option value="4" <?= $pil5['pilar5_1a'] == "4" ? "selected" : "" ?>>4 = AO memiliki kompetensi yang Kurang Baik</option>
                                                    <option value="5" <?= $pil5['pilar5_1a'] == "5" ? "selected" : "" ?>>5 = AO memiliki kompetensi yang Sangat Buruk</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1a'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                         

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1a" value="<?= number_format($bobot7_1 ,2) ?>" class="form-control" id="koreksippl5_par1a" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1a" value="<?= $pil5['hasil_pil5_par1a'] ?>" class="form-control" id="nilaippl5_par1a" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b. Kompetensi Analis
                                                <select class="form-select" form="my_form" name="pilar5_1b" id="pilar5_1b">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1b'] == "1" ? "selected" : "" ?>>1 = Analis memiliki kompetensi yang Sangat Baik</option>
                                                    <option value="2" <?= $pil5['pilar5_1b'] == "2" ? "selected" : "" ?>>2 = Analis memiliki kompetensi yang Baik</option>
                                                    <option value="3" <?= $pil5['pilar5_1b'] == "3" ? "selected" : "" ?>>3 = Analis memiliki kompetensi yang Cukup Baik</option>
                                                    <option value="4" <?= $pil5['pilar5_1b'] == "4" ? "selected" : "" ?>>4 = Analis memiliki kompetensi yang Kurang Baik</option>
                                                    <option value="5" <?= $pil5['pilar5_1b'] == "5" ? "selected" : "" ?>>5 = Analis memiliki kompetensi yang Sangat Buruk</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1b'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1b" value="<?= number_format($bobot7_2 ,2) ?>" class="form-control" id="koreksippl5_par1b" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1b" value="<?= $pil5['hasil_pil5_par1b'] ?>" class="form-control" id="nilaippl5_par1b" readonly>

                                            </th>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c. Komite Kredit
                                                <select class="form-select" form="my_form" name="pilar5_1c" id="pilar5_1c">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1c'] == "1" ? "selected" : "" ?>>1. Pembahasan Semua Aspek Perkreditan Meliputi 7C</option>
                                                    <option value="2" <?= $pil5['pilar5_1c'] == "2" ? "selected" : "" ?>>2. Pembahasan Semua Aspek Perkreditan Meliputi 6C</option>
                                                    <option value="3" <?= $pil5['pilar5_1c'] == "3" ? "selected" : "" ?>>3. Pembahasan Semua Aspek Perkreditan Meliputi 5C</option>
                                                    <option value="4" <?= $pil5['pilar5_1c'] == "4" ? "selected" : "" ?>>4. Pembahasan Semua Aspek Perkreditan Meliputi 3C (Character, Capital, Capacity)</option>
                                                    <option value="5" <?= $pil5['pilar5_1c'] == "5" ? "selected" : "" ?>>5. Pembahasan Semua Aspek Perkreditan Tidak Meliputi 5C</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1c'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1c" value="<?= number_format($bobot7_3 ,2) ?>" class="form-control" id="koreksippl5_par1c" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1c" value="<?= $pil5['hasil_pil5_par1c'] ?>" class="form-control" id="nilaippl5_par1c" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                d. Keputusan dan Realisasi Kredit
                                                <select class="form-select" form="my_form" name="pilar5_1d" id="pilar5_1d">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1d'] == "1" ? "selected" : "" ?>>1. Keputusan Kredit Ditandatangani pada Hari yang Sama Saat Komite, Realisasi Dilakukan Apabila Seluruh Persyaratan terpenuhi</option>
                                                    <option value="2" <?= $pil5['pilar5_1d'] == "2" ? "selected" : "" ?>>2. Keputusan Kredit Maksimal 1 (Satu) Hari Kerja Setelah Komite, Realisasi Dilakukan Apabila Seluruh Persyaratan terpenuhi</option>
                                                    <option value="3" <?= $pil5['pilar5_1d'] == "3" ? "selected" : "" ?>>3. Keputusan Kredit Maksimal 1 (Satu) Hari Kerja Setelah Komite, Realisasi Dilakukan Apabila Persyaratan Utama terpenuhi</option>
                                                    <option value="4" <?= $pil5['pilar5_1d'] == "4" ? "selected" : "" ?>>4. Keputusan Kredit Ditandatangani pada Hari yang Sama Saat Komite, Realisasi Dilakukan Apabila Persyaratan Terpenuhi Sebagian</option>
                                                    <option value="5" <?= $pil5['pilar5_1d'] == "5" ? "selected" : "" ?>>5. Keputusan Kredit Ditandatangani pada Hari yang Sama Saat Komite, Realisasi Dilakukan Apabila Seluruh Persyaratan Belum Terpenuhi</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1d'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                        

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1d" value="<?= number_format($bobot7_4 ,2) ?>" class="form-control" id="koreksippl5_par1d" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1d" value="<?= $pil5['hasil_pil5_par1d'] ?>" class="form-control" id="nilaippl5_par1d" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                e. Monitoring Penggunaan Dana Kredit
                                                <select class="form-select" form="my_form" name="pilar5_1e" id="pilar5_1e">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1e'] == "1" ? "selected" : "" ?>>1 = Monitoring Penggunaan Dana 3 (Tiga) Hari Kerja Setelah Realisasi</option>
                                                    <option value="2" <?= $pil5['pilar5_1e'] == "2" ? "selected" : "" ?>>2 = Monitoring Penggunaan Dana 15 (Lima Belas) Hari Kerja Setelah Realisasi</option>
                                                    <option value="3" <?= $pil5['pilar5_1e'] == "3" ? "selected" : "" ?>>3 = Monitoring Penggunaan Dana 20 (Lima Belas) Hari Kerja Setelah Realisasi</option>
                                                    <option value="4" <?= $pil5['pilar5_1e'] == "4" ? "selected" : "" ?>>4 = Monitoring Penggunaan Dana 25 (Dua Puluh Lima) Hari Kerja Setelah Realisasi</option>
                                                    <option value="5" <?= $pil5['pilar5_1e'] == "5" ? "selected" : "" ?>>5 = Monitoring Penggunaan Dana > 25 (Dua Puluh Lima) Hari Kerja Setelah Realisasi</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1e'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1e" value="<?= number_format($bobot7_5 ,2) ?>" class="form-control" id="koreksippl5_par1e" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1e" value="<?= $pil5['hasil_pil5_par1e'] ?>" class="form-control" id="nilaippl5_par1e" readonly>

                                            </th>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                f. Pengawasan Kredit
                                                <select class="form-select" form="my_form" name="pilar5_1f" id="pilar5_1f">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1f'] == "1" ? "selected" : "" ?>>1 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) Minimal 1 (satu) Kali Sebulan</option>
                                                    <option value="2" <?= $pil5['pilar5_1f'] == "2" ? "selected" : "" ?>>2 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) Minimal 2 (Dua) Kali Sebulan</option>
                                                    <option value="3" <?= $pil5['pilar5_1f'] == "3" ? "selected" : "" ?>>3 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) Minimal 1 (Satu) Kali Sebulan, Kecuali Debitur Tanpa Tunggakan Maksimal 2 (Dua) Bulan 1 (Satu) Kali Kunjungan </option>
                                                    <option value="4" <?= $pil5['pilar5_1f'] == "4" ? "selected" : "" ?>>4 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) 1 (Satu) Kali Sebulan, Kecuali Debitur Tanpa Tunggakan Maksimal 3 (Tiga) Bulan 1 (Satu) Kali Kunjungan </option>
                                                    <option value="5" <?= $pil5['pilar5_1f'] == "5" ? "selected" : "" ?>>5 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) kurang dari 1 (Satu) Kali Sebulan, Debitur Tanpa Tunggakan > 2 (Dua) Bulan untuk 1 (Satu) Kali Kunjungan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1f'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1f" value="<?= number_format($bobot7_6 ,2) ?>" class="form-control" id="koreksippl5_par1f" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1f" value="<?= $pil5['hasil_pil5_par1f'] ?>" class="form-control" id="nilaippl5_par1f" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                g. Kecukupan Jumlah SDM Perkreditan
                                                <select class="form-select" form="my_form" name="pilar5_1g" id="pilar5_1g">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1g'] == "1" ? "selected" : "" ?>>1 =Tidak Terdapat Kekosongan SOTK Bidang Perkreditan</option>
                                                    <option value="2" <?= $pil5['pilar5_1g'] == "2" ? "selected" : "" ?>>2 =Terdapat Kekosongan SOTK Pada 2 (Dua) Formasi Non Struktural Bidang Perkreditan</option>
                                                    <option value="3" <?= $pil5['pilar5_1g'] == "3" ? "selected" : "" ?>>3 =Terdapat Kekosongan SOTK Pada 3 (Tiga) Formasi Non Struktural Bidang Perkreditan</option>
                                                    <option value="4" <?= $pil5['pilar5_1g'] == "4" ? "selected" : "" ?>>4 =Terdapat Kekosongan SOTK Pada 5 (Lima) Formasi Non Struktural Bidang Perkreditan</option>
                                                    <option value="5" <?= $pil5['pilar5_1g'] == "5" ? "selected" : "" ?>>5 =Terdapat Kekosongan SOTK Pada > 5 (Lima) Formasi Non Struktural Bidang Perkreditan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1g'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1g" value="<?= number_format($bobot7_7 ,2) ?>" class="form-control" id="koreksippl5_par1g" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1g" value="<?= $pil5['hasil_pil5_par1g'] ?>" class="form-control" id="nilaippl5_par1g" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                h. Kompetensi SDM Perkreditan
                                                <select class="form-select" form="my_form" name="pilar5_1h" id="pilar5_1h">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1h'] == "1" ? "selected" : "" ?>>1. 100% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>
                                                    <option value="2" <?= $pil5['pilar5_1h'] == "2" ? "selected" : "" ?>>2. 80% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>
                                                    <option value="3" <?= $pil5['pilar5_1h'] == "3" ? "selected" : "" ?>>3. 75% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>
                                                    <option value="4" <?= $pil5['pilar5_1h'] == "4" ? "selected" : "" ?>>4. 50% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>
                                                    <option value="5" <?= $pil5['pilar5_1h'] == "5" ? "selected" : "" ?>>5. < 50% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1h'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                          

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1h" value="<?= number_format($bobot7_8 ,2) ?>" class="form-control" id="koreksippl5_par1h" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1h" value="<?= $pil5['hasil_pil5_par1h'] ?>" class="form-control" id="nilaippl5_par1h" readonly>

                                            </th>

                                        </tr>

  


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                i. Pengawasan Internal (Risk Taking Unit dan </br> Satuan Kerja Pengendalian) di Bidang Perkreditan
                                                <select class="form-select" form="my_form" name="pilar5_1k" id="pilar5_1k">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1k'] == "1" ? "selected" : "" ?>>1 = Pengawasan Internal Berkala Setiap Hari</option>
                                                    <option value="2" <?= $pil5['pilar5_1k'] == "2" ? "selected" : "" ?>>2 = Pengawasan Internal Berkala Minimal Seminggu Sekali</option>
                                                    <option value="3" <?= $pil5['pilar5_1k'] == "3" ? "selected" : "" ?>>3 = Pengawasan Internal Berkala Minimal 2 (Dua) Minggu Sekali</option>
                                                    <option value="4" <?= $pil5['pilar5_1k'] == "4" ? "selected" : "" ?>>4 = Pengawasan Internal Berkala 1 (Satu) Sebulan</option>
                                                    <option value="5" <?= $pil5['pilar5_1k'] == "5" ? "selected" : "" ?>>5 = Pengawasan Internal Berkala Tidak Dilakukan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1k'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1k" value="<?= number_format($bobot7_11 ,2) ?>" class="form-control" id="koreksippl5_par1k" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1k" value="<?= $pil5['hasil_pil5_par1k'] ?>" class="form-control" id="nilaippl5_par1k" readonly>

                                            </th>

                                        </tr>

                                        <tr style="font-size: 18px;" bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko lainnya</center>
                                            </th>
                                            <th >
                                                
                                            </th>
                                            <th >
                                                
                                            </th>
                                            <th >
                                                
                                            </th>
                                            <th colspan="2">
                                                
                                            </th>
                                            <th >
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil5" value="<?= $hasil['pil5_tingkat_risiko'] ?>" class="form-control" id="risiko_pil5" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" maxlength="500" id="ket_pil5" form="my_form" name="ket_pil5" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil5'] ?></textarea>
                                            <span id="penghitung-karakter15"><?= $length['l15'] ?></span><span> / 500</span>
                                            </th>

                                        </tr>


                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->

<br></br>
<br></br>


                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th style="font-size: 20px;" colspan="9">
                                                <center>REKAP PENILAIAN INHEREN KREDIT</center>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 1 - Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit
                                            </th>
                                            
                                            <td width="10%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil1" form="my_form" value="<?= $hasil['pil1_tingkat_risiko'] ?>" name="hasil_risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 2 - Kualitas Aset
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil2" form="my_form" value="<?= number_format($pil2_tingkat_risiko ,2) ?>" name="hasil_risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 3 - Strategi Penyediaan Dana
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil3" form="my_form" value="<?= $hasil['pil3_tingkat_risiko'] ?>" name="hasil_risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 4 - Faktor Eksternal
                                            </th>
                                           
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil4" form="my_form" value="<?= $hasil['pil4_tingkat_risiko'] ?>" name="hasil_risiko_pil4" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Lainnya
                                            </th>
                                           
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil5" form="my_form" value="<?= $hasil['pil5_tingkat_risiko'] ?>" name="hasil_risiko_pil5" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                    
                                    <tbody>
                                        <tr class="table" bgcolor="#74c7ff">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Inheren
                                            </th>
                                            <td width="8%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_inheren" form="my_form" value="<?= $hasil['hasil_inheren_tertinggi'] ?>" name="tertinggi_inheren" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_inheren" form="my_form" value="<?= $hasil['hasil_inheren_terendah'] ?>" name="terendah_inheren" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_inheren" form="my_form" value="<?= $hasil['hasil_inheren_rata_rata'] ?>" name="rata_rata_inheren" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                                <center>Nilai diambil</center>
                                                <select class="form-select" id="opsi_inheren" disabled>
                                                    <option value="1" <?= $inheren['inheren_kre_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $inheren['inheren_kre_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $inheren['inheren_kre_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select>
                                            </td>
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_inheren" form="my_form" value="<?= $hasil['hasil_tingkat_risiko'] ?>" name="risiko_inheren" class="form-control"  readonly="">
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_inheren" form="my_form" value="<?= $hasil['hasil_peringkat'] ?>" name="peringkat_inheren" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead class="table-primary">
                                        <tr style="font-size: 20px;">

                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Kredit</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control" maxlength="1000" id="ket_inheren" form="my_form" name="ket_inheren" cols="60" rows="10"><?= $ket_inhern_kredit['ket_inheren'] ?></textarea>
                                            <span id="penghitung-karakter16"><?= $length['l16'] ?></span><span> / 1000</span>
                                            </th>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>































                            <hr>
                            </hr>

                            <br></br>

                            <div class="row">
                                <div class="col-12">
                                    <div class="col-lg-1 ">
                                        <button class="btn btn-primary" form="my_form" type="submit" name="submit">Simpan</button>
                                    </div>

                                </div>
                            </div>





                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>


            <!-- end row -->


            <!-- end row -->



            <!-- end row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->



</div>


