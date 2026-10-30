<?php
// FIX AUTOSAVE: buffer output agar response AJAX bersih JSON, bukan tercampur HTML/modal.
if (!ob_get_level()) { ob_start(); }

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
$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang WHERE id_profil_risiko = ?", [$id]));

$frame_laporan_likuiditas = mysqli_fetch_array(simpro_db_query($conn, "SELECT user,tahun,periode,data_pembanding FROM frame_laporan_profil_risiko WHERE id_profil_risiko = ?", [$id]));
$jenis_pr = $frame_laporan_likuiditas['user'];
$tahun = $frame_laporan_likuiditas['tahun'];
$periode = $frame_laporan_likuiditas['periode'];
$dp = $frame_laporan_likuiditas['data_pembanding'];


$master_likuiditas_P1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_likuiditas_pilar1 WHERE id_profil_risiko = ?", [$id]));
$master_kredit_P1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar1 WHERE id_profil_risiko = ?", [$id]));

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_likuiditas_lainnya WHERE id_profil_risiko = ?", [$id]));

$pembanding_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_likuiditas_lainnya WHERE id_profil_risiko = ?", [$dp]));

$hasil = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = ?", [$id]));


$inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_likuiditas WHERE user = ? AND tahun = ? AND periode = ?", [$jenis_pr, $tahun, $periode]));

$ket_inhern_likuiditas = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren_likuiditas WHERE id_profil_risiko = ?", [$id]));


// Ambang batas likuiditas harus ambil row yang sesuai user/jenis profil risiko aktif.
// Sebelumnya hanya berdasarkan tahun, sehingga bisa mengambil row lama/salah jika ada lebih dari satu setting ambang pada tahun yang sama.
$q_amb_lik = simpro_db_query($conn, "
    SELECT *
    FROM ambang_batas_likuiditas
    WHERE tahun = ?
      AND user = ?
    ORDER BY id_ambang_batas_likuiditas DESC
    LIMIT 1
", [$tahun, $jenis_pr]);
if ($q_amb_lik && mysqli_num_rows($q_amb_lik) > 0) {
    $ambang_batas_likuiditas = mysqli_fetch_array($q_amb_lik);
} else {
    $q_amb_lik = simpro_db_query($conn, "
        SELECT *
        FROM ambang_batas_likuiditas
        WHERE tahun = ?
          AND (user IS NULL OR user = 0 OR user = '')
        ORDER BY id_ambang_batas_likuiditas DESC
        LIMIT 1
    ", [$tahun]);
    $ambang_batas_likuiditas = ($q_amb_lik && mysqli_num_rows($q_amb_lik) > 0) ? mysqli_fetch_array($q_amb_lik) : [];
}
// Bobot likuiditas menggunakan setting aktif bobot_likuiditas_per_parameter.

$info_kuantitatif_likuiditas = [];
$cek_info_kuantitatif_likuiditas = mysqli_query($conn, "SHOW TABLES LIKE 'info_kuantitatif_inheren'");
if ($cek_info_kuantitatif_likuiditas && mysqli_num_rows($cek_info_kuantitatif_likuiditas) > 0) {
    $q_info_kuantitatif_likuiditas = mysqli_query($conn, "SELECT parameter_key, info_text FROM info_kuantitatif_inheren WHERE risiko='likuiditas'");
    while ($iq = mysqli_fetch_assoc($q_info_kuantitatif_likuiditas)) {
        $info_kuantitatif_likuiditas[$iq['parameter_key']] = $iq['info_text'];
    }
}

function likuiditas_info_kuantitatif_btn($map, $key){
    $txt = trim((string)($map[$key] ?? ''));
    if ($txt === '') $txt = 'Info kuantitatif untuk parameter ini belum diisi.';
    return '<button type="button" class="info-kuantitatif-btn" data-info="'.htmlspecialchars($txt, ENT_QUOTES, 'UTF-8').'" title="Info kuantitatif"><i class="mdi mdi-information-outline"></i></button>';
}



//pembobotan
// FIX: Bobot likuiditas harus mengikuti setting aktif pada menu Penetapan Bobot Faktor.
// Sebelumnya hanya SELECT berdasarkan tahun, sehingga untuk user=3 (Profil Risiko Kantor Cabang)
// bisa terbaca bobot SKMR / setting lain pada tahun yang sama.
$is_profil_risiko_cabang = ((int)$jenis_pr === 3);

$q_bobot_likuiditas_aktif = mysqli_query($conn, "
    SELECT blp.*
    FROM frame_bobot fb
    INNER JOIN bobot_likuiditas_per_parameter blp
        ON blp.id_bobot = fb.id_bobot
    WHERE fb.user = '".mysqli_real_escape_string($conn, (string)$jenis_pr)."'
      AND fb.is_aktif = '1'
    ORDER BY fb.id_bobot DESC
    LIMIT 1
");

if ($q_bobot_likuiditas_aktif && mysqli_num_rows($q_bobot_likuiditas_aktif) > 0) {
    $pembobotan = mysqli_fetch_array($q_bobot_likuiditas_aktif);
} else {
    // fallback data lama jika belum memakai frame_bobot
    $pembobotan = mysqli_fetch_array(simpro_db_query($conn, "
        SELECT *
        FROM bobot_likuiditas_per_parameter
        WHERE tahun = ?
        ORDER BY id_bobot_likuiditas_per_parameter DESC
        LIMIT 1
    ", [$tahun]));
}

if (!function_exists('lik_bobot_num_fix')) {
function lik_bobot_num_fix($row, $field, $fallback = 0){
    if (is_array($row) && isset($row[$field]) && $row[$field] !== '' && $row[$field] !== null) {
        return (float)$row[$field];
    }
    return (float)$fallback;
}}

$bobot2_1 = lik_bobot_num_fix($pembobotan, 'sub_parameter2_1', $is_profil_risiko_cabang ? 0.12500 : 0.11111);
$bobot2_2 = lik_bobot_num_fix($pembobotan, 'sub_parameter2_2', $is_profil_risiko_cabang ? 0.12500 : 0.11111);
$bobot2_3 = lik_bobot_num_fix($pembobotan, 'sub_parameter2_3', $is_profil_risiko_cabang ? 0.12500 : 0.11111);
$bobot2_4 = lik_bobot_num_fix($pembobotan, 'sub_parameter2_4', $is_profil_risiko_cabang ? 0.12500 : 0.11111);
$bobot2_5 = lik_bobot_num_fix($pembobotan, 'sub_parameter2_5', $is_profil_risiko_cabang ? 0.12500 : 0.11111);
$bobot2_6 = lik_bobot_num_fix($pembobotan, 'sub_parameter2_6', $is_profil_risiko_cabang ? 0.12500 : 0.11111);
$bobot2_7 = lik_bobot_num_fix($pembobotan, 'sub_parameter2_7', $is_profil_risiko_cabang ? 0.12500 : 0.11111);
$bobot2_8 = $is_profil_risiko_cabang ? 0.00000 : lik_bobot_num_fix($pembobotan, 'sub_parameter2_8', 0.11111);
$bobot2_9 = lik_bobot_num_fix($pembobotan, 'sub_parameter2_9', $is_profil_risiko_cabang ? 0.12500 : 0.11111);

$bobot3_1 = lik_bobot_num_fix($pembobotan, 'sub_parameter3_1', 0.33333);
$bobot3_2 = lik_bobot_num_fix($pembobotan, 'sub_parameter3_2', 0.33333);
$bobot3_3 = lik_bobot_num_fix($pembobotan, 'sub_parameter3_3', 0.33333);
$bobot3_4 = lik_bobot_num_fix($pembobotan, 'sub_parameter3_4', 0.33333);
$bobot4_1 = lik_bobot_num_fix($pembobotan, 'sub_parameter4_1', 0.25000);
$bobot4_2 = lik_bobot_num_fix($pembobotan, 'sub_parameter4_2', 0.25000);
$bobot4_3 = lik_bobot_num_fix($pembobotan, 'sub_parameter4_3', 0.25000);
$bobot4_4 = lik_bobot_num_fix($pembobotan, 'sub_parameter4_4', 0.25000);
$bobot5_1 = lik_bobot_num_fix($pembobotan, 'sub_parameter5_1', 0.33333);
$bobot5_2 = lik_bobot_num_fix($pembobotan, 'sub_parameter5_2', 0.33333);
$bobot5_3 = lik_bobot_num_fix($pembobotan, 'sub_parameter5_3', 0.33333);
$bobot6_1 = lik_bobot_num_fix($pembobotan, 'sub_parameter6_1', 0.33333);
$bobot6_2 = lik_bobot_num_fix($pembobotan, 'sub_parameter6_2', 0.33333);
$bobot6_3 = lik_bobot_num_fix($pembobotan, 'sub_parameter6_3', 0.33333);
$bobot6_4 = lik_bobot_num_fix($pembobotan, 'sub_parameter6_4', 0.00000);
$bobot6_5 = lik_bobot_num_fix($pembobotan, 'sub_parameter6_5', 0.00000);
$bobot6_6 = lik_bobot_num_fix($pembobotan, 'sub_parameter6_6', 0.00000);

//setingan ditetapkan
$set_pil1 = $inheren['inheren_lik_set_pil1'];
$set_pil2 = $inheren['inheren_lik_set_pil2'];
$set_pil3 = $inheren['inheren_lik_set_pil3'];
$set_tingkat_risiko = $inheren['inheren_lik_set_tingkat_risiko'];

// === FIX: NILAI DIAMBIL MENGIKUTI SETTING PERUMUSAN ===
// Jika setting perumusan = Perskalaan, maka nilai diambil mengikuti metode Tertinggi/Terendah/Rata-rata.
// Jika setting perumusan = Pembobotan, maka nilai pilar dihitung dari Rata-rata x Bobot Pilar.
if (!function_exists('lik_table_exists_local')) {
function lik_table_exists_local($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}}
if (!function_exists('lik_col_exists_local')) {
function lik_col_exists_local($conn, $table, $column){
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}}
if (!function_exists('lik_one_local')) {
function lik_one_local($conn, $sql){
    $q = mysqli_query($conn, $sql);
    return ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : null;
}}
if (!function_exists('lik_pick_nilai_setting')) {
function lik_pick_nilai_setting($mode, $metode, $bobot, $tertinggi, $terendah, $rata){
    $mode = strtolower((string)$mode);
    $metode = (int)$metode;
    $bobot = (float)$bobot;
    $tertinggi = (float)$tertinggi;
    $terendah = (float)$terendah;
    $rata = (float)$rata;
    if ($mode === 'pembobotan') return round($rata * ($bobot / 100), 2);
    if ($metode === 1) return round($tertinggi, 2);
    if ($metode === 2) return round($terendah, 2);
    return round($rata, 2);
}}

$setris_mode_lik = 'perskalaan';
$setris_bobot_pil1 = 0;
$setris_bobot_pil2 = 0;
$setris_bobot_pil3 = 0;
$perumusan_likuiditas = null;
$perumusan_likuiditas_pilar = [];

if (lik_table_exists_local($conn, 'frame_perumusan') && lik_table_exists_local($conn, 'perumusan_inheren') && lik_table_exists_local($conn, 'perumusan_inheren_pilar')) {
    $whereAktif = " WHERE is_aktif = '1' ";
    if (lik_col_exists_local($conn, 'frame_perumusan', 'user_id')) {
        $whereAktif .= " AND user_id = '".mysqli_real_escape_string($conn, (string)$jenis_pr)."' ";
    }
    $frame_perumusan_lik = lik_one_local($conn, "
        SELECT *
        FROM frame_perumusan
        $whereAktif
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");

    if ($frame_perumusan_lik) {
        $perumusan_likuiditas = lik_one_local($conn, "
            SELECT *
            FROM perumusan_inheren
            WHERE id_frame_perumusan = '".(int)$frame_perumusan_lik['id_frame_perumusan']."'
              AND (
                    UPPER(nama_risiko) = 'RISIKO LIKUIDITAS'
                 OR UPPER(nama_risiko) = 'LIKUIDITAS'
                 OR UPPER(nama_risiko) LIKE '%LIKUIDITAS%'
              )
            ORDER BY id_perumusan_inheren DESC
            LIMIT 1
        ");

        if ($perumusan_likuiditas) {
            $setris_mode_lik = ((int)($perumusan_likuiditas['pembobotan'] ?? 0) === 1) ? 'pembobotan' : 'perskalaan';

            $qPilSet = mysqli_query($conn, "
                SELECT *
                FROM perumusan_inheren_pilar
                WHERE id_perumusan_inheren = '".(int)$perumusan_likuiditas['id_perumusan_inheren']."'
                ORDER BY id_pilar ASC
            ");
            if ($qPilSet) {
                while ($rPilSet = mysqli_fetch_assoc($qPilSet)) {
                    $perumusan_likuiditas_pilar[(int)$rPilSet['id_pilar']] = $rPilSet;
                }
            }

            if (isset($perumusan_likuiditas_pilar[1])) {
                $set_pil1 = (int)($perumusan_likuiditas_pilar[1]['perskalaan_metode'] ?: $set_pil1);
                $setris_bobot_pil1 = (float)$perumusan_likuiditas_pilar[1]['pembobotan'];
            }
            if (isset($perumusan_likuiditas_pilar[2])) {
                $set_pil2 = (int)($perumusan_likuiditas_pilar[2]['perskalaan_metode'] ?: $set_pil2);
                $setris_bobot_pil2 = (float)$perumusan_likuiditas_pilar[2]['pembobotan'];
            }
            if (isset($perumusan_likuiditas_pilar[3])) {
                $set_pil3 = (int)($perumusan_likuiditas_pilar[3]['perskalaan_metode'] ?: $set_pil3);
                $setris_bobot_pil3 = (float)$perumusan_likuiditas_pilar[3]['pembobotan'];
            }
        }
    }
}

// Fallback jika belum ada setting perumusan aktif
if (!in_array((int)$set_pil1, [1,2,3])) $set_pil1 = 1;
if (!in_array((int)$set_pil2, [1,2,3])) $set_pil2 = 1;
if (!in_array((int)$set_pil3, [1,2,3])) $set_pil3 = 1;
if (!in_array((int)$set_tingkat_risiko, [1,2,3])) $set_tingkat_risiko = 1;




//penamaan rasio
$kyd = $master_kredit_P1['kyd'];

$aset_likuid = $master_likuiditas_P1['aset_likuid'];
$kas = $master_likuiditas_P1['kas'];
$giro_aba = $master_likuiditas_P1['giro_aba'];
$tabungan_aba = $master_likuiditas_P1['tabungan_aba'];
$total_aset = $master_likuiditas_P1['total_aset'];
$kewajiban_lancar = $master_likuiditas_P1['kewajiban_lancar'];
$kewajiban_segera = $master_likuiditas_P1['kewajiban_segera'];
$tabungan = $master_likuiditas_P1['tabungan'];
$deposito = $master_likuiditas_P1['deposito'];
$pendanaan_jangka_pendek = $master_likuiditas_P1['pendanaan_jangka_pendek'];
$kewajiban_jangka_pendek = $master_likuiditas_P1['kewajiban_jangka_pendek'];
$deposito_1bln = $master_likuiditas_P1['deposito_1bln'];
$deposito_3bln = $master_likuiditas_P1['deposito_3bln'];
$deposito_6bln = $master_likuiditas_P1['deposito_6bln'];
$deposito_12bln = $master_likuiditas_P1['deposito_12bln'];
$pendanaan_non_inti = $master_likuiditas_P1['pendanaan_non_inti'];
$dpk_lbh_2m = $master_likuiditas_P1['dpk_lbh_2m'];
$deposito_diatas_cr = $master_likuiditas_P1['deposito_diatas_cr'];
$deposito_diatas_lps = $master_likuiditas_P1['deposito_diatas_lps'];
$korporasi = $master_likuiditas_P1['korporasi'];

$dpk_des_thn_sebelum = $master_likuiditas_P1['dpk_des_thn_sebelum'];
$alat_likuid = $master_likuiditas_P1['alat_likuid'];
$penempatan_pd_bank_lain = $master_likuiditas_P1['penempatan_pd_bank_lain'];
$modal_disetor = $master_likuiditas_P1['modal_disetor'];
$kredit_des_thn_sebelum = $master_likuiditas_P1['kredit_des_thn_sebelum'];
$pinjaman = $master_likuiditas_P1['pinjaman'];
$kredit_kolek_lancar = $master_likuiditas_P1['kredit_kolek_lancar'];
$pertumbuhan_kredit = $master_likuiditas_P1['pertumbuhan_kredit'];
$dpk_dijamin_lps = $master_likuiditas_P1['dpk_dijamin_lps'];
$simpanan_tdk_dijamin_lps = $master_likuiditas_P1['simpanan_tdk_dijamin_lps'];
$total_dpk = $master_likuiditas_P1['total_dpk'];
$dpk_tdk_dijamin_lps = $master_likuiditas_P1['dpk_tdk_dijamin_lps'];
$deposan_tabungan_terbesar25 = $master_likuiditas_P1['deposan_tabungan_terbesar25'];
$besar_deposan25 = $master_likuiditas_P1['besar_deposan25'];
$besar_penabung25 = $master_likuiditas_P1['besar_penabung25'];
$deposito_rs = $master_likuiditas_P1['deposito_rs'];
$arus_kas_netto = $master_likuiditas_P1['arus_kas_netto'];
$kas_besar_debet = $master_likuiditas_P1['kas_besar_debet'];
$kas_besar_kredit = $master_likuiditas_P1['kas_besar_kredit'];
$deposito_inti = $master_likuiditas_P1['deposito_inti'];





// menghitung rumus
$p1 = ($aset_likuid / $total_aset) * 100;
$p1a_atas =($total_aset - $aset_likuid);
$p1a_bawah =($total_dpk - $aset_likuid);
$p1a = round(($p1a_atas/$p1a_bawah) * 100, 2);

$p2 = round(($aset_likuid / $kewajiban_lancar) * 100, 2);

$p2a = round(($aset_likuid / $pendanaan_jangka_pendek) * 100, 2);
$p2b = round(($aset_likuid / $kewajiban_jangka_pendek) * 100, 2);
// FIX EXCEL: Arus Kas Netto dihitung dari Kas Besar Kredit - Kas Besar Debet jika datanya tersedia.
// Pada Excel nilai arus kas netto bisa negatif, sehingga tidak boleh hanya mengambil field arus_kas_netto yang sudah jadi.
$arus_kas_netto_hitung = $arus_kas_netto;
if (((float)$kas_besar_debet != 0) || ((float)$kas_besar_kredit != 0)) {
    $arus_kas_netto_hitung = ((float)$kas_besar_kredit - (float)$kas_besar_debet);
}
$p2c = round(($arus_kas_netto / $total_dpk) * 100, 2);
$p2d = round(($tabungan / $total_dpk) * 100, 2);
$p2e = round(($deposito_3bln / $total_dpk) * 100, 2);
$p2f = round(($deposito_6bln / $total_dpk) * 100, 2);
$p2g = round(($deposito_12bln / $total_dpk) * 100, 2);
$p2h = round(($modal_disetor / $total_dpk) * 100, 2);
$p2i = round(($pinjaman / $total_dpk) * 100, 2);


$p3 = round((100 * $kyd) / $total_dpk, 2);
$p3a = round(($dpk_dijamin_lps / $total_dpk) * 100, 2);

$p3b_atas = ($alat_likuid+$kredit_kolek_lancar);
$p3b = round(($p3b_atas / $total_dpk) * 100, 2);
$p3c = round(($deposito_6bln / $alat_likuid) * 100, 2);

$p3d_atas = (($kyd-$kredit_des_thn_sebelum)/$kredit_des_thn_sebelum) * 100;
$p3d_bawah = (($total_dpk-$dpk_des_thn_sebelum)/$dpk_des_thn_sebelum) * 100;
$p3d = round(($p3d_atas / $p3d_bawah) * 100, 2);

$p4 = round(($deposan_tabungan_terbesar25/ $total_dpk) *100, 2);

if ($pendanaan_non_inti == 0) {
    $p5 = 0;
} else {
    $p5 = round((100 * $pendanaan_non_inti) / $total_dpk, 2);
}

$p5a_atas = ($pendanaan_non_inti-$alat_likuid);
$p5a_bawah = ($total_aset-$aset_likuid);
$p5a = round($p5a_atas / $p5a_bawah , 2);

$p5b = round(($deposito_rs / $alat_likuid) * 100, 2);
$p5c = round(($aset_likuid / $pendanaan_non_inti) * 100, 2);

$p5d = round(($deposito_inti / $total_dpk) * 100, 2);











$bobot = 1 / 8;

$ab = $ambang_batas_likuiditas['al_per_ta'];
if ($p1 < $ab) {
    $hsl1 = 0;
} else {
    $hsl1 = 1;
}

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


$nilai1a = $hsl1a * $bobot;






if ($hsl1a < $hsl1) {
    $nilai = $hsl1;
}
else if ($hsl1 == 0) {
    $nilai = $hsl1a;
} else {
    $nilai = ($hsl1a + $hsl1) / 2;
}






//pil2



$para2_ab = $ambang_batas_likuiditas['al_per_kl'];
if ($p2 <= $para2_ab) {
    $hsl2 = 0;
} else {
    $hsl2 = 1;
}

//par2a
$para2_aba = $ambang_batas_likuiditas['tal_per_pjp'];
$para2_ab2a = $ambang_batas_likuiditas['rr_tal_per_pjp'];
$para2_ab3a = $ambang_batas_likuiditas['rrr_tal_per_pjp'];
$para2_ab4a = $ambang_batas_likuiditas['rrrr_tal_per_pjp'];
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
$para2_abb = $ambang_batas_likuiditas['al_per_kjp'];
$para2_ab2b = $ambang_batas_likuiditas['rr_al_per_kjp'];
$para2_ab3b = $ambang_batas_likuiditas['rrr_al_per_kjp'];
$para2_ab4b = $ambang_batas_likuiditas['rrrr_al_per_kjp'];
if ($p2b >= $para2_abb) {
    $hsl2b = 1;
} else if ($p2b < $para2_abb && $p2b >= $para2_ab2b) {
    $hsl2b = 2;
} else if ($p2b < $para2_ab2b && $p2b >= $para2_ab3b) {
    $hsl2b = 3;
} elseif ($p2b < $para2_ab3b && $p2b >= $para2_ab4b) {
    $hsl2b = 4;
} else {
    $hsl2b = 5;
}


$nilai2b = $hsl2b * $bobot2_2;

//par2c
$para2_abc = $ambang_batas_likuiditas['akn_per_tdpk'];
$para2_ab2c = $ambang_batas_likuiditas['rr_akn_per_tdpk'];
$para2_ab3c = $ambang_batas_likuiditas['rrr_akn_per_tdpk'];
$para2_ab4c = $ambang_batas_likuiditas['rrrr_akn_per_tdpk'];
// Arus Kas Netto / Total DPK mengikuti Excel:
// =IF(rasio>=ambang;1;IF(rasio>=rr;2;IF(rasio>=rrr;3;IF(rasio<=rrrr;4;5))))
if ($p2c >= $para2_abc) {
    $hsl2c = 1;
} else if ($p2c < $para2_abc && $p2c >= $para2_ab2c) {
    $hsl2c = 2;
} else if ($p2c < $para2_ab2c && $p2c >= $para2_ab3c) {
    $hsl2c = 3;
} elseif ($p2c <= $para2_ab4c) {
    $hsl2c = 4;
} else {
    $hsl2c = 5;
}


$nilai2c = $hsl2c * $bobot2_3;



//par2d
$para2_abd = (float)$ambang_batas_likuiditas['tabungan_per_tdpk'];
$para2_ab2d = (float)$ambang_batas_likuiditas['rr_tabungan_per_tdpk'];
$para2_ab3d = (float)$ambang_batas_likuiditas['rrr_tabungan_per_tdpk'];
$para2_ab4d = (float)$ambang_batas_likuiditas['rrrr_tabungan_per_tdpk'];



if ($p2d <= $para2_abd) {
    $hsl2d = 1;
} else if ($p2d <= $para2_ab2d) {
    $hsl2d = 2;
} else if ($p2d <= $para2_ab3d) {
    $hsl2d = 3;
} else if ($p2d <= $para2_ab4d) {
    $hsl2d = 4;
} else {
    $hsl2d = 5;
}


$nilai2d = $hsl2d * $bobot2_4;


//par2e
$para2_abe = $ambang_batas_likuiditas['djw3bln_per_tdpk'];
$para2_ab2e = $ambang_batas_likuiditas['rr_djw3bln_per_tdpk'];
$para2_ab3e = $ambang_batas_likuiditas['rrr_djw3bln_per_tdpk'];
$para2_ab4e = $ambang_batas_likuiditas['rrrr_djw3bln_per_tdpk'];
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



//par2f
$para2_abf = $ambang_batas_likuiditas['djw6bln_per_tdpk'];
$para2_ab2f = $ambang_batas_likuiditas['rr_djw6bln_per_tdpk'];
$para2_ab3f = $ambang_batas_likuiditas['rrr_djw6bln_per_tdpk'];
$para2_ab4f = $ambang_batas_likuiditas['rrrr_djw6bln_per_tdpk'];
if ($p2f >= $para2_abf) {
    $hsl2f = 1;
} else if ($p2f < $para2_abf && $p2f >= $para2_ab2f) {
    $hsl2f = 2;
} else if ($p2f < $para2_ab2f && $p2f >= $para2_ab3f) {
    $hsl2f = 3;
} elseif ($p2f < $para2_ab3f && $p2f >= $para2_ab4f) {
    $hsl2f = 4;
} else {
    $hsl2f = 5;
}

$nilai2f = $hsl2f * $bobot2_6;



//par2g
$para2_abg = $ambang_batas_likuiditas['djw12bln_per_tdpk'];
$para2_ab2g = $ambang_batas_likuiditas['rr_djw12bln_per_tdpk'];
$para2_ab3g = $ambang_batas_likuiditas['rrr_djw12bln_per_tdpk'];
$para2_ab4g = $ambang_batas_likuiditas['rrrr_djw12bln_per_tdpk'];
if ($p2g <= $para2_abg) {
    $hsl2g = 1;
} else if ($p2g > $para2_abg && $p2g <= $para2_ab2g) {
    $hsl2g = 2;
} else if ($p2g > $para2_ab2g && $p2g <= $para2_ab3g) {
    $hsl2g = 3;
} elseif ($p2g > $para2_ab3g && $p2g <= $para2_ab4g) {
    $hsl2g = 4;
} else {
    $hsl2g = 5;
}

$nilai2g = $hsl2g * $bobot2_7;


//par2h
$para2_abh = $ambang_batas_likuiditas['md_per_tdpk'];
$para2_ab2h = $ambang_batas_likuiditas['rr_md_per_tdpk'];
$para2_ab3h = $ambang_batas_likuiditas['rrr_md_per_tdpk'];
$para2_ab4h = $ambang_batas_likuiditas['rrrr_md_per_tdpk'];
if ($p2h >= $para2_abh) {
    $hsl2h = 1;
} else if ($p2h < $para2_abh && $p2h >= $para2_ab2h) {
    $hsl2h = 2;
} else if ($p2h < $para2_ab2h && $p2h >= $para2_ab3h) {
    $hsl2h = 3;
} elseif ($p2h < $para2_ab3h && $p2h >= $para2_ab4h) {
    $hsl2h = 4;
} else {
    $hsl2h = 5;
}

$nilai2h = $hsl2h * $bobot2_8;


//par2i
$para2_abi = $ambang_batas_likuiditas['pin_per_tdpk'];
$para2_ab2i = $ambang_batas_likuiditas['rr_pin_per_tdpk'];
$para2_ab3i = $ambang_batas_likuiditas['rrr_pin_per_tdpk'];
$para2_ab4i = $ambang_batas_likuiditas['rrrr_pin_per_tdpk'];
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

$nilai2i = $hsl2i * $bobot2_9;






// FIX EXCEL: Modal Disetor dihilangkan, sehingga tidak ikut koreksi parameter tambahan Pilar 2.
if ($is_profil_risiko_cabang) {
    // khusus Profil Risiko Kantor Cabang: Modal Disetor dihilangkan
    $koreksi2 = $nilai2a + $nilai2b + $nilai2c + $nilai2d + $nilai2e + $nilai2f + $nilai2g + $nilai2i;
} else {
    // user selain Cabang tetap memakai Modal Disetor sesuai setting bobot lama
    $koreksi2 = $nilai2a + $nilai2b + $nilai2c + $nilai2d + $nilai2e + $nilai2f + $nilai2g + $nilai2h + $nilai2i;
}


// FIX EXCEL: Aset Likuid / Kewajiban Lancar
// Rumus Excel: =IF(koreksi < rumus; rumus; IF(rumus = 0; koreksi; (rumus + koreksi) / 2))
// Jika rumus utama = 0, hasil harus langsung mengikuti nilai koreksi, bukan dibagi 2.
if ((float)$koreksi2 < (float)$hsl2) {
    $nilai2 = $hsl2;
} else if ((float)$hsl2 == 0) {
    $nilai2 = $koreksi2;
} else {
    $nilai2 = ($hsl2 + $koreksi2) / 2;
}






//par 3


$para3_ab = $ambang_batas_likuiditas['kyd_per_tdpkbk'];
if ($p3 > $para3_ab) {
    $hsl3 = 0;
} else {
    $hsl3 = 1;
}



//par3a
$para3_aba = $ambang_batas_likuiditas['dpkydlps_per_dpk'];
$para3_ab2a = $ambang_batas_likuiditas['rr_dpkydlps_per_dpk'];
$para3_ab3a = $ambang_batas_likuiditas['rrr_dpkydlps_per_dpk'];
$para3_ab4a = $ambang_batas_likuiditas['rrrr_dpkydlps_per_dpk'];
// DPK Yang Dijamin LPS / DPK mengikuti Excel:
// =IF(rasio>=ambang;1;IF(rasio>=rr;2;IF(rasio>=rrr;3;IF(rasio>=rrrr;4;5))))
if ($p3a >= $para3_aba) {
    $hsl3a = 1;
} else if ($p3a < $para3_aba && $p3a >= $para3_ab2a) {
    $hsl3a = 2;
} else if ($p3a < $para3_ab2a && $p3a >= $para3_ab3a) {
    $hsl3a = 3;
} elseif ($p3a < $para3_ab3a && $p3a >= $para3_ab4a) {
    $hsl3a = 4;
} else {
    $hsl3a = 5;
}


$nilai3a = $hsl3a * $bobot3_1;

//par3b
$para3_abb = $ambang_batas_likuiditas['alkl_per_dpk3'];
$para3_ab2b = $ambang_batas_likuiditas['rr_alkl_per_dpk3'];
$para3_ab3b = $ambang_batas_likuiditas['rrr_alkl_per_dpk3'];
$para3_ab4b = $ambang_batas_likuiditas['rrrr_alkl_per_dpk3'];
if ($p3b >= $para3_abb) {
    $hsl3b = 1;
} else if ($p3b < $para3_abb && $p3b >= $para3_ab2b) {
    $hsl3b = 2;
} else if ($p3b < $para3_ab2b && $p3b >= $para3_ab3b) {
    $hsl3b = 3;
} elseif ($p3b < $para3_ab3b && $p3b >= $para3_ab4b) {
    $hsl3b = 4;
} else {
    $hsl3b = 5;
}


$nilai3b = $hsl3b * $bobot3_2;

//par3c
$para3_abc = $ambang_batas_likuiditas['dtsd6bln_per_al'];
$para3_ab2c = $ambang_batas_likuiditas['rr_dtsd6bln_per_al'];
$para3_ab3c = $ambang_batas_likuiditas['rrr_dtsd6bln_per_al'];
$para3_ab4c = $ambang_batas_likuiditas['rrrr_dtsd6bln_per_al'];
if ($p3c > $para3_abc) {
    $hsl3c = 1;
} else if ($p3c < $para3_abc && $p3c >= $para3_ab2c) {
    $hsl3c = 2;
} else if ($p3c < $para3_ab2c && $p3c >= $para3_ab3c) {
    $hsl3c = 3;
} elseif ($p3c < $para3_ab3c && $p3c >= $para3_ab4c)  {
    $hsl3c = 4;
} else {
    $hsl3c = 5;
}


$nilai3c = $hsl3c * $bobot3_3;



//par3d
$para3_abd = $ambang_batas_likuiditas['pk_per_ps'];
$para3_ab2d = $ambang_batas_likuiditas['rr_pk_per_ps'];
$para3_ab3d = $ambang_batas_likuiditas['rrr_pk_per_ps'];
$para3_ab4d = $ambang_batas_likuiditas['rrrr_pk_per_ps'];
if ($p3d <= $para3_abd) {
    $hsl3d = 1;
} else if ($p3d > $para3_abd && $p3d <= $para3_ab2d) {
    $hsl3d = 2;
} else if ($p3d > $para3_ab2d && $p3d <= $para3_ab3d) {
    $hsl3d = 3;
} elseif ($p3d > $para3_ab3d && $p3d <= $para3_ab4d) {
    $hsl3d = 4;
} else {
    $hsl3d = 5;
}


$nilai3d = $hsl3d * $bobot3_4;

$koreksi3 = $nilai3a + $nilai3b + $nilai3d; // p3c dihilangkan


// FIX EXCEL: Kredit Yang Diberikan / Total Dana Pihak Ketiga Bukan Bank.
// Rumus Excel: jika koreksi < rumus ambil rumus; jika rumus = 0 ambil koreksi; selain itu rata-rata.
if ((float)$koreksi3 < (float)$hsl3) {
    $nilai3 = $hsl3;
} else if ((float)$hsl3 == 0) {
    $nilai3 = $koreksi3;
} else {
    $nilai3 = ($hsl3 + $koreksi3) / 2;
}



//par 4
$para4_ab = $ambang_batas_likuiditas['ddpt25_per_tdpk'];
if ($p4 > $para4_ab) {
    $hsl4 = 4;
} else {
    $hsl4 = 1;
}

// FIX EXCEL: 25 Deposan dan Penabung Terbesar / Total DPK.
// Nilai koreksi dipilih dari dropdown komposisi; hasil mengikuti formula Excel:
// jika koreksi < rumus ambil rumus; jika rumus = 0 ambil koreksi; selain itu rata-rata.
$koreksi4 = (isset($pil1['pilar1_4']) && $pil1['pilar1_4'] !== '' && $pil1['pilar1_4'] !== null) ? (float)$pil1['pilar1_4'] : 0;
if ((float)$koreksi4 < (float)$hsl4) {
    $nilai4 = $hsl4;
} else if ((float)$hsl4 == 0) {
    $nilai4 = $koreksi4;
} else {
    $nilai4 = round(((float)$hsl4 + (float)$koreksi4) / 2, 2);
}






//par 5

$para5_ab = $ambang_batas_likuiditas['pni_per_tp'];
// FIX EXCEL: Pendanaan Non Inti / Total Pendanaan.
// Jika rasio melebihi ambang utama, rumus utama = 0, lalu hasil akhir dihitung bersama koreksi parameter tambahan.
if ($p5 > $para5_ab) {
    $hsl5 = 0;
} else {
    $hsl5 = 1;
}


//par5a
$para5_aba = $ambang_batas_likuiditas['pnial_per_taal'];
$para5_ab2a = $ambang_batas_likuiditas['rr_pnial_per_taal'];
$para5_ab3a = $ambang_batas_likuiditas['rrr_pnial_per_taal'];
$para5_ab4a = $ambang_batas_likuiditas['rrrr_pnial_per_taal'];
if ($p5a <= $para5_aba) {
    $hsl5a = 1;
} else if ($p5a > $para5_aba && $p5a <= $para5_ab2a) {
    $hsl5a = 2;
} else if ($p5a > $para5_ab2a && $p5a <= $para5_ab3a) {
    $hsl5a = 3;
} elseif ($p5a > $para5_ab3a && $p5a <= $para5_ab4a) {
    $hsl5a = 4;
} else {
    $hsl5a = 5;
}


$nilai5a = $hsl5a * $bobot4_1;

//par3b
$para5_abb = $ambang_batas_likuiditas['drs_per_al'];
$para5_ab2b = $ambang_batas_likuiditas['rr_drs_per_al'];
$para5_ab3b = $ambang_batas_likuiditas['rrr_drs_per_al'];
$para5_ab4b = $ambang_batas_likuiditas['rrrr_drs_per_al'];
if ($p5b <= $para5_abb) {
    $hsl5b = 1;
} else if ($p5b > $para5_abb && $p5b <= $para5_ab2b) {
    $hsl5b = 2;
} else if ($p5b > $para5_ab2b && $p5b <= $para5_ab3b) {
    $hsl5b = 3;
} elseif ($p5b > $para5_ab3b && $p5b <= $para5_ab4b) {
    $hsl5b = 4;
} else {
    $hsl5b = 5;
}


$nilai5b = $hsl5b * $bobot4_2;

//par5c
$para5_abc = $ambang_batas_likuiditas['al_per_pni'];
$para5_ab2c = $ambang_batas_likuiditas['rr_al_per_pni'];
$para5_ab3c = $ambang_batas_likuiditas['rrr_al_per_pni'];
$para5_ab4c = $ambang_batas_likuiditas['rrrr_al_per_pni'];
if ($p5c >= $para5_abc) {
    $hsl5c = 1;
} else if ($p5c < $para5_abc && $p5c >= $para5_ab2c) {
    $hsl5c = 2;
} else if ($p5c < $para5_ab2c && $p5c >= $para5_ab3c) {
    $hsl5c = 3;
} elseif ($p5c < $para5_ab3c && $p5c >= $para5_ab4c)  {
    $hsl5c = 4;
} else {
    $hsl5c = 5;
}


$nilai5c = $hsl5c * $bobot4_3;



//par5d
$para5_abd = $ambang_batas_likuiditas['di_per_tdpk'];
$para5_ab2d = $ambang_batas_likuiditas['rr_di_per_tdpk'];
$para5_ab3d = $ambang_batas_likuiditas['rrr_di_per_tdpk'];
$para5_ab4d = $ambang_batas_likuiditas['rrrr_di_per_tdpk'];
if ($p5d <= $para5_abd) {
    $hsl5d = 1;
} else if ($p5d > $para5_abd && $p5d <= $para5_ab2d) {
    $hsl5d = 2;
} else if ($p5d > $para5_ab2d && $p5d <= $para5_ab3d) {
    $hsl5d = 3;
} elseif ($p5d > $para5_ab3d && $p5d <= $para5_ab4d) {
    $hsl5d = 4;
} else {
    $hsl5d = 5;
}


$nilai5d = $hsl5d * $bobot4_4;

$koreksi5 = $nilai5a + $nilai5b + $nilai5c + $nilai5d;



if ($koreksi5 < $hsl5) {
    $nilai5 = $hsl5;
} else {
    $nilai5 = ($hsl5 + $koreksi5) / 2;
}


$bobot_pil2_1 = 1/3;

$bobot_pil3_1 = 1/6;

if (!function_exists('pv')) {
function pv($key, $default = ''){
    global $conn;
    $val = isset($_POST[$key]) ? $_POST[$key] : $default;
    if (is_array($val)) $val = implode(',', $val);
    // FIX AUTOSAVE: semua input POST di-escape agar query UPDATE tidak gagal saat ada tanda petik/kutip di textarea.
    if (isset($conn) && $conn) {
        return mysqli_real_escape_string($conn, (string)$val);
    }
    return (string)$val;
}}

if (!function_exists('lik_table_exists_fix')) {
function lik_table_exists_fix($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}}
if (!function_exists('lik_column_exists_fix')) {
function lik_column_exists_fix($conn, $table, $column){
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}}
if (!function_exists('lik_ensure_row_fix')) {
function lik_ensure_row_fix($conn, $table, $id_profil_risiko){
    if (!lik_table_exists_fix($conn, $table)) return;
    if (!lik_column_exists_fix($conn, $table, 'id_profil_risiko')) return;
    $id_profil_risiko = (int)$id_profil_risiko;
    $cek = mysqli_query($conn, "SELECT id_profil_risiko FROM `$table` WHERE id_profil_risiko = '$id_profil_risiko' LIMIT 1");
    if ($cek && mysqli_num_rows($cek) > 0) return;
    mysqli_query($conn, "INSERT INTO `$table` (id_profil_risiko) VALUES ('$id_profil_risiko')");
}}
if (!function_exists('lik_save_query_fix')) {
function lik_save_query_fix($conn, $sql, $label = 'SQL'){
    $ok = mysqli_query($conn, $sql);
    if (!$ok) {
        if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
        if (ob_get_level()) { @ob_clean(); }
        echo json_encode([
            'success' => false,
            'message' => $label . ' ERROR: ' . mysqli_error($conn),
            'sql' => $sql
        ]);
        exit();
    }
    return $ok;
}}

if (isset($_POST['submit']) || pv('autosave') == '1') {
    $is_autosave = (pv('autosave') == '1');
    require dirname(__DIR__, 2).'/conn/conn.php';

    // FIX AUTOSAVE: pastikan row target sudah ada. Jika row belum ada, UPDATE tidak akan menyimpan apa pun.
    lik_ensure_row_fix($conn, 'inheren_likuiditas_pilar1', $id);
    lik_ensure_row_fix($conn, 'inheren_likuiditas_pilar2', $id);
    lik_ensure_row_fix($conn, 'inheren_likuiditas_lainnya', $id);
    lik_ensure_row_fix($conn, 'hasil_inheren_likuiditas', $id);
    lik_ensure_row_fix($conn, 'keterangan_inheren_likuiditas', $id);


//p1
    $hasil_pil1_par1 = $nilai;
    $hasil_pil1_par2 = $nilai2;
    $hasil_pil1_par2a = $nilai2a;
    $hasil_pil1_par2b = $nilai2b;
    $hasil_pil1_par2c = $nilai2c;
    $hasil_pil1_par2d = $nilai2d;
    $hasil_pil1_par2e = $nilai2e;
    $hasil_pil1_par2f = $nilai2f;
    $hasil_pil1_par2g = $nilai2g;
    $hasil_pil1_par2h = $nilai2h;
    $hasil_pil1_par2i = $nilai2i;
    $hasil_pil1_par3 = $nilai3;
    $hasil_pil1_par3a = $nilai3a;
    $hasil_pil1_par3b = $nilai3b;
    $hasil_pil1_par3c = 0; // dihilangkan sesuai format baru
    $hasil_pil1_par3d = $nilai3d;
    $pilar1_4 = pv('sektor_terbesar3');
    $hasil_pil1_par4 = pv('nilaippl1_par4');
    $hasil_pil1_par5 = $nilai5;
    $hasil_pil1_par5a = $nilai5a;
    $hasil_pil1_par5b = $nilai5b;
    $hasil_pil1_par5c = $nilai5c;
    $hasil_pil1_par5d = $nilai5d;


    //p2
    $hasil_pil2_par1 = pv('hasil_pil2_par1');
    $pil2_par1a = pv('pilar2_1a');
    $hasil_pil2_par1a = pv('nilaippl2_par1a');
    $pil2_par1b = pv('pilar2_1b');
    $hasil_pil2_par1b = pv('nilaippl2_par1b');
    $pil2_par1c = pv('pilar2_1c');
    $hasil_pil2_par1c = pv('nilaippl2_par1c');
    $pil2_par2 = pv('pilar2_2');
    $hasil_pil2_par2 = pv('nilaippl2_par2');

    //p3
    $pil3_par1a = pv('pilar3_1a');
    $hasil_pil3_par1a = pv('nilaippl3_par1a');
    $pil3_par1b = pv('pilar3_1b');
    $hasil_pil3_par1b = pv('nilaippl3_par1b');
    $pil3_par1c = pv('pilar3_1c');
    $hasil_pil3_par1c = pv('nilaippl3_par1c');
    $hasil_pil3_par1 = round((float)$hasil_pil3_par1a + (float)$hasil_pil3_par1b + (float)$hasil_pil3_par1c, 2);
    $pil3_par1d = isset($_POST['pilar3_1d']) ? pv('pilar3_1d') : 0;
    $hasil_pil3_par1d = isset($_POST['nilaippl3_par1d']) ? pv('nilaippl3_par1d') : 0;
    $pil3_par1e = isset($_POST['pilar3_1e']) ? pv('pilar3_1e') : 0;
    $hasil_pil3_par1e = isset($_POST['nilaippl3_par1e']) ? pv('nilaippl3_par1e') : 0;
    $pil3_par1f = isset($_POST['pilar3_1f']) ? pv('pilar3_1f') : 0;
    $hasil_pil3_par1f = isset($_POST['nilaippl3_par1f']) ? pv('nilaippl3_par1f') : 0;




//hasil
    $pil1_tertinggi = pv('tertinggi_pil1');
    $pil1_terendah = pv('terendah_pil1');
    $pil1_rata_rata = pv('rata_rata_pil1');
    $pil1_risiko_ditetapkan = (int)$set_pil1;
    $pil1_tingkat_risiko = lik_pick_nilai_setting($setris_mode_lik, $pil1_risiko_ditetapkan, $setris_bobot_pil1, $pil1_tertinggi, $pil1_terendah, $pil1_rata_rata);

    $pil2_tertinggi = pv('tertinggi_pil2');
    $pil2_terendah = pv('terendah_pil2');
    $pil2_rata_rata = pv('rata_rata_pil2');
    $pil2_risiko_ditetapkan = (int)$set_pil2;
    $pil2_tingkat_risiko = lik_pick_nilai_setting($setris_mode_lik, $pil2_risiko_ditetapkan, $setris_bobot_pil2, $pil2_tertinggi, $pil2_terendah, $pil2_rata_rata);

    $pil3_tertinggi = pv('tertinggi_pil3');
    $pil3_terendah = pv('terendah_pil3');
    $pil3_rata_rata = pv('rata_rata_pil3');
    $pil3_risiko_ditetapkan = (int)$set_pil3;
    $pil3_tingkat_risiko = lik_pick_nilai_setting($setris_mode_lik, $pil3_risiko_ditetapkan, $setris_bobot_pil3, $pil3_tertinggi, $pil3_terendah, $pil3_rata_rata);

    $hasil_inheren_tertinggi = round(max((float)$pil1_tingkat_risiko, (float)$pil2_tingkat_risiko, (float)$pil3_tingkat_risiko), 2);
    $hasil_inheren_terendah = round(min((float)$pil1_tingkat_risiko, (float)$pil2_tingkat_risiko, (float)$pil3_tingkat_risiko), 2);
    $hasil_inheren_rata_rata = round(((float)$pil1_tingkat_risiko + (float)$pil2_tingkat_risiko + (float)$pil3_tingkat_risiko) / 3, 2);
    $hasil_risiko_ditetapkan = isset($_POST['opsi_inheren']) ? (int)pv('opsi_inheren') : (int)$set_tingkat_risiko;

    if ($setris_mode_lik === 'pembobotan') {
        $hasil_tingkat_risiko = round((float)$pil1_tingkat_risiko + (float)$pil2_tingkat_risiko + (float)$pil3_tingkat_risiko, 2);
    } else {
        $hasil_tingkat_risiko = lik_pick_nilai_setting($setris_mode_lik, $hasil_risiko_ditetapkan, 0, $hasil_inheren_tertinggi, $hasil_inheren_terendah, $hasil_inheren_rata_rata);
    }

    if ($hasil_tingkat_risiko < 1.00) {
        $hasil_peringkat = "";
    } else if ($hasil_tingkat_risiko >= 1.00 && $hasil_tingkat_risiko < 1.25) {
        $hasil_peringkat = "Sangat Rendah";
    } else if ($hasil_tingkat_risiko >= 1.25 && $hasil_tingkat_risiko < 2.25) {
        $hasil_peringkat = "Rendah";
    } else if ($hasil_tingkat_risiko >= 2.25 && $hasil_tingkat_risiko < 3.25) {
        $hasil_peringkat = "Sedang";
    } else if ($hasil_tingkat_risiko >= 3.25 && $hasil_tingkat_risiko < 4.25) {
        $hasil_peringkat = "Tinggi";
    } else if ($hasil_tingkat_risiko >= 4.25 && $hasil_tingkat_risiko <= 5.00) {
        $hasil_peringkat = "Sangat Tinggi";
    } else {
        $hasil_peringkat = "";
    }

    //ket
    $ket_pil1_1 = pv('ket_pil1_1');
    $ket_pil1_2 = pv('ket_pil1_2');
    $ket_pil1_3 = pv('ket_pil1_3');
    $ket_pil1_4 = pv('ket_pil1_4');
    $ket_pil1_5 = pv('ket_pil1_5');
    $ket_pil1 = pv('ket_pil1');
    $ket_pil2_1 = pv('ket_pil2_1');
    $ket_pil2_2 = pv('ket_pil2_2');
    $ket_pil2_3 = pv('ket_pil2_3');
    $ket_pil2 = pv('ket_pil2');
    $ket_pil3_1 = pv('ket_pil3_1');
    $ket_pil3 = pv('ket_pil3');
    $ket_pil4_1 = pv('ket_pil4_1');
    $ket_pil4 = pv('ket_pil4');
    $ket_pil5_1 = pv('ket_pil5_1');
    $ket_pil5 = pv('ket_pil5');
    $ket_inheren = pv('ket_inheren');




    lik_save_query_fix($conn, "UPDATE inheren_likuiditas_pilar1 SET 
        hasil_pil1_par1 ='$hasil_pil1_par1',
        hasil_pil1_par2 ='$hasil_pil1_par2',
        hasil_pil1_par2a ='$hasil_pil1_par2a',
        hasil_pil1_par2b ='$hasil_pil1_par2b',
        hasil_pil1_par2c ='$hasil_pil1_par2c',
        hasil_pil1_par2d ='$hasil_pil1_par2d',
        hasil_pil1_par2e ='$hasil_pil1_par2e',
        hasil_pil1_par2f ='$hasil_pil1_par2f',
        hasil_pil1_par2g ='$hasil_pil1_par2g',
        hasil_pil1_par2h ='$hasil_pil1_par2h',
        hasil_pil1_par2i ='$hasil_pil1_par2i',
        hasil_pil1_par3 ='$hasil_pil1_par3',
        hasil_pil1_par3a ='$hasil_pil1_par3a',
        hasil_pil1_par3b ='$hasil_pil1_par3b',
        hasil_pil1_par3c ='$hasil_pil1_par3c',
        hasil_pil1_par3d ='$hasil_pil1_par3d',
        hasil_pil1_par5 ='$hasil_pil1_par5',
        hasil_pil1_par5a ='$hasil_pil1_par5a',
        hasil_pil1_par5b ='$hasil_pil1_par5b',
        hasil_pil1_par5c ='$hasil_pil1_par5c',
        hasil_pil1_par5d ='$hasil_pil1_par5d',
        
        pilar1_4 ='$pilar1_4',
        hasil_pil1_par4 ='$hasil_pil1_par4'
    WHERE id_profil_risiko ='$id'");



    lik_save_query_fix($conn, "UPDATE inheren_likuiditas_pilar2 SET 
    hasil_pil2_par1 = '$hasil_pil2_par1',
    pil2_par1a = '$pil2_par1a',
    hasil_pil2_par1a = '$hasil_pil2_par1a',
    pil2_par1b = '$pil2_par1b',
    hasil_pil2_par1b = '$hasil_pil2_par1b',
    pil2_par1c = '$pil2_par1c',
    hasil_pil2_par1c = '$hasil_pil2_par1c',
    pil2_par2 = '$pil2_par2',
    hasil_pil2_par2 = '$hasil_pil2_par2'
    WHERE id_profil_risiko = '$id'");


    lik_save_query_fix($conn, "UPDATE inheren_likuiditas_lainnya SET 
    hasil_pil3_par1 = '$hasil_pil3_par1',
    pil3_par1a = '$pil3_par1a',
    hasil_pil3_par1a = '$hasil_pil3_par1a',
    pil3_par1b = '$pil3_par1b',
    hasil_pil3_par1b = '$hasil_pil3_par1b',
    pil3_par1c = '$pil3_par1c',
    hasil_pil3_par1c = '$hasil_pil3_par1c',
    pil3_par1d = '$pil3_par1d',
    hasil_pil3_par1d = '$hasil_pil3_par1d',
    pil3_par1e = '$pil3_par1e',
    hasil_pil3_par1e = '$hasil_pil3_par1e',
    pil3_par1f = '$pil3_par1f',
    hasil_pil3_par1f = '$hasil_pil3_par1f'
    WHERE id_profil_risiko = '$id'");




    lik_save_query_fix($conn, "UPDATE hasil_inheren_likuiditas SET 
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
        hasil_inheren_tertinggi = '$hasil_inheren_tertinggi',
        hasil_inheren_terendah = '$hasil_inheren_terendah',
        hasil_inheren_rata_rata = '$hasil_inheren_rata_rata',
        hasil_risiko_ditetapkan = '$hasil_risiko_ditetapkan',
        hasil_tingkat_risiko = '$hasil_tingkat_risiko',
        hasil_peringkat = '$hasil_peringkat'
    WHERE id_profil_risiko = '$id'");


    lik_save_query_fix($conn, "UPDATE keterangan_inheren_likuiditas SET 
        ket_pil1_1 ='$ket_pil1_1',
        ket_pil1_2 ='$ket_pil1_2',
        ket_pil1_3 ='$ket_pil1_3',
        ket_pil1_4 ='$ket_pil1_4',
        ket_pil1_5 ='$ket_pil1_5',
        ket_pil1 ='$ket_pil1',
        ket_pil2_1 ='$ket_pil2_1',
        ket_pil2_2 ='$ket_pil2_2',
        ket_pil2 ='$ket_pil2',
        ket_pil3_1 ='$ket_pil3_1',
        ket_pil3 ='$ket_pil3',
        ket_inheren ='$ket_inheren'
    WHERE id_profil_risiko = '$id'");

    if ($is_autosave) {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
        }
        // FIX AUTOSAVE: bersihkan HTML yang sudah terlanjur ter-output supaya fetch menerima JSON murni.
        if (ob_get_level()) { @ob_clean(); }
        echo json_encode([
            'success' => true,
            'message' => 'Autosave berhasil',
            'hasil_tingkat_risiko' => number_format((float)$hasil_tingkat_risiko, 2, '.', ''),
            'hasil_peringkat' => (string)$hasil_peringkat,
            'hasil_risiko_ditetapkan' => (int)$hasil_risiko_ditetapkan
        ]);
        exit();
    }

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=lik_inhern&id=$id");
    exit();
}

?>










                                    <script type="text/javascript">
                                        $(document).ready(function() {

                                           

                                            
                                            $('#sektor_terbesar3').change(function() {
                                                var val = this.value;
                                                $("#koreksippl1_par4").val(val);

                                                var hsl4 = <?php echo json_encode($hsl4); ?>;

                                                if (parseFloat(val) < parseFloat(hsl4)) {
                                                    var nilai = parseFloat(hsl4);
                                                } else if (parseFloat(hsl4) == 0) {
                                                    var nilai = parseFloat(val);
                                                } else {
                                                    var nilai = (parseFloat(hsl4) + parseFloat(val)) / 2;
                                                }
                                                nilai = parseFloat(nilai || 0).toFixed(2);
                                                $("#nilaippl1_par4").val(nilai);
                                            });

                                            $("#sektor_terbesar3").change(function() {
                                                var pilar1_par1 = <?php echo $nilai; ?>;
                                                var pilar1_par2 = <?php echo $nilai2; ?>;
                                                var pilar1_par3 = <?php echo $nilai3; ?>;
                                                var pilar1_par4 = $("#nilaippl1_par4").val();
                                                var pilar1_par5 = <?php echo $nilai5; ?>;


                                                const max = [pilar1_par1, pilar1_par2, pilar1_par3, pilar1_par4, pilar1_par5];
                                                const maxValue = Math.max(...max);
                                                tertinggi_pil1 = maxValue.toFixed(2);

                                                $("#tertinggi_pil1").val(tertinggi_pil1);
                                    

                                                const min = [pilar1_par1, pilar1_par2, pilar1_par3, pilar1_par4, pilar1_par5];
                                                const minValue = Math.min(...min);
                                                terendah_pil1 = minValue.toFixed(2);

                                                $("#terendah_pil1").val(terendah_pil1);

                                                var total_rata_rata = parseFloat(pilar1_par1) + parseFloat(pilar1_par2) + parseFloat(pilar1_par3) + parseFloat(pilar1_par4) + parseFloat(pilar1_par5);
                                                
                                                var rata_rata_pil1 = parseFloat(total_rata_rata) / 5;
                                                rata_rata_pil1 = rata_rata_pil1.toFixed(2);

                                                rr1 = rata_rata_pil1;

                                                $("#rata_rata_pil1").val(rata_rata_pil1);
                                            });

                                            $("#sektor_terbesar3").change(function() {
                                                var mode_lik = <?php echo json_encode($setris_mode_lik); ?>;
                                                var set_pil1 = <?php echo json_encode((int)$set_pil1); ?>;
                                                var bobot_setting = <?php echo json_encode((float)$setris_bobot_pil1); ?>;
                                                if (mode_lik === 'pembobotan') {
                                                    var risiko_pil1 = (parseFloat(rr1 || 0) * parseFloat(bobot_setting || 0) / 100).toFixed(2);
                                                } else if (set_pil1 == 1) {
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


                                            



//=-=-=-=-=-=
                                            $('#pilar2_1a').change(function() {
                                                var pilar2_1a = $("#pilar2_1a").val();

                                                var bobot5_1 = <?php echo json_encode($bobot5_1); ?>;
                                                
                                                var nilai = parseFloat(pilar2_1a) * parseFloat(bobot5_1);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl2_par1a").val(nilai);

                                                var nilai2 = parseFloat(pilar2_1a) * parseFloat(bobot5_1);
                                                $("#nilaippl2_p1a").val(nilai2);
                                            });

                                            
                                            $('#pilar2_1b').change(function() {
                                                var pilar2_1b = $("#pilar2_1b").val();

                                                var bobot5_2 = <?php echo json_encode($bobot5_2); ?>;

                                                
                                                var nilai = parseFloat(pilar2_1b) * parseFloat(bobot5_2);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl2_par1b").val(nilai);

                                                var nilai2 = parseFloat(pilar2_1b) * parseFloat(bobot5_2);
                                                $("#nilaippl2_p1b").val(nilai2);
                                            });
                                            
                                            $('#pilar2_1c').change(function() {
                                                var pilar2_1c = $("#pilar2_1c").val();

                                                var bobot5_3 = <?php echo json_encode($bobot5_3); ?>;

                                                
                                                var nilai = parseFloat(pilar2_1c) * parseFloat(bobot5_3);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl2_par1c").val(nilai);

                                                var nilai2 = parseFloat(pilar2_1c) * parseFloat(bobot5_3);
                                                $("#nilaippl2_p1c").val(nilai2);
                                            });

                                           

                                            $("#pilar2_1a, #pilar2_1b, #pilar2_1c").change(function() {
                                                var pilar2_1a = $("#pilar2_1a").val();
                                                var pilar2_1b = $("#pilar2_1b").val();
                                                var pilar2_1c = $("#pilar2_1c").val();
                                                var bobot5_1 = <?php echo json_encode($bobot5_1); ?>;
                                                var bobot5_2 = <?php echo json_encode($bobot5_2); ?>;
                                                var bobot5_3 = <?php echo json_encode($bobot5_3); ?>;


                                                var pilar2_par1 = parseFloat(pilar2_1a) * parseFloat(bobot5_1);
                                                pilar2_par1 = pilar2_par1.toFixed(2);

                                                var pilar2_par2 = parseFloat(pilar2_1b) * parseFloat(bobot5_2);
                                                pilar2_par2 = pilar2_par2.toFixed(2);

                                                var pilar2_par3 = parseFloat(pilar2_1c) * parseFloat(bobot5_3);
                                                pilar2_par3 = pilar2_par3.toFixed(2);



                                                var total_rata_rata = parseFloat(pilar2_par1) + parseFloat(pilar2_par2) + parseFloat(pilar2_par3);
                                            
                                                total_rata_rata = total_rata_rata.toFixed(2);

                                                $("#hasil_pil2_par1").val(total_rata_rata);
                                            });

                                            $('#pilar2_2').change(function() {
                                                var pilar2_2 = $("#pilar2_2").val();
                                                
                                                $("#nilaippl2_par2").val(pilar2_2);
                                            });






                                            $("#pilar2_1a, #pilar2_1b, #pilar2_1c, #pilar2_2").change(function() {
                                                var pilar2_1a = $("#pilar2_1a").val();
                                                var pilar2_1b = $("#pilar2_1b").val();
                                                var pilar2_1c = $("#pilar2_1c").val();
                                                var bobot5_1 = <?php echo json_encode($bobot5_1); ?>;
                                                var bobot5_2 = <?php echo json_encode($bobot5_2); ?>;
                                                var bobot5_3 = <?php echo json_encode($bobot5_3); ?>;
                                                var pilar2_2 = $("#pilar2_2").val();


                                                var pilar2_par1 = parseFloat(pilar2_1a) * parseFloat(bobot5_1);
                                                

                                                var pilar2_par2 = parseFloat(pilar2_1b) * parseFloat(bobot5_2);
                                                

                                                var pilar2_par3 = parseFloat(pilar2_1c) * parseFloat(bobot5_3);
                                                


                                                var total_Pil2 = parseFloat(pilar2_par1) + parseFloat(pilar2_par2) + parseFloat(pilar2_par3);
                                            
                                                


                                                const max = [total_Pil2, pilar2_2];
                                                const maxValue = Math.max(...max);
                                                tertinggi_pil2 = maxValue.toFixed(2);

                                                $("#tertinggi_pil2").val(tertinggi_pil2);
                                    

                                                const min = [total_Pil2, pilar2_2];
                                                const minValue = Math.min(...min);
                                                terendah_pil2 = minValue.toFixed(2);

                                                $("#terendah_pil2").val(terendah_pil2);

                                                var total_rata_rata = parseFloat(total_Pil2) + parseFloat(pilar2_2);
                                                
                                                var rata_rata_pil2 = parseFloat(total_rata_rata) / 2;
                                                rata_rata_pil2 = rata_rata_pil2.toFixed(2);

                                                rr2 = rata_rata_pil2;
                                                $("#rata_rata_pil2").val(rata_rata_pil2);
                                            });
                                            $("#pilar2_1a, #pilar2_1b, #pilar2_1c, #pilar2_2").change(function() {
                                                var mode_lik = <?php echo json_encode($setris_mode_lik); ?>;
                                                var set_pil2 = <?php echo json_encode((int)$set_pil2); ?>;
                                                var bobot_setting = <?php echo json_encode((float)$setris_bobot_pil2); ?>;
                                                if (mode_lik === 'pembobotan') {
                                                    var risiko_pil2 = (parseFloat(rr2 || 0) * parseFloat(bobot_setting || 0) / 100).toFixed(2);
                                                } else if (set_pil2 == 1) {
                                                    var risiko_pil2 = tertinggi_pil2;
                                                } else if (set_pil2 == 2) {
                                                    var risiko_pil2 = terendah_pil2;
                                                } else if (set_pil2 == 3) {
                                                    var risiko_pil2 = rr2;
                                                } else {
                                                    var risiko_pil2 = 0;
                                                }

                                                $("#risiko_pil2").val(risiko_pil2);
                                                $("#hasil_risiko_pil2").val(risiko_pil2);
                                            });



                                        
                                            $('#pilar3_1a').change(function() {
                                                var pilar3_1a = $("#pilar3_1a").val();

                                                var bobot6_1 = <?php echo json_encode($bobot6_1); ?>;

                                                
                                                var nilai = parseFloat(pilar3_1a) * parseFloat(bobot6_1);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl3_par1a").val(nilai);

                                                var nilai2 = parseFloat(pilar3_1a) * parseFloat(bobot6_1);
                                                $("#nilaippl3_p1a").val(nilai2);
                                            });

                                            
                                            $('#pilar3_1b').change(function() {
                                                var pilar3_1b = $("#pilar3_1b").val();

                                                var bobot6_2 = <?php echo json_encode($bobot6_2); ?>;

                                                
                                                var nilai = parseFloat(pilar3_1b) * parseFloat(bobot6_2);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl3_par1b").val(nilai);

                                                var nilai2 = parseFloat(pilar3_1b) * parseFloat(bobot6_2);
                                                $("#nilaippl3_p1b").val(nilai2);
                                            });
                                            
                                            $('#pilar3_1c').change(function() {
                                                var pilar3_1c = $("#pilar3_1c").val();

                                                var bobot6_3 = <?php echo json_encode($bobot6_3); ?>;

                                                
                                                var nilai = parseFloat(pilar3_1c) * parseFloat(bobot6_3);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl3_par1c").val(nilai);

                                                var nilai2 = parseFloat(pilar3_1c) * parseFloat(bobot6_3);
                                                $("#nilaippl3_p1c").val(nilai2);
                                            });

                                            
                                            // Sub parameter Lainnya d-f dihilangkan
                                            $("#pilar3_1a, #pilar3_1b, #pilar3_1c").change(function() {
                                                var pilar3_1a = $("#pilar3_1a").val();
                                                var pilar3_1b = $("#pilar3_1b").val();
                                                var pilar3_1c = $("#pilar3_1c").val();
                                                var bobot6_1 = <?php echo json_encode($bobot6_1); ?>;
                                                var bobot6_2 = <?php echo json_encode($bobot6_2); ?>;
                                                var bobot6_3 = <?php echo json_encode($bobot6_3); ?>;


                                                var pilar3_par1 = parseFloat(pilar3_1a) * parseFloat(bobot6_1);
                                                
                                                var pilar3_par2 = parseFloat(pilar3_1b) * parseFloat(bobot6_2);
                                               
                                                var pilar3_par3 = parseFloat(pilar3_1c) * parseFloat(bobot6_3);
                                                
                                                
                                                
                                                



                                                var total_pil3 = parseFloat(pilar3_par1) + parseFloat(pilar3_par2) + parseFloat(pilar3_par3);
                                            
                                                total_pil3 = total_pil3.toFixed(2);
                                                $("#hasil_pil3_par1").val(total_pil3);
                                                

                                                const max = [total_pil3];
                                                const maxValue = Math.max(...max);
                                                tertinggi_pil3 = maxValue.toFixed(2);

                                                $("#tertinggi_pil3").val(tertinggi_pil3);
                                    

                                                const min = [total_pil3];
                                                const minValue = Math.min(...min);
                                                terendah_pil3 = minValue.toFixed(2);

                                                $("#terendah_pil3").val(terendah_pil3);

                                                var total_rata_rata = parseFloat(total_pil3);
                                                
                                                var rata_rata_pil3 = parseFloat(total_rata_rata) / 1;
                                                rata_rata_pil3 = rata_rata_pil3.toFixed(2);

                                                rr3 = rata_rata_pil3;
                                                $("#rata_rata_pil3").val(rata_rata_pil3);
                                            });
                                            $("#pilar3_1a, #pilar3_1b, #pilar3_1c").change(function() {
                                                var mode_lik = <?php echo json_encode($setris_mode_lik); ?>;
                                                var set_pil3 = <?php echo json_encode((int)$set_pil3); ?>;
                                                var bobot_setting = <?php echo json_encode((float)$setris_bobot_pil3); ?>;
                                                if (mode_lik === 'pembobotan') {
                                                    var risiko_pil3 = (parseFloat(rr3 || 0) * parseFloat(bobot_setting || 0) / 100).toFixed(2);
                                                } else if (set_pil3 == 1) {
                                                    var risiko_pil3 = tertinggi_pil3;
                                                } else if (set_pil3 == 2) {
                                                    var risiko_pil3 = terendah_pil3;
                                                } else if (set_pil3 == 3) {
                                                    var risiko_pil3 = rr3;
                                                } else {
                                                    var risiko_pil3 = 0;
                                                }

                                                $("#risiko_pil3").val(risiko_pil3);
                                                $("#hasil_risiko_pil3").val(risiko_pil3);
                                            });

                                            



                                    



                                            $("#sektor_terbesar3, #pilar2_1a, #pilar2_1b, #pilar2_1c, #pilar2_2, #pilar3_1a, #pilar3_1b, #pilar3_1c").change(function() {
                                                var val = this.value;
                                                var hsl_risiko_pilar1 = $("#risiko_pil1").val();
                                                var hsl_risiko_pilar2 = $("#risiko_pil2").val();
                                                var hsl_risiko_pilar3 = $("#risiko_pil3").val();

                                                const max = [hsl_risiko_pilar1, hsl_risiko_pilar2, hsl_risiko_pilar3];
                                                const maxValue = Math.max(...max);
                                                tertinggi_inheren = maxValue.toFixed(2);
                                                $("#tertinggi_inheren").val(tertinggi_inheren);
                                
                                                const min = [hsl_risiko_pilar1, hsl_risiko_pilar2, hsl_risiko_pilar3];
                                                const minValue = Math.min(...min);
                                                terendah_inheren = minValue.toFixed(2);
                                                $("#terendah_inheren").val(terendah_inheren);
                                        
                                                var total_rata_rata = parseFloat(hsl_risiko_pilar1) + parseFloat(hsl_risiko_pilar2) + parseFloat(hsl_risiko_pilar3);
                                                var rata_rata_inheren = parseFloat(total_rata_rata) / 3;
                                                rata_rata_inheren = rata_rata_inheren.toFixed(2);
                                                rr_inheren = rata_rata_inheren;

                                                $("#rata_rata_inheren").val(rata_rata_inheren);
                                            });
                                            $("#sektor_terbesar3, #pilar2_1a, #pilar2_1b, #pilar2_1c, #pilar2_2, #pilar3_1a, #pilar3_1b, #pilar3_1c").change(function() {
                                                var mode_lik = <?php echo json_encode($setris_mode_lik); ?>;
                                                var set_tingkat_risiko = <?php echo json_encode((int)$set_tingkat_risiko); ?>;
                                                if (mode_lik === 'pembobotan') {
                                                    var risiko_inheren = (
                                                        parseFloat(hsl_risiko_pilar1 || 0) +
                                                        parseFloat(hsl_risiko_pilar2 || 0) +
                                                        parseFloat(hsl_risiko_pilar3 || 0)
                                                    ).toFixed(2);
                                                } else if (set_tingkat_risiko == 1) {
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






<div class="content-page">
    <div class="content">


<style>
.info-kuantitatif-btn{
    width:26px;
    height:26px;
    border:0;
    border-radius:999px;
    background:#eef2ff;
    color:#4f46e5;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    margin-left:6px;
    vertical-align:middle;
    cursor:pointer;
}
.info-kuantitatif-btn:hover{background:#6658dd;color:#fff}
.info-kuantitatif-pop{display:none;position:fixed;inset:0;z-index:100000;background:rgba(15,23,42,.42);align-items:center;justify-content:center;padding:18px}
.info-kuantitatif-pop.show{display:flex}
.info-kuantitatif-card{width:min(560px,94vw);background:#fff;border-radius:12px;box-shadow:0 24px 60px rgba(15,23,42,.24);padding:18px}
.info-kuantitatif-head{display:flex;align-items:center;justify-content:space-between;gap:12px;border-bottom:1px solid #eef0f4;padding-bottom:10px;margin-bottom:12px}
.info-kuantitatif-head h5{margin:0;font-weight:800}
.info-kuantitatif-close{width:32px;height:32px;border:0;border-radius:999px;background:#f3f4f6;color:#334155;font-size:18px}
.info-kuantitatif-text{white-space:pre-wrap;line-height:1.45;color:#334155}
</style>
<div class="info-kuantitatif-pop" id="infoKuantitatifPop" aria-hidden="true">
    <div class="info-kuantitatif-card">
        <div class="info-kuantitatif-head">
            <h5>Info Kuantitatif</h5>
            <button type="button" class="info-kuantitatif-close" id="infoKuantitatifClose" aria-label="Tutup"><i class="mdi mdi-close"></i></button>
        </div>
        <div class="info-kuantitatif-text" id="infoKuantitatifText"></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var pop = document.getElementById('infoKuantitatifPop');
    var text = document.getElementById('infoKuantitatifText');
    var close = document.getElementById('infoKuantitatifClose');
    document.querySelectorAll('.info-kuantitatif-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            if(text) text.textContent = this.getAttribute('data-info') || 'Info kuantitatif belum diisi.';
            if(pop) pop.classList.add('show');
        });
    });
    function hide(){ if(pop) pop.classList.remove('show'); }
    if(close) close.addEventListener('click', hide);
    if(pop) pop.addEventListener('click', function(e){ if(e.target === pop) hide(); });
});
</script>
        <!-- Start Content-->
        <div class="container-fluid">
        <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Liquiditas Inhern [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fa3939; color: white;">

                            <h4 class="page-title">Risiko Likuiditas Inheren</h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren Profil Risiko Likuiditas</h4>

                            <hr>
                            </hr>


     


                            </br>


                            <!-- likuiditas-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
                                                <h4>
                                                    <center><b>RISIKO LIKUIDITAS INHEREN</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr style="color: #050505;">
                                            <th width="2%">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center" width="20%">
                                                PARAMETER
                                            </th>

                                            <th class="text-center" width="13%">
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
                                            <th class="text-center" width="8%">
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
                                                    <b>PILAR 1 : Komposisi dan Konsentrasi Aset dan Kewajiban</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th >
                                                <center>Aset Likuid</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['aset_likuid']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_aset']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p1,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['al_per_ta'] ?></td>

                                            <td>
                                                <center><?= $hsl1 ?></center>
                                            </td>

                                            <td>
                                                <center><?= $hsl1a ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil1_1'] ?></textarea><?= likuiditas_info_kuantitatif_btn($info_kuantitatif_likuiditas, 'ket_pil1_1') ?>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a.<center>Total Aset-Aset Likuid</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK-Aset Likuid</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($p1a_atas) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($p1a_bawah) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p1a,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['ta_al_per_td_al'] ?> </td>

                                            <td>
                                                <center><?= $hsl1a ?></center>
                                            </td>

                                            <td>
                                                
                                            </td>
                                            <td>
                                                
                                            </td>

                                        </tr>




                                        











                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th >
                                                <center>Aset Likuid</center>
                                                <hr>
                                                </hr>
                                                <center>Kewajiban Lancar</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['aset_likuid']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['kewajiban_lancar']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['al_per_kl'] ?></td>

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
                                            <textarea class="form-control" id="ket_pil1_2" form="my_form" name="ket_pil1_2" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil1_2'] ?></textarea><?= likuiditas_info_kuantitatif_btn($info_kuantitatif_likuiditas, 'ket_pil1_2') ?>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a.<center>Total Aset Likuid</center>
                                                <hr>
                                                </hr>
                                                <center>Pendanaan jangka Pendek</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['aset_likuid']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['pendanaan_jangka_pendek']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2a,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['tal_per_pjp'] ?> </td>

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
                                                b.<center>Aset Likuid</center>
                                                <hr>
                                                </hr>
                                                <center>Kewajiban Jangka Pendek</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['aset_likuid']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['kewajiban_jangka_pendek']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2b,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['al_per_kjp'] ?> </td>

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
                                                c.<center>Arus Kas Netto</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($arus_kas_netto) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= number_format($p2c,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['akn_per_tdpk'] ?> </td>

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
                                                d.<center>Tabungan</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['tabungan']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2d,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['tabungan_per_tdpk'] ?> </td>

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
                                                e.<center>Deposito Jangka Waktu 3 bln</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['deposito_3bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2e,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['djw3bln_per_tdpk'] ?> </td>

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
                                                f.<center>Deposito Jangka Waktu 6 bln</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['deposito_6bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2f,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['djw6bln_per_tdpk'] ?> </td>

                                            <td>
                                                <center><?= $hsl2f ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2f, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                g.<center>Deposito Jangka Waktu 12 bln</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['deposito_12bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2g,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['djw12bln_per_tdpk'] ?> </td>

                                            <td>
                                                <center><?= $hsl2g ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_7, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2g, 2) ?></center>
                                            </td>

                                        </tr>


                                        <?php if (!$is_profil_risiko_cabang): ?>
                                        <tr>
                                            <th></th>
                                            <th>
                                                h.<center>Modal Disetor</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_likuiditas_P1['modal_disetor']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2h,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['md_per_tdpk'] ?>
                                            </td>
                                            <td>
                                                <center><?= $hsl2h ?></center>
                                            </td>
                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_8, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2h, 2) ?></center>
                                            </td>
                                        </tr>
                                        <?php endif; ?>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                h.<center>Pinjaman</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['pinjaman']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p2i,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['pin_per_tdpk'] ?> </td>

                                            <td>
                                                <center><?= $hsl2i ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_9, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2i, 2) ?></center>
                                            </td>

                                        </tr>


                                        














                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th >
                                                <center>Kredit Yang Diberikan</center>
                                                <hr>
                                                </hr>
                                                <center>Total Dana Pihak Ketiga Bukan Bank</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p3 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['kyd_per_tdpkbk'] ?></td>

                                            <td>
                                                <center><?= $hsl3 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi3, 2) ?></center>
                                            </td>
                                            <td>

                                                <center><?= number_format($nilai3, 2) ?></center>

                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_3" form="my_form" name="ket_pil1_3" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil1_3'] ?></textarea><?= likuiditas_info_kuantitatif_btn($info_kuantitatif_likuiditas, 'ket_pil1_3') ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a.<center>DPK Yang Dijamin LPS</center>
                                                <hr>
                                                </hr>
                                                <center>DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['dpk_dijamin_lps']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p3a,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['dpkydlps_per_dpk'] ?> </td>

                                            <td>
                                                <center><?= $hsl3a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai3a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b.<center>Alat Likuid + Kredit Lancar</center>
                                                <hr>
                                                </hr>
                                                <center>Dana Pihak Ke 3</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($p3b_atas) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p3b,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['alkl_per_dpk3'] ?> </td>

                                            <td>
                                                <center><?= $hsl3b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai3b, 2) ?></center>
                                            </td>
                                        </tr>


                                        
                                        <?php /* baris pilar 1 parameter 3c dihilangkan */ ?>




                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c.<center>Pertumbuhan Kredit</center>
                                                <hr>
                                                </hr>
                                                <center>Pertumbuhan Simpanan</center>
                                            </th>
                                            <th >
                                                <center><?= number_format($p3d_atas,2) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= number_format($p3d_bawah,2) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p3d,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['pk_per_ps'] ?> </td>

                                            <td>
                                                <center><?= $hsl3d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai3d, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th >
                                                <center>25 Deposan dan Penabung Terbesar</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['deposan_tabungan_terbesar25']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p4 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['ddpt25_per_tdpk'] ?></td>

                                            <td>
                                                <center><?= $hsl4 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par4" value="<?= number_format($koreksi4, 2, '.', '') ?>" class="form-control" id="koreksippl1_par4" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="text" form="my_form" name="nilaippl1_par4" value="<?= number_format($nilai4, 2, '.', '') ?>" class="form-control" id="nilaippl1_par4" readonly></center>

                                            </td>

                                            <td>
                                            <textarea class="form-control" id="ket_pil1_4" form="my_form" name="ket_pil1_4" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil1_4'] ?></textarea><?= likuiditas_info_kuantitatif_btn($info_kuantitatif_likuiditas, 'ket_pil1_4') ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th >
                                                <label for="example-select" class="form-label">Komposisi 50 deposan dan penabung </br> terbesar tersebut adalah :</label>
                                                <select class="form-select" form="my_form" name="sektor_terbesar3" id="sektor_terbesar3">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil1['pilar1_4'] == "1" ? "selected" : "" ?>>1 = seluruhnya nasabah lama dengan saldo terjaga lama</option>
                                                    <option value="2" <?= $pil1['pilar1_4'] == "2" ? "selected" : "" ?>>2 = seluruhnya nasabah lama</option>
                                                    <option value="3" <?= $pil1['pilar1_4'] == "3" ? "selected" : "" ?>>3 = sebagian besar adalah nasabah lama</option>
                                                    <option value="4" <?= $pil1['pilar1_4'] == "4" ? "selected" : "" ?>>4 = sebagian besar adalah nasabah baru</option>
                                                    <option value="5" <?= $pil1['pilar1_4'] == "5" ? "selected" : "" ?>>5 = seluruhnya nasaba baru</option>
                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_4'] ?></center>
                                            </th>
                                            <th colspan="6"></th>
                                        </tr>




                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th >
                                                <center>Pendanaan Non Inti</center>
                                                <hr>
                                                </hr>
                                                <center>Total Pendanaan</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['pendanaan_non_inti']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p5 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['pni_per_tp'] ?></td>

                                            <td>
                                                <center><?= $hsl5 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi5, 2) ?></center>
                                            </td>
                                            <td>

                                                <center><?= number_format($nilai5, 2) ?></center>

                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_5" form="my_form" name="ket_pil1_5" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil1_5'] ?></textarea><?= likuiditas_info_kuantitatif_btn($info_kuantitatif_likuiditas, 'ket_pil1_5') ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a.<center>Pendanaan Non Inti-Alat Likuid</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset-Aset Likuid</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($p5a_atas) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($p5a_bawah) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p5a,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['pnial_per_taal'] ?> </td>

                                            <td>
                                                <center><?= $hsl5a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai5a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b.<center>Deposito Rate Spesial</center>
                                                <hr>
                                                </hr>
                                                <center>Alat Likuid</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['deposito_rs']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['alat_likuid']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p5b,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['drs_per_al'] ?> </td>

                                            <td>
                                                <center><?= $hsl5b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai5b, 2) ?></center>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c.<center>Aset Likuid</center>
                                                <hr>
                                                </hr>
                                                <center>Pendanaan Non Inti</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['aset_likuid']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['pendanaan_non_inti']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= number_format($p5c,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_likuiditas['al_per_pni'] ?> </td>

                                            <td>
                                                <center><?= $hsl5c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai5c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                d.<center>Deposito Inti (100 Deposan)</center>
                                                <hr>
                                                </hr>
                                                <center>Total DPK</center>
                                            </th>
                                            <th >
                                                <center><?= rupiah($master_likuiditas_P1['deposito_inti']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_likuiditas_P1['total_dpk']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p5d,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_likuiditas['di_per_tdpk'] ?> </td>

                                            <td>
                                                <center><?= $hsl5d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai5d, 2) ?></center>
                                            </td>

                                        </tr>





                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
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
                                                <?php if ($setris_mode_lik === 'pembobotan'): ?>
                                                    <input type="hidden" id="set_pil1" name="set_pil1" form="my_form" value="<?= $set_pil1 ?>">
                                                    <input type="text" class="form-control" value="Bobot <?= number_format((float)$setris_bobot_pil1, 2, '.', '') ?>%" readonly>
                                                <?php else: ?>
                                                    <input type="hidden" name="set_pil1" form="my_form" value="<?= $set_pil1 ?>">
                                                    <select class="form-select" id="set_pil1" disabled>
                                                        <option value="1" <?= $set_pil1 == "1" ? "selected" : "" ?>>Tertinggi</option>
                                                        <option value="2" <?= $set_pil1 == "2" ? "selected" : "" ?>>Terendah</option>
                                                        <option value="3" <?= $set_pil1 == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                    </select>
                                                <?php endif; ?>
                                            </th>
                                            <th >
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil1" value="<?= $hasil['pil1_tingkat_risiko'] ?>" class="form-control" id="risiko_pil1" readonly></center>
                                            </th>

                                            <th>
                                            <textarea class="form-control" id="ket_pil1" form="my_form" name="ket_pil1" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil1'] ?></textarea>
                                            </th>


                                        </tr>




























<!--pilar2--->







                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 2 : Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber Pendanaan</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th  colspan="2">
                                            Penilaian kebutuhan pendanaan BPR pada situasi normal maupun krisis, dan kemampuan BPR untuk memenuhi kebutuhan pendanaan
                                            </th>
                                            <td>
                                                
                                            </td>
                                            <td colspan="3">
                                            Hasil Penilaian dari Parameter Tambahan :
                                            </td>
                                            
                                            <td>
                                                <center><input type="number" form="my_form" name="hasil_pil2_par1" value="<?= $pil2['hasil_pil2_par1'] ?>" class="form-control" id="hasil_pil2_par1" readonly></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil2_1'] ?></textarea><?= likuiditas_info_kuantitatif_btn($info_kuantitatif_likuiditas, 'ket_pil2_1') ?>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                a. Sumber Pendanaan Untuk Memenuhi Kebutuhan</br> Likuiditas
                                                <select class="form-select" form="my_form" name="pilar2_1a" id="pilar2_1a">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil2['pil2_par1a'] == "1" ? "selected" : "" ?>>1 = Terdapat > 2 (Dua) Jenis Sumber Pendanaan untuk Pemenuhan Likuiditas</option>
                                                    <option value="2" <?= $pil2['pil2_par1a'] == "2" ? "selected" : "" ?>>2 = Terdapat 2 (Dua) Jenis Sumber Pendanaan untuk Pemenuhan Likuiditas</option>
                                                    <option value="3" <?= $pil2['pil2_par1a'] == "3" ? "selected" : "" ?>>3 = Terdapat 1 (Satu) Jenis Sumber Pendanaan untuk Pemenuhan Likuiditas</option>
                                                    <option value="4" <?= $pil2['pil2_par1a'] == "4" ? "selected" : "" ?>>4 = Terdapat 1 (Satu) Jenis Sumber Pendanaan untuk Pemenuhan Likuiditas yang Terbatas</option>
                                                    <option value="5" <?= $pil2['pil2_par1a'] == "5" ? "selected" : "" ?>>5 = Tidak Terdapat Sumber Pendanaan untuk Pemenuhan Likuiditas</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil2['pil2_par1a'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                    

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl2_par1a" value="<?= number_format($bobot5_1, 2) ?>" class="form-control" id="koreksippl2_par1a" readonly>
                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl2_par1a" value="<?= $pil2['hasil_pil2_par1a'] ?>" class="form-control" id="nilaippl2_par1a" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b. Identifikasi Terhadap Produk Kredit dan Simpanan 
                                                <select class="form-select" form="my_form" name="pilar2_1b" id="pilar2_1b">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil2['pil2_par1b'] == "1" ? "selected" : "" ?>>1 = Identifikasi Produk Dilakukan lebih dari Sekali dalam Setahun sekali</option>
                                                    <option value="2" <?= $pil2['pil2_par1b'] == "2" ? "selected" : "" ?>>2 = Identifikasi Produk Dilakukan Setahun Sekali</option>
                                                    <option value="3" <?= $pil2['pil2_par1b'] == "3" ? "selected" : "" ?>>3 = Identifikasi Produk Dilakukan 1,5Tahun Sekali</option>
                                                    <option value="4" <?= $pil2['pil2_par1b'] == "4" ? "selected" : "" ?>>4 = Identifikasi Produk Dilakukan 2 Tahun Sekali</option>
                                                    <option value="5" <?= $pil2['pil2_par1b'] == "5" ? "selected" : "" ?>>5 = Identifikasi Produk Dilakukan > 2 Tahun Sekali</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil2['pil2_par1b'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl2_par1b" value="<?= number_format($bobot5_2, 2) ?>" class="form-control" id="koreksippl2_par1b" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl2_par1b" value="<?= $pil2['hasil_pil2_par1b'] ?>" class="form-control" id="nilaippl2_par1b" readonly>

                                            </th>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c. Identifikasi Sumber Pendanaan Non Inti
                                                <select class="form-select" form="my_form" name="pilar2_1c" id="pilar2_1c">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil2['pil2_par1c'] == "1" ? "selected" : "" ?>>1 = Identifikasi Sumber Pendanaan Non Inti Setiap 1 (Satu) Bulan</option>
                                                    <option value="2" <?= $pil2['pil2_par1c'] == "2" ? "selected" : "" ?>>2 = Identifikasi Sumber Pendanaan Non Inti Setiap 2 (Dua) Bulan</option>
                                                    <option value="3" <?= $pil2['pil2_par1c'] == "3" ? "selected" : "" ?>>3 = Identifikasi Sumber Pendanaan Non Inti Setiap 3 (Tiga) Bulan</option>
                                                    <option value="4" <?= $pil2['pil2_par1c'] == "4" ? "selected" : "" ?>>4 = Identifikasi Sumber Pendanaan Non Inti Semester</option>
                                                    <option value="5" <?= $pil2['pil2_par1c'] == "5" ? "selected" : "" ?>>5 = Identifikasi Sumber Pendanaan Non Inti Tidak Pernah Dilakukan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil2['pil2_par1c'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl2_par1c" value="<?= number_format($bobot5_3, 2) ?>" class="form-control" id="koreksippl2_par1c" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl2_par1c" value="<?= $pil2['hasil_pil2_par1c'] ?>" class="form-control" id="nilaippl2_par1c" readonly>

                                            </th>

                                        </tr>








                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th colspan="2">
                                            Penilaian terhadap seberapa luas atau seberapa besar BPR memiliki komitmen pendanaan yang dapat digunakan jika dibutuhkan
                                            </th>
                                            <td></td>
                                            <td>
                                               

                                            <td>
                                               
                                            </td>

                                            <td>
                                                
                                            </td>
                                            <td>
                                            <center><input type="number" form="my_form" name="nilaippl2_par2" value="<?= $pil2['hasil_pil2_par2'] ?>" class="form-control" id="nilaippl2_par2" readonly>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil2_2'] ?></textarea><?= likuiditas_info_kuantitatif_btn($info_kuantitatif_likuiditas, 'ket_pil2_2') ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                <select class="form-select" form="my_form" name="pilar2_2" id="pilar2_2">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil2['pil2_par2'] == "1" ? "selected" : "" ?>> 1 = sangat memadai</option>
                                                    <option value="2" <?= $pil2['pil2_par2'] == "2" ? "selected" : "" ?>> 2 = memadai</option>
                                                    <option value="3" <?= $pil2['pil2_par2'] == "3" ? "selected" : "" ?>> 3 = cukup memadai</option>
                                                    <option value="4" <?= $pil2['pil2_par2'] == "4" ? "selected" : "" ?>> 4 = kurang memadai</option>
                                                    <option value="5" <?= $pil2['pil2_par2'] == "5" ? "selected" : "" ?>> 5 = tidak memadais</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil2['pil2_par2'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                    

                                            <th colspan="2">
                                                
                                            </th>
                                            <th>
                                               

                                            </th>

                                        </tr>






                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 2</center>
                                            </th>
                                            <th >
                                                <center>Tertinggi</center>
                                                <center><input type="number" form="my_form" name="tertinggi_pil2" class="form-control" value="<?= $hasil['pil2_tertinggi'] ?>" id="tertinggi_pil2" readonly></center>
                                            </th>
                                            <th >
                                                <center>Terendah</center>
                                                <center><input type="number" form="my_form" name="terendah_pil2" class="form-control"  value="<?= $hasil['pil2_terendah'] ?>" id="terendah_pil2" readonly></center>
                                            </th>
                                            <th >
                                                <center>Rata-rata</center>
                                                <center><input type="number" form="my_form" name="rata_rata_pil2" class="form-control"  value="<?= $hasil['pil2_rata_rata'] ?>" id="rata_rata_pil2" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <?php if ($setris_mode_lik === 'pembobotan'): ?>
                                                    <input type="hidden" id="set_pil2" name="set_pil2" form="my_form" value="<?= $set_pil2 ?>">
                                                    <input type="text" class="form-control" value="Bobot <?= number_format((float)$setris_bobot_pil2, 2, '.', '') ?>%" readonly>
                                                <?php else: ?>
                                                    <input type="hidden" name="set_pil2" form="my_form" value="<?= $set_pil2 ?>">
                                                    <select class="form-select" id="set_pil2" disabled>
                                                        <option value="1" <?= $set_pil2 == "1" ? "selected" : "" ?>>Tertinggi</option>
                                                        <option value="2" <?= $set_pil2 == "2" ? "selected" : "" ?>>Terendah</option>
                                                        <option value="3" <?= $set_pil2 == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                    </select>
                                                <?php endif; ?>
                                            </th>
                                            <th >
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil2" class="form-control"  value="<?= $hasil['pil2_tingkat_risiko'] ?>" id="risiko_pil2" readonly></center>
                                            </th>

                                            <th>
                                            <textarea class="form-control" id="ket_pil2" form="my_form" name="ket_pil2" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil2'] ?></textarea>
                                            </th>


                                        </tr>








<!--pilar3--->





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
                                            <center><input type="number" form="my_form" name="hasil_pil3_par1" value="<?= $pil3['hasil_pil3_par1'] ?>" class="form-control" id="hasil_pil3_par1" readonly></center>
                                            </th>
                                            <td>
                                            <textarea class="form-control" id="ket_pil3_1" form="my_form" name="ket_pil3_1" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil3_1'] ?></textarea><?= likuiditas_info_kuantitatif_btn($info_kuantitatif_likuiditas, 'ket_pil3_1') ?>
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
                                                a. Identifikasi Risk Event yang mempengaruhi kemampuan likuiditas yang bersumber dari eksternal
                                                <select class="form-select" form="my_form" name="pilar3_1a" id="pilar3_1a">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil3['pil3_par1a'] == "1" ? "selected" : "" ?>>1 = Dilakukan Setiap Mingguan</option>
                                                    <option value="2" <?= $pil3['pil3_par1a'] == "2" ? "selected" : "" ?>>2 = Dilakukan Setiap Bulan</option>
                                                    <option value="3" <?= $pil3['pil3_par1a'] == "3" ? "selected" : "" ?>>3 = Dilakukan Setiap 2 (Dua) Bulan</option>
                                                    <option value="4" <?= $pil3['pil3_par1a'] == "4" ? "selected" : "" ?>>4 = Dilakukan Setiap 3 (Tiga) Bulan</option>
                                                    <option value="5" <?= $pil3['pil3_par1a'] == "5" ? "selected" : "" ?>>5 = Tidak Pernah Dilakukan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil3['pil3_par1a'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                         

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl3_par1a" value="<?= number_format($bobot6_1, 2) ?>" class="form-control" id="koreksippl3_par1a" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1a" value="<?= $pil3['hasil_pil3_par1a'] ?>" class="form-control" id="nilaippl3_par1a" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                b. Identifikasi dan Evaluasi terhadap jenis risiko lain yang meningkatkan risiko likuiditas
                                                <select class="form-select" form="my_form" name="pilar3_1b" id="pilar3_1b">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil3['pil3_par1b'] == "1" ? "selected" : "" ?>>1 = Dilakukan Setiap Mingguan</option>
                                                    <option value="2" <?= $pil3['pil3_par1b'] == "2" ? "selected" : "" ?>>2 = Dilakukan Setiap Bulan</option>
                                                    <option value="3" <?= $pil3['pil3_par1b'] == "3" ? "selected" : "" ?>>3 = Dilakukan Setiap 2 (Dua) Bulan</option>
                                                    <option value="4" <?= $pil3['pil3_par1b'] == "4" ? "selected" : "" ?>>4 = Dilakukan Setiap 3 (Tiga) Bulan</option>
                                                    <option value="5" <?= $pil3['pil3_par1b'] == "5" ? "selected" : "" ?>>5 = Tidak Pernah Dilakukan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil3['pil3_par1b'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl3_par1b" value="<?= number_format($bobot6_2, 2) ?>" class="form-control" id="koreksippl3_par1b" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1b" value="<?= $pil3['hasil_pil3_par1b'] ?>" class="form-control" id="nilaippl3_par1b" readonly>

                                            </th>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th >
                                                c. Monitoring tingkat suku bunga pasar
                                                <select class="form-select" form="my_form" name="pilar3_1c" id="pilar3_1c">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil3['pil3_par1c'] == "1" ? "selected" : "" ?>>1 = Dilakukan Setiap Bulan</option>
                                                    <option value="2" <?= $pil3['pil3_par1c'] == "2" ? "selected" : "" ?>>2 = Dilakukan Setiap 3 (Tiga) Bulan</option>
                                                    <option value="3" <?= $pil3['pil3_par1c'] == "3" ? "selected" : "" ?>>3 = Dilakukan Setiap 6 (Enam) Bulan</option>
                                                    <option value="4" <?= $pil3['pil3_par1c'] == "4" ? "selected" : "" ?>>4 = Dilakukan Setiap Tahun</option>
                                                    <option value="5" <?= $pil3['pil3_par1c'] == "5" ? "selected" : "" ?>>5 = Tidak Pernah Dilakukan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil3['pil3_par1c'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl3_par1c" value="<?= number_format($bobot6_3, 2) ?>" class="form-control" id="koreksippl3_par1c" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1c" value="<?= $pil3['hasil_pil3_par1c'] ?>" class="form-control" id="nilaippl3_par1c" readonly>

                                            </th>

                                        </tr>


                                        
                                        <?php /* baris lainnya d dihilangkan */ ?>



                                        
                                        <?php /* baris lainnya e dihilangkan */ ?>


                                        
                                        <?php /* baris lainnya f dihilangkan */ ?>









                                        

                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk Lainnya</center>
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
                                                <?php if ($setris_mode_lik === 'pembobotan'): ?>
                                                    <input type="hidden" id="set_pil3" name="set_pil3" form="my_form" value="<?= $set_pil3 ?>">
                                                    <input type="text" class="form-control" value="Bobot <?= number_format((float)$setris_bobot_pil3, 2, '.', '') ?>%" readonly>
                                                <?php else: ?>
                                                    <input type="hidden" name="set_pil3" form="my_form" value="<?= $set_pil3 ?>">
                                                    <select class="form-select" id="set_pil3" disabled>
                                                        <option value="1" <?= $set_pil3 == "1" ? "selected" : "" ?>>Tertinggi</option>
                                                        <option value="2" <?= $set_pil3 == "2" ? "selected" : "" ?>>Terendah</option>
                                                        <option value="3" <?= $set_pil3 == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                    </select>
                                                <?php endif; ?>
                                            </th>
                                            <th >
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil3" value="<?= $hasil['pil3_tingkat_risiko'] ?>" class="form-control" id="risiko_pil3" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" id="ket_pil3" form="my_form" name="ket_pil3" cols="40" rows="5"><?= $ket_inhern_likuiditas['ket_pil3'] ?></textarea>
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

                                            <th colspan="9">
                                                <center>REKAP PENILAIAN INHEREN LIKUIDITAS</center>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 1 - Komposisi Portofolio Aset Dan Tingkat Konsentrasi Likuiditas
                                            </th>
                                            
                                            <td width="10%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil1" form="my_form" value="<?= $hasil['pil1_tingkat_risiko'] ?>" name="hasil_risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 2 - Kualitas Aset
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil2" form="my_form" value="<?= $hasil['pil2_tingkat_risiko'] ?>" name="hasil_risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Lainnya
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil3" form="my_form" value="<?= $hasil['pil3_tingkat_risiko'] ?>" name="hasil_risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                       
                                        
                                    </tbody>
                                    
                                    <tbody>
                                        <tr class="table" bgcolor="#74c7ff">
                                            <th scope="row" colspan="4">
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
                                                <?php if ($setris_mode_lik === 'pembobotan'): ?>
                                                    <input type="hidden" id="opsi_inheren" name="opsi_inheren" form="my_form" value="<?= $set_tingkat_risiko ?>">
                                                    <input type="text" class="form-control" value="Pembobotan" readonly>
                                                <?php else: ?>
                                                    <select class="form-select" id="opsi_inheren" name="opsi_inheren" form="my_form">
                                                        <option value="1" <?= $set_tingkat_risiko == "1" ? "selected" : "" ?>>Tertinggi</option>
                                                        <option value="2" <?= $set_tingkat_risiko == "2" ? "selected" : "" ?>>Terendah</option>
                                                        <option value="3" <?= $set_tingkat_risiko == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                    </select>
                                                <?php endif; ?>
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
                                        <tr>

                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren likuiditas</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control" id="ket_inheren" form="my_form" name="ket_inheren" cols="60" rows="10"><?= $ket_inhern_likuiditas['ket_inheren'] ?></textarea>
                                            </th>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>































                            <hr>
                            </hr>

                            <br></br>


                            <!-- Tombol Simpan dihapus karena sudah autosave -->



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




<script>
/* === FIX: dropdown "Nilai diambil" editable seperti Inheren Kredit === */
(function(){
    function num(id){
        var el = document.getElementById(id);
        if (!el) return 0;
        var v = parseFloat(String(el.value || '0').replace(',', '.'));
        return isNaN(v) ? 0 : v;
    }
    function setVal(id, val){
        var el = document.getElementById(id);
        if (!el) return;
        el.value = (parseFloat(val) || 0).toFixed(2);
    }
    function pick(method, hi, low, avg){
        method = String(method || '1');
        if (method === '1') return hi;
        if (method === '2') return low;
        if (method === '3') return avg;
        return hi;
    }
    function labelRisiko(v){
        v = parseFloat(v) || 0;
        if (v >= 1.00 && v < 1.25) return 'Sangat Rendah';
        if (v >= 1.25 && v < 2.25) return 'Rendah';
        if (v >= 2.25 && v < 3.25) return 'Sedang';
        if (v >= 3.25 && v < 4.25) return 'Tinggi';
        if (v >= 4.25 && v <= 5.00) return 'Sangat Tinggi';
        return '';
    }
    function updatePilar(prefix, selectId){
        var metode = document.getElementById(selectId) ? document.getElementById(selectId).value : '1';
        var nilai = pick(metode, num('tertinggi_' + prefix), num('terendah_' + prefix), num('rata_rata_' + prefix));
        setVal('risiko_' + prefix, nilai);
        setVal('hasil_risiko_' + prefix, nilai);
        return nilai;
    }
    function updateInheren(){
        var r1 = num('risiko_pil1');
        var r2 = num('risiko_pil2');
        var r3 = num('risiko_pil3');
        var arr = [r1, r2, r3];
        var max = Math.max.apply(null, arr);
        var min = Math.min.apply(null, arr);
        var avg = (r1 + r2 + r3) / 3;

        setVal('tertinggi_inheren', max);
        setVal('terendah_inheren', min);
        setVal('rata_rata_inheren', avg);

        var metode = document.getElementById('opsi_inheren') ? document.getElementById('opsi_inheren').value : '1';
        var nilai = pick(metode, max, min, avg);
        setVal('risiko_inheren', nilai);

        var peringkat = document.getElementById('peringkat_inheren');
        if (peringkat) peringkat.value = labelRisiko(nilai);
    }
    var autosaveTimer = null;
    var autosaveRunning = false;
    var autosavePending = false;

    function buildAutosaveData(){
        updateAll();
        var fd = new FormData();
        fd.append('autosave', '1');

        var controls = Array.prototype.slice.call(document.querySelectorAll('[form="my_form"]')).filter(function(el){
            if (!el.name) return false;
            if ((el.type || '').toLowerCase() === 'submit') return false;
            if (el.name === 'submit') return false;
            // field disabled di level pilar memang readonly, tidak perlu dikirim.
            if (el.disabled && ['set_pil1','set_pil2','set_pil3'].indexOf(el.id) !== -1) return false;
            return true;
        });

        controls.forEach(function(el){
            if (!el.name) return;
            var tag = (el.tagName || '').toUpperCase();
            var type = (el.type || '').toLowerCase();

            if ((type === 'checkbox' || type === 'radio') && !el.checked) return;

            if (tag === 'SELECT' && el.multiple) {
                Array.prototype.slice.call(el.options).forEach(function(opt){
                    if (opt.selected) fd.append(el.name, opt.value);
                });
            } else {
                fd.append(el.name, el.value == null ? '' : el.value);
            }
        });

        // Pastikan field penting tetap terkirim walaupun tidak masuk daftar controls.
        ['opsi_inheren','tertinggi_pil1','terendah_pil1','rata_rata_pil1','risiko_pil1','tertinggi_pil2','terendah_pil2','rata_rata_pil2','risiko_pil2','tertinggi_pil3','terendah_pil3','rata_rata_pil3','risiko_pil3','tertinggi_inheren','terendah_inheren','rata_rata_inheren','risiko_inheren','peringkat_inheren'].forEach(function(id){
            var el = document.getElementById(id);
            if (el && el.name && !fd.has(el.name)) fd.append(el.name, el.value || '');
        });

        return fd;
    }

    function doAutosave(){
        if (autosaveRunning) {
            autosavePending = true;
            return;
        }
        autosaveRunning = true;

        fetch(window.location.href, {
            method: 'POST',
            body: buildAutosaveData(),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
        .then(function(res){ return res.text(); })
        .then(function(txt){
            try {
                var res = JSON.parse(txt);
                if (res && res.success) {
                    var ri = document.getElementById('risiko_inheren');
                    var pi = document.getElementById('peringkat_inheren');
                    if (ri && res.hasil_tingkat_risiko !== undefined) ri.value = res.hasil_tingkat_risiko;
                    if (pi && res.hasil_peringkat !== undefined) pi.value = res.hasil_peringkat;
                    console.log('autosave likuiditas ok');
                } else {
                    console.log('autosave likuiditas response:', txt);
                }
            } catch(e) {
                console.log('autosave likuiditas response:', txt);
            }
        })
        .catch(function(err){
            console.error('Autosave likuiditas error:', err);
        })
        .finally(function(){
            autosaveRunning = false;
            if (autosavePending) {
                autosavePending = false;
                doAutosave();
            }
        });
    }

    function autosaveLikuiditas(delay){
        clearTimeout(autosaveTimer);
        autosaveTimer = setTimeout(function(){ doAutosave(); }, delay || 600);
    }

    function updateAll(){
        updatePilar('pil1', 'set_pil1');
        updatePilar('pil2', 'set_pil2');
        updatePilar('pil3', 'set_pil3');
        updateInheren();
    }

    document.addEventListener('DOMContentLoaded', function(){
        ['set_pil1','set_pil2','set_pil3'].forEach(function(id){
            var el = document.getElementById(id);
            if (el) el.disabled = true;
        });

        var opsiInheren = document.getElementById('opsi_inheren');
        if (opsiInheren) {
            opsiInheren.disabled = false;
            opsiInheren.addEventListener('change', function(){
                updateAll();
                autosaveLikuiditas(150);
            });
        }

        var controls = Array.prototype.slice.call(document.querySelectorAll('[form="my_form"]')).filter(function(el){
            if (!el.name) return false;
            if (el.disabled) return false;
            if ((el.type || '').toLowerCase() === 'submit') return false;
            if (el.name === 'submit') return false;
            return true;
        });

        controls.forEach(function(el){
            var tag = (el.tagName || '').toUpperCase();
            if (tag === 'SELECT') {
                el.addEventListener('change', function(){ updateAll(); autosaveLikuiditas(150); });
                el.addEventListener('input', function(){ updateAll(); autosaveLikuiditas(150); });
            } else if (tag === 'TEXTAREA') {
                el.addEventListener('input', function(){ autosaveLikuiditas(500); });
                el.addEventListener('blur', function(){ autosaveLikuiditas(150); });
            } else {
                el.addEventListener('input', function(){ updateAll(); autosaveLikuiditas(500); });
                el.addEventListener('change', function(){ updateAll(); autosaveLikuiditas(150); });
                el.addEventListener('blur', function(){ updateAll(); autosaveLikuiditas(150); });
            }
        });

        updateAll();
    });
})();
</script>

