<?php include "../verif_folder.php"; ?>
<?php
if (empty($id) || $id === null) {
  $displayModal = true;
} else {
  $displayModal = false;
}
$masterUploadType = 'kredit';
include __DIR__ . '/upload_result_modal.php';
?>
<style>
#notifModalMaster .modal-dialog{
    max-width:620px;
    width:92%;
    margin:1.75rem auto;
}
#notifModalMaster .modal-content{
    border:0;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 20px 45px rgba(0,0,0,.25);
}
#notifModalMaster .modal-header{
    padding:14px 18px;
    border-bottom:1px solid #e9ecef;
}
#notifModalMaster .modal-title{
    font-size:18px;
    font-weight:700;
    color:#3d4b5d;
}
#notifModalMaster .notif-close-x{
    border:0;
    background:transparent;
    font-size:32px;
    line-height:1;
    color:#7d8793;
    padding:0;
    margin-left:auto;
    cursor:pointer;
}
#notifModalMaster .modal-body{
    padding:24px 28px 20px;
}
#notifModalMaster .notif-message{
    margin:0;
    text-align:center;
    font-size:19px;
    line-height:1.55;
    font-weight:700;
    color:#3d4b5d;
}
#notifModalMaster .modal-footer{
    padding:14px 18px;
    border-top:1px solid #e9ecef;
}
#notifModalMaster .notif-btn-close{
    min-width:70px;
    border:0;
    border-radius:4px;
    background:#ff5c7c;
    color:#fff;
    font-weight:500;
    padding:9px 16px;
    cursor:pointer;
    text-decoration:none;
}
#notifModalMaster .notif-btn-close:hover,
#notifModalMaster .notif-btn-close:focus{
    color:#fff;
    background:#f34b6b;
    text-decoration:none;
}
</style>

<script>
function goBackNotifMaster(){
    if (document.referrer && document.referrer !== window.location.href) {
        window.location.href = document.referrer;
        return false;
    }
    history.back();
    return false;
}
$(document).ready(function() {
    <?php if ($displayModal) { ?>
      $('#notifModalMaster').modal('show');
    <?php } ?>
    $('#notifModalMaster').on('hide.bs.modal', function (e) {
        if (<?php echo $displayModal ? 'true' : 'false'; ?>) {
            goBackNotifMaster();
        }
    });
});
window.onclick = null;
</script>

<div class="modal fade" id="notifModalMaster" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Notifikasi</h5>
        <button type="button" class="notif-close-x" aria-label="Close" onclick="return goBackNotifMaster()">&times;</button>
      </div>
      <div class="modal-body">
        <p class="notif-message">Mohon untuk memilih laporan risiko di menu dashboard -> laporan profil risiko -> klik (aktif) terlebih dahulu.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="notif-btn-close" onclick="return goBackNotifMaster()">Close</button>
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
$jenis_pr = $frame['user'];
$tahun = $frame['tahun'];
$periode = $frame['periode'];
$dp = $frame['data_pembanding'];


$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = '$id'"));


function reqv($key, $default = '') {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}

function num_only($v) {
    $v = trim((string)$v);
    if ($v === '') return 0;
    $v = str_replace('.', '', $v);
    $v = str_replace(',', '.', $v);
    $v = preg_replace('/[^0-9\.-]/', '', $v);
    return is_numeric($v) ? (float)$v : 0;
}

// Khusus nilai rasio/persen. Contoh yang diterima:
// 14,04%  -> 14.04
// 14.04%  -> 14.04
// 1.234,56% -> 1234.56
function num_ratio($v) {
    $v = trim((string)$v);
    if ($v === '') return 0;

    $v = str_replace(['%', ' '], '', $v);

    $hasComma = strpos($v, ',') !== false;
    $hasDot   = strpos($v, '.') !== false;

    if ($hasComma && $hasDot) {
        // Separator yang paling kanan dianggap desimal.
        if (strrpos($v, ',') > strrpos($v, '.')) {
            $v = str_replace('.', '', $v);
            $v = str_replace(',', '.', $v);
        } else {
            $v = str_replace(',', '', $v);
        }
    } elseif ($hasComma) {
        $v = str_replace(',', '.', $v);
    }

    $v = preg_replace('/[^0-9\.-]/', '', $v);
    return is_numeric($v) ? (float)$v : 0;
}

function ensure_master_kredit_row($conn, $table, $id) {
    $id = (int)$id;
    $cek = mysqli_query($conn, "SELECT id_profil_risiko FROM `$table` WHERE id_profil_risiko='$id' LIMIT 1");
    if ($cek && mysqli_num_rows($cek) > 0) return;
    @mysqli_query($conn, "INSERT INTO `$table` (id_profil_risiko) VALUES ('$id')");
}

function save_autosave_fields($conn, $id, $data) {
    $id = (int)$id;
    $check = @mysqli_query($conn, "SELECT 1 FROM master_kredit_autosave LIMIT 1");
    if (!$check) return;
    foreach ($data as $field => $value) {
        $field = mysqli_real_escape_string($conn, $field);
        $value = mysqli_real_escape_string($conn, (string)$value);
        mysqli_query($conn, "INSERT INTO master_kredit_autosave (id_profil_risiko, field_name, field_value, updated_at)
            VALUES ('$id', '$field', '$value', NOW())
            ON DUPLICATE KEY UPDATE field_value=VALUES(field_value), updated_at=NOW()");
    }
}

function read_autosave_fields($conn, $id) {
    $id = (int)$id;
    $out = [];
    $check = @mysqli_query($conn, "SELECT 1 FROM master_kredit_autosave LIMIT 1");
    if (!$check) return $out;
    $q = mysqli_query($conn, "SELECT field_name, field_value FROM master_kredit_autosave WHERE id_profil_risiko='$id'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)) {
            $out[$r['field_name']] = $r['field_value'];
        }
    }
    return $out;
}

function apply_field_map(&$target, $map, $fields) {
    if (!is_array($target)) $target = [];
    foreach ($fields as $field) {
        if (isset($map[$field])) {
            $target[$field] = $map[$field];
        }
    }
}

$pil1 = is_array($pil1) ? $pil1 : [];
$pil2 = is_array($pil2) ? $pil2 : [];
$pil3 = is_array($pil3) ? $pil3 : [];

$autosaveMap = read_autosave_fields($conn, $id);
apply_field_map($pil1, $autosaveMap, ['aba', 'aset_produktif', 'kyd', 'total_aset', 'noa_kyd', 'debitur_inti25', 'kredit_3sektor_ekonomi_terbesar', 'kredit_spg', 'kredit_pbta', 'kredit_jpendek', 'kredit_jmenengah', 'kredit_jpanjang', 'kredit_agunan_tb', 'kredit_agunan_kb', 'kredit_agunan_kr2', 'kredit_ta', 'kredit_kub', 'kredit_korporasi', 'kredit_pep', 'kredit_lebih350', 'kredit_joglo_mitra']);
apply_field_map($pil2, $autosaveMap, ['aset_produktif_bermasalah', 'total_aset_produktif', 'kredit_bermasalah', 'noa_kredit_bermasalah', 'kredit_bermasalah_neto', 'saldo_ckpn', 'ayda', 'kyd', 'modal_inti', 'macet_jatuh_tempo', 'kkr', 'kredit_par4', 'osc_bln_sebelumnya', 'osc_2bln_sebelumnya', 'kredit_dp', 'noa_fpd_6bln', 'noa_ekspansi_6bln', 'nominal_fpd_6bln', 'plafond_ekspansi_6bln', 'npl_kredit_sd150', 'kyd_plafon_sd150', 'noa_kredit_sd150', 'npl_kredit_diatas50', 'kyd_plafon_diatas50', 'npl_apht', 'kyd_apht', 'npl_skmht', 'kyd_skmht', 'npl_agunan_lrd_bakidebet', 'kredit_agunan_lrd_bakidebet']);
apply_field_map($pil3, $autosaveMap, ['osc_akhir_tahun_lalu', 'noa_osc_akhir_tahun_lalu', 'npl_akhir_tahun_lalu', 'noa_npl_akhir_tahun_lalu', 'osc_per_bln_penilaian', 'pertumbuhan_rata2_bpr_thn_lalu', 'pertumbuhan_rata2_bpr', 'pertumbuhan_kyd_bpr', 'rasio_pertumbuhan_rata2_bpr', 'td_pp_l', 'td_pp_dp', 'td_pp_kl', 'td_pp_d', 'td_pp_m', 'td_pp_l_noa', 'td_pp_dp_noa', 'td_pp_kl_noa', 'td_pp_d_noa', 'td_pp_m_noa', 'td_ps_l', 'td_ps_dp', 'td_ps_kl', 'td_ps_d', 'td_ps_m', 'td_ps_l_noa', 'td_ps_dp_noa', 'td_ps_kl_noa', 'td_ps_d_noa', 'td_ps_m_noa', 'd_pp_l', 'd_pp_dp', 'd_pp_kl', 'd_pp_d', 'd_pp_m', 'd_pp_l_noa', 'd_pp_dp_noa', 'd_pp_kl_noa', 'd_pp_d_noa', 'd_pp_m_noa', 'd_ps_l', 'd_ps_dp', 'd_ps_kl', 'd_ps_d', 'd_ps_m', 'd_ps_l_noa', 'd_ps_dp_noa', 'd_ps_kl_noa', 'd_ps_d_noa', 'd_ps_m_noa', 'osc_2bln_sebelumnya', 'noa_2bln_sebelumnya', 'npl_2bln_sebelumnya', 'rasio_2bln_sebelumnya', 'osc_1bln_sebelumnya', 'noa_1bln_sebelumnya', 'npl_1bln_sebelumnya', 'noa_npl_2bln_sebelumnya', 'rasio_npl_2bln_sebelumnya', 'rasio_1bln_sebelumnya', 'osc_bln_penilaian', 'noa_bln_penilaian', 'npl_bln_penilaian', 'rasio_bln_penilaian', 'aba', 'aba_tertinggi', 'aba_bank_umum', 'aba_bpr', 'noa_npl_1bln_sebelumnya', 'rasio_npl_1bln_sebelumnya', 'noa_npl_bln_penilaian', 'rasio_npl_bln_penilaian']);

if (isset($autosaveMap['total_aset'])) $frame['total_aset'] = $autosaveMap['total_aset'];
if (isset($autosaveMap['modal_inti'])) $frame['modal_inti'] = $autosaveMap['modal_inti'];

if (isset($pil1['aset_produktif'])) $pil2['total_aset_produktif'] = $pil1['aset_produktif'];
if (isset($pil1['kyd'])) $pil2['kyd'] = $pil1['kyd'];
if (isset($pil1['kyd'])) $pil3['osc_bln_penilaian'] = $pil1['kyd'];
if (isset($pil1['noa_kyd'])) $pil3['noa_bln_penilaian'] = $pil1['noa_kyd'];
if (isset($pil2['aset_produktif_bermasalah'])) $pil3['npl_bln_penilaian'] = $pil2['aset_produktif_bermasalah'];

$__osc_per_bln_penilaian = num_only(isset($pil3['osc_per_bln_penilaian']) ? $pil3['osc_per_bln_penilaian'] : 0);
$__osc_akhir_tahun_lalu = num_only(isset($pil3['osc_akhir_tahun_lalu']) ? $pil3['osc_akhir_tahun_lalu'] : 0);
$__pertumbuhan_rata2_bpr = num_only(isset($pil3['pertumbuhan_rata2_bpr']) ? $pil3['pertumbuhan_rata2_bpr'] : 0);
$__pertumbuhan_rata2_bpr_thn_lalu = num_only(isset($pil3['pertumbuhan_rata2_bpr_thn_lalu']) ? $pil3['pertumbuhan_rata2_bpr_thn_lalu'] : 0);

// Rasio pertumbuhan KYD sesuai rumus Excel:
// (OSC akhir tahun lalu - OSC bulan penilaian) / OSC akhir tahun lalu * 100
$pil3['pertumbuhan_kyd_bpr'] = ($__osc_akhir_tahun_lalu == 0) ? 0 : ((($__osc_akhir_tahun_lalu - $__osc_per_bln_penilaian) / $__osc_akhir_tahun_lalu) * 100);
$pil3['rasio_pertumbuhan_rata2_bpr'] = ($__pertumbuhan_rata2_bpr_thn_lalu == 0) ? 0 : ((($__pertumbuhan_rata2_bpr - $__pertumbuhan_rata2_bpr_thn_lalu) / $__pertumbuhan_rata2_bpr_thn_lalu) * 100);

if (isset($_POST['submit']) || (isset($_POST['autosave']) && $_POST['autosave'] == '1')) {
    $is_autosave = (isset($_POST['autosave']) && $_POST['autosave'] == '1');

    $p1Fields = ['aba', 'aset_produktif', 'kyd', 'total_aset', 'noa_kyd', 'debitur_inti25', 'kredit_3sektor_ekonomi_terbesar', 'kredit_spg', 'kredit_pbta', 'kredit_jpendek', 'kredit_jmenengah', 'kredit_jpanjang', 'kredit_agunan_tb', 'kredit_agunan_kb', 'kredit_agunan_kr2', 'kredit_ta', 'kredit_kub', 'kredit_korporasi', 'kredit_pep', 'kredit_lebih350', 'kredit_joglo_mitra'];
    $p2Fields = ['aset_produktif_bermasalah', 'total_aset_produktif', 'kredit_bermasalah', 'noa_kredit_bermasalah', 'kredit_bermasalah_neto', 'saldo_ckpn', 'ayda', 'kyd', 'modal_inti', 'macet_jatuh_tempo', 'kkr', 'kredit_par4', 'osc_bln_sebelumnya', 'osc_2bln_sebelumnya', 'kredit_dp', 'noa_fpd_6bln', 'noa_ekspansi_6bln', 'nominal_fpd_6bln', 'plafond_ekspansi_6bln', 'npl_kredit_sd150', 'kyd_plafon_sd150', 'noa_kredit_sd150', 'npl_kredit_diatas50', 'kyd_plafon_diatas50', 'npl_apht', 'kyd_apht', 'npl_skmht', 'kyd_skmht', 'npl_agunan_lrd_bakidebet', 'kredit_agunan_lrd_bakidebet'];
    $p3Fields = ['osc_akhir_tahun_lalu', 'noa_osc_akhir_tahun_lalu', 'npl_akhir_tahun_lalu', 'noa_npl_akhir_tahun_lalu', 'osc_per_bln_penilaian', 'pertumbuhan_rata2_bpr_thn_lalu', 'pertumbuhan_rata2_bpr', 'pertumbuhan_kyd_bpr', 'rasio_pertumbuhan_rata2_bpr', 'td_pp_l', 'td_pp_dp', 'td_pp_kl', 'td_pp_d', 'td_pp_m', 'td_pp_l_noa', 'td_pp_dp_noa', 'td_pp_kl_noa', 'td_pp_d_noa', 'td_pp_m_noa', 'td_ps_l', 'td_ps_dp', 'td_ps_kl', 'td_ps_d', 'td_ps_m', 'td_ps_l_noa', 'td_ps_dp_noa', 'td_ps_kl_noa', 'td_ps_d_noa', 'td_ps_m_noa', 'd_pp_l', 'd_pp_dp', 'd_pp_kl', 'd_pp_d', 'd_pp_m', 'd_pp_l_noa', 'd_pp_dp_noa', 'd_pp_kl_noa', 'd_pp_d_noa', 'd_pp_m_noa', 'd_ps_l', 'd_ps_dp', 'd_ps_kl', 'd_ps_d', 'd_ps_m', 'd_ps_l_noa', 'd_ps_dp_noa', 'd_ps_kl_noa', 'd_ps_d_noa', 'd_ps_m_noa', 'osc_2bln_sebelumnya', 'noa_2bln_sebelumnya', 'npl_2bln_sebelumnya', 'rasio_2bln_sebelumnya', 'osc_1bln_sebelumnya', 'noa_1bln_sebelumnya', 'npl_1bln_sebelumnya', 'noa_npl_2bln_sebelumnya', 'rasio_npl_2bln_sebelumnya', 'rasio_1bln_sebelumnya', 'osc_bln_penilaian', 'noa_bln_penilaian', 'npl_bln_penilaian', 'rasio_bln_penilaian', 'aba', 'aba_tertinggi', 'aba_bank_umum', 'aba_bpr', 'noa_npl_1bln_sebelumnya', 'rasio_npl_1bln_sebelumnya', 'noa_npl_bln_penilaian', 'rasio_npl_bln_penilaian'];

    $p1 = [];
    foreach ($p1Fields as $f) { $p1[$f] = reqv($f); }

    $p2 = [];
    foreach ($p2Fields as $f) {
        if ($f === 'total_aset_produktif') {
            $p2[$f] = reqv('aset_produktif');
        } elseif ($f === 'kyd') {
            $p2[$f] = reqv('kyd');
        } elseif ($f === 'saldo_ckpn') {
            $p2[$f] = reqv('saldo_ckpn', reqv('saldo_ppap'));
        } else {
            $p2[$f] = reqv($f);
        }
    }

    $p3 = [];
    foreach ($p3Fields as $f) {
        if ($f === 'osc_bln_penilaian') {
            $p3[$f] = reqv('kyd');
        } elseif ($f === 'noa_bln_penilaian') {
            $p3[$f] = reqv('noa_kyd');
        } elseif ($f === 'npl_bln_penilaian') {
            $p3[$f] = reqv('aset_produktif_bermasalah');
        } elseif ($f === 'aba') {
            $p3[$f] = reqv('aba');
        } elseif ($f == 'noa_npl_bln_penilaian') {
            $p3[$f] = reqv('noa_kredit_bermasalah');
        } else {
            $p3[$f] = reqv($f);
        }
    }

    $osc_per_bln_penilaian = num_only($p3['osc_per_bln_penilaian']);
    $osc_akhir_tahun_lalu = num_only($p3['osc_akhir_tahun_lalu']);
    $pertumbuhan_rata2_bpr = num_only($p3['pertumbuhan_rata2_bpr']);
    $pertumbuhan_rata2_bpr_thn_lalu = num_only($p3['pertumbuhan_rata2_bpr_thn_lalu']);

    // Rasio pertumbuhan KYD sesuai rumus Excel:
    // (OSC akhir tahun lalu - OSC bulan penilaian) / OSC akhir tahun lalu * 100
    $p3['pertumbuhan_kyd_bpr'] = ($osc_akhir_tahun_lalu == 0) ? 0 : ((($osc_per_bln_penilaian - $osc_akhir_tahun_lalu) / $osc_akhir_tahun_lalu) * 100);
    $p3['rasio_pertumbuhan_rata2_bpr'] = ($pertumbuhan_rata2_bpr_thn_lalu == 0) ? 0 : ((($pertumbuhan_rata2_bpr - $pertumbuhan_rata2_bpr_thn_lalu) / $pertumbuhan_rata2_bpr_thn_lalu) * 100);

    $allSave = array_merge($p1, $p2, $p3, [
        'total_aset' => reqv('total_aset'),
        'modal_inti' => reqv('modal_inti')
    ]);
    save_autosave_fields($conn, $id, $allSave);

    ensure_master_kredit_row($conn, 'master_kredit_pilar1', $id);
    ensure_master_kredit_row($conn, 'master_kredit_pilar2', $id);
    ensure_master_kredit_row($conn, 'master_kredit_pilar3', $id);

    $set1 = [];
    foreach ($p1 as $k => $v) {
        $set1[] = "`$k`='" . mysqli_real_escape_string($conn, (string)$v) . "'";
    }
    @mysqli_query($conn, "UPDATE master_kredit_pilar1 SET " . implode(',', $set1) . " WHERE id_profil_risiko='".(int)$id."'");

    $set2 = [];
    foreach ($p2 as $k => $v) {
        $set2[] = "`$k`='" . mysqli_real_escape_string($conn, (string)$v) . "'";
    }
    @mysqli_query($conn, "UPDATE master_kredit_pilar2 SET " . implode(',', $set2) . " WHERE id_profil_risiko='".(int)$id."'");

    $set3 = [];
    foreach ($p3 as $k => $v) {
        $set3[] = "`$k`='" . mysqli_real_escape_string($conn, (string)$v) . "'";
    }
    @mysqli_query($conn, "UPDATE master_kredit_pilar3 SET " . implode(',', $set3) . " WHERE id_profil_risiko='".(int)$id."'");

    @mysqli_query($conn, "UPDATE frame_laporan_profil_risiko SET
        total_aset='" . mysqli_real_escape_string($conn, reqv('total_aset')) . "',
        modal_inti='" . mysqli_real_escape_string($conn, reqv('modal_inti')) . "'
        WHERE id_profil_risiko='".(int)$id."'");

    if ($is_autosave) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => true, 'id' => (int)$id]);
        exit();
    }

    header("Location: index.php?page=maskre&id=".(int)$id."&saved=1");
    exit();
}

?>

<script>
    function handleChange(value) {
        console.log(value)
    }
</script>






<script>
document.addEventListener('DOMContentLoaded', () => {

  function addOneToString(numStr) {
    let carry = 1;
    let res = '';
    for (let i = numStr.length - 1; i >= 0; i--) {
      const d = numStr.charCodeAt(i) - 48;
      if (d < 0 || d > 9) { res = '0' + res; continue; }
      const sum = d + carry;
      carry = sum >= 10 ? 1 : 0;
      res = String(sum % 10) + res;
    }
    if (carry) res = '1' + res;
    res = res.replace(/^0+(?=\d)/, '');
    return res || '0';
  }

  function formatWithDots(intStr, isNegative = false) {
    intStr = intStr.replace(/^0+(?=\d)/, '');
    if (!intStr) intStr = '0';
    const formatted = intStr.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    return isNegative ? '-' + formatted : formatted;
  }

  // ✅ Perbaikan utama ada di sini
  function normalizeAndSplit(val) {
    val = (val || '').toString().trim();
    if (!val) return { isNegative:false, intPart:'0', decPart:'' };

    const isNegative = val.startsWith('-');
    if (isNegative) val = val.slice(1);
    val = val.replace(/\s/g, '');
    val = val.replace(/[^0-9.,]/g, '');

    const dotCount = (val.match(/\./g) || []).length;
    const commaCount = (val.match(/,/g) || []).length;

    // ✅ Aturan baru: jika cuma satu titik dan di belakangnya 2 digit → desimal
    if (dotCount === 1 && commaCount === 0) {
      const [left, right] = val.split('.');
      if (/^\d{1,2}$/.test(right)) {
        // 2 digit di belakang titik -> desimal
        return { isNegative, intPart: left.replace(/[.,]/g, '') || '0', decPart: right };
      } else if (/^\d{3}$/.test(right)) {
        // 3 digit di belakang titik -> ribuan separator
        return { isNegative, intPart: val.replace(/[.,]/g, '') || '0', decPart: '' };
      }
    }

    // ✅ Sama untuk koma
    if (commaCount === 1 && dotCount === 0) {
      const [left, right] = val.split(',');
      if (/^\d{1,2}$/.test(right)) {
        return { isNegative, intPart: left.replace(/[.,]/g, '') || '0', decPart: right };
      } else if (/^\d{3}$/.test(right)) {
        return { isNegative, intPart: val.replace(/[.,]/g, '') || '0', decPart: '' };
      }
    }

    // Kasus campuran format internasional
    if (dotCount > 1 && commaCount === 1) {
      const [intRaw, decRaw] = val.split(',');
      return { isNegative, intPart: intRaw.replace(/[.,]/g, '') || '0', decPart: (decRaw||'').replace(/[.,]/g, '') };
    }

    if (commaCount > 1 && dotCount === 1) {
      const [intRaw, decRaw] = val.split('.');
      return { isNegative, intPart: intRaw.replace(/[.,]/g, '') || '0', decPart: (decRaw||'').replace(/[.,]/g, '') };
    }

    // default: hapus semua separator
    const cleanInt = val.replace(/[.,]/g, '') || '0';
    return { isNegative, intPart: cleanInt, decPart: '' };
  }

  function countDigitsBefore(raw, pos) {
    let count = 0;
    for (let i=0; i<pos && i<raw.length; i++) if (/\d/.test(raw[i])) count++;
    return count;
  }

  function findPosFromDigitCount(formatted, digitCount) {
    if (digitCount <= 0) return 0;
    let c = 0;
    for (let i=0;i<formatted.length;i++){
      if (/\d/.test(formatted[i])) {
        c++;
        if (c === digitCount) return i+1;
      }
    }
    return formatted.length;
  }

  function handleRealtime(e) {
    const input = e.target;
    const raw = input.value;
    const sel = input.selectionStart;

    const digitBefore = countDigitsBefore(raw, sel);
    const isNegative = raw.trim().startsWith('-');
    const cleanedDigits = raw.replace(/[^0-9]/g, '') || '0';
    const formatted = formatWithDots(cleanedDigits, isNegative);

    input.value = formatted;
    const newPos = findPosFromDigitCount(formatted, digitBefore);
    input.setSelectionRange(newPos, newPos);
  }

  function finalizeInput(input, sourceText = null) {
    const src = sourceText !== null ? sourceText : input.value;
    const { isNegative, intPart, decPart } = normalizeAndSplit(src);

    let finalInt = intPart.replace(/^0+(?=\d)/, '') || '0';
    if (decPart && decPart.length > 0) {
      if (decPart[0] >= '5') finalInt = addOneToString(finalInt);
    }

    input.value = formatWithDots(finalInt, isNegative);
    input.setSelectionRange(input.value.length, input.value.length);
  }

  function handlePaste(ev) {
    ev.preventDefault();
    const input = ev.target;
    const text = (ev.clipboardData || window.clipboardData).getData('text');
    finalizeInput(input, text);
  }

  document.querySelectorAll('.rupiah').forEach(input => {
    if (input.value) {
      const { isNegative, intPart, decPart } = normalizeAndSplit(input.value);
      if (decPart) {
        if (decPart[0] >= '5') input.value = formatWithDots(addOneToString(intPart), isNegative);
        else input.value = formatWithDots(intPart, isNegative);
      } else {
        input.value = formatWithDots(intPart, isNegative);
      }
    }

    input.addEventListener('input', handleRealtime);
    input.addEventListener('paste', handlePaste);
    input.addEventListener('blur', () => finalizeInput(input));
  });

  function sanitizeForm(form) {
    form.querySelectorAll('.rupiah').forEach(inp => {
      inp.value = inp.value.replace(/\./g, '').replace(/^(-?)0+(?=\d)/, '$1');
    });
    document.querySelectorAll(`.rupiah[form="${form.id}"]`).forEach(inp => {
      inp.value = inp.value.replace(/\./g, '').replace(/^(-?)0+(?=\d)/, '$1');
    });

    // Rasio tampil 14,04% di layar, tetapi dikirim sebagai 14.04 ke PHP/DB.
    form.querySelectorAll('.rasio-persen').forEach(inp => {
      if (window.normalizeRasioForSubmit) inp.value = window.normalizeRasioForSubmit(inp.value);
    });
    document.querySelectorAll(`.rasio-persen[form="${form.id}"]`).forEach(inp => {
      if (window.normalizeRasioForSubmit) inp.value = window.normalizeRasioForSubmit(inp.value);
    });
  }

  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', () => sanitizeForm(form));
  });

});
</script>




<script>
// ============================================================
// FORMAT INPUT RASIO / PERSEN
// Tampilan : 14,04%
// Nilai POST/autosave : 14.04
// ============================================================
(function () {
    function normalizeRasioRaw(value) {
        var v = (value == null ? '' : String(value)).trim();
        if (!v) return '';

        v = v.replace(/%/g, '').replace(/\s/g, '');
        v = v.replace(/[^0-9,\.\-]/g, '');

        var comma = v.lastIndexOf(',');
        var dot = v.lastIndexOf('.');

        if (comma !== -1 && dot !== -1) {
            // Separator paling kanan dianggap sebagai desimal.
            if (comma > dot) {
                v = v.replace(/\./g, '').replace(',', '.');
            } else {
                v = v.replace(/,/g, '');
            }
        } else if (comma !== -1) {
            v = v.replace(/,/g, '.');
        }

        var negative = v.charAt(0) === '-';
        v = v.replace(/-/g, '');

        var parts = v.split('.');
        var intPart = (parts.shift() || '0').replace(/^0+(?=\d)/, '');
        var decPart = parts.join('').replace(/\D/g, '');

        if (intPart === '') intPart = '0';
        return (negative ? '-' : '') + intPart + (decPart ? '.' + decPart : '');
    }

    window.normalizeRasioForSubmit = function (value) {
        return normalizeRasioRaw(value);
    };

    window.formatRasioForDisplay = function (value) {
        var normalized = normalizeRasioRaw(value);
        if (normalized === '') return '';
        return normalized.replace('.', ',') + '%';
    };

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.rasio-persen').forEach(function (input) {
            // Nilai dari DB 14.04 akan tampil sebagai 14,04%
            if (input.value !== '') {
                input.value = window.formatRasioForDisplay(input.value);
            }

            // Paste 14,04% / 14.04% -> tetap tampil 14,04%
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                var text = (e.clipboardData || window.clipboardData).getData('text');
                input.value = window.formatRasioForDisplay(text);
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            input.addEventListener('input', function () {
                // Titik yang diketik diubah ke koma pada tampilan.
                var v = input.value.replace(/\./g, ',');
                v = v.replace(/[^0-9,\-%]/g, '');

                var negative = v.charAt(0) === '-';
                v = v.replace(/-/g, '');

                var firstComma = v.indexOf(',');
                if (firstComma !== -1) {
                    v = v.substring(0, firstComma + 1) + v.substring(firstComma + 1).replace(/,/g, '');
                }

                // % ditambahkan kembali saat blur/paste agar mengetik tetap nyaman.
                v = v.replace(/%/g, '');
                input.value = (negative ? '-' : '') + v;
            });

            input.addEventListener('blur', function () {
                if (input.value.trim() !== '') {
                    input.value = window.formatRasioForDisplay(input.value);
                }
            });
        });
    });
})();
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var formId = 'my_form';
    var fields = Array.prototype.slice.call(document.querySelectorAll('[form="' + formId + '"]')).filter(function(el){
        if (!el.name) return false;
        if (el.disabled) return false;
        if (el.type === 'file') return false;
        if (el.name === 'submit' || el.name === '#' || el.name === '-') return false;
        return ['INPUT','SELECT','TEXTAREA'].indexOf(el.tagName) !== -1;
    });

    if (!fields.length) return;

    var timer = null;
    var saving = false;
    var dirty = false;

    function normalizeValue(el){
        var value = el.value || '';
        if (el.classList.contains('rupiah')) {
            value = value.replace(/\./g, '').replace(/^(-?)0+(?=\d)/, '$1');
        }
        if (el.classList.contains('rasio-persen') && window.normalizeRasioForSubmit) {
            value = window.normalizeRasioForSubmit(value);
        }
        return value;
    }

    function buildFormData(){
        var fd = new FormData();
        fd.append('autosave', '1');
        fields.forEach(function(el){
            fd.append(el.name, normalizeValue(el));
        });
        return fd;
    }

    function sendAutosave(useBeacon){
        if (!dirty && !useBeacon) return;

        if (useBeacon && navigator.sendBeacon) {
            try {
                navigator.sendBeacon(window.location.href, buildFormData());
                dirty = false;
                return;
            } catch (e) {}
        }

        if (saving) return;
        saving = true;

        fetch(window.location.href, {
            method: 'POST',
            body: buildFormData(),
            credentials: 'same-origin',
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
        .then(function(res){ return res.text(); })
        .then(function(){ dirty = false; })
        .catch(function(err){ console.error('Autosave error:', err); })
        .finally(function(){ saving = false; });
    }

    function triggerAutosave(){
        dirty = true;
        clearTimeout(timer);
        timer = setTimeout(function(){ sendAutosave(false); }, 600);
    }

    fields.forEach(function(el){
        el.addEventListener('input', triggerAutosave);
        el.addEventListener('change', function(){ dirty = true; clearTimeout(timer); sendAutosave(false); });
        el.addEventListener('blur', function(){ dirty = true; clearTimeout(timer); sendAutosave(false); });
    });

    window.addEventListener('beforeunload', function(){
        clearTimeout(timer);
        if (dirty) sendAutosave(true);
    });

    window.addEventListener('pagehide', function(){
        clearTimeout(timer);
        if (dirty) sendAutosave(true);
    });
});
</script>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Master Kredit</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Master Data Kredit Untuk Profil Risiko Kredit [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                            <p class="text-muted font-13">
                                Isilah Data keuangan dibawah ini
                            </p>
                            <hr>
                            </hr>
<div class="row">
                                <div class="col-12">
                                    <div class="col-sm-6">
                                    <form action="data_master/upload_kredit.php?id=<?= (int)$id ?>" method="POST" enctype="multipart/form-data">
                                    <label class="form-label">Upload File CSV</label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="file_csv" accept=".csv" required>
                                            <button class="btn btn-dark" type="submit" name="upload">Upload</button>
                                            <a class="btn btn-outline-primary" href="data_master/upload_kredit.php?template=1">Download Template CSV</a>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted font-40">
                                <b>*semua parameter harus terisi jika (tidak ada) isi saja angka 0 </br>
                                    * Dalam Mengisi Rasio bilangan decimal gunakan (.) contoh : penulisan 10,25 ditulis 10.25 (mohon untuk menginput angka saja bukan huruf)</b>
                            </p>
                            <!-- PILAR 1-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>PILAR 1 :KOMPOSISI PORTOFOLIO DAN TINGKAT KONSENTRASI KREDIT</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class="text-center">
                                                NOMINAL
                                            </th>
                                            <th class="text-center">
                                                NOA
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">ABA</th>
                                            <td>Rp. <input type="text"  form="my_form" name="aba" value="<?= $pil1['aba'] ?>" class="form-control rupiah" id="rupiah"></td>
                                            <td></td>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Produktif</th>
                                            <td>Rp. <input type="text"  form="my_form" name="aset_produktif" value="<?= $pil1['aset_produktif'] ?>" class="form-control rupiah" id="aset_produktif"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Aset</th>
                                            <td>Rp. <input type="text"  form="my_form" name="total_aset" value="<?= $pil1['total_aset'] ?>" class="form-control rupiah" id="total_aset"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Yang Diberikan (KYD)</th>
                                            <td>Rp. <input type="text"  form="my_form" name="kyd" value="<?= $pil1['kyd'] ?>" class="form-control rupiah" id="kyd"></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_kyd" value="<?= $pil1['noa_kyd'] ?>" class="form-control rupiah" id="noa_kyd"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">25 Debitur Inti
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="debitur_inti25" value="<?= $pil1['debitur_inti25'] ?>" class="form-control rupiah" id="debitur_inti25"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>6</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit 3 Sektor Ekonomi terbesar
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_3sektor_ekonomi_terbesar" value="<?= $pil1['kredit_3sektor_ekonomi_terbesar'] ?>" class="form-control rupiah" id="kredit_3sektor_ekonomi_terbesar"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>7</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Dengan Skema Potong Gaji (diluar KKPP)
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_spg" value="<?= $pil1['kredit_spg'] ?>" class="form-control rupiah" id="kredit_spg"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>8</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Dengan Pola Bayar Tanpa Angsuran
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_pbta" value="<?= $pil1['kredit_pbta'] ?>" class="form-control rupiah" id="kredit_pbta"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>9</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Jangka Pendek ( ≤ 36 bulan)
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_jpendek" value="<?= $pil1['kredit_jpendek'] ?>" class="form-control rupiah" id="kredit_jpendek"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>10</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Jangka Menengah (> 36 bulan sd ≤ 60 bulan)
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_jmenengah" value="<?= $pil1['kredit_jmenengah'] ?>" class="form-control rupiah" id="kredit_jmenengah"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>11</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Jangka Panjang > 60 bulan
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_jpanjang" value="<?= $pil1['kredit_jpanjang'] ?>" class="form-control rupiah" id="kredit_jpanjang"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>12</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Dengan Agunan Tanah dan Bangunan
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_agunan_tb" value="<?= $pil1['kredit_agunan_tb'] ?>" class="form-control rupiah" id="kredit_agunan_tb"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>13</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Agunan Kendaraan Bermotor
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_agunan_kb" value="<?= $pil1['kredit_agunan_kb'] ?>" class="form-control rupiah" id="kredit_agunan_kb"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>14</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Agunan Kendaraan Roda 2
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_agunan_kr2" value="<?= $pil1['kredit_agunan_kr2'] ?>" class="form-control rupiah" id="kredit_agunan_kr2"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>15</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Tanpa Agunan
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_ta" value="<?= $pil1['kredit_ta'] ?>" class="form-control rupiah" id="kredit_ta"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>16</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Produk KUB
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_kub" value="<?= $pil1['kredit_kub'] ?>" class="form-control rupiah" id="kredit_kub"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>17</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Korporasi
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_korporasi" value="<?= $pil1['kredit_korporasi'] ?>" class="form-control rupiah" id="kredit_korporasi"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>18</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit PEP
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_pep" value="<?= $pil1['kredit_pep'] ?>" class="form-control rupiah" id="kredit_pep"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>19</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit plafon > 350 jt
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_lebih350" value="<?= $pil1['kredit_lebih350'] ?>" class="form-control rupiah" id="kredit_lebih350"></td>
                                            <td></td>


                                        </tr>
                                        <tr>
                                            <th>
                                                <center>20</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Joglo Mitra
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_joglo_mitra" value="<?= $pil1['kredit_joglo_mitra'] ?>" class="form-control rupiah" id="kredit_joglo_mitra"></td>
                                            <td></td>


                                        </tr>


                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->































                            <hr>
                            </hr>

                            <br></br>




                            <!-- PILAR 2-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>PILAR 2 :KUALITAS ASET</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class="text-center">
                                                NOMINAL
                                            </th>
                                            <th class="text-center">
                                                NOA
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Produktif Bermasalah
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="aset_produktif_bermasalah" value="<?= $pil2['aset_produktif_bermasalah'] ?>" class="form-control rupiah" id="aset_produktif_bermasalah"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Aset Produktif (otomatis terinput)
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="#" value="<?= $pil2['total_aset_produktif'] ?>" class="form-control rupiah" id="#" disabled></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Bermasalah (NPL Gross)
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_bermasalah" value="<?= $pil2['kredit_bermasalah'] ?>" class="form-control rupiah" id="kredit_bermasalah"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NOA Kredit Bermasalah (NPL Gross)
                                            </th>
                                            <td></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_kredit_bermasalah" value="<?= $pil2['noa_kredit_bermasalah'] ?>" class="form-control rupiah" id="noa_kredit_bermasalah"></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Bermasalah Neto (NPL Net)
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_bermasalah_neto" value="<?= $pil2['kredit_bermasalah_neto'] ?>" class="form-control rupiah" id="kredit_bermasalah_neto"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>6</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Saldo CKPN
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="saldo_ckpn" value="<?= isset($pil2['saldo_ckpn']) ? $pil2['saldo_ckpn'] : (isset($pil2['saldo_ppap']) ? $pil2['saldo_ppap'] : '') ?>" class="form-control rupiah" id="saldo_ckpn"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>7</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">AYDA
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="ayda" value="<?= $pil2['ayda'] ?>" class="form-control rupiah" id="ayda"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>8</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Modal Inti
                                            </th>
                                            <td>Rp. <input type="text" form="my_form"  name="modal_inti" class="form-control rupiah" value="<?= $pil2['modal_inti'] ?>" id="modal_inti"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>9</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Macet melewati Jatuh Tempo Kredit
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="macet_jatuh_tempo" value="<?= $pil2['macet_jatuh_tempo'] ?>" class="form-control rupiah" id="macet_jatuh_tempo"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>10</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Yang Diberikan (KYD) (otomatis terinput)

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="-" class="form-control rupiah" value="<?= $pil2['kyd'] ?>" id="-" disabled></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>11</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Kualitas Rendah

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kkr" value="<?= $pil2['kkr'] ?>" class="form-control rupiah" id="kkr"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>12</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit PAR 4

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_par4" value="<?= $pil2['kredit_par4'] ?>" class="form-control rupiah" id="kredit_par4"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>13</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">OSC Bulan Sebelumnya

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="osc_bln_sebelumnya" value="<?= $pil2['osc_bln_sebelumnya'] ?>" class="form-control rupiah" id="osc_bln_sebelumnya"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>14</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">OSC 2 Bulan Sebelumnya

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="osc_2bln_sebelumnya" value="<?= $pil2['osc_2bln_sebelumnya'] ?>" class="form-control rupiah" id="osc_2bln_sebelumnya"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>15</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit DP (PAR 3 + PAR 4 )

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_dp" value="<?= $pil2['kredit_dp'] ?>" class="form-control rupiah" id="kredit_dp"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>16</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NOA FPD 6 Bulan Terakhir

                                            </th>
                                            <td></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_fpd_6bln" value="<?= $pil2['noa_fpd_6bln'] ?>" class="form-control rupiah" id="noa_fpd_6bln"></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>17</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NOA Ekspansi 6 Bulan Terakhir

                                            </th>
                                            <td></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_ekspansi_6bln" value="<?= $pil2['noa_ekspansi_6bln'] ?>" class="form-control rupiah" id="noa_ekspansi_6bln"></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>18</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Nominal FPD 6 Bulan Terakhir

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="nominal_fpd_6bln" value="<?= $pil2['nominal_fpd_6bln'] ?>" class="form-control rupiah" id="nominal_fpd_6bln"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>19</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Plafond Ekspansi 6 Bulan Terakhir

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="plafond_ekspansi_6bln" value="<?= $pil2['plafond_ekspansi_6bln'] ?>" class="form-control rupiah" id="plafond_ekspansi_6bln"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>20</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL Kredit plafon s/d 150 juta

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_kredit_sd150" value="<?= $pil2['npl_kredit_sd150'] ?>" class="form-control rupiah" id="npl_kredit_sd150"></td>
                                            <td></td>


                                        </tr>


                                        <tr>
                                            <th>
                                                <center>21</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total KYD Plafond s/d 150 jt

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kyd_plafon_sd150" value="<?= $pil2['kyd_plafon_sd150'] ?>" class="form-control rupiah" id="kyd_plafon_sd150"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>22</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NOA Kredit Plafond s/d 150jt

                                            </th>
                                            <td></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_kredit_sd150" value="<?= $pil2['noa_kredit_sd150'] ?>" class="form-control rupiah" id="noa_kredit_sd150"></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>23</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL Kredit plafon diatas 50 juta

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_kredit_diatas50" value="<?= $pil2['npl_kredit_diatas50'] ?>" class="form-control rupiah" id="npl_kredit_diatas50"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>24</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total KYD Plafond diatas 50 jt

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kyd_plafon_diatas50" value="<?= $pil2['kyd_plafon_diatas50'] ?>" class="form-control rupiah" id="kyd_plafon_diatas50"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>25</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL Kredit Dengan Perikatan APHT

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_apht" value="<?= $pil2['npl_apht'] ?>" class="form-control rupiah" id="npl_apht"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>26</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">KYD Kredit Dengan Perikatan APHT

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kyd_apht" value="<?= $pil2['kyd_apht'] ?>" class="form-control rupiah" id="kyd_apht"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>27</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL Kredit Dengan Perikatan SKMHT

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_skmht" value="<?= $pil2['npl_skmht'] ?>" class="form-control rupiah" id="npl_skmht"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>28</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">KYD Kredit Dengan Perikatan SKMHT

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kyd_skmht" value="<?= $pil2['kyd_skmht'] ?>" class="form-control rupiah" id="kyd_skmht"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>29</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit NPL Nilai Agunan Lebih Rendah dari Baki Debet

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_agunan_lrd_bakidebet" value="<?= $pil2['npl_agunan_lrd_bakidebet'] ?>" class="form-control rupiah" id="npl_agunan_lrd_bakidebet"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>30</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet

                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="kredit_agunan_lrd_bakidebet" value="<?= $pil2['kredit_agunan_lrd_bakidebet'] ?>" class="form-control rupiah" id=""></td>
                                            <td></td>


                                        </tr>


                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->




                            <hr>
                            </hr>

                            <br></br>



                            <!-- PILAR 3-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>PILAR 3 :STRATEGI PENYEDIAAN DANA</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class="text-center">
                                                NOMINAL
                                            </th>
                                            <th class="text-center">
                                                NOA & RASIO
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">OSC akhir tahun lalu</th>
                                            <td>Rp. <input type="text"  form="my_form" name="osc_akhir_tahun_lalu" value="<?= $pil3['osc_akhir_tahun_lalu'] ?>" class="form-control rupiah" id="osc_akhir_tahun_lalu"></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_osc_akhir_tahun_lalu" value="<?= $pil3['noa_osc_akhir_tahun_lalu'] ?>" class="form-control rupiah" id="noa_osc_akhir_tahun_lalu"></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL akhir tahun lalu</th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_akhir_tahun_lalu" value="<?= $pil3['npl_akhir_tahun_lalu'] ?>" class="form-control rupiah" id="npl_akhir_tahun_lalu"></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_npl_akhir_tahun_lalu" value="<?= $pil3['noa_npl_akhir_tahun_lalu'] ?>" class="form-control rupiah" id="noa_npl_akhir_tahun_lalu"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">OSC per bulan penilaian (sesuai data sekda)</th>
                                            <td>Rp. <input type="text"  form="my_form" name="osc_per_bln_penilaian" value="<?= $pil3['osc_per_bln_penilaian'] ?>" class="form-control rupiah" id="osc_per_bln_penilaian"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pertumbuhan Kyd<br></br>Rata rata Pertumbuhan kredit industri BPR tingkat kabupaten/Kota </br><a href="https://www.bi.go.id/id/statistik/ekonomi-keuangan/sekda/StatistikRegionalDetail.aspx?idprov=33" target="_blank"> https://www.bi.go.id/id/statistik/ekonomi-keuangan/sekda/StatistikRegionalDetail.aspx?idprov=33</a></th>
                                            <td>

                                            Pertumbuhan Bpr des tahun sebelumnya <input type="text" form="my_form" name="pertumbuhan_rata2_bpr_thn_lalu" value="<?= $pil3['pertumbuhan_rata2_bpr_thn_lalu'] ?>" class="form-control rupiah" id="pertumbuhan_rata2_bpr_thn_lalu">
                                            Pertumbuhan rata-rata Bpr <input type="text" form="my_form" name="pertumbuhan_rata2_bpr" value="<?= $pil3['pertumbuhan_rata2_bpr'] ?>" class="form-control rupiah" id="pertumbuhan_rata2_bpr">
                                            </td>
                                            <td>Rasio pertumbuhan kyd <input type="text" form="my_form" name="pertumbuhan_kyd_bpr" value="<?= $pil3['pertumbuhan_kyd_bpr'] ?>" class="form-control rasio-persen" id="pertumbuhan_kyd_bpr" disabled>
                                                Rasio pertumbuhan rata-rata Bpr <input type="text" form="my_form" name="rasio_pertumbuhan_rata2_bpr" value="<?= $pil3['rasio_pertumbuhan_rata2_bpr'] ?>" class="form-control rasio-persen" id="rasio_pertumbuhan_rata2_bpr" disabled></td>

                                        </tr>

                                        <tr>
                                            <td>
                                                <center>5</center>
                                            </td>
                                            <td class="text-nowrap" scope="row">Pertumbuhan Sektor Ekonomi yang tidak dikuasai
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>

                                            </td>
                                            <td class="text-nowrap" scope="row"><b>5.1 Periode Penilaian</b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">L
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_pp_l" value="<?= $pil3['td_pp_l'] ?>" class="form-control rupiah" id="td_pp_l"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_pp_l_noa" value="<?= $pil3['td_pp_l_noa'] ?>" class="form-control rupiah" id="td_pp_l_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">DP
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_pp_dp" value="<?= $pil3['td_pp_dp'] ?>" class="form-control rupiah" id="td_pp_dp"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_pp_dp_noa" value="<?= $pil3['td_pp_dp_noa'] ?>" class="form-control rupiah" id="td_pp_dp_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">KL
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_pp_kl" value="<?= $pil3['td_pp_kl'] ?>" class="form-control rupiah" id="td_pp_kl"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_pp_kl_noa" value="<?= $pil3['td_pp_kl_noa'] ?>" class="form-control rupiah" id="td_pp_kl_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">D
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_pp_d" value="<?= $pil3['td_pp_d'] ?>" class="form-control rupiah" id="td_pp_d"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_pp_d_noa" value="<?= $pil3['td_pp_d_noa'] ?>" class="form-control rupiah" id="td_pp_d_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">M
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_pp_m" value="<?= $pil3['td_pp_m'] ?>" class="form-control rupiah" id="td_pp_m"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_pp_m_noa" value="<?= $pil3['td_pp_m_noa'] ?>" class="form-control rupiah" id="td_pp_m_noa"></td>

                                        </tr>


                                        <tr>
                                            <td>

                                            </td>
                                            <td class="text-nowrap" scope="row"><b>5.2 Periode Sebelumnya</b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">L
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_ps_l" value="<?= $pil3['td_ps_l'] ?>" class="form-control rupiah" id="td_ps_l"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_ps_l_noa" value="<?= $pil3['td_ps_l_noa'] ?>" class="form-control rupiah" id="td_ps_l_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">DP
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_ps_dp" value="<?= $pil3['td_ps_dp'] ?>" class="form-control rupiah" id="td_ps_dp"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_ps_dp_noa" value="<?= $pil3['td_ps_dp_noa'] ?>" class="form-control rupiah" id="td_ps_dp_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">KL
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_ps_kl" value="<?= $pil3['td_ps_kl'] ?>" class="form-control rupiah" id="td_ps_kl"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_ps_kl_noa" value="<?= $pil3['td_ps_kl_noa'] ?>" class="form-control rupiah" id="td_ps_kl_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">D
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_ps_d" value="<?= $pil3['td_ps_d'] ?>" class="form-control rupiah" id="td_ps_d"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_ps_d_noa" value="<?= $pil3['td_ps_d_noa'] ?>" class="form-control rupiah" id="td_ps_d_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">M
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="td_ps_m" value="<?= $pil3['td_ps_m'] ?>" class="form-control rupiah" id="td_ps_m"></td>
                                            <td>Noa <input type="text"  form="my_form" name="td_ps_m_noa" value="<?= $pil3['td_ps_m_noa'] ?>" class="form-control rupiah" id="td_ps_m_noa"></td>

                                        </tr>




                                        <tr>
                                            <td>
                                                <center>6</center>
                                            </td>
                                            <td class="text-nowrap" scope="row">Pertumbuhan Sektor Ekonomi yang dikuasai
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>

                                            </td>
                                            <td class="text-nowrap" scope="row"><b>6.1 Periode Penilaian</b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">L
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_pp_l" value="<?= $pil3['d_pp_l'] ?>" class="form-control rupiah" id="d_pp_l"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_pp_l_noa" value="<?= $pil3['d_pp_l_noa'] ?>" class="form-control rupiah" id="d_pp_l_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">DP
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_pp_dp" value="<?= $pil3['d_pp_dp'] ?>" class="form-control rupiah" id="d_pp_dp"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_pp_dp_noa" value="<?= $pil3['d_pp_dp_noa'] ?>" class="form-control rupiah" id="d_pp_dp_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">KL
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_pp_kl" value="<?= $pil3['d_pp_kl'] ?>" class="form-control rupiah" id="d_pp_kl"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_pp_kl_noa" value="<?= $pil3['d_pp_kl_noa'] ?>" class="form-control rupiah" id="d_pp_kl_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">D
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_pp_d" value="<?= $pil3['d_pp_d'] ?>" class="form-control rupiah" id="d_pp_d"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_pp_d_noa" value="<?= $pil3['d_pp_d_noa'] ?>" class="form-control rupiah" id="d_pp_d_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">M
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_pp_m" value="<?= $pil3['d_pp_m'] ?>" class="form-control rupiah" id="d_pp_m"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_pp_m_noa" value="<?= $pil3['d_pp_m_noa'] ?>" class="form-control rupiah" id="d_pp_m_noa"></td>

                                        </tr>


                                        <tr>
                                            <td>

                                            </td>
                                            <td class="text-nowrap" scope="row"><b>6.2 Periode Sebelumnya</b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">L
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_ps_l" value="<?= $pil3['d_ps_l'] ?>" class="form-control rupiah" id="d_ps_l"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_ps_l_noa" value="<?= $pil3['d_ps_l_noa'] ?>" class="form-control rupiah" id="d_ps_l_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">DP
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_ps_dp" value="<?= $pil3['d_ps_dp'] ?>" class="form-control rupiah" id="d_ps_dp"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_ps_dp_noa" value="<?= $pil3['d_ps_dp_noa'] ?>" class="form-control rupiah" id="d_ps_dp_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">KL
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_ps_kl" value="<?= $pil3['d_ps_kl'] ?>" class="form-control rupiah" id="d_ps_kl"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_ps_kl_noa" value="<?= $pil3['d_ps_kl_noa'] ?>" class="form-control rupiah" id="d_ps_kl_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">D
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_ps_d" value="<?= $pil3['d_ps_d'] ?>" class="form-control rupiah" id="d_ps_d"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_ps_d_noa" value="<?= $pil3['d_ps_d_noa'] ?>" class="form-control rupiah" id="d_ps_d_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">M
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="d_ps_m" value="<?= $pil3['d_ps_m'] ?>" class="form-control rupiah" id="d_ps_m"></td>
                                            <td>Noa <input type="text"  form="my_form" name="d_ps_m_noa" value="<?= $pil3['d_ps_m_noa'] ?>" class="form-control rupiah" id="d_ps_m_noa"></td>

                                        </tr>




                                        <tr>
                                            <td>
                                                <center>7</center>
                                            </td>
                                            <td class="text-nowrap" scope="row">Pertumbuhan OSC dan NPL
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">OSC 2 bulan sebelumnya
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="osc_2bln_sebelumnya" value="<?= $pil3['osc_2bln_sebelumnya'] ?>" class="form-control rupiah" id="osc_2bln_sebelumnya"></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_2bln_sebelumnya" value="<?= $pil3['noa_2bln_sebelumnya'] ?>" class="form-control rupiah" id="noa_2bln_sebelumnya">
                                                Rasio <input type="text" form="my_form" name="rasio_2bln_sebelumnya" value="<?= $pil3['rasio_2bln_sebelumnya'] ?>" class="form-control rasio-persen" id="rasio_2bln_sebelumnya"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">OSC 1 bulan sebelumnya
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="osc_1bln_sebelumnya" value="<?= $pil3['osc_1bln_sebelumnya'] ?>" class="form-control rupiah" id="osc_1bln_sebelumnya"></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_1bln_sebelumnya" value="<?= $pil3['noa_1bln_sebelumnya'] ?>" class="form-control rupiah" id="noa_1bln_sebelumnya">
                                                Rasio <input type="text" form="my_form" name="rasio_1bln_sebelumnya" value="<?= $pil3['rasio_1bln_sebelumnya'] ?>" class="form-control rasio-persen" id="rasio_1bln_sebelumnya"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">OSC periode penilaian (nominatif & noa otomatis terisi)
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="osc_bln_penilaian" value="<?= $pil3['osc_bln_penilaian'] ?>" class="form-control rupiah" id="osc_bln_penilaian" disabled></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_bln_penilaian" value="<?= $pil3['noa_bln_penilaian'] ?>" class="form-control rupiah" id="noa_bln_penilaian" disabled>
                                                Rasio <input type="text" form="my_form" name="rasio_bln_penilaian" value="<?= $pil3['rasio_bln_penilaian'] ?>" class="form-control rasio-persen" id="rasio_bln_penilaian"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">NPL 2 bulan sebelumnya
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_2bln_sebelumnya" value="<?= $pil3['npl_2bln_sebelumnya'] ?>" class="form-control rupiah" id="npl_2bln_sebelumnya"></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_npl_2bln_sebelumnya" value="<?= $pil3['noa_npl_2bln_sebelumnya'] ?>" class="form-control rupiah" id="noa_npl_2bln_sebelumnya">
                                                Rasio <input type="text" form="my_form" name="rasio_npl_2bln_sebelumnya" value="<?= $pil3['rasio_npl_2bln_sebelumnya'] ?>" class="form-control rasio-persen" id="rasio_npl_2bln_sebelumnya"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">NPL 1 bulan sebelumnya
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_1bln_sebelumnya" value="<?= $pil3['npl_1bln_sebelumnya'] ?>" class="form-control rupiah" id="npl_1bln_sebelumnya"></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_npl_1bln_sebelumnya" value="<?= $pil3['noa_npl_1bln_sebelumnya'] ?>" class="form-control rupiah" id="noa_npl_1bln_sebelumnya">
                                                Rasio <input type="text" form="my_form" name="rasio_npl_1bln_sebelumnya" value="<?= $pil3['rasio_npl_1bln_sebelumnya'] ?>" class="form-control rasio-persen" id="rasio_npl_1bln_sebelumnya"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">NPL Periode Penilaian (nominatif & noa otomatis terisi)
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="npl_bln_penilaian" value="<?= $pil3['npl_bln_penilaian'] ?>" class="form-control rupiah" id="npl_bln_penilaian" disabled></td>
                                            <td>Noa <input type="text"  form="my_form" name="noa_npl_bln_penilaian" value="<?= $pil3['noa_npl_bln_penilaian'] ?>" class="form-control rupiah" id="noa_npl_bln_penilaian" disabled>
                                                Rasio <input type="text" form="my_form" name="rasio_npl_bln_penilaian" value="<?= $pil3['rasio_npl_bln_penilaian'] ?>" class="form-control rasio-persen" id="rasio_npl_bln_penilaian"></td>

                                        </tr>










                                        <tr>
                                            <td>
                                                <center>8</center>
                                            </td>
                                            <td class="text-nowrap" scope="row">Penempatan ABA
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">Total ABA
                                            </th>
                                            <td>Rp. <input type="text"  name="aba" value="<?= $pil3['aba'] ?>" class="form-control rupiah" id="aba" disabled></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">ABA Pada satu bank tertinggi
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="aba_tertinggi" value="<?= $pil3['aba_tertinggi'] ?>" class="form-control rupiah" id="aba_tertinggi"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">ABA pada bank umum
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="aba_bank_umum" value="<?= $pil3['aba_bank_umum'] ?>" class="form-control rupiah" id="aba_bank_umum"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">ABA pada BPR
                                            </th>
                                            <td>Rp. <input type="text"  form="my_form" name="aba_bpr" value="<?= $pil3['aba_bpr'] ?>" class="form-control rupiah" id="aba_bpr"></td>
                                            <td></td>
                                        </tr>








                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->




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
