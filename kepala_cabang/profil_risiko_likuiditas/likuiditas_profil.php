<?php
// PROFIL LIKUIDITAS - AUTOSAVE TANPA TOMBOL SIMPAN
// Implementasi autosave seperti Profil Kredit/Inheren Kredit.
if (!ob_get_level()) { ob_start(); }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$displayModal = ($id <= 0);
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

if (!function_exists('lik_safe')) {
function lik_safe($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}}

if (!function_exists('lik_db_one')) {
function lik_db_one($conn, $sql){
    $q = mysqli_query($conn, $sql);
    return ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : [];
}}

if (!function_exists('lik_table_exists')) {
function lik_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}
/* FIX FORM TINDAK LANJUT SEPERTI KEPATUHAN */
if (!function_exists('lik_likuiditas_column_exists')) {
function lik_likuiditas_column_exists($conn, $table, $column){
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}}
if (!function_exists('lik_likuiditas_ensure_respon_cabang_column')) {
function lik_likuiditas_ensure_respon_cabang_column($conn){
    if (!lik_table_exists($conn, 'keterangan_profil_likuiditas')) return;
    if (!lik_likuiditas_column_exists($conn, 'keterangan_profil_likuiditas', 'ket_respon_cabang')) {
        mysqli_query($conn, "ALTER TABLE keterangan_profil_likuiditas ADD COLUMN ket_respon_cabang LONGTEXT NULL AFTER ket_profil_risiko");
    }
}}
}

if (!function_exists('lik_ensure_ket_row')) {
function lik_ensure_ket_row($conn, $id){
    $id = (int)$id;
    if ($id <= 0) return;
    $cek = mysqli_query($conn, "SELECT id_profil_risiko FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$id' LIMIT 1");
    if (!$cek || mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO keterangan_profil_likuiditas (id_profil_risiko) VALUES ('$id')");
    }
}}

if (!function_exists('lik_label_inheren')) {
function lik_label_inheren($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Rendah';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Rendah';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Sedang';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Tinggi';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}}


if (!function_exists('lik_label_kpmr')) {
function lik_label_kpmr($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Memadai';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Memadai';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Cukup Memadai';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Kurang Memadai';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Tidak Memadai';
    return '';
}}

if (!function_exists('lik_col_exists')) {
function lik_col_exists($conn, $table, $column){
    if (!lik_table_exists($conn, $table)) return false;
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}}

if (!function_exists('lik_pick_result')) {
function lik_pick_result($row, $jenis = 'inheren'){
    $nilaiKeys = [
        'hasil_tingkat_risiko', 'tingkat_risiko', 'hasil_kpmr', 'hasil_penilaian_kpmr',
        'nilai_kpmr', 'total_nilai', 'hasil_rata_rata', 'rata_rata', 'nilai'
    ];
    $rankKeys = ['hasil_peringkat', 'peringkat', 'predikat', 'hasil_predikat', 'ket_tingkat_risiko'];

    $nilai = 0;
    foreach ($nilaiKeys as $k) {
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') {
            $nilai = (float)str_replace(',', '.', (string)$row[$k]);
            if ($nilai > 0) break;
        }
    }

    $rank = '';
    foreach ($rankKeys as $k) {
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') {
            $rank = trim((string)$row[$k]);
            break;
        }
    }
    if ($rank === '') {
        $rank = ($jenis === 'kpmr') ? lik_label_kpmr($nilai) : lik_label_inheren($nilai);
    }

    return [
        'hasil_tingkat_risiko' => round((float)$nilai, 2),
        'hasil_peringkat' => $rank
    ];
}}

if (!function_exists('lik_result_from_tables')) {
function lik_result_from_tables($conn, $id, $tables, $jenis = 'inheren'){
    $id = (int)$id;
    $best = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => ''];
    if ($id <= 0) return $best;

    foreach ((array)$tables as $table) {
        if (!lik_table_exists($conn, $table)) continue;
        $row = lik_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko = '$id' LIMIT 1");
        if (!$row) continue;
        $picked = lik_pick_result($row, $jenis);
        if ((float)$picked['hasil_tingkat_risiko'] > 0 || trim((string)$picked['hasil_peringkat']) !== '') {
            // Jika ketemu hasil yang bernilai, langsung pakai. Ini mengatasi hasil KPMR yang tersimpan di tabel lama/alternatif.
            if ((float)$picked['hasil_tingkat_risiko'] > 0) return $picked;
            $best = $picked;
        }
    }
    return $best;
}}

if (!function_exists('lik_read_uraian_multi')) {
function lik_read_uraian_multi($conn, $id, $sources){
    $id = (int)$id;
    if ($id <= 0) return '';
    foreach ((array)$sources as $src) {
        $table = $src[0] ?? '';
        $field = $src[1] ?? '';
        $where = $src[2] ?? '';
        if ($table === '' || $field === '' || !lik_table_exists($conn, $table) || !lik_col_exists($conn, $table, $field)) continue;
        $fieldSafe = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $extraWhere = trim((string)$where);
        $sql = "SELECT `$fieldSafe` AS uraian FROM `$table` WHERE id_profil_risiko = '$id'";
        if ($extraWhere !== '') $sql .= " AND $extraWhere";
        $sql .= " LIMIT 1";
        $row = lik_db_one($conn, $sql);
        $txt = trim((string)($row['uraian'] ?? ''));
        if ($txt !== '') return $txt;
    }
    return '';
}}

if (!function_exists('lik_matrix_value')) {
function lik_matrix_value($inherenRank, $kpmrRank){
    $m = [
        'Sangat Rendah' => [
            'Sangat Memadai' => 1.00,
            'Memadai' => 1.10,
            'Cukup Memadai' => 1.15,
            'Kurang Memadai' => 1.20,
            'Tidak Memadai' => 1.25,
        ],
        'Rendah' => [
            'Sangat Memadai' => 1.05,
            'Memadai' => 1.68,
            'Cukup Memadai' => 1.96,
            'Kurang Memadai' => 2.11,
            'Tidak Memadai' => 2.25,
        ],
        'Sedang' => [
            'Sangat Memadai' => 1.39,
            'Memadai' => 1.82,
            'Cukup Memadai' => 2.92,
            'Kurang Memadai' => 3.08,
            'Tidak Memadai' => 3.25,
        ],
        'Tinggi' => [
            'Sangat Memadai' => 1.54,
            'Memadai' => 2.58,
            'Cukup Memadai' => 3.50,
            'Kurang Memadai' => 4.00,
            'Tidak Memadai' => 4.25,
        ],
        'Sangat Tinggi' => [
            'Sangat Memadai' => 2.42,
            'Memadai' => 2.75,
            'Cukup Memadai' => 3.75,
            'Kurang Memadai' => 4.63,
            'Tidak Memadai' => 5.00,
        ],
    ];
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}}

if (!function_exists('lik_kualitas_mr')) {
function lik_kualitas_mr($i, $k){
    $m = [
        'Sangat Rendah|Sangat Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Cukup Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Kurang Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Tidak Memadai' => 'Risiko Sangat Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',

        'Rendah|Sangat Memadai' => 'Risiko Sangat Rendah',
        'Rendah|Memadai' => 'Risiko Rendah',
        'Rendah|Cukup Memadai' => 'Risiko Rendah',
        'Rendah|Kurang Memadai' => 'Risiko rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
        'Rendah|Tidak Memadai' => 'Risiko Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',

        'Sedang|Sangat Memadai' => 'Risiko Rendah',
        'Sedang|Memadai' => 'Risiko Rendah',
        'Sedang|Cukup Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
        'Sedang|Kurang Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Sedang|Tidak Memadai' => 'Risiko Sedang (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)',

        'Tinggi|Sangat Memadai' => 'Risiko Rendah',
        'Tinggi|Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Cukup Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Kurang Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Tidak Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)',

        'Sangat Tinggi|Sangat Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Sangat Tinggi|Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Cukup Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Kurang Memadai' => 'Risiko Sangat Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Tidak Memadai' => 'Risiko Sangat Tinggi (Dilakukan pengawasan melekat, membutuhkan pemantauan lebih mendalam)',
    ];
    $key = trim((string)$i).'|'.trim((string)$k);
    return $m[$key] ?? '';
}}

if (!function_exists('lik_read_uraian')) {
function lik_read_uraian($conn, $table, $field, $id){
    $id = (int)$id;
    if ($id <= 0 || !lik_table_exists($conn, $table)) return '';
    $fieldSafe = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
    $row = lik_db_one($conn, "SELECT `$fieldSafe` AS uraian FROM `$table` WHERE id_profil_risiko = '$id' LIMIT 1");
    return trim((string)($row['uraian'] ?? ''));
}}

// === FIX PROFIL LIKUIDITAS: hitung langsung KPMR 2 dinamis jika tabel hasil lama kosong ===
if (!function_exists('lik_num_avg')) {
function lik_num_avg($arr){
    $nums = [];
    foreach ((array)$arr as $v) {
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(array_sum($nums) / count($nums), 2) : 0;
}}
if (!function_exists('lik_num_max')) {
function lik_num_max($arr){
    $nums = [];
    foreach ((array)$arr as $v) {
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(max($nums), 2) : 0;
}}
if (!function_exists('lik_num_min')) {
function lik_num_min($arr){
    $nums = [];
    foreach ((array)$arr as $v) {
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(min($nums), 2) : 0;
}}
if (!function_exists('lik_risk_mode_label')) {
function lik_risk_mode_label($riskRow){
    if (!$riskRow || empty($riskRow)) return 'Perskalaan';
    return ((int)($riskRow['pembobotan'] ?? 0) === 1) ? 'Pembobotan' : 'Perskalaan';
}}
if (!function_exists('lik_find_frame_perumusan')) {
function lik_find_frame_perumusan($conn, $frame){
    if (!$frame || !lik_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = lik_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan = '".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }

    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';

    return lik_db_one($conn, "
        SELECT *
        FROM frame_perumusan
        WHERE tahun = '".mysqli_real_escape_string($conn, (string)($frame['tahun'] ?? ''))."'
          AND user_id = '".(int)($frame['user'] ?? 0)."'
          AND (
                UPPER(COALESCE(triwulan,'')) = '".mysqli_real_escape_string($conn, $kategori)."'
                OR (UPPER(COALESCE(triwulan,'')) = '' AND '".$kategori."' = 'KONSOLIDASI')
              )
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
}}
if (!function_exists('lik_pilar_perumusan_map')) {
function lik_pilar_perumusan_map($conn, $id_perumusan_kpmr){
    $map = [];
    if ((int)$id_perumusan_kpmr <= 0 || !lik_table_exists($conn, 'perumusan_kpmr_pilar')) return $map;
    $q = mysqli_query($conn, "SELECT * FROM perumusan_kpmr_pilar WHERE id_perumusan_kpmr = '".(int)$id_perumusan_kpmr."'");
    if ($q) {
        while ($r = mysqli_fetch_assoc($q)) {
            $map[(int)$r['id_pilar']] = $r;
        }
    }
    return $map;
}}
if (!function_exists('lik_dynamic_method_kpmr')) {
function lik_dynamic_method_kpmr($conn, $id){
    $id = (int)$id;
    $metode = 'rata_rata';
    if ($id > 0 && lik_table_exists($conn, 'kpmr2_likuiditas_catatan_dinamis')) {
        $row = lik_db_one($conn, "SELECT metode FROM kpmr2_likuiditas_catatan_dinamis WHERE id_profil_risiko = '$id' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['metode'] ?? '')) !== '') $metode = trim((string)$row['metode']);
    }
    return in_array($metode, ['tertinggi','terendah','rata_rata']) ? $metode : 'rata_rata';
}}
if (!function_exists('lik_compute_kpmr2_likuiditas')) {
function lik_compute_kpmr2_likuiditas($conn, $id){
    $fallback = lik_result_from_tables($conn, $id, [
        'hasil_kpmr_likuiditas',
        'hasil_kpmr2_likuiditas',
        'hasil_kpmr_lik'
    ], 'kpmr');

    $id = (int)$id;
    if ($id <= 0) return $fallback;

    $needed = [
        'frame_laporan_profil_risiko','assessment_kpmr','assessment_kpmr_detail',
        'kpmr_pilih_parameter','kpmr_pilih_parameter_detail','kpmr_periode',
        'kpmr_jenis_risiko','kpmr_pilar','kpmr_parameter'
    ];
    foreach ($needed as $tb) {
        if (!lik_table_exists($conn, $tb)) return $fallback;
    }

    $frame = lik_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '$id'
        LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = lik_db_one($conn, "
        SELECT *
        FROM assessment_kpmr
        WHERE id_profil_risiko = '$id'
          AND UPPER(jenis_risiko) = 'RISIKO LIKUIDITAS'
        LIMIT 1
    ");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_kpmr_detail WHERE id_assessment_kpmr = '".(int)$assessment['id_assessment_kpmr']."'");
    if ($dq) {
        while ($r = mysqli_fetch_assoc($dq)) {
            $detailMap[$r['ref_tipe'].'|'.(int)$r['ref_id']] = $r;
        }
    }

    $pilihHeader = lik_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM kpmr_pilih_parameter pp
        INNER JOIN kpmr_periode pi ON pp.kpmr_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)($frame['tahun'] ?? ''))."'
          AND pp.id_user_profil_risiko = '".(int)($frame['user'] ?? 0)."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = [];
    $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM kpmr_pilih_parameter_detail WHERE kpmr_pilih_parameter_id = '".(int)$pilihHeader['id']."'");
    if ($cq) {
        while ($ck = mysqli_fetch_assoc($cq)) {
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $periode_master_id = (int)$pilihHeader['kpmr_periode_id'];
    $hasSub = lik_table_exists($conn, 'kpmr_sub_parameter');
    $group = [];
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM kpmr_jenis_risiko jr
        INNER JOIN kpmr_pilar p ON p.jenis_risiko_id = jr.id AND p.kpmr_periode_id = '$periode_master_id'
        INNER JOIN kpmr_parameter pm ON pm.pilar_id = p.id AND pm.kpmr_periode_id = '$periode_master_id'
        ".($hasSub ? "LEFT JOIN kpmr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.kpmr_periode_id = '$periode_master_id'" : "")."
        WHERE UPPER(jr.nama_risiko) = 'RISIKO LIKUIDITAS'
          AND jr.kpmr_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;

    while ($r = mysqli_fetch_assoc($q)) {
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;

        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id, 'urutan'=>(int)$r['pilar_urutan'], 'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }

    if (empty($group)) return $fallback;

    $framePerumusan = lik_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && lik_table_exists($conn, 'perumusan_kpmr')) {
        $riskPerumusan = lik_db_one($conn, "
            SELECT *
            FROM perumusan_kpmr
            WHERE id_frame_perumusan = '".(int)$framePerumusan['id_frame_perumusan']."'
              AND UPPER(nama_risiko) = 'RISIKO LIKUIDITAS'
            LIMIT 1
        ");
    }
    $pilarPerumusanMap = $riskPerumusan ? lik_pilar_perumusan_map($conn, (int)$riskPerumusan['id_perumusan_kpmr']) : [];
    $overallMode = lik_risk_mode_label($riskPerumusan);

    $rekapPilar = [];
    foreach ($group as $pilar_id => $pilar) {
        $parameterScores = [];
        foreach ($pilar['parameters'] as $parameter_id => $parameter) {
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = $detailMap[$paramKey] ?? null;
            $subScores = [];
            foreach ($parameter['subs'] as $sub) {
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = $detailMap[$subKey] ?? null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? lik_num_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }

        $statMax = lik_num_max($parameterScores);
        $statMin = lik_num_min($parameterScores);
        $statAvg = lik_num_avg($parameterScores);
        $perumusanPilar = $pilarPerumusanMap[$pilar_id] ?? null;

        if ($overallMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMax = lik_num_max($rekapPilar);
    $overallMin = lik_num_min($rekapPilar);
    $overallAvg = lik_num_avg($rekapPilar);
    if ($overallMode === 'Pembobotan') {
        $overallNilai = round(array_sum($rekapPilar), 2);
    } else {
        $overallMethod = lik_dynamic_method_kpmr($conn, $id);
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }

    if ((float)$overallNilai <= 0 && (float)$fallback['hasil_tingkat_risiko'] > 0) return $fallback;
    return [
        'hasil_tingkat_risiko' => round((float)$overallNilai, 2),
        'hasil_peringkat' => lik_label_kpmr($overallNilai)
    ];
}}



if (!function_exists('lik_lookup_definisi_tingkat_risiko_likuiditas')) {
function lik_lookup_definisi_tingkat_risiko_likuiditas($conn, $tingkatRisikoLabel){
    $tingkatRisikoLabel = trim((string)$tingkatRisikoLabel);
    if ($tingkatRisikoLabel === '') return '';
    $tables = [
        'matrik_ojk_likuiditas',
        'matrik_ojk_likuiditas1',
        'matriks_ojk_likuiditas',
        'matrik_ojk'
    ];
    foreach ($tables as $tb) {
        if (!lik_table_exists($conn, $tb)) continue;
        $label = mysqli_real_escape_string($conn, $tingkatRisikoLabel);
        $row = lik_db_one($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko = '$label' LIMIT 1");
        if ($row) {
            foreach (['definisi_tingkat_risiko','definisi','keterangan','uraian','tingkat_risiko'] as $field) {
                if (isset($row[$field]) && trim((string)$row[$field]) !== '') {
                    return trim((string)$row[$field]);
                }
            }
        }
    }
    return $tingkatRisikoLabel;
}}

if (!function_exists('lik_get_highest_analysis_likuiditas')) {
function lik_get_highest_analysis_likuiditas($conn, $idProfil){
    $idProfil = (int)$idProfil;
    $hasilDefault = [
        'pilar' => 'Belum ada data nilai tertinggi risiko likuiditas.',
        'rows' => []
    ];
    if ($idProfil <= 0) return $hasilDefault;
    if (!lik_table_exists($conn, 'hasil_inheren_likuiditas')) return $hasilDefault;

    $hasil = lik_db_one($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko='$idProfil' LIMIT 1");
    if (!$hasil) return $hasilDefault;

    $pil1 = lik_table_exists($conn, 'inheren_likuiditas_pilar1') ? lik_db_one($conn, "SELECT * FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko='$idProfil' LIMIT 1") : [];
    $pil2 = lik_table_exists($conn, 'inheren_likuiditas_pilar2') ? lik_db_one($conn, "SELECT * FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko='$idProfil' LIMIT 1") : [];
    $pil3 = lik_table_exists($conn, 'inheren_likuiditas_lainnya') ? lik_db_one($conn, "SELECT * FROM inheren_likuiditas_lainnya WHERE id_profil_risiko='$idProfil' LIMIT 1") : [];

    $frame = lik_table_exists($conn, 'frame_laporan_profil_risiko') ? lik_db_one($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko='$idProfil' LIMIT 1") : [];
    $framePerumusan = $frame ? lik_find_frame_perumusan($conn, $frame) : null;
    $riskPerumusan = null;
    if ($framePerumusan && lik_table_exists($conn, 'perumusan_inheren')) {
        $riskPerumusan = lik_db_one($conn, "
            SELECT * FROM perumusan_inheren
            WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."'
              AND (
                    UPPER(TRIM(nama_risiko)) = UPPER('RISIKO LIKUIDITAS')
                 OR UPPER(TRIM(nama_risiko)) = UPPER('LIKUIDITAS')
                 OR UPPER(TRIM(nama_risiko)) LIKE '%LIKUIDITAS%'
              )
            ORDER BY id_perumusan_inheren DESC
            LIMIT 1
        ");
    }
    $riskMode = lik_risk_mode_label($riskPerumusan);

    $pilarPerumusanMap = [];
    if ($riskPerumusan && lik_table_exists($conn, 'perumusan_inheren_pilar')) {
        $qPil = mysqli_query($conn, "SELECT * FROM perumusan_inheren_pilar WHERE id_perumusan_inheren='".(int)$riskPerumusan['id_perumusan_inheren']."'");
        if ($qPil) {
            while ($rPil = mysqli_fetch_assoc($qPil)) {
                $pilarPerumusanMap[(int)$rPil['id_pilar']] = $rPil;
            }
        }
    }

    $num = function($row, $field){
        if (!is_array($row) || !isset($row[$field]) || $row[$field] === '' || $row[$field] === null) return 0.0;
        return (float)$row[$field];
    };
    $fmt = function($v){ return number_format((float)$v, 2, '.', ''); };

    $pickBest = function($items){
        $bestName = '-';
        $bestVal = null;
        foreach ((array)$items as $it) {
            $name = $it[0];
            $val = (float)$it[1];
            if ($bestVal === null || $val > $bestVal) {
                $bestVal = $val;
                $bestName = $name;
            }
        }
        return [$bestName, ($bestVal === null ? 0 : $bestVal)];
    };

    $pilarDefs = [
        1 => [
            'nama' => 'Komposisi Portofolio Aset Dan Tingkat Konsentrasi Likuiditas',
            'nilai' => $num($hasil, 'pil1_tingkat_risiko'),
            'params' => [
                ['Aset Likuid / Total Aset', $num($pil1, 'hasil_pil1_par1'), []],
                ['Aset Likuid / Kewajiban Lancar', $num($pil1, 'hasil_pil1_par2'), [
                    ['Total Aset Likuid / Pendanaan Jangka Pendek', $num($pil1, 'hasil_pil1_par2a')],
                    ['Aset Likuid / Kewajiban Jangka Pendek', $num($pil1, 'hasil_pil1_par2b')],
                    ['Arus Kas Netto / Total DPK', $num($pil1, 'hasil_pil1_par2c')],
                    ['Tabungan / Total DPK', $num($pil1, 'hasil_pil1_par2d')],
                    ['Deposito Jangka Waktu 3 bln / Total DPK', $num($pil1, 'hasil_pil1_par2e')],
                    ['Deposito Jangka Waktu 6 bln / Total DPK', $num($pil1, 'hasil_pil1_par2f')],
                    ['Deposito Jangka Waktu 12 bln / Total DPK', $num($pil1, 'hasil_pil1_par2g')],
                    ['Modal Disetor / Total DPK', $num($pil1, 'hasil_pil1_par2h')],
                    ['Pinjaman / Total DPK', $num($pil1, 'hasil_pil1_par2i')],
                ]],
                ['Kredit Yang Diberikan / Total Dana Pihak Ketiga Bukan Bank', $num($pil1, 'hasil_pil1_par3'), [
                    ['DPK Yang Dijamin LPS / DPK', $num($pil1, 'hasil_pil1_par3a')],
                    ['Alat Likuid + Kredit Lancar / Dana Pihak Ke 3', $num($pil1, 'hasil_pil1_par3b')],
                    ['Pertumbuhan Kredit / Pertumbuhan Simpanan', $num($pil1, 'hasil_pil1_par3d')],
                ]],
                ['25 Deposan dan Penabung Terbesar / Total DPK', $num($pil1, 'hasil_pil1_par4'), []],
                ['Pendanaan Non Inti / Total Pendanaan', $num($pil1, 'hasil_pil1_par5'), [
                    ['Pendanaan Non Inti - Alat Likuid / Total Aset - Aset Likuid', $num($pil1, 'hasil_pil1_par5a')],
                    ['Deposito Rate Spesial / Alat Likuid', $num($pil1, 'hasil_pil1_par5b')],
                    ['Aset Likuid / Pendanaan Non Inti', $num($pil1, 'hasil_pil1_par5c')],
                    ['Deposito Inti / Total DPK', $num($pil1, 'hasil_pil1_par5d')],
                ]],
            ],
        ],
        2 => [
            'nama' => 'Kualitas Aset',
            'nilai' => $num($hasil, 'pil2_tingkat_risiko'),
            'params' => [
                ['Rasio Kewajiban Segera / Aset Likuid', $num($pil2, 'hasil_pil2_par1'), [
                    ['Kewajiban Segera / Aset Likuid', $num($pil2, 'hasil_pil2_par1a')],
                    ['Pendanaan Jangka Pendek / Aset Likuid', $num($pil2, 'hasil_pil2_par1b')],
                    ['Kewajiban Jangka Pendek / Aset Likuid', $num($pil2, 'hasil_pil2_par1c')],
                ]],
                ['Konsentrasi Sumber Pendanaan', $num($pil2, 'hasil_pil2_par2'), []],
            ],
        ],
        3 => [
            'nama' => 'Lainnya',
            'nilai' => $num($hasil, 'pil3_tingkat_risiko'),
            'params' => [
                ['Lainnya', $num($pil3, 'hasil_pil3_par1'), [
                    ['Sumber Pendanaan Alternatif', $num($pil3, 'hasil_pil3_par1a')],
                    ['Akses Pendanaan Antar Bank', $num($pil3, 'hasil_pil3_par1b')],
                    ['Komitmen Fasilitas Pendanaan', $num($pil3, 'hasil_pil3_par1c')],
                    ['Konsentrasi Deposan Besar', $num($pil3, 'hasil_pil3_par1d')],
                    ['Stabilitas DPK', $num($pil3, 'hasil_pil3_par1e')],
                    ['Monitoring Likuiditas', $num($pil3, 'hasil_pil3_par1f')],
                ]],
            ],
        ],
    ];

    $rows = [];
    $bestPilarText = '';
    $bestPilarNilai = null;

    foreach ($pilarDefs as $idx => $pilar) {
        $pilarNama = $pilar['nama'];
        $nilaiPilar = (float)$pilar['nilai'];

        if ($nilaiPilar == 0) {
            $paramVals = [];
            foreach ($pilar['params'] as $param) $paramVals[] = (float)$param[1];
            $max = lik_num_max($paramVals);
            $min = lik_num_min($paramVals);
            $avg = lik_num_avg($paramVals);
            $perumusanPilar = isset($pilarPerumusanMap[$idx]) ? $pilarPerumusanMap[$idx] : null;
            if ($riskMode === 'Pembobotan') {
                $bobotPilar = (float)($perumusanPilar['pembobotan'] ?? 0);
                $nilaiPilar = round($avg * ($bobotPilar / 100), 2);
            } else {
                $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
                if ($metodePilar === 1) $nilaiPilar = $max;
                elseif ($metodePilar === 2) $nilaiPilar = $min;
                else $nilaiPilar = $avg;
            }
        }

        if ($bestPilarNilai === null || $nilaiPilar > $bestPilarNilai) {
            $bestPilarNilai = $nilaiPilar;
            $bestPilarText = 'Nilai risiko yang tertinggi ada di PILAR '.$idx.' : '.$pilarNama.' dengan nilai ('.$fmt($nilaiPilar).')';
        }

        $bestParamName = '-';
        $bestParamVal = null;
        $bestSubName = '-';
        $bestSubVal = null;
        foreach ($pilar['params'] as $param) {
            $paramName = $param[0];
            $paramVal = (float)$param[1];
            $subList = isset($param[2]) ? $param[2] : [];
            $localBestSub = $pickBest($subList);
            if ($bestParamVal === null || $paramVal > $bestParamVal) {
                $bestParamVal = $paramVal;
                $bestParamName = $paramName;
                $bestSubName = $localBestSub[0];
                $bestSubVal = $localBestSub[1];
            }
        }
        if ($bestParamVal === null) $bestParamVal = 0;

        $label = ($idx == 3) ? 'Parameter Pilar Lainnya' : 'Parameter Pilar '.$idx;
        $text = 'Pada PILAR '.$idx.' : '.$pilarNama.'.<br>';
        $text .= 'parameter dengan nilai tertinggi ada di '.$bestParamName.' dengan nilai ('.$fmt($bestParamVal).'), dengan sub parameter yg tertinggi pada '.($bestSubName ?: '-');
        if ($bestSubName !== '-' && $bestSubVal !== null) {
            $text .= ' dengan nilai ('.$fmt($bestSubVal).')';
        }

        $rows[] = ['label' => $label, 'text' => $text];
    }

    return [
        'pilar' => $bestPilarText !== '' ? $bestPilarText : 'Belum ada data nilai tertinggi risiko likuiditas.',
        'rows' => $rows
    ];
}}


$frame = lik_db_one($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
WHERE id_profil_risiko = '$id' LIMIT 1");

/*
  FIX SEPERTI OP PROFIL:
  frame_laporan_profil_risiko.user = 3 adalah PROFIL RISIKO CABANG.
  Untuk cabang, tampilan Profil Likuiditas hanya menampilkan Tingkat Risiko Inheren.
*/
$isProfilRisikoCabang = ((int)($frame['user'] ?? 0) === 3);

$dp = (int)($frame['data_pembanding'] ?? 0);

$inheren = lik_result_from_tables($conn, $id, ['hasil_inheren_likuiditas'], 'inheren');
$kpmr = lik_compute_kpmr2_likuiditas($conn, $id);
$pembanding_inheren = lik_result_from_tables($conn, $dp, ['hasil_inheren_likuiditas'], 'inheren');
$pembanding_kpmr = lik_compute_kpmr2_likuiditas($conn, $dp);

lik_ensure_ket_row($conn, $id);
lik_likuiditas_ensure_respon_cabang_column($conn);
$ket = lik_db_one($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$id' LIMIT 1");

$i = trim((string)($inheren['hasil_peringkat'] ?? ''));
$k = trim((string)($kpmr['hasil_peringkat'] ?? ''));
$tingkat_risiko = lik_matrix_value($i, $k);
$ket_tingkat_risiko = lik_label_inheren($tingkat_risiko);
$tingkat_kualitas_mr = lik_kualitas_mr($i, $k);

$pem_i = trim((string)($pembanding_inheren['hasil_peringkat'] ?? ''));
$pem_k = trim((string)($pembanding_kpmr['hasil_peringkat'] ?? ''));
$pembanding_tingkat_risiko = lik_matrix_value($pem_i, $pem_k);
$pem_ket_tingkat_risiko = lik_label_inheren($pembanding_tingkat_risiko);
$pembanding_tingkat_kualitas_mr = lik_kualitas_mr($pem_i, $pem_k);

// Uraian otomatis dari halaman Inheren/KPMR Likuiditas.
// Dibuat readonly di Profil, sehingga nilainya mengikuti sumber utama, bukan diketik manual di halaman Profil.
$auto_uraian_inheren = lik_read_uraian_multi($conn, $id, [
    ['keterangan_inheren_likuiditas', 'ket_inheren', ''],
    ['keterangan_inheren2_likuiditas', 'ket_inheren', ''],
    ['inheren2_likuiditas_catatan_dinamis', 'catatan', "scope_type = 'risiko' AND scope_ref_id = 0"]
]);
$auto_uraian_kpmr = lik_read_uraian_multi($conn, $id, [
    ['keterangan_kpmr_likuiditas', 'ket_kpmr', ''],
    ['keterangan_kpmr_likuiditas', 'ket_kpmr_likuiditas', ''],
    ['keterangan_kpmr2_likuiditas', 'ket_kpmr', ''],
    ['kpmr2_likuiditas_catatan_dinamis', 'catatan', "scope_type = 'risiko' AND scope_ref_id = 0"],
    ['keterangan_kpmr_kredit', 'ket_kpmr', '']
]);
// Untuk Profil Risiko Cabang, Analisis Risiko Likuiditas (ket_profil_inheren) boleh diisi manual.
// Jadi jangan ditimpa otomatis dari halaman Inheren saat mode Cabang.
if (!$isProfilRisikoCabang && $auto_uraian_inheren !== '') $ket['ket_profil_inheren'] = $auto_uraian_inheren;
if ($auto_uraian_kpmr !== '') $ket['ket_profil_kpmr'] = $auto_uraian_kpmr;

$analisaTertinggiLikuiditas = lik_get_highest_analysis_likuiditas($conn, $id);
$definisiTingkatRisikoLikuiditas = lik_lookup_definisi_tingkat_risiko_likuiditas($conn, (string)($inheren['hasil_peringkat'] ?? ''));

if (isset($_POST['autosave_profil']) && $_POST['autosave_profil'] == '1') {
    if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
    if (ob_get_level()) { @ob_clean(); }

    lik_ensure_ket_row($conn, $id);

    $inheren_likuiditas = number_format((float)($inheren['hasil_tingkat_risiko'] ?? 0), 2, '.', '');
    $kpmr_likuiditas = number_format((float)($kpmr['hasil_tingkat_risiko'] ?? 0), 2, '.', '');
    $nilai_tingkat_risiko = number_format((float)$tingkat_risiko, 2, '.', '');

    $ket_profil_risiko_input = array_key_exists('ket_profil_risiko', $_POST) ? (string)$_POST['ket_profil_risiko'] : (string)($ket['ket_profil_risiko'] ?? '');
    $ket_profil_risiko = mysqli_real_escape_string($conn, $ket_profil_risiko_input);
    $ket_respon_cabang_input = array_key_exists('ket_respon_cabang', $_POST) ? (string)$_POST['ket_respon_cabang'] : (string)($ket['ket_respon_cabang'] ?? '');
    $ket_respon_cabang = mysqli_real_escape_string($conn, $ket_respon_cabang_input);
    $ket_profil_inheren_input = array_key_exists('ket_profil_inheren', $_POST) ? (string)$_POST['ket_profil_inheren'] : (string)($ket['ket_profil_inheren'] ?? $auto_uraian_inheren);
    $ket_profil_inheren = mysqli_real_escape_string($conn, $isProfilRisikoCabang ? $ket_profil_inheren_input : (string)$auto_uraian_inheren);
    $ket_profil_kpmr = mysqli_real_escape_string($conn, (string)$auto_uraian_kpmr);
    $label_tingkat_risiko = mysqli_real_escape_string($conn, (string)$ket_tingkat_risiko);
    $label_kualitas_mr = mysqli_real_escape_string($conn, (string)$tingkat_kualitas_mr);

    $ok = mysqli_query($conn, "UPDATE keterangan_profil_likuiditas SET 
        inheren_likuiditas = '$inheren_likuiditas',
        kpmr_likuiditas = '$kpmr_likuiditas',
        tingkat_risiko = '$nilai_tingkat_risiko',
        peringkat_tingkat_risiko = '$label_tingkat_risiko',
        tingkat_kualitas_mr = '$label_kualitas_mr',
        ket_profil_risiko = '$ket_profil_risiko',
        ket_respon_cabang = '$ket_respon_cabang',
        ket_profil_inheren = '$ket_profil_inheren',
        ket_profil_kpmr = '$ket_profil_kpmr'
        WHERE id_profil_risiko = '$id'");

    echo json_encode([
        'ok' => $ok ? true : false,
        'message' => $ok ? 'Autosave berhasil' : mysqli_error($conn),
        'tingkat_risiko' => $nilai_tingkat_risiko,
        'peringkat' => (string)$ket_tingkat_risiko,
        'kualitas' => (string)$tingkat_kualitas_mr
    ]);
    exit();
}

// Fallback submit manual tetap disediakan untuk kompatibilitas lama, namun tombol submit sudah dihapus dari tampilan.
if (isset($_POST['submit'])) {
    lik_ensure_ket_row($conn, $id);
    $inheren_likuiditas = number_format((float)($inheren['hasil_tingkat_risiko'] ?? 0), 2, '.', '');
    $kpmr_likuiditas = number_format((float)($kpmr['hasil_tingkat_risiko'] ?? 0), 2, '.', '');
    $nilai_tingkat_risiko = number_format((float)$tingkat_risiko, 2, '.', '');

    $ket_profil_risiko_input = array_key_exists('ket_profil_risiko', $_POST) ? (string)$_POST['ket_profil_risiko'] : (string)($ket['ket_profil_risiko'] ?? '');
    $ket_profil_risiko = mysqli_real_escape_string($conn, $ket_profil_risiko_input);
    $ket_respon_cabang_input = array_key_exists('ket_respon_cabang', $_POST) ? (string)$_POST['ket_respon_cabang'] : (string)($ket['ket_respon_cabang'] ?? '');
    $ket_respon_cabang = mysqli_real_escape_string($conn, $ket_respon_cabang_input);
    $ket_profil_inheren_input = array_key_exists('ket_profil_inheren', $_POST) ? (string)$_POST['ket_profil_inheren'] : (string)($ket['ket_profil_inheren'] ?? $auto_uraian_inheren);
    $ket_profil_inheren = mysqli_real_escape_string($conn, $isProfilRisikoCabang ? $ket_profil_inheren_input : (string)$auto_uraian_inheren);
    $ket_profil_kpmr = mysqli_real_escape_string($conn, (string)$auto_uraian_kpmr);
    $label_tingkat_risiko = mysqli_real_escape_string($conn, (string)$ket_tingkat_risiko);
    $label_kualitas_mr = mysqli_real_escape_string($conn, (string)$tingkat_kualitas_mr);

    mysqli_query($conn, "UPDATE keterangan_profil_likuiditas SET 
        inheren_likuiditas = '$inheren_likuiditas',
        kpmr_likuiditas = '$kpmr_likuiditas',
        tingkat_risiko = '$nilai_tingkat_risiko',
        peringkat_tingkat_risiko = '$label_tingkat_risiko',
        tingkat_kualitas_mr = '$label_kualitas_mr',
        ket_profil_risiko = '$ket_profil_risiko',
        ket_respon_cabang = '$ket_respon_cabang',
        ket_profil_inheren = '$ket_profil_inheren',
        ket_profil_kpmr = '$ket_profil_kpmr'
        WHERE id_profil_risiko = '$id'");

    header("Location: index.php?page=lik_profil&id=$id");
    exit();
}
?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Risiko Likuiditas Profil [<?= lik_safe($frame['cabang'] ?? '') ?> Tahun <?= lik_safe($frame['tahun'] ?? '') ?> - <?= lik_safe($frame['periode_laporan'] ?? '') ?>]</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fa3939; color: white;">
                            <h4 class="page-title">Profil Risiko Likuiditas</h4>
                        </div>
                    </div>
                </div>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Hasil Profil Risiko Likuiditas</h4>
                            <hr>

                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">
                                            <th colspan="9"><center>RISIKO LIKUIDITAS</center></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <br>

                            <?php if ($isProfilRisikoCabang) { ?>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead bgcolor="#00e6e6">
                                                    <tr><th colspan="2"><h4><center><b>Penilaian Profil Risiko</b></center></h4></th></tr>
                                                    <tr>
                                                        <th width="50%"><center>Jenis Risiko</center></th>
                                                        <th width="50%"><center>Tingkat Risiko Inheren</center></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr bgcolor="#edebe8">
                                                        <th rowspan="2"><center>Risiko likuiditas</center></th>
                                                        <th><center><b><?= number_format((float)($inheren['hasil_tingkat_risiko'] ?? 0), 2) ?></b></center></th>
                                                    </tr>
                                                    <tr bgcolor="#edebe8">
                                                        <th><center><b><?= lik_safe($inheren['hasil_peringkat'] ?? '') ?></b></center></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead bgcolor="#ffc266">
                                                    <tr><th colspan="2"><h4><center><b>Penilaian Profil Risiko Periode Sebelumnya</b></center></h4></th></tr>
                                                    <tr>
                                                        <th width="50%"><center>Jenis Risiko</center></th>
                                                        <th width="50%"><center>Tingkat Risiko Inheren</center></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr bgcolor="#edebe8">
                                                        <th rowspan="2"><center>Risiko likuiditas</center></th>
                                                        <th><center><b><?= number_format((float)($pembanding_inheren['hasil_tingkat_risiko'] ?? 0), 2) ?></b></center></th>
                                                    </tr>
                                                    <tr bgcolor="#edebe8">
                                                        <th><center><b><?= lik_safe($pembanding_inheren['hasil_peringkat'] ?? '') ?></b></center></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
<div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead bgcolor="#00e6e6">
                                                    <tr><th colspan="5"><h4><center><b>Penilaian Profil Risiko</b></center></h4></th></tr>
                                                    <tr>
                                                        <th width="20%"><center>Jenis Risiko</center></th>
                                                        <th width="20%"><center>Tingkat Risiko Inheren</center></th>
                                                        <th width="20%"><center>Tingkat KPMR</center></th>
                                                        <th width="20%"><center>Tingkat Risiko</center></th>
                                                        <th width="20%"><center>Tingkat Kualitas Manajemen Risiko</center></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr bgcolor="#edebe8">
                                                        <th rowspan="2"><center>Risiko likuiditas</center></th>
                                                        <th><center><b><?= number_format((float)($inheren['hasil_tingkat_risiko'] ?? 0), 2) ?></b></center></th>
                                                        <th><center><b><?= number_format((float)($kpmr['hasil_tingkat_risiko'] ?? 0), 2) ?></b></center></th>
                                                        <th><center><b><?= number_format((float)$tingkat_risiko, 2) ?></b></center></th>
                                                        <th rowspan="2">
                                                            <div style="max-height:220px; overflow-y:auto; overflow-x:hidden; white-space:normal; text-align:left; padding:8px 10px; line-height:1.5;">
                                                                <b><?= lik_safe($tingkat_kualitas_mr) ?></b>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr bgcolor="#edebe8">
                                                        <th><center><b><?= lik_safe($inheren['hasil_peringkat'] ?? '') ?></b></center></th>
                                                        <th><center><b><?= lik_safe($kpmr['hasil_peringkat'] ?? '') ?></b></center></th>
                                                        <th><center><b><?= lik_safe($ket_tingkat_risiko) ?></b></center></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead bgcolor="#ffc266">
                                                    <tr><th colspan="5"><h4><center><b>Penilaian Profil Risiko Periode Sebelumnya</b></center></h4></th></tr>
                                                    <tr>
                                                        <th width="20%"><center>Jenis Risiko</center></th>
                                                        <th width="20%"><center>Tingkat Risiko Inheren</center></th>
                                                        <th width="20%"><center>Tingkat KPMR</center></th>
                                                        <th width="20%"><center>Tingkat Risiko</center></th>
                                                        <th width="20%"><center>Tingkat Kualitas Manajemen Risiko</center></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr bgcolor="#edebe8">
                                                        <th rowspan="2"><center>Risiko likuiditas</center></th>
                                                        <th><center><b><?= number_format((float)($pembanding_inheren['hasil_tingkat_risiko'] ?? 0), 2) ?></b></center></th>
                                                        <th><center><b><?= number_format((float)($pembanding_kpmr['hasil_tingkat_risiko'] ?? 0), 2) ?></b></center></th>
                                                        <th><center><b><?= number_format((float)$pembanding_tingkat_risiko, 2) ?></b></center></th>
                                                        <th rowspan="2">
                                                            <div style="max-height:220px; overflow-y:auto; overflow-x:hidden; white-space:normal; text-align:left; padding:8px 10px; line-height:1.5;">
                                                                <b><?= lik_safe($pembanding_tingkat_kualitas_mr) ?></b>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr bgcolor="#edebe8">
                                                        <th><center><b><?= lik_safe($pembanding_inheren['hasil_peringkat'] ?? '') ?></b></center></th>
                                                        <th><center><b><?= lik_safe($pembanding_kpmr['hasil_peringkat'] ?? '') ?></b></center></th>
                                                        <th><center><b><?= lik_safe($pem_ket_tingkat_risiko) ?></b></center></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <?php } ?>
                            <br>
                            <hr>

                            <?php if ($isProfilRisikoCabang) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <tbody bgcolor="#edebe8">
                                        <tr bgcolor="#ffb3b3">
                                            <th width="20%"><center>Komponen</center></th>
                                            <th width="80%"><center>Analisis Risiko Likuiditas</center></th>
                                        </tr>
                                        <tr>
                                            <th><center>Risiko Inheren</center></th>
                                            <th>
                                                <textarea class="form-control autosave-profil" maxlength="2000" id="ket_profil_inheren" form="my_form" name="ket_profil_inheren" cols="60" rows="10" <?= (($frame['kunci_laporan'] ?? 0) == 1 ? 'readonly' : '') ?>><?= lik_safe($ket['ket_profil_inheren'] ?? '') ?></textarea>
                                                <span><?= strlen((string)($ket['ket_profil_inheren'] ?? '')) ?></span><span> / 2000</span>
                                            </th>
                                        </tr>

                                        <tr bgcolor="#ffb3b3">
                                            <th><center>Komponen</center></th>
                                            <th><center>Analisa Nilai Tertinggi Risiko Likuiditas</center></th>
                                        </tr>
                                        <tr>
                                            <th><center>Pilar</center></th>
                                            <th><?= !empty($analisaTertinggiLikuiditas['pilar']) ? $analisaTertinggiLikuiditas['pilar'] : 'Nilai risiko tertinggi belum tersedia / belum ada data perhitungan.' ?></th>
                                        </tr>
                                        <?php if (!empty($analisaTertinggiLikuiditas['rows'])) { ?>
                                            <?php foreach ($analisaTertinggiLikuiditas['rows'] as $rowAnalisa) { ?>
                                                <tr>
                                                    <th><center><?= lik_safe($rowAnalisa['label']) ?></center></th>
                                                    <th><?= $rowAnalisa['text'] ?></th>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <th><center>Parameter</center></th>
                                                <th>Analisa nilai tertinggi belum tersedia. Pastikan data penilaian inheren likuiditas sudah terisi.</th>
                                            </tr>
                                        <?php } ?>

                                        <tr bgcolor="#ffb3b3">
                                            <th><center>Tingkat Risiko</center></th>
                                            <th><center>Definisi Tingkat Risiko Likuiditas (Matrik OJK)</center></th>
                                        </tr>
                                        <tr>
                                            <th><center><?= lik_safe($inheren['hasil_peringkat'] ?? '') ?></center></th>
                                            <th>
                                                <textarea class="form-control" cols="60" rows="8" readonly><?= lik_safe($definisiTingkatRisikoLikuiditas ?: 'Definisi tingkat risiko belum tersedia pada tabel matrik OJK likuiditas.') ?></textarea>
                                            </th>
                                        </tr>

                                        <tr bgcolor="#ffb3b3">
                                            <th><center>Komponen</center></th>
                                            <th><center>Form Tindak Lanjut</center></th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>Usulan Perbaikan &<br>Tindak Lanjut</center>
                                                <br><small style="color:#8a9aa8;">note. di isi oleh residence dan korwil</small>
                                            </th>
                                            <th>
                                                <textarea class="form-control autosave-profil" maxlength="2000" id="ket_profil_risiko" form="my_form" name="ket_profil_risiko" cols="60" rows="8" <?= (($frame['kunci_laporan'] ?? 0) == 1 ? 'readonly' : '') ?> readonly><?= lik_safe($ket['ket_profil_risiko'] ?? '') ?></textarea>
                                                <span><?= strlen((string)($ket['ket_profil_risiko'] ?? '')) ?></span><span> / 2000</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>Respon Cabang &<br>Hasil Perbaikan</center>
                                                <br><small style="color:#8a9aa8;">note. di isi oleh cabang</small>
                                            </th>
                                            <th>
                                                <textarea class="form-control" maxlength="2000" id="ket_respon_cabang" form="my_form" name="ket_respon_cabang" cols="60" rows="8" ><?= lik_safe($ket['ket_respon_cabang'] ?? '') ?></textarea>
                                                <span><?= strlen((string)($ket['ket_respon_cabang'] ?? '')) ?></span><span> / 2000</span>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead bgcolor="#ffb3b3">
                                        <tr>
                                            <th width="20%"><center>Komponen</center></th>
                                            <th width="80%"><center>Analisis Risiko Likuiditas</center></th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        <tr>
                                            <th><center>Tingkat Risiko</center></th>
                                            <th>
                                                <textarea class="form-control autosave-profil" id="ket_profil_risiko" form="my_form" name="ket_profil_risiko" cols="60" rows="10" <?= (($frame['kunci_laporan'] ?? 0) == 1 ? 'readonly' : '') ?>><?= lik_safe($ket['ket_profil_risiko'] ?? '') ?></textarea>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><center>Risiko Inheren</center></th>
                                            <th>
                                                <textarea class="form-control" id="ket_profil_inheren" form="my_form" name="ket_profil_inheren" cols="60" rows="10" readonly><?= lik_safe($ket['ket_profil_inheren'] ?? '') ?></textarea>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><center>Risiko KPMR</center></th>
                                            <th>
                                                <textarea class="form-control" id="ket_profil_kpmr" form="my_form" name="ket_profil_kpmr" cols="60" rows="10" readonly><?= lik_safe($ket['ket_profil_kpmr'] ?? '') ?></textarea>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>

                            <hr>
                            <br>
                            <!-- Tombol Simpan dihapus karena sudah autosave -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var fields = Array.prototype.slice.call(document.querySelectorAll('.autosave-profil'));
    if (!fields.length) return;

    fields = fields.filter(function(el){ return !el.hasAttribute('readonly'); });
    if (!fields.length) return;

    var saveTimer = null;
    var isSaving = false;
    var pending = false;
    var lastPayload = getPayloadString();

    function getPayloadString(){
        return fields.map(function(el){ return el.name + '=' + encodeURIComponent(el.value || ''); }).join('&');
    }

    function buildFormData(){
        var fd = new FormData();
        fd.append('autosave_profil', '1');
        fields.forEach(function(el){ fd.append(el.name, el.value || ''); });
        return fd;
    }

    function doSave(force){
        var currentPayload = getPayloadString();
        if (!force && currentPayload === lastPayload) return;
        if (isSaving) { pending = true; return; }

        isSaving = true;
        pending = false;

        fetch(window.location.href, {
            method: 'POST',
            body: buildFormData(),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(function(r){ return r.text(); })
        .then(function(txt){
            try {
                var res = JSON.parse(txt);
                if (res && res.ok) {
                    lastPayload = getPayloadString();
                } else {
                    console.error('Autosave gagal:', res && res.message ? res.message : txt);
                }
            } catch(e) {
                console.error('Autosave response invalid:', txt);
            }
        }).catch(function(err){
            console.error('Autosave error:', err);
        }).finally(function(){
            isSaving = false;
            if (pending) {
                clearTimeout(saveTimer);
                saveTimer = setTimeout(function(){ doSave(true); }, 300);
            }
        });
    }

    fields.forEach(function(el){
        el.addEventListener('input', function(){
            clearTimeout(saveTimer);
            saveTimer = setTimeout(function(){ doSave(false); }, 700);
        });
        el.addEventListener('change', function(){ doSave(true); });
        el.addEventListener('blur', function(){ doSave(true); });
        el.addEventListener('paste', function(){
            clearTimeout(saveTimer);
            saveTimer = setTimeout(function(){ doSave(false); }, 700);
        });
    });

    window.addEventListener('beforeunload', function(){
        clearTimeout(saveTimer);
        if (getPayloadString() === lastPayload) return;
        var fd = buildFormData();
        if (navigator.sendBeacon) {
            navigator.sendBeacon(window.location.href, fd);
        }
    });
});
</script>
