<?php include "../verif_folder.php"; ?>
<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$displayModal = empty($id);
$masterUploadType = 'likuiditas';
include __DIR__ . '/upload_result_modal.php';
?>
<style>
#notifModalMasterLik .modal-dialog{
    max-width:620px;
    width:92%;
    margin:1.75rem auto;
}
#notifModalMasterLik .modal-content{
    border:0;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 20px 45px rgba(0,0,0,.25);
}
#notifModalMasterLik .modal-header{
    padding:14px 18px;
    border-bottom:1px solid #e9ecef;
}
#notifModalMasterLik .modal-title{
    font-size:18px;
    font-weight:700;
    color:#3d4b5d;
}
#notifModalMasterLik .notif-close-x{
    border:0;
    background:transparent;
    font-size:32px;
    line-height:1;
    color:#7d8793;
    padding:0;
    margin-left:auto;
    cursor:pointer;
}
#notifModalMasterLik .modal-body{
    padding:24px 28px 20px;
}
#notifModalMasterLik .notif-message{
    margin:0;
    text-align:center;
    font-size:19px;
    line-height:1.55;
    font-weight:700;
    color:#3d4b5d;
}
#notifModalMasterLik .modal-footer{
    padding:14px 18px;
    border-top:1px solid #e9ecef;
}
#notifModalMasterLik .notif-btn-close{
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
#notifModalMasterLik .notif-btn-close:hover,
#notifModalMasterLik .notif-btn-close:focus{
    color:#fff;
    background:#f34b6b;
    text-decoration:none;
}
</style>

<script>
function goBackNotifMasterLik(){
    if (document.referrer && document.referrer !== window.location.href) {
        window.location.href = document.referrer;
        return false;
    }
    history.back();
    return false;
}
$(document).ready(function() {
    <?php if ($displayModal) { ?>
      $('#notifModalMasterLik').modal('show');
    <?php } ?>
    $('#notifModalMasterLik').on('hide.bs.modal', function () {
        if (<?php echo $displayModal ? 'true' : 'false'; ?>) {
            goBackNotifMasterLik();
        }
    });
});
window.onclick = null;
</script>

<div class="modal fade" id="notifModalMasterLik" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Notifikasi</h5>
        <button type="button" class="notif-close-x" aria-label="Close" onclick="return goBackNotifMasterLik()">&times;</button>
      </div>
      <div class="modal-body">
        <p class="notif-message">Mohon untuk memilih laporan risiko di menu dashboard -> laporan profil risiko -> klik (aktif) terlebih dahulu.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="notif-btn-close" onclick="return goBackNotifMasterLik()">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang WHERE id_profil_risiko = ?", [$id]));
$jenis_pr = $frame['user'];
$tahun = $frame['tahun'];
$periode = $frame['periode'];
$dp = $frame['data_pembanding'];

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_likuiditas_pilar1 WHERE id_profil_risiko = ?", [$id]));
if (isset($_POST['submit']) || (isset($_POST['autosave']) && $_POST['autosave'] === '1')) {
    $is_autosave = (isset($_POST['autosave']) && $_POST['autosave'] === '1');
    require dirname(__DIR__, 2).'/conn/conn.php';

    $num = function($key){
        $v = isset($_POST[$key]) ? (string)$_POST[$key] : '0';
        $v = str_replace('.', '', $v);
        $v = str_replace(',', '.', $v);
        $v = preg_replace('/[^0-9\-]/', '', $v);
        if ($v === '' || $v === '-') $v = '0';
        return (float)$v;
    };

    $fmt = function($value){
        $value = (float)$value;
        if (abs($value - round($value)) < 0.00001) {
            return (string)(int)round($value);
        }
        return number_format($value, 2, '.', '');
    };

    // pilar 1 input
    $kas = $num('kas');
    $giro_aba = $num('giro_aba');
    $tabungan_aba = $num('tabungan_aba');
    $total_aset = $num('total_aset');
    $kewajiban_segera = $num('kewajiban_segera');
    $tabungan = $num('tabungan');
    $deposito = $num('deposito');
    $deposito_1bln = $num('deposito_1bln');
    $deposito_3bln = $num('deposito_3bln');
    $deposito_6bln = $num('deposito_6bln');
    $deposito_12bln = $num('deposito_12bln');
    $dpk_lbh_2m = $num('dpk_lbh_2m');
    $deposito_diatas_cr = $num('deposito_diatas_cr');
    $deposito_diatas_lps = $num('deposito_diatas_lps');
    $korporasi = $num('korporasi');
    $dpk_des_thn_sebelum = $num('dpk_des_thn_sebelum');
    $penempatan_pd_bank_lain = $num('penempatan_pd_bank_lain');
    $modal_disetor = $num('modal_disetor');
    $kredit_des_thn_sebelum = $num('kredit_des_thn_sebelum');
    $pinjaman = $num('pinjaman');
    $kredit_kolek_lancar = $num('kredit_kolek_lancar');
    $pertumbuhan_kredit = $num('pertumbuhan_kredit');
    $simpanan_tdk_dijamin_lps = $num('simpanan_tdk_dijamin_lps');
    $besar_deposan25 = $num('besar_deposan25');
    $besar_penabung25 = $num('besar_penabung25');
    $deposito_rs = $num('deposito_rs');
    $kas_besar_debet = $num('kas_besar_debet');
    $kas_besar_kredit = $num('kas_besar_kredit');
    $deposito_inti = $num('deposito_inti');
    $sisa_jangka_waktu_deposito = $num('sisa_jangka_waktu_deposito');
    $kredit_l_dp = $num('kredit_l_dp');
    $deposan_tabungan_terbesar25 = $num('deposan_tabungan_terbesar25');

    // hitung otomatis
    $aset_likuid = $kas + $giro_aba + $tabungan_aba;
    $kewajiban_lancar = $kewajiban_segera + $tabungan + $deposito;
    $pendanaan_jangka_pendek = $tabungan + $deposito_1bln + $deposito_3bln;
    $kewajiban_jangka_pendek = $kewajiban_segera + $tabungan + $deposito_1bln + $deposito_3bln;
    $pendanaan_non_inti = $simpanan_tdk_dijamin_lps + $deposito_diatas_cr + $deposito_diatas_lps + $korporasi;
    $alat_likuid = $kas + $penempatan_pd_bank_lain;
    $total_dpk = $tabungan + $deposito;
    $dpk_dijamin_lps = ($tabungan + $deposito) - $simpanan_tdk_dijamin_lps;
    $dpk_tdk_dijamin_lps = $total_dpk - $dpk_dijamin_lps;
    $arus_kas_netto = $kas - $kas_besar_debet;

    $data = [
        'id_profil_risiko' => (int)$id,
        'aset_likuid' => $fmt($aset_likuid),
        'kas' => $fmt($kas),
        'giro_aba' => $fmt($giro_aba),
        'tabungan_aba' => $fmt($tabungan_aba),
        'total_aset' => $fmt($total_aset),
        'kewajiban_lancar' => $fmt($kewajiban_lancar),
        'kewajiban_segera' => $fmt($kewajiban_segera),
        'tabungan' => $fmt($tabungan),
        'deposito' => $fmt($deposito),
        'pendanaan_jangka_pendek' => $fmt($pendanaan_jangka_pendek),
        'kewajiban_jangka_pendek' => $fmt($kewajiban_jangka_pendek),
        'deposito_1bln' => $fmt($deposito_1bln),
        'deposito_3bln' => $fmt($deposito_3bln),
        'deposito_6bln' => $fmt($deposito_6bln),
        'deposito_12bln' => $fmt($deposito_12bln),
        'pendanaan_non_inti' => $fmt($pendanaan_non_inti),
        'dpk_lbh_2m' => $fmt($dpk_lbh_2m),
        'deposito_diatas_cr' => $fmt($deposito_diatas_cr),
        'deposito_diatas_lps' => $fmt($deposito_diatas_lps),
        'korporasi' => $fmt($korporasi),
        'dpk_des_thn_sebelum' => $fmt($dpk_des_thn_sebelum),
        'alat_likuid' => $fmt($alat_likuid),
        'penempatan_pd_bank_lain' => $fmt($penempatan_pd_bank_lain),
        'modal_disetor' => $fmt($modal_disetor),
        'kredit_des_thn_sebelum' => $fmt($kredit_des_thn_sebelum),
        'pinjaman' => $fmt($pinjaman),
        'kredit_kolek_lancar' => $fmt($kredit_kolek_lancar),
        'pertumbuhan_kredit' => $fmt($pertumbuhan_kredit),
        'dpk_dijamin_lps' => $fmt($dpk_dijamin_lps),
        'simpanan_tdk_dijamin_lps' => $fmt($simpanan_tdk_dijamin_lps),
        'total_dpk' => $fmt($total_dpk),
        'dpk_tdk_dijamin_lps' => $fmt($dpk_tdk_dijamin_lps),
        'deposan_tabungan_terbesar25' => $fmt($deposan_tabungan_terbesar25),
        'besar_deposan25' => $fmt($besar_deposan25),
        'besar_penabung25' => $fmt($besar_penabung25),
        'deposito_rs' => $fmt($deposito_diatas_cr),
        'arus_kas_netto' => $fmt($arus_kas_netto),
        'kas_besar_debet' => $fmt($kas_besar_debet),
        'kas_besar_kredit' => $fmt($kas_besar_kredit),
        'deposito_inti' => $fmt($deposito_inti),
        'sisa_jangka_waktu_deposito' => $fmt($sisa_jangka_waktu_deposito),
        'kredit_l_dp' => $fmt($kredit_l_dp),
    ];

    // backup autosave berbasis id laporan
    if (mysqli_query($conn, "SHOW TABLES LIKE 'master_likuiditas_autosave'") && mysqli_num_rows(mysqli_query($conn, "SHOW TABLES LIKE 'master_likuiditas_autosave'")) > 0) {
        $payload = mysqli_real_escape_string($conn, json_encode($data));
        mysqli_query($conn, "INSERT INTO master_likuiditas_autosave (id_profil_risiko, payload_json, updated_at)
                             VALUES ('".(int)$id."', '$payload', NOW())
                             ON DUPLICATE KEY UPDATE payload_json='$payload', updated_at=NOW()");
    }

    $cek = mysqli_query($conn, "SELECT id_profil_risiko FROM master_likuiditas_pilar1 WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    $setParts = [];
    foreach ($data as $kolom => $nilai) {
        if ($kolom === 'id_profil_risiko') continue;
        $setParts[] = $kolom."='".mysqli_real_escape_string($conn, (string)$nilai)."'";
    }
    $sqlSet = implode(",
    ", $setParts);

    if ($cek && mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE master_likuiditas_pilar1 SET 
    $sqlSet
    WHERE id_profil_risiko='".(int)$id."'");
    } else {
        $cols = [];
        $vals = [];
        foreach ($data as $kolom => $nilai) {
            $cols[] = $kolom;
            $vals[] = "'".mysqli_real_escape_string($conn, (string)$nilai)."'";
        }
        mysqli_query($conn, "INSERT INTO master_likuiditas_pilar1 (".implode(',', $cols).") VALUES (".implode(',', $vals).")");
    }

    if ($is_autosave) {
        if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => true, 'id_profil_risiko' => (int)$id]);
        exit();
    }

    header("Location: index.php?page=maslik&id=$id");
    exit();
}
?>


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
  }

  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', () => sanitizeForm(form));
  });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const elems = Array.from(document.querySelectorAll('[form="my_form"]')).filter(function(el){
        if (!el.name) return false;
        if (el.disabled) return false;
        if (el.type === 'submit' || el.type === 'button' || el.type === 'file') return false;
        return ['INPUT','SELECT','TEXTAREA'].includes(el.tagName);
    });

    if (!elems.length) return;

    let timer = null;
    let isSaving = false;

    function serializeData() {
        const map = {};
        elems.forEach(function(el){
            let value = el.value || '';
            if (el.classList.contains('rupiah')) {
                value = value.replace(/\./g, '');
            }
            map[el.name] = value;
        });

        const body = new URLSearchParams();
        body.append('autosave', '1');
        Object.keys(map).forEach(function(key){
            body.append(key, map[key]);
        });
        return body;
    }

    function doAutosave(force) {
        if (isSaving && !force) return;
        isSaving = true;

        const body = serializeData();
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: body.toString()
        }).then(function(res){
            return res.text();
        }).then(function(txt){
            try { JSON.parse(txt); } catch (e) {}
        }).catch(function(err){
            console.error('Autosave likuiditas error:', err);
        }).finally(function(){
            isSaving = false;
        });
    }

    function debounceSave() {
        clearTimeout(timer);
        timer = setTimeout(function(){ doAutosave(false); }, 700);
    }

    elems.forEach(function(el){
        el.addEventListener('input', debounceSave);
        el.addEventListener('change', function(){ doAutosave(true); });
        el.addEventListener('blur', function(){ doAutosave(true); });
        el.addEventListener('paste', function(){
            clearTimeout(timer);
            timer = setTimeout(function(){ doAutosave(true); }, 800);
        });
    });

    window.addEventListener('beforeunload', function(){
        clearTimeout(timer);
        const body = serializeData();
        if (navigator.sendBeacon) {
            navigator.sendBeacon(window.location.href, body);
        }
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

                        <h4 class="page-title">Master Likuiditas</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Master Data Likuiditas Untuk Profil Risiko Kredit [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                            <p class="text-muted font-13">
                                Isilah Data keuangan dibawah ini
                            </p>
                            <hr>
                            </hr>
<div class="row">
                                <div class="col-12">
                                    <div class="col-sm-6">
                                    <form action="data_master/upload_likuiditas.php?id=<?= (int)$id ?>" method="POST" enctype="multipart/form-data">
                                    <label class="form-label">Upload File CSV</label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="file_csv" accept=".csv" required>
                                            <button class="btn btn-dark" type="submit" name="upload">Upload</button>
                                            <a class="btn btn-outline-primary" href="data_master/upload_likuiditas.php?template=1">Download Template CSV</a>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>


                            <p class="text-muted font-13">
                                *semua parameter harus terisi jika (tidak ada) isi saja angka 0
                            </p>

                            <!-- PILAR 1-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>PILAR 1 :KOMPOSISI DAN KONSENTRASI ASET DAN KEWAJIBAN</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th colspan="2">
                                                NOMINAL
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Likuid</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="aset_likuid" value="<?= $pil1['aset_likuid'] ?>" class="form-control rupiah" id="aset_likuid" readonly></td>
                                            <td>KAS Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kas" value="<?= $pil1['kas'] ?>" class="form-control rupiah" id="kas">
                                                Giro ABA Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="giro_aba" value="<?= $pil1['giro_aba'] ?>" class="form-control rupiah" id="giro_aba">
                                                Tabungan ABA Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="tabungan_aba" value="<?= $pil1['tabungan_aba'] ?>" class="form-control rupiah" id="tabungan_aba">
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Aset</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="total_aset" value="<?= $pil1['total_aset'] ?>" class="form-control rupiah" id="total_aset"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kewajiban Lancar</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kewajiban_lancar" value="<?= $pil1['kewajiban_lancar'] ?>" class="form-control rupiah" id="kewajiban_lancar" readonly></td>
                                            <td>
                                                Kewajiban-kewajiban yang segera Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kewajiban_segera" value="<?= $pil1['kewajiban_segera'] ?>" class="form-control rupiah" id="kewajiban_segera">
                                                Tabungan Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="tabungan" value="<?= $pil1['tabungan'] ?>" class="form-control rupiah" id="tabungan">
                                                Deposito Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito" value="<?= $pil1['deposito'] ?>" class="form-control rupiah" id="deposito">
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pendanaan Jangka Pendek</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="pendanaan_jangka_pendek" value="<?= $pil1['pendanaan_jangka_pendek'] ?>" class="form-control rupiah" id="pendanaan_jangka_pendek" readonly></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kewajiban Jangka Pendek</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kewajiban_jangka_pendek" value="<?= $pil1['kewajiban_jangka_pendek'] ?>" class="form-control rupiah" id="kewajiban_jangka_pendek" readonly></td>
                                            <td>
                                                Kewajiban-kewajiban yang segera Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kewajiban_segera" value="<?= $pil1['kewajiban_segera'] ?>" class="form-control rupiah" id="kewajiban_segera" disabled>
                                                Tabungan Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="tabungan" value="<?= $pil1['tabungan'] ?>" class="form-control rupiah" id="tabungan" disabled>
                                                Deposito 1 Bln Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_1bln" value="<?= $pil1['deposito_1bln'] ?>" class="form-control rupiah" id="deposito_1bln">
                                                Deposito 3 Bln Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_3bln" value="<?= $pil1['deposito_3bln'] ?>" class="form-control rupiah" id="deposito_3bln">
                                                Deposito 6 Bln Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_6bln" value="<?= $pil1['deposito_6bln'] ?>" class="form-control rupiah" id="deposito_6bln">
                                                Deposito 12 Bln Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_12bln" value="<?= $pil1['deposito_12bln'] ?>" class="form-control rupiah" id="deposito_12bln">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pendanaan Non Inti
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="pendanaan_non_inti" value="<?= $pil1['pendanaan_non_inti'] ?>" class="form-control rupiah" id="pendanaan_non_inti" readonly></td>
                                            <td>
                                                Simpanan tidak dijamin LPS Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="simpanan_tdk_dijamin_lps" value="<?= $pil1['simpanan_tdk_dijamin_lps'] ?>" class="form-control rupiah" id="simpanan_tdk_dijamin_lps">
                                                Deposito rate diatas counter rate Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_diatas_cr" value="<?= $pil1['deposito_diatas_cr'] ?>" class="form-control rupiah" id="deposito_diatas_cr">
                                                Deposito rate diatas LPS Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_diatas_lps" value="<?= $pil1['deposito_diatas_lps'] ?>" class="form-control rupiah" id="deposito_diatas_lps">
                                                Korporasi Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="korporasi" value="<?= $pil1['korporasi'] ?>" class="form-control rupiah" id="korporasi">
                                                DPK periode sebelumnya Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="dpk_des_thn_sebelum" value="<?= $pil1['dpk_des_thn_sebelum'] ?>" class="form-control rupiah" id="dpk_des_thn_sebelum">

                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>6</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Alat Likuid
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="alat_likuid" value="<?= $pil1['alat_likuid'] ?>" class="form-control rupiah" id="alat_likuid" readonly></td>
                                            <td>
                                                Kas Rp.<input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kas" value="<?= $pil1['kas'] ?>" class="form-control rupiah" id="kas" disabled>
                                                Penempatan pada bank lain Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="penempatan_pd_bank_lain" value="<?= $pil1['penempatan_pd_bank_lain'] ?>" class="form-control rupiah" id="penempatan_pd_bank_lain">
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>7</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Modal Disetor
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="modal_disetor" value="<?= $pil1['modal_disetor'] ?>" class="form-control rupiah" id="modal_disetor"></td>
                                            <td>
                                                Kredit periode sebelumnya Rp.<input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kredit_des_thn_sebelum" value="<?= $pil1['kredit_des_thn_sebelum'] ?>" class="form-control rupiah" id="kredit_des_thn_sebelum">
                                                Pinjaman Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="pinjaman" value="<?= $pil1['pinjaman'] ?>" class="form-control rupiah" id="pinjaman">
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Kolek Lancar
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kredit_kolek_lancar" value="<?= $pil1['kredit_kolek_lancar'] ?>" class="form-control rupiah" id="kredit_kolek_lancar"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pertumbuhan Kredit
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="pertumbuhan_kredit" value="<?= $pil1['pertumbuhan_kredit'] ?>" class="form-control rupiah" id="pertumbuhan_kredit"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>8</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">DPK Yang Dijamin LPS
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="dpk_dijamin_lps" value="<?= $pil1['dpk_dijamin_lps'] ?>" class="form-control rupiah" id="dpk_dijamin_lps" disabled></td>
                                            <td>
                                                Deposito Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito" value="<?= $pil1['deposito'] ?>" class="form-control rupiah" id="deposito" disabled>
                                                Tabungan Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="tabungan" value="<?= $pil1['tabungan'] ?>" class="form-control rupiah" id="tabungan" disabled>
                                                Simpanan tidak dijamin LPS Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="simpanan_tdk_dijamin_lps" value="<?= $pil1['simpanan_tdk_dijamin_lps'] ?>" class="form-control rupiah" id="simpanan_tdk_dijamin_lps" disabled>
                                                Total DPK Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="total_dpk" value="<?= $pil1['total_dpk'] ?>" class="form-control rupiah" id="total_dpk" disabled>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>9</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">DPK Yang TIDAK Dijamin LPS
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="dpk_tdk_dijamin_lps" value="<?= $pil1['dpk_tdk_dijamin_lps'] ?>" class="form-control rupiah" id="dpk_tdk_dijamin_lps" disabled></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>10</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">25 Deposan & Tabungan Terbesar
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposan_tabungan_terbesar25" value="<?= $pil1['deposan_tabungan_terbesar25'] ?>" class="form-control rupiah" id="deposan_tabungan_terbesar25"></td>
                                            <td>
                                               
                                            </td>


                                        </tr>
                                        <tr>
                                            <th>
                                                <center>11</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Deposito Rate Spesial
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_rs" value="<?= $pil1['deposito_diatas_cr'] ?>" class="form-control rupiah" id="deposito_rs" disabled></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>12</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Arus Kas Netto
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="arus_kas_netto" value="<?= $pil1['arus_kas_netto'] ?>" class="form-control rupiah" id="arus_kas_netto" disabled></td>
                                            <td>
                                            Saldo Kas Akhir Periode Sebelumnya Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kas_besar_debet" value="<?= $pil1['kas_besar_debet'] ?>" class="form-control rupiah" id="kas_besar_debet">
                                            Saldo Kas Akhir Periode Penilaian Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kas_besar_kredit" value="<?= $pil1['kas'] ?>" class="form-control rupiah" id="kas_besar_kredit" disabled>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>13</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Deposito Inti
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_inti" value="<?= $pil1['deposito_inti'] ?>" class="form-control rupiah" id="deposito_inti"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>14</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Sisa Jangka Waktu Deposito
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="sisa_jangka_waktu_deposito" value="<?= $pil1['sisa_jangka_waktu_deposito'] ?>" class="form-control rupiah" id="sisa_jangka_waktu_deposito"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>15</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit L dan DP JT
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kredit_l_dp" value="<?= $pil1['kredit_l_dp'] ?>" class="form-control rupiah" id="kredit_l_dp"></td>
                                            <td></td>

                                        </tr>


                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->































                            <hr>
                            </hr>

                            <br></br>









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
