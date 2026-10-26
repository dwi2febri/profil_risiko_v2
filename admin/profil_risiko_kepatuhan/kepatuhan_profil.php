<?php
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




// $id sudah didefinisikan di atas

function op_db_one($conn, $sql){
    $res = mysqli_query($conn, $sql);
    if (!$res) return null;
    return mysqli_fetch_assoc($res);
}
function op_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}
function op_avg($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(array_sum($n)/count($n), 2) : 0;
}
function op_max($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(max($n), 2) : 0;
}
function op_min($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(min($n), 2) : 0;
}
function kep_label_inheren($nilai)
{
    $nilai = (float) $nilai;

    if ($nilai < 1.00 || $nilai > 5.00) {
        return '';
    }

    if ($nilai >= 1.00 && $nilai <= 1.25) {
        return 'Sangat Rendah';
    }

    if ($nilai > 1.25 && $nilai <= 2.25) {
        return 'Rendah';
    }

    if ($nilai > 2.25 && $nilai <= 3.25) {
        return 'Sedang';
    }

    if ($nilai > 3.25 && $nilai <= 4.25) {
        return 'Tinggi';
    }

    if ($nilai > 4.25 && $nilai <= 5.00) {
        return 'Sangat Tinggi';
    }

    return '';
}


function kep_label_kpmr($nilai)
{
    $nilai = (float) $nilai;

    if ($nilai < 1.00 || $nilai > 5.00) {
        return '';
    }

    if ($nilai >= 1.00 && $nilai <= 1.25) {
        return 'Sangat Memadai';
    }

    if ($nilai > 1.25 && $nilai <= 2.25) {
        return 'Memadai';
    }

    if ($nilai > 2.25 && $nilai <= 3.25) {
        return 'Cukup Memadai';
    }

    if ($nilai > 3.25 && $nilai <= 4.25) {
        return 'Kurang Memadai';
    }

    if ($nilai > 4.25 && $nilai <= 5.00) {
        return 'Tidak Memadai';
    }

    return '';
}


function op_kualitas_mr_matrix($inherenRank, $kpmrRank){
    // Matrix Penetapan Tingkat Risiko OJK: Risiko Inheren x Tingkat Kualitas Manajemen Risiko
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
    $key = trim((string)$inherenRank).'|'.trim((string)$kpmrRank);
    return $m[$key] ?? '';
}

function op_matrix_kepatuhan_value($inherenRank, $kpmrRank){
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
}

function op_lookup_kualitas_mr_kepatuhan($conn, $tingkatRisikoLabel){
    $tingkatRisikoLabel = trim((string)$tingkatRisikoLabel);
    if ($tingkatRisikoLabel === '') return '';
    $tables = ['matrik_ojk_kepatuhan', 'matrik_ojk_kepatuhan1'];
    foreach ($tables as $tb) {
        if (!op_table_exists($conn, $tb)) continue;
        $label = mysqli_real_escape_string($conn, $tingkatRisikoLabel);
        $row = op_db_one($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko = '$label' LIMIT 1");
        if ($row) {
            if (isset($row['definisi_tingkat_risiko']) && trim((string)$row['definisi_tingkat_risiko']) !== '') {
                return trim((string)$row['definisi_tingkat_risiko']);
            }
            if (isset($row['tingkat_risiko']) && trim((string)$row['tingkat_risiko']) !== '') {
                return trim((string)$row['tingkat_risiko']);
            }
        }
    }
    return $tingkatRisikoLabel;
}

function op_read_source_uraian($conn, $dynamicTable, $legacyTable, $legacyField, $idProfil){
    $idProfil = (int)$idProfil;
    if ($idProfil <= 0) return '';
    if ($dynamicTable !== '' && op_table_exists($conn, $dynamicTable)) {
        $row = op_db_one($conn, "SELECT catatan FROM `$dynamicTable` WHERE id_profil_risiko = '$idProfil' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['catatan'] ?? '')) !== '') {
            return trim((string)$row['catatan']);
        }
    }
    if ($legacyTable !== '' && op_table_exists($conn, $legacyTable)) {
        $row = op_db_one($conn, "SELECT `$legacyField` AS uraian FROM `$legacyTable` WHERE id_profil_risiko = '$idProfil' LIMIT 1");
        if ($row && trim((string)($row['uraian'] ?? '')) !== '') {
            return trim((string)$row['uraian']);
        }
    }
    return '';
}
function op_fallback_result($conn, $table, $id, $jenis = 'inheren'){
    $emptyRank = ($jenis === 'kpmr') ? '' : '';
    $out = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => $emptyRank];
    if ((int)$id <= 0 || !op_table_exists($conn, $table)) return $out;
    $row = op_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    if (!$row) return $out;
    $nilai = 0;
    if (isset($row['hasil_tingkat_risiko'])) $nilai = (float)$row['hasil_tingkat_risiko'];
    elseif (isset($row['tingkat_risiko'])) $nilai = (float)$row['tingkat_risiko'];
    elseif (isset($row['total_nilai'])) $nilai = (float)$row['total_nilai'];
    $rank = '';
    if (isset($row['hasil_peringkat']) && trim((string)$row['hasil_peringkat']) !== '') $rank = trim((string)$row['hasil_peringkat']);
    elseif (isset($row['peringkat']) && trim((string)$row['peringkat']) !== '') $rank = trim((string)$row['peringkat']);
    else $rank = ($jenis === 'kpmr') ? kep_label_kpmr($nilai) : kep_label_inheren($nilai);
    return ['hasil_tingkat_risiko' => round($nilai, 2), 'hasil_peringkat' => $rank];
}
function op_find_frame_perumusan($conn, $frame){
    if (!$frame || !op_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = op_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }
    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';
    return op_db_one($conn, "
        SELECT * FROM frame_perumusan
        WHERE tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND user_id = '".(int)$frame['user']."'
          AND (
                UPPER(COALESCE(triwulan,'')) = '".mysqli_real_escape_string($conn, $kategori)."'
                OR (UPPER(COALESCE(triwulan,'')) = '' AND '".$kategori."' = 'KONSOLIDASI')
              )
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
}
function op_risk_mode_label($riskRow){
    if (!$riskRow) return 'Perskalaan';
    if ((int)($riskRow['pembobotan'] ?? 0) === 1) return 'Pembobotan';
    return 'Perskalaan';
}
function op_pilar_perumusan_map($conn, $table, $fk, $id){
    $map = [];
    if ((int)$id <= 0 || !op_table_exists($conn, $table)) return $map;
    $q = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$fk`='".(int)$id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){ $map[(int)$r['id_pilar']] = $r; }
    }
    return $map;
}
function op_dynamic_method($conn, $table, $id){
    if ((int)$id <= 0 || !op_table_exists($conn, $table)) return 'rata_rata';
    $row = op_db_one($conn, "SELECT metode FROM `$table` WHERE id_profil_risiko='".(int)$id."' AND scope_type='risiko' AND scope_ref_id='0' LIMIT 1");
    $metode = trim((string)($row['metode'] ?? 'rata_rata'));
    if (!in_array($metode, ['tertinggi','terendah','rata_rata'])) $metode = 'rata_rata';
    return $metode;
}
function op_compute_inheren2_kepatuhan($conn, $id){
    $fallback = op_fallback_result($conn, 'hasil_inheren_kepatuhan', $id, 'inheren');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_inheren','assessment_inheren_detail','pr_pilih_parameter','pr_pilih_parameter_detail','pr_inheren_periode','pr_jenis_risiko','pr_pilar','pr_parameter'];
    foreach($needed as $tb){ if (!op_table_exists($conn, $tb)) return $fallback; }

    $frame = op_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = op_db_one($conn, "SELECT * FROM assessment_inheren WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO KEPATUHAN' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment['id_assessment_inheren']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = op_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM pr_pilih_parameter_detail WHERE pr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['pr_inheren_periode_id'];
    $hasSub = op_table_exists($conn, 'pr_sub_parameter');
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
        FROM pr_jenis_risiko jr
        INNER JOIN pr_pilar p ON p.jenis_risiko_id = jr.id AND p.pr_inheren_periode_id = '$periode_master_id'
        INNER JOIN pr_parameter pm ON pm.pilar_id = p.id AND pm.pr_inheren_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN pr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.pr_inheren_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO KEPATUHAN'
          AND jr.pr_inheren_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = op_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && op_table_exists($conn, 'perumusan_inheren')) {
        $riskPerumusan = op_db_one($conn, "SELECT * FROM perumusan_inheren WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO KEPATUHAN') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? op_pilar_perumusan_map($conn, 'perumusan_inheren_pilar', 'id_perumusan_inheren', (int)$riskPerumusan['id_perumusan_inheren']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? op_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = op_max($parameterScores);
        $statMin = op_min($parameterScores);
        $statAvg = op_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = op_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
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

    $overallMode = op_risk_mode_label($riskPerumusan);
    $overallMax = op_max($rekapPilar);
    $overallMin = op_min($rekapPilar);
    $overallAvg = op_avg($rekapPilar);
    $overallMethod = op_dynamic_method($conn, 'inheren2_kepatuhan_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => kep_label_inheren($overallNilai)];
}
function op_compute_kpmr2_kepatuhan($conn, $id){
    $fallback = op_fallback_result($conn, 'hasil_kpmr_kepatuhan', $id, 'kpmr');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_kpmr','assessment_kpmr_detail','kpmr_pilih_parameter','kpmr_pilih_parameter_detail','kpmr_periode','kpmr_jenis_risiko','kpmr_pilar','kpmr_parameter'];
    foreach($needed as $tb){ if (!op_table_exists($conn, $tb)) return $fallback; }

    $frame = op_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = op_db_one($conn, "SELECT * FROM assessment_kpmr WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO KEPATUHAN' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_kpmr_detail WHERE id_assessment_kpmr='".(int)$assessment['id_assessment_kpmr']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = op_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM kpmr_pilih_parameter pp
        INNER JOIN kpmr_periode pi ON pp.kpmr_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM kpmr_pilih_parameter_detail WHERE kpmr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['kpmr_periode_id'];
    $hasSub = op_table_exists($conn, 'kpmr_sub_parameter');
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
        INNER JOIN kpmr_parameter pm ON pm.pilar_id = p.id AND pm.kpmr_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN kpmr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.kpmr_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO KEPATUHAN'
          AND jr.kpmr_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = op_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && op_table_exists($conn, 'perumusan_kpmr')) {
        $riskPerumusan = op_db_one($conn, "SELECT * FROM perumusan_kpmr WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO KEPATUHAN') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? op_pilar_perumusan_map($conn, 'perumusan_kpmr_pilar', 'id_perumusan_kpmr', (int)$riskPerumusan['id_perumusan_kpmr']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? op_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = op_max($parameterScores);
        $statMin = op_min($parameterScores);
        $statAvg = op_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = op_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
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

    $overallMode = op_risk_mode_label($riskPerumusan);
    $overallMax = op_max($rekapPilar);
    $overallMin = op_min($rekapPilar);
    $overallAvg = op_avg($rekapPilar);
    $overallMethod = op_dynamic_method($conn, 'kpmr2_kepatuhan_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => kep_label_kpmr($overallNilai)];
}

$frame = op_db_one($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang WHERE id_profil_risiko = '".(int)$id."' LIMIT 1");
$dp = (int)($frame['data_pembanding'] ?? 0);

$inheren = op_compute_inheren2_kepatuhan($conn, $id);
$kpmr = op_compute_kpmr2_kepatuhan($conn, $id);
$pembanding_inheren = op_compute_inheren2_kepatuhan($conn, $dp);
$pembanding_kpmr = op_compute_kpmr2_kepatuhan($conn, $dp);

$ket = op_db_one($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '".(int)$id."' LIMIT 1");
if (!$ket) {
    mysqli_query($conn, "INSERT INTO keterangan_profil_kepatuhan (id_profil_risiko) VALUES ('".(int)$id."')");
    $ket = op_db_one($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '".(int)$id."' LIMIT 1");
}

$pem_i = $pembanding_inheren['hasil_peringkat'];
$pem_k = $pembanding_kpmr['hasil_peringkat'];

$i = $inheren['hasil_peringkat'];
$k =  $kpmr['hasil_peringkat'];

// Matrix tingkat risiko kepatuhan
$tingkat_risiko = op_matrix_kepatuhan_value($i, $k);
$ket_tingkat_risiko = kep_label_inheren($tingkat_risiko);
$tingkat_kualitas_mr = op_kualitas_mr_matrix($i, $k);

$pembanding_tingkat_risiko = op_matrix_kepatuhan_value($pem_i, $pem_k);
$pem_ket_tingkat_risiko = kep_label_inheren($pembanding_tingkat_risiko);
$pembanding_tingkat_kualitas_mr = op_kualitas_mr_matrix($pem_i, $pem_k);

// Uraian otomatis dari Inheren 2 dan KPMR 2
$auto_uraian_inheren = op_read_source_uraian($conn, 'inheren2_kepatuhan_catatan_dinamis', 'keterangan_inheren2_kepatuhan', 'ket_inheren', $id);
$auto_uraian_kpmr = op_read_source_uraian($conn, 'kpmr2_kepatuhan_catatan_dinamis', 'keterangan_kpmr2_kepatuhan', 'ket_kpmr', $id);

// Jika kolom profil masih kosong, tampilkan otomatis dari sumber
if (!isset($ket['ket_profil_inheren']) || trim((string)$ket['ket_profil_inheren']) === '') {
    $ket['ket_profil_inheren'] = $auto_uraian_inheren;
}
if (!isset($ket['ket_profil_kpmr']) || trim((string)$ket['ket_profil_kpmr']) === '') {
    $ket['ket_profil_kpmr'] = $auto_uraian_kpmr;
}

if (isset($_POST['autosave_profil']) && $_POST['autosave_profil'] == '1') {
    include "../conn/conn.php";
    if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');

    $inheren_kepatuhan = (float)$inheren['hasil_tingkat_risiko'];
    $kpmr_kepatuhan = (float)$kpmr['hasil_tingkat_risiko'];
    $ket_profil_risiko = mysqli_real_escape_string($conn, (string)($_POST['ket_profil_risiko'] ?? ''));
    $ket_profil_inheren = mysqli_real_escape_string($conn, (string)$auto_uraian_inheren);
    $ket_profil_kpmr = mysqli_real_escape_string($conn, (string)$auto_uraian_kpmr);
    $nilai_tingkat_risiko = is_numeric($tingkat_risiko) ? (float)$tingkat_risiko : 0;
    $label_tingkat_risiko = mysqli_real_escape_string($conn, (string)$ket_tingkat_risiko);
    $label_kualitas_mr = mysqli_real_escape_string($conn, (string)$tingkat_kualitas_mr);

    $cekKet = mysqli_query($conn, "SELECT id_profil_risiko FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '".(int)$id."' LIMIT 1");
    if (!$cekKet || mysqli_num_rows($cekKet) == 0) {
        mysqli_query($conn, "INSERT INTO keterangan_profil_kepatuhan (id_profil_risiko) VALUES ('".(int)$id."')");
    }

    $ok = mysqli_query($conn, "UPDATE keterangan_profil_kepatuhan SET 
        inheren_kepatuhan = '".mysqli_real_escape_string($conn, number_format($inheren_kepatuhan, 2, '.', ''))."',
        kpmr_kepatuhan = '".mysqli_real_escape_string($conn, number_format($kpmr_kepatuhan, 2, '.', ''))."',
        tingkat_risiko = '".mysqli_real_escape_string($conn, number_format($nilai_tingkat_risiko, 2, '.', ''))."',
        peringkat_tingkat_risiko = '$label_tingkat_risiko',
        tingkat_kualitas_mr = '$label_kualitas_mr',
        ket_profil_risiko = '$ket_profil_risiko',
        ket_profil_inheren = '$ket_profil_inheren',
        ket_profil_kpmr = '$ket_profil_kpmr'
        WHERE id_profil_risiko = '".(int)$id."'");

    echo json_encode([
        'ok' => $ok ? true : false,
        'tingkat_risiko' => number_format($nilai_tingkat_risiko, 2, '.', ''),
        'peringkat' => (string)$ket_tingkat_risiko,
        'kualitas' => (string)$tingkat_kualitas_mr
    ]);
    exit();
}

if (isset($_POST['submit'])) {
    include "../conn/conn.php";
    $inheren_kepatuhan = (float)$inheren['hasil_tingkat_risiko'];
    $kpmr_kepatuhan = (float)$kpmr['hasil_tingkat_risiko'];
    $ket_profil_risiko = mysqli_real_escape_string($conn, (string)($_POST['ket_profil_risiko'] ?? ''));
    $ket_profil_inheren = mysqli_real_escape_string($conn, (string)$auto_uraian_inheren);
    $ket_profil_kpmr = mysqli_real_escape_string($conn, (string)$auto_uraian_kpmr);
    $nilai_tingkat_risiko = is_numeric($tingkat_risiko) ? (float)$tingkat_risiko : 0;
    $label_tingkat_risiko = mysqli_real_escape_string($conn, (string)$ket_tingkat_risiko);
    $label_kualitas_mr = mysqli_real_escape_string($conn, (string)$tingkat_kualitas_mr);

    $cekKet = mysqli_query($conn, "SELECT id_profil_risiko FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '".(int)$id."' LIMIT 1");
    if (!$cekKet || mysqli_num_rows($cekKet) == 0) {
        mysqli_query($conn, "INSERT INTO keterangan_profil_kepatuhan (id_profil_risiko) VALUES ('".(int)$id."')");
    }

    mysqli_query($conn, "UPDATE keterangan_profil_kepatuhan SET 
        inheren_kepatuhan = '".mysqli_real_escape_string($conn, number_format($inheren_kepatuhan, 2, '.', ''))."',
        kpmr_kepatuhan = '".mysqli_real_escape_string($conn, number_format($kpmr_kepatuhan, 2, '.', ''))."',
        tingkat_risiko = '".mysqli_real_escape_string($conn, number_format($nilai_tingkat_risiko, 2, '.', ''))."',
        peringkat_tingkat_risiko = '$label_tingkat_risiko',
        tingkat_kualitas_mr = '$label_kualitas_mr',
        ket_profil_risiko = '$ket_profil_risiko',
        ket_profil_inheren = '$ket_profil_inheren',
        ket_profil_kpmr = '$ket_profil_kpmr'
        WHERE id_profil_risiko = '".(int)$id."'");

    header("Location: index.php?page=op_profil&id=$id");
    exit();
}
?>





















<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">
        <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Kepatuhan Profil [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
            
<script>
document.addEventListener('DOMContentLoaded', function(){
    var textarea = document.getElementById('ket_profil_risiko');
    if (!textarea || textarea.hasAttribute('readonly')) return;

    var saveTimer = null;
    var lastValue = textarea.value;
    var isSaving = false;

    function doSave(force){
        var val = textarea.value;
        if (!force && val === lastValue) return;
        if (isSaving) return;
        isSaving = true;

        var formData = new FormData();
        formData.append('autosave_profil', '1');
        formData.append('ket_profil_risiko', val);

        fetch(window.location.href, {
            method: 'POST',
            body: formData,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(function(r){
            return r.text();
        }).then(function(txt){
            try {
                var res = JSON.parse(txt);
                if (res && res.ok) {
                    lastValue = val;
                }
            } catch (e) {
                console.error('Autosave response invalid:', txt);
            }
        }).catch(function(err){
            console.error(err);
        }).finally(function(){
            isSaving = false;
        });
    }

    textarea.addEventListener('input', function(){
        clearTimeout(saveTimer);
        saveTimer = setTimeout(function(){ doSave(false); }, 700);
    });

    textarea.addEventListener('change', function(){ doSave(true); });
    textarea.addEventListener('blur', function(){ doSave(true); });
    textarea.addEventListener('paste', function(){
        clearTimeout(saveTimer);
        saveTimer = setTimeout(function(){ doSave(false); }, 700);
    });

    window.addEventListener('beforeunload', function(){
        clearTimeout(saveTimer);
        if (textarea.value === lastValue) return;
        var data = new FormData();
        data.append('autosave_profil', '1');
        data.append('ket_profil_risiko', textarea.value);
        if (navigator.sendBeacon) {
            navigator.sendBeacon(window.location.href, data);
        } else {
            doSave(true);
        }
    });
});
</script>

        </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #e6cb43; color: white;">

                            <h4 class="page-title">Profil Risiko Kepatuhan</h4>
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
                            <h4 class="header-title">Hasil Profil Risiko Kepatuhan</h4>

                            <hr>
                            </hr>


                            </br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
                                                <center>RISIKO KEPATUHAN</center>
                                            </th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
</br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                            <!-- kepatuhan-->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-centered mb-0">
                                                    <thead bgcolor="#00e6e6">
                                                        <tr>

                                                            <th colspan="5">
                                                                <h4>
                                                                    <center><b>Penilaian Profil Risiko</b></center>
                                                                </h4>
                                                            </th>

                                                        </tr>

                                                        <tr>
                                                            <th width="20%">
                                                                <center>Jenis Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko Inheren</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat KPMR</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Kualitas Manajemen Risiko</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr bgcolor="#edebe8">
                                                            <th rowspan="2">
                                                                <center>Risiko Kepatuhan</center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= number_format((float)$inheren['hasil_tingkat_risiko'], 2) ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= number_format((float)$kpmr['hasil_tingkat_risiko'], 2) ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= number_format($tingkat_risiko, 2) ?></b></center>
                                                            </th>
                                                            <th rowspan="2">
                                                            <div style="max-height:220px; overflow-y:auto; overflow-x:hidden; white-space:normal; text-align:left; padding:8px 10px; line-height:1.5;">
                                                                <b><?= htmlspecialchars((string)$tingkat_kualitas_mr, ENT_QUOTES, 'UTF-8') ?></b>
                                                            </div>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#edebe8">
                                                            
                                                            <th>
                                                            <center><b><?= $inheren['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $kpmr['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket_tingkat_risiko ?></b></center>
                                                            </th>
                                                        </tr>


                                                    </tbody>


                                                </table>
                                            </div> <!-- end table-responsive-->
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card">
                                            <!-- kepatuhan-->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-centered mb-0">
                                                    <thead bgcolor="#ffc266">
                                                        <tr>

                                                            <th colspan="5">
                                                                <h4>
                                                                    <center><b>Penilaian Profil Risiko Periode Sebelumnya</b></center>
                                                                </h4>
                                                            </th>

                                                        </tr>

                                                        <tr>
                                                            <th width="20%">
                                                                <center>Jenis Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko Inheren</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat KPMR</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Kualitas Manajemen Risiko</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr bgcolor="#edebe8">
                                                            <th rowspan="2">
                                                                <center>Risiko Kepatuhan</center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= number_format((float)$pembanding_inheren['hasil_tingkat_risiko'], 2) ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= number_format((float)$pembanding_kpmr['hasil_tingkat_risiko'], 2) ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= number_format($pembanding_tingkat_risiko, 2) ?></b></center>
                                                            </th>
                                                            <th rowspan="2">
                                                            <div style="max-height:220px; overflow-y:auto; overflow-x:hidden; white-space:normal; text-align:left; padding:8px 10px; line-height:1.5;">
                                                                <b><?= htmlspecialchars((string)$pembanding_tingkat_kualitas_mr, ENT_QUOTES, 'UTF-8') ?></b>
                                                            </div>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#edebe8">
                                                          
                                                            <th>
                                                            <center><b><?= $pembanding_inheren['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_kpmr['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pem_ket_tingkat_risiko ?></b></center>
                                                            </th>
                                                        </tr>


                                                    </tbody>


                                                </table>
                                            </div> <!-- end table-responsive-->
                                    </div>
                                </div>
                            </div>

                            <br></br>
                            <hr></hr>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                               
                                    <thead bgcolor="#ffb3b3">
                                        <tr>
                                            <th width="20%">
                                            <center>Komponen</center>
                                            </th>
                                            <th width="80%">
                                                <center>Analisis Risiko Kepatuhan</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        <tr>
                                            <th>
                                            <center>Tingkat Risiko</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" id="ket_profil_risiko" form="my_form" name="ket_profil_risiko" cols="60" rows="10" <?= ($frame['kunci_laporan'] == 1 ? 'readonly' : '') ?>><?= htmlspecialchars((string)($ket['ket_profil_risiko'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                            <center>Risiko Inheren</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" id="ket_profil_inheren" form="my_form" name="ket_profil_inheren" cols="60" rows="10" readonly><?= htmlspecialchars((string)($ket['ket_profil_inheren'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                            <center>Risiko KPMR</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" id="ket_profil_kpmr" form="my_form" name="ket_profil_kpmr" cols="60" rows="10" readonly><?= htmlspecialchars((string)($ket['ket_profil_kpmr'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>












































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