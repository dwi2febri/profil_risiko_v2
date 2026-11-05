<?php
/**
 * Read-only counterpart of the dynamic KC profile calculators.
 * Keep rounding, selected parameter hierarchy, formula frame and dynamic method
 * identical to the admin KC profile forms.
 */
// The original form calculations are checked independently by the parity test.
function hasil_kc_source_db_one($conn, $sql){
    static $cache;
    $cache ??= new WeakMap();
    $rows = $cache[$conn] ?? [];
    if (array_key_exists($sql, $rows)) return $rows[$sql];
    $res = mysqli_query($conn, $sql);
    if (!$res) return null;
    $row = mysqli_fetch_assoc($res);
    $rows[$sql] = $row;
    $cache[$conn] = $rows;
    return $row;
}

function hasil_kc_source_table_exists($conn, $table){
    static $cache;
    $cache ??= new WeakMap();
    $tables = $cache[$conn] ?? [];
    if (array_key_exists($table, $tables)) return $tables[$table];
    $name = $table;
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    $tables[$name] = $q && mysqli_num_rows($q) > 0;
    $cache[$conn] = $tables;
    return $tables[$name];
}

function hasil_kc_source_avg($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(array_sum($n)/count($n), 2) : 0;
}

function hasil_kc_source_max($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(max($n), 2) : 0;
}

function hasil_kc_source_min($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(min($n), 2) : 0;
}

function hasil_kc_source_label_inheren($nilai){
    $nilai = (float)$nilai;
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

function hasil_kc_source_label_kpmr($nilai){
    $nilai = (float)$nilai;
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

function hasil_kc_source_fallback_result($conn, $table, $id, $jenis = 'inheren'){
    $emptyRank = ($jenis === 'kpmr') ? '' : '';
    $out = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => $emptyRank];
    if ((int)$id <= 0 || !hasil_kc_source_table_exists($conn, $table)) return $out;
    $row = hasil_kc_source_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    if (!$row) return $out;
    $nilai = 0;
    if (isset($row['hasil_tingkat_risiko'])) $nilai = (float)$row['hasil_tingkat_risiko'];
    elseif (isset($row['tingkat_risiko'])) $nilai = (float)$row['tingkat_risiko'];
    elseif (isset($row['total_nilai'])) $nilai = (float)$row['total_nilai'];
    $rank = '';
    if (isset($row['hasil_peringkat']) && trim((string)$row['hasil_peringkat']) !== '') $rank = trim((string)$row['hasil_peringkat']);
    elseif (isset($row['peringkat']) && trim((string)$row['peringkat']) !== '') $rank = trim((string)$row['peringkat']);
    else $rank = ($jenis === 'kpmr') ? hasil_kc_source_label_kpmr($nilai) : hasil_kc_source_label_inheren($nilai);
    return ['hasil_tingkat_risiko' => round($nilai, 2), 'hasil_peringkat' => $rank];
}

function hasil_kc_source_find_frame_perumusan($conn, $frame){
    if (!$frame || !hasil_kc_source_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = hasil_kc_source_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }
    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';
    return hasil_kc_source_db_one($conn, "
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

function hasil_kc_source_risk_mode_label($riskRow){
    if (!$riskRow) return 'Perskalaan';
    if ((int)($riskRow['pembobotan'] ?? 0) === 1) return 'Pembobotan';
    return 'Perskalaan';
}

function hasil_kc_source_pilar_perumusan_map($conn, $table, $fk, $id){
    $map = [];
    if ((int)$id <= 0 || !hasil_kc_source_table_exists($conn, $table)) return $map;
    $q = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$fk`='".(int)$id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){ $map[(int)$r['id_pilar']] = $r; }
    }
    return $map;
}

function hasil_kc_source_dynamic_method($conn, $table, $id){
    if ((int)$id <= 0 || !hasil_kc_source_table_exists($conn, $table)) return 'rata_rata';
    $row = hasil_kc_source_db_one($conn, "SELECT metode FROM `$table` WHERE id_profil_risiko='".(int)$id."' AND scope_type='risiko' AND scope_ref_id='0' LIMIT 1");
    $metode = trim((string)($row['metode'] ?? 'rata_rata'));
    if (!in_array($metode, ['tertinggi','terendah','rata_rata'])) $metode = 'rata_rata';
    return $metode;
}

function hasil_kc_source_inherent_result(mysqli $conn, int $id, string $risk): array
{
    if ($risk !== 'likuiditas') {
        $result = hasil_kc_source_dynamic_result($conn, $id, $risk);
        $result['_source'] ??= 'Hasil inheren - Profil KC';
        return $result;
    }
    $result = ['hasil_tingkat_risiko'=>0.0, 'hasil_peringkat'=>'', '_source'=>'Hasil inheren - Profil KC'];
    if ($id <= 0 || !hasil_kc_source_table_exists($conn, 'hasil_inheren_likuiditas')) return $result;
    $row = hasil_kc_source_db_one($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko='$id' LIMIT 1") ?? [];
    foreach (['hasil_tingkat_risiko','tingkat_risiko','hasil_kpmr','hasil_penilaian_kpmr','nilai_kpmr','total_nilai','hasil_rata_rata','rata_rata','nilai'] as $key) {
        if (isset($row[$key]) && trim((string)$row[$key]) !== '') {
            $result['hasil_tingkat_risiko'] = (float)str_replace(',', '.', (string)$row[$key]);
            if ($result['hasil_tingkat_risiko'] > 0) break;
        }
    }
    foreach (['hasil_peringkat','peringkat','predikat','hasil_predikat','ket_tingkat_risiko'] as $key) {
        if (isset($row[$key]) && trim((string)$row[$key]) !== '') { $result['hasil_peringkat'] = trim((string)$row[$key]); break; }
    }
    if ($result['hasil_peringkat'] === '') $result['hasil_peringkat'] = hasil_kc_source_label_inheren($result['hasil_tingkat_risiko']);
    $result['hasil_tingkat_risiko'] = round($result['hasil_tingkat_risiko'], 2);
    return $result;
}

function hasil_kc_source_dynamic_result($conn, $id, string $risk){
    if (!in_array($risk, ['kredit','operasional','kepatuhan','reputasi','stratejik'], true)) throw new InvalidArgumentException('Unsupported inherent risk');
    $riskName = 'RISIKO ' . strtoupper($risk);
    $fallback = hasil_kc_source_fallback_result($conn, 'hasil_inheren_' . $risk, $id, 'inheren');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_inheren','assessment_inheren_detail','pr_pilih_parameter','pr_pilih_parameter_detail','pr_inheren_periode','pr_jenis_risiko','pr_pilar','pr_parameter'];
    foreach($needed as $tb){ if (!hasil_kc_source_table_exists($conn, $tb)) return $fallback; }

    $frame = hasil_kc_source_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = hasil_kc_source_db_one($conn, "SELECT * FROM assessment_inheren WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='$riskName' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment['id_assessment_inheren']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = hasil_kc_source_db_one($conn, "
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
    $hasSub = hasil_kc_source_table_exists($conn, 'pr_sub_parameter');
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
        WHERE jr.nama_risiko = '$riskName'
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

    $framePerumusan = hasil_kc_source_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && hasil_kc_source_table_exists($conn, 'perumusan_inheren')) {
        if ($risk === 'operasional') {
        $riskPerumusan = hasil_kc_source_db_one($conn, "SELECT * FROM perumusan_inheren WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(TRIM(nama_risiko))=UPPER('$riskName') ORDER BY id_perumusan_inheren DESC LIMIT 1");
        } else {
        $riskPerumusan = hasil_kc_source_db_one($conn, "SELECT * FROM perumusan_inheren WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('$riskName') LIMIT 1");
        }
    }
    $pilarPerumusanMap = $riskPerumusan ? hasil_kc_source_pilar_perumusan_map($conn, 'perumusan_inheren_pilar', 'id_perumusan_inheren', (int)$riskPerumusan['id_perumusan_inheren']) : [];
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
            $nilaiParam = count($parameter['subs']) > 0 ? hasil_kc_source_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = hasil_kc_source_max($parameterScores);
        $statMin = hasil_kc_source_min($parameterScores);
        $statAvg = hasil_kc_source_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = hasil_kc_source_risk_mode_label($riskPerumusan);
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

    $overallMode = hasil_kc_source_risk_mode_label($riskPerumusan);
    $overallMax = hasil_kc_source_max($rekapPilar);
    $overallMin = hasil_kc_source_min($rekapPilar);
    $overallAvg = hasil_kc_source_avg($rekapPilar);
    $overallMethod = hasil_kc_source_dynamic_method($conn, 'inheren2_' . $risk . '_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => hasil_kc_source_label_inheren($overallNilai), '_source'=>'Perhitungan Profil KC dari parameter terpilih'];
}
