<?php
include "../fungsi/fungsi.php";
include "../conn/conn.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function pg_esc($v){ return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
function pg_num($v){ return (int)max(0, min(100, round((float)$v))); }
function pg_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}
function pg_col_exists($conn, $table, $col){
    if (!pg_table_exists($conn, $table)) return false;
    $table = mysqli_real_escape_string($conn, $table);
    $col = mysqli_real_escape_string($conn, $col);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$col'");
    return $q && mysqli_num_rows($q) > 0;
}
function pg_one($conn, $sql){
    $q = mysqli_query($conn, $sql);
    return ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : [];
}
function pg_rows($conn, $sql){
    $out = [];
    $q = mysqli_query($conn, $sql);
    if ($q) while($r = mysqli_fetch_assoc($q)) $out[] = $r;
    return $out;
}
function pg_clean_key($txt){
    $txt = strtolower(trim((string)$txt));
    $txt = str_replace(['risiko ', 'profil ', 'kantor ', 'cabang '], '', $txt);
    $txt = preg_replace('/[^a-z0-9]+/', '_', $txt);
    return trim($txt, '_');
}
function pg_is_filled($v){
    if ($v === null) return false;
    $s = trim((string)$v);
    if ($s === '') return false;
    $nol = strtolower(str_replace([' ', '\t', '\n', '\r'], '', $s));
    // Nilai default/placeholder tidak dihitung sebagai sudah terisi.
    if (in_array($nol, ['0','0.0','0.00','0,0','0,00','-','--','null','0000-00-00'], true)) return false;
    return true;
}
function pg_percent($filled, $total){
    $total = (int)$total;
    if ($total <= 0) return 0;
    return pg_num(($filled / $total) * 100);
}
function pg_count_table_generic($conn, $table, $id){
    $empty = ['filled'=>0,'total'=>0];
    if ((int)$id <= 0 || !pg_table_exists($conn, $table) || !pg_col_exists($conn, $table, 'id_profil_risiko')) return $empty;
    $id = (int)$id;
    $q = mysqli_query($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='$id' LIMIT 1");
    if (!$q || mysqli_num_rows($q) <= 0) return $empty;
    $row = mysqli_fetch_assoc($q);
    $skip = ['id_profil_risiko','dibuat_by','dibuat_at','created_at','updated_at','created_by','updated_by','tanggal','tgl','waktu'];
    $filled = 0; $total = 0;
    foreach($row as $col => $val){
        $lc = strtolower($col);
        if (in_array($lc, $skip, true)) continue;
        if (preg_match('/^id($|_)/i', $col)) continue;
        if (preg_match('/(^|_)id$/i', $col)) continue;
        $total++;
        if (pg_is_filled($val)) $filled++;
    }
    return ['filled'=>$filled,'total'=>$total];
}
function pg_pct_from_tables($conn, $id, array $tables){
    $filled = 0; $total = 0;
    foreach($tables as $tb){
        $c = pg_count_table_generic($conn, $tb, $id);
        $filled += (int)$c['filled'];
        $total  += (int)$c['total'];
    }
    return pg_percent($filled, $total);
}
function pg_dynamic_assessment_pct($conn, $id, $jenis, $riskName){
    $jenis = strtolower($jenis) === 'kpmr' ? 'kpmr' : 'inheren';
    // FIX CABANG: pada Inheren Kredit/Likuiditas, nilai 0 adalah nilai valid untuk beberapa baris rasio.
    // Jadi 0 jangan otomatis dianggap kosong. Keterangan/catatan tetap wajib jika kolomnya ada.
    $riskUpperRaw = strtoupper(trim((string)$riskName));
    $zeroNilaiValid = ($jenis === 'inheren' && in_array($riskUpperRaw, ['RISIKO KREDIT','RISIKO LIKUIDITAS'], true));
    $main = $jenis === 'kpmr' ? 'assessment_kpmr' : 'assessment_inheren';
    $detail = $jenis === 'kpmr' ? 'assessment_kpmr_detail' : 'assessment_inheren_detail';
    $idcol = $jenis === 'kpmr' ? 'id_assessment_kpmr' : 'id_assessment_inheren';
    if (!pg_table_exists($conn, $main) || !pg_table_exists($conn, $detail)) return null;
    if (!pg_col_exists($conn, $main, 'id_profil_risiko') || !pg_col_exists($conn, $main, 'jenis_risiko')) return null;
    if (!pg_col_exists($conn, $detail, $idcol)) return null;
    $id = (int)$id;
    $risk = mysqli_real_escape_string($conn, strtoupper($riskName));
    $ass = pg_one($conn, "SELECT * FROM `$main` WHERE id_profil_risiko='$id' AND UPPER(jenis_risiko)='$risk' LIMIT 1");
    if (!$ass || empty($ass[$idcol])) return null;
    $aid = (int)$ass[$idcol];
    $q = mysqli_query($conn, "SELECT * FROM `$detail` WHERE `$idcol`='$aid'");
    if (!$q || mysqli_num_rows($q) <= 0) return null;

    /*
      Progress detail dibuat sama dengan rekap progress:
      - nilai default 0/0.00/0,00 tidak dihitung terisi;
      - jika baris detail memiliki kolom keterangan/catatan, kolom tersebut ikut wajib diisi.
      Ini mencegah progress menjadi 100% padahal masih ada 1 keterangan yang kosong.
    */
    $filled = 0;
    $total  = 0;

    while($r = mysqli_fetch_assoc($q)){
        $valueCols = ['nilai','peringkat','hasil','jawaban','skor'];

        /*
          FIX CABANG KREDIT/LIKUIDITAS:
          Pada form Kredit dan Likuiditas ada nilai valid yang memang bisa bernilai 0.
          Sebelumnya angka 0 selalu dianggap kosong, akibatnya Inheren Kredit/Likuiditas
          tetap 80%-an walaupun seluruh isian yang tampil sudah lengkap.

          Aturan baru:
          - keterangan/catatan/uraian tetap wajib dihitung dan tetap harus terisi;
          - nilai 0 boleh dihitung terisi hanya jika baris tersebut punya keterangan/catatan/uraian
            yang sudah terisi. Jadi progress tetap tidak akan 100% kalau masih ada keterangan kosong.
        */
        $hasKetCol = false;
        $hasKetFilled = false;
        foreach(['keterangan','catatan','uraian'] as $ketCol){
            if (array_key_exists($ketCol, $r)) {
                $hasKetCol = true;
                if (pg_is_filled($r[$ketCol])) $hasKetFilled = true;
                break;
            }
        }

        $hasValueCol = false;
        $hasValue = false;
        foreach($valueCols as $col){
            if (array_key_exists($col, $r)) {
                $hasValueCol = true;
                if (pg_is_filled($r[$col])) {
                    $hasValue = true;
                } else {
                    $valRaw = trim((string)$r[$col]);
                    $valNorm = strtolower(str_replace([' ', '\t', '\n', '\r'], '', $valRaw));
                    if (($hasKetFilled || ($zeroNilaiValid && !$hasKetCol)) && in_array($valNorm, ['0','0.0','0.00','0,0','0,00'], true)) {
                        $hasValue = true;
                    }
                }
            }
        }

        if ($hasValueCol) {
            $total++;
            if ($hasValue) $filled++;
        }

        if ($hasKetCol) {
            $total++;
            if ($hasKetFilled) $filled++;
        }
    }

    return pg_percent($filled, $total);
}
function pg_profile_pct($conn, $id, $table, $isDivisi){
    if ((int)$id <= 0 || !pg_table_exists($conn, $table) || !pg_col_exists($conn, $table, 'id_profil_risiko')) return 0;
    $id = (int)$id;
    $row = pg_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='$id' LIMIT 1");
    if (!$row) return 0;

    // Sesuai kebutuhan sebelumnya: jika Analisis Risiko / Uraian profil sudah diisi, profil dianggap selesai.
    $priority = ['ket_profil_inheren','analisis_risiko','analisa_risiko','uraian_risiko','ket_profil_risiko','usulan_perbaikan','ket_respon_cabang','respon_cabang'];
    foreach($priority as $col){
        if (isset($row[$col]) && pg_is_filled($row[$col])) return 100;
    }

    $needed = $isDivisi ? ['ket_profil_inheren','ket_profil_kpmr','ket_profil_risiko'] : ['ket_profil_inheren','ket_profil_risiko'];
    $total = 0; $filled = 0;
    foreach($needed as $col){
        if (array_key_exists($col, $row)) {
            $total++;
            if (pg_is_filled($row[$col])) $filled++;
        }
    }
    if ($total <= 0) {
        $c = pg_count_table_generic($conn, $table, $id);
        return pg_percent($c['filled'], $c['total']);
    }
    return pg_percent($filled, $total);
}
function pg_profile_nilai_pct($conn, $id){
    $pct1 = pg_pct_from_tables($conn, $id, ['nilai_profil']);
    $pct2 = pg_pct_from_tables($conn, $id, ['peringkat_profil']);
    return max($pct1, $pct2);
}


/* =========================================================
   FIX FINAL REKAP CABANG KREDIT/LIKUIDITAS
   Menyamakan hitungan rekap Excel dengan halaman Progress Pengerjaan per-ID:
   - denominator diambil dari checklist parameter yang aktif dan punya skala 1-5 lengkap;
   - jika parameter punya sub-parameter aktif, parent tidak ikut dihitung;
   - nilai terisi dihitung dari assessment_detail nilai 1-5;
   - ini mencegah Inheren Kredit/Likuiditas nyangkut 80%/87% padahal di progress per-ID sudah 100%.
   ========================================================= */
function pg_skala_has_value($conn, $table, $periode_col, $periode_id, $ref_tipe, $ref_id){
    if (!pg_table_exists($conn, $table)) return true;
    $table = mysqli_real_escape_string($conn, $table);
    $periode_col = preg_replace('/[^a-zA-Z0-9_]/', '', (string)$periode_col);
    $periode_id = (int)$periode_id;
    $ref_tipe = mysqli_real_escape_string($conn, (string)$ref_tipe);
    $ref_id = (int)$ref_id;

    $q = mysqli_query($conn, "
        SELECT skala, deskripsi
        FROM `$table`
        WHERE ref_tipe = '$ref_tipe'
          AND ref_id = '$ref_id'
          AND `$periode_col` = '$periode_id'
          AND skala BETWEEN 1 AND 5
    ");
    if (!$q) return true;

    $isi = [];
    while($r = mysqli_fetch_assoc($q)){
        $sk = (int)($r['skala'] ?? 0);
        if ($sk < 1 || $sk > 5) continue;
        $v = trim(strip_tags((string)($r['deskripsi'] ?? '')));
        $v = str_replace(["&nbsp;", "Â ", "\xc2\xa0"], ' ', $v);
        $v = trim($v);
        if ($v !== '' && $v !== '-' && $v !== '–') $isi[$sk] = true;
    }
    for ($i=1; $i<=5; $i++) {
        if (empty($isi[$i])) return false;
    }
    return true;
}

function pg_dynamic_assessment_pct_checklist($conn, $id, $jenis, $nama_risiko){
    $id = (int)$id;
    if ($id <= 0) return null;

    $frame = pg_one($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko='$id' LIMIT 1");
    if (!$frame) return null;

    $jenis = strtolower((string)$jenis);
    $isKpmr = ($jenis === 'kpmr');

    $tblPilih       = $isKpmr ? 'kpmr_pilih_parameter'        : 'pr_pilih_parameter';
    $tblPilihDetail = $isKpmr ? 'kpmr_pilih_parameter_detail' : 'pr_pilih_parameter_detail';
    $tblPeriode     = $isKpmr ? 'kpmr_periode'                : 'pr_inheren_periode';
    $tblJenis       = $isKpmr ? 'kpmr_jenis_risiko'           : 'pr_jenis_risiko';
    $tblPilar       = $isKpmr ? 'kpmr_pilar'                  : 'pr_pilar';
    $tblParameter   = $isKpmr ? 'kpmr_parameter'              : 'pr_parameter';
    $tblSub         = $isKpmr ? 'kpmr_sub_parameter'          : 'pr_sub_parameter';
    $periodeCol     = $isKpmr ? 'kpmr_periode_id'             : 'pr_inheren_periode_id';
    $tblAssess      = $isKpmr ? 'assessment_kpmr'             : 'assessment_inheren';
    $tblDetail      = $isKpmr ? 'assessment_kpmr_detail'      : 'assessment_inheren_detail';
    $idAssessCol    = $isKpmr ? 'id_assessment_kpmr'          : 'id_assessment_inheren';

    foreach ([$tblPilih, $tblPilihDetail, $tblPeriode, $tblJenis, $tblPilar, $tblParameter, $tblAssess, $tblDetail] as $tb) {
        if (!pg_table_exists($conn, $tb)) return null;
    }

    $tahun = mysqli_real_escape_string($conn, (string)($frame['tahun'] ?? ''));
    $user  = (int)($frame['user'] ?? 0);
    if ($tahun === '' || $user <= 0) return null;

    $pilih = pg_one($conn, "
        SELECT pp.*, per.tahun
        FROM `$tblPilih` pp
        INNER JOIN `$tblPeriode` per ON pp.`$periodeCol` = per.id
        WHERE per.tahun = '$tahun'
          AND pp.id_user_profil_risiko = '$user'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilih) return null;

    $idPilih = (int)$pilih['id'];
    $periodeId = (int)$pilih[$periodeCol];

    $fkPilihDetail = $isKpmr ? 'kpmr_pilih_parameter_id' : 'pr_pilih_parameter_id';

    $checkedParam = [];
    $checkedSub   = [];

    $qCek = mysqli_query($conn, "
        SELECT ref_tipe, ref_id
        FROM `$tblPilihDetail`
        WHERE `$fkPilihDetail` = '$idPilih'
    ");
    if ($qCek) {
        while($r = mysqli_fetch_assoc($qCek)){
            if ($r['ref_tipe'] === 'parameter') {
                $checkedParam[(int)$r['ref_id']] = true;
            }
            if ($r['ref_tipe'] === 'sub_parameter') {
                $checkedSub[(int)$r['ref_id']] = true;
            }
        }
    }

    $namaSql = mysqli_real_escape_string($conn, strtoupper((string)$nama_risiko));
    $hasSub = pg_table_exists($conn, $tblSub);

    $qData = mysqli_query($conn, "
        SELECT
            pm.id AS parameter_id,
            ".($hasSub ? "sp.id" : "0")." AS sub_parameter_id
        FROM `$tblJenis` jr
        INNER JOIN `$tblPilar` p
            ON p.jenis_risiko_id = jr.id
           AND p.`$periodeCol` = '$periodeId'
        INNER JOIN `$tblParameter` pm
            ON pm.pilar_id = p.id
           AND pm.`$periodeCol` = '$periodeId'
        ".($hasSub ? "LEFT JOIN `$tblSub` sp ON sp.parameter_id = pm.id AND sp.`$periodeCol` = '$periodeId'" : "")."
        WHERE UPPER(jr.nama_risiko) = '$namaSql'
          AND jr.`$periodeCol` = '$periodeId'
        ORDER BY p.urutan, pm.urutan".($hasSub ? ", sp.urutan" : "")."
    ");
    if (!$qData) return null;

    $rawRows = [];
    $paramHasCheckedSub = [];

    while($r = mysqli_fetch_assoc($qData)){
        $pid = (int)$r['parameter_id'];
        $sid = (int)$r['sub_parameter_id'];

        $rawRows[] = [
            'pid' => $pid,
            'sid' => $sid
        ];

        if ($sid > 0 && isset($checkedSub[$sid])) {
            $paramHasCheckedSub[$pid] = true;
        }
    }

    $expected = [];

    foreach($rawRows as $r){
        $pid = (int)$r['pid'];
        $sid = (int)$r['sid'];

        if (isset($checkedParam[$pid]) && empty($paramHasCheckedSub[$pid])) {
            $expected['parameter|'.$pid] = true;
        }

        if ($sid > 0 && isset($checkedSub[$sid])) {
            $expected['sub_parameter|'.$sid] = true;
        }
    }

    $total = count($expected);
    if ($total <= 0) return null;

    $assessment = pg_one($conn, "
        SELECT *
        FROM `$tblAssess`
        WHERE id_profil_risiko = '$id'
          AND UPPER(jenis_risiko) = '$namaSql'
        LIMIT 1
    ");
    if (!$assessment || empty($assessment[$idAssessCol])) return 0;

    $aid = (int)$assessment[$idAssessCol];

    $filledMap = [];

    $qIsi = mysqli_query($conn, "
        SELECT ref_tipe, ref_id, nilai
        FROM `$tblDetail`
        WHERE `$idAssessCol` = '$aid'
    ");
    if ($qIsi) {
        while($r = mysqli_fetch_assoc($qIsi)){
            $key = $r['ref_tipe'].'|'.(int)$r['ref_id'];
            if (!isset($expected[$key])) continue;

            /*
              FIX UTAMA KREDIT & LIKUIDITAS:
              nilai 0 boleh valid. Yang penting row assessment_detail sudah ada
              dan nilai tidak NULL/kosong.
            */
            if (array_key_exists('nilai', $r) && trim((string)$r['nilai']) !== '') {
                $filledMap[$key] = true;
            }
        }
    }

    return pg_percent(count($filledMap), $total);
}


/* =========================================================
   HITUNGAN INHEREN KREDIT & LIKUIDITAS DISAMAKAN DENGAN SCRIPT KEDUA
   Sumber acuan: progress_pengisian_profil_risiko.php per-ID.
   ========================================================= */
if (!function_exists('pg_progress_script2_inheren_kredit')) {
function pg_progress_script2_inheren_kredit($conn, $id){
    $id = (int)$id;
    if ($id <= 0) return 0;

//inheren kredit
$inheren_kredit1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN hasil_pil1_par1 IS NOT NULL AND TRIM(hasil_pil1_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil1_par1a IS NOT NULL AND TRIM(hasil_pil1_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil1_par1b IS NOT NULL AND TRIM(hasil_pil1_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1c IS NOT NULL AND TRIM(hasil_pil1_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1d IS NOT NULL AND TRIM(hasil_pil1_par1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil1_par1e IS NOT NULL AND TRIM(hasil_pil1_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1f IS NOT NULL AND TRIM(hasil_pil1_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1g IS NOT NULL AND TRIM(hasil_pil1_par1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1h IS NOT NULL AND TRIM(hasil_pil1_par1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2 IS NOT NULL AND TRIM(hasil_pil1_par2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2a IS NOT NULL AND TRIM(hasil_pil1_par2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2b IS NOT NULL AND TRIM(hasil_pil1_par2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2c IS NOT NULL AND TRIM(hasil_pil1_par2c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2d IS NOT NULL AND TRIM(hasil_pil1_par2d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2e IS NOT NULL AND TRIM(hasil_pil1_par2e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2f IS NOT NULL AND TRIM(hasil_pil1_par2f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2g IS NOT NULL AND TRIM(hasil_pil1_par2g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2h IS NOT NULL AND TRIM(hasil_pil1_par2h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2i IS NOT NULL AND TRIM(hasil_pil1_par2i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2j IS NOT NULL AND TRIM(hasil_pil1_par2j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2k IS NOT NULL AND TRIM(hasil_pil1_par2k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par3 IS NOT NULL AND TRIM(hasil_pil1_par3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par4 IS NOT NULL AND TRIM(hasil_pil1_par4) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$ik_pilar1 = $inheren_kredit1['jumlah'];


$inheren_kredit2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN hasil_pil2_par1 IS NOT NULL AND TRIM(hasil_pil2_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil2_par2 IS NOT NULL AND TRIM(hasil_pil2_par2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil2_par2a IS NOT NULL AND TRIM(hasil_pil2_par2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2b IS NOT NULL AND TRIM(hasil_pil2_par2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2c IS NOT NULL AND TRIM(hasil_pil2_par2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil2_par2d IS NOT NULL AND TRIM(hasil_pil2_par2d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2e IS NOT NULL AND TRIM(hasil_pil2_par2e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2f IS NOT NULL AND TRIM(hasil_pil2_par2f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3 IS NOT NULL AND TRIM(hasil_pil2_par3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3a IS NOT NULL AND TRIM(hasil_pil2_par3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3b IS NOT NULL AND TRIM(hasil_pil2_par3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3c IS NOT NULL AND TRIM(hasil_pil2_par3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3d IS NOT NULL AND TRIM(hasil_pil2_par3d) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$ik_pilar2 = $inheren_kredit2['jumlah'];

$inheren_kredit3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1 IS NOT NULL AND TRIM(hasil_pil3_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1a IS NOT NULL AND TRIM(hasil_pil3_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1b IS NOT NULL AND TRIM(hasil_pil3_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1c IS NOT NULL AND TRIM(hasil_pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1d IS NOT NULL AND TRIM(hasil_pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1e IS NOT NULL AND TRIM(hasil_pil3_par1e) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$ik_pilar3 = $inheren_kredit3['jumlah'];

$inheren_kredit4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil4_par1 IS NOT NULL AND TRIM(hasil_pil4_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil4_par1a IS NOT NULL AND TRIM(hasil_pil4_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil4_par1b IS NOT NULL AND TRIM(hasil_pil4_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil4_par1c IS NOT NULL AND TRIM(hasil_pil4_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil4_par1d IS NOT NULL AND TRIM(hasil_pil4_par1d) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$id'"));
$ik_pilar4 = $inheren_kredit4['jumlah'];



$inheren_kredit_lainnya = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1g IS NOT NULL AND TRIM(pilar5_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1h IS NOT NULL AND TRIM(pilar5_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1i IS NOT NULL AND TRIM(pilar5_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1j IS NOT NULL AND TRIM(pilar5_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1k IS NOT NULL AND TRIM(pilar5_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1 IS NOT NULL AND TRIM(hasil_pil5_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1a IS NOT NULL AND TRIM(hasil_pil5_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1b IS NOT NULL AND TRIM(hasil_pil5_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1c IS NOT NULL AND TRIM(hasil_pil5_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1d IS NOT NULL AND TRIM(hasil_pil5_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1e IS NOT NULL AND TRIM(hasil_pil5_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1f IS NOT NULL AND TRIM(hasil_pil5_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1g IS NOT NULL AND TRIM(hasil_pil5_par1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1h IS NOT NULL AND TRIM(hasil_pil5_par1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1i IS NOT NULL AND TRIM(hasil_pil5_par1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1j IS NOT NULL AND TRIM(hasil_pil5_par1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1k IS NOT NULL AND TRIM(hasil_pil5_par1k) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$id'"));
$ik_pilarl = $inheren_kredit_lainnya['jumlah'];

$keterangan_inheren_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren_kredit WHERE id_profil_risiko = '$id'"));
$ik_ket = $keterangan_inheren_kredit['jumlah'];


$inheren_kredit = round((($ik_pilar1 + $ik_pilar2 + $ik_pilar3 + $ik_pilar4 + $ik_pilarl + $ik_ket) / 98) * 100);

    return pg_num($inheren_kredit);
}}

if (!function_exists('pg_progress_script2_inheren_likuiditas')) {
function pg_progress_script2_inheren_likuiditas($conn, $id){
    $id = (int)$id;
    if ($id <= 0) return 0;

//inheren likuiditas
$inheren_likuiditas1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN hasil_pil1_par1 IS NOT NULL AND TRIM(hasil_pil1_par1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN hasil_pil1_par2 IS NOT NULL AND TRIM(hasil_pil1_par2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2a IS NOT NULL AND TRIM(hasil_pil1_par2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2b IS NOT NULL AND TRIM(hasil_pil1_par2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2c IS NOT NULL AND TRIM(hasil_pil1_par2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2d IS NOT NULL AND TRIM(hasil_pil1_par2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2e IS NOT NULL AND TRIM(hasil_pil1_par2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2f IS NOT NULL AND TRIM(hasil_pil1_par2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2g IS NOT NULL AND TRIM(hasil_pil1_par2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2h IS NOT NULL AND TRIM(hasil_pil1_par2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2i IS NOT NULL AND TRIM(hasil_pil1_par2i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3 IS NOT NULL AND TRIM(hasil_pil1_par3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3a IS NOT NULL AND TRIM(hasil_pil1_par3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3b IS NOT NULL AND TRIM(hasil_pil1_par3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3c IS NOT NULL AND TRIM(hasil_pil1_par3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3d IS NOT NULL AND TRIM(hasil_pil1_par3d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5 IS NOT NULL AND TRIM(hasil_pil1_par5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5a IS NOT NULL AND TRIM(hasil_pil1_par5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5b IS NOT NULL AND TRIM(hasil_pil1_par5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5c IS NOT NULL AND TRIM(hasil_pil1_par5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5d IS NOT NULL AND TRIM(hasil_pil1_par5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par4 IS NOT NULL AND TRIM(hasil_pil1_par4) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$ilik_pilar1 = $inheren_likuiditas1['jumlah'];


$inheren_likuiditas2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN hasil_pil2_par1 IS NOT NULL AND TRIM(hasil_pil2_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pil2_par1a IS NOT NULL AND TRIM(pil2_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil2_par1a IS NOT NULL AND TRIM(hasil_pil2_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil2_par1b IS NOT NULL AND TRIM(pil2_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par1b IS NOT NULL AND TRIM(hasil_pil2_par1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pil2_par1c IS NOT NULL AND TRIM(pil2_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par1c IS NOT NULL AND TRIM(hasil_pil2_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil2_par2 IS NOT NULL AND TRIM(pil2_par2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2 IS NOT NULL AND TRIM(hasil_pil2_par2) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko = '$id'"));
$ilik_pilar2 = $inheren_likuiditas2['jumlah'];

$inheren_likuiditas_lainnya = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN hasil_pil3_par1 IS NOT NULL AND TRIM(hasil_pil3_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pil3_par1a IS NOT NULL AND TRIM(pil3_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil3_par1a IS NOT NULL AND TRIM(hasil_pil3_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil3_par1b IS NOT NULL AND TRIM(pil3_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1b IS NOT NULL AND TRIM(hasil_pil3_par1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pil3_par1c IS NOT NULL AND TRIM(pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1c IS NOT NULL AND TRIM(hasil_pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil3_par1d IS NOT NULL AND TRIM(pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1d IS NOT NULL AND TRIM(hasil_pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil3_par1e IS NOT NULL AND TRIM(pil3_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1e IS NOT NULL AND TRIM(hasil_pil3_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil3_par1f IS NOT NULL AND TRIM(pil3_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1f IS NOT NULL AND TRIM(hasil_pil3_par1f) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_likuiditas_lainnya WHERE id_profil_risiko = '$id'"));
$ilik_pilarl = $inheren_likuiditas_lainnya['jumlah'];



$keterangan_inheren_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$ilik_ket = $keterangan_inheren_likuiditas['jumlah'];


$inheren_likuiditas = round((($ilik_pilar1 + $ilik_pilar2 + $ilik_pilarl + $ilik_ket) / 57) * 100);

    return pg_num($inheren_likuiditas);
}}


function pg_risk_progress($conn, $id, $risk, $part, $isDivisi){
    $risk = strtolower($risk);
    $part = strtolower($part);

    $map = [
        'kredit' => [
            'label'=>'Kredit', 'risk_name'=>'RISIKO KREDIT',
            'inheren'=>['inheren_kredit_pilar1','inheren_kredit_pilar2','inheren_kredit_pilar3','inheren_kredit_pilar4','inheren_kredit_lainnya','keterangan_inheren_kredit','hasil_inheren_kredit'],
            'kpmr'=>['kpmr_kredit_pilar1','kpmr_kredit_pilar2','kpmr_kredit_pilar3','kpmr_kredit_pilar4','respon_unit_kerja_kredit_pil1','respon_unit_kerja_kredit_pil2','respon_unit_kerja_kredit_pil3','respon_unit_kerja_kredit_pil4','keterangan_kpmr2_kredit','hasil_kpmr_kredit'],
            'profil'=>'keterangan_profil_kredit'
        ],
        'operasional' => [
            'label'=>'Operasional', 'risk_name'=>'RISIKO OPERASIONAL',
            'inheren'=>['inheren_operasional_pilar1','inheren_operasional_pilar2','inheren_operasional_pilar3','inheren_operasional_pilar4','inheren_operasional_pilar5','inheren_operasional_lainnya','ket_inheren_operasional_pilar1','ket_inheren_operasional_pilar2','ket_inheren_operasional_pilar3','ket_inheren_operasional_pilar4','ket_inheren_operasional_pilar5','ket_inheren_operasional_lainnya','keterangan_inheren2_operasional','hasil_inheren_operasional'],
            'kpmr'=>['kpmr_operasional_pilar1','kpmr_operasional_pilar2','kpmr_operasional_pilar3','kpmr_operasional_pilar4','respon_unit_kerja_operasional_pil1','respon_unit_kerja_operasional_pil2','respon_unit_kerja_operasional_pil3','respon_unit_kerja_operasional_pil4','keterangan_kpmr2_operasional','hasil_kpmr_operasional'],
            'profil'=>'keterangan_profil_operasional'
        ],
        'kepatuhan' => [
            'label'=>'Kepatuhan', 'risk_name'=>'RISIKO KEPATUHAN',
            'inheren'=>['inheren_kepatuhan_pilar1','inheren_kepatuhan_pilar2','inheren_kepatuhan_lainnya','ket_inheren_kepatuhan_pilar1','ket_inheren_kepatuhan_pilar2','ket_inheren_kepatuhan_lainnya','keterangan_inheren2_kepatuhan','hasil_inheren_kepatuhan'],
            'kpmr'=>['kpmr_kepatuhan_pilar1','kpmr_kepatuhan_pilar2','kpmr_kepatuhan_pilar3','kpmr_kepatuhan_pilar4','respon_unit_kerja_kepatuhan_pil1','respon_unit_kerja_kepatuhan_pil2','respon_unit_kerja_kepatuhan_pil3','respon_unit_kerja_kepatuhan_pil4','keterangan_kpmr2_kepatuhan','hasil_kpmr_kepatuhan'],
            'profil'=>'keterangan_profil_kepatuhan'
        ],
        'likuiditas' => [
            'label'=>'Likuiditas', 'risk_name'=>'RISIKO LIKUIDITAS',
            'inheren'=>['master_likuiditas_pilar1','inheren_likuiditas_pilar1','inheren_likuiditas_pilar2','inheren_likuiditas_lainnya','keterangan_inheren_likuiditas','hasil_inheren_likuiditas'],
            'kpmr'=>['kpmr_likuiditas_pilar1','kpmr_likuiditas_pilar2','kpmr_likuiditas_pilar3','kpmr_likuiditas_pilar4','respon_unit_kerja_likuiditas_pil1','respon_unit_kerja_likuiditas_pil2','respon_unit_kerja_likuiditas_pil3','respon_unit_kerja_likuiditas_pil4','keterangan_kpmr2_likuiditas','hasil_kpmr_likuiditas'],
            'profil'=>'keterangan_profil_likuiditas'
        ],
        'reputasi' => [
            'label'=>'Reputasi', 'risk_name'=>'RISIKO REPUTASI',
            'inheren'=>['inheren_reputasi_pilar1','inheren_reputasi_pilar2','inheren_reputasi_pilar3','inheren_reputasi_lainnya','ket_inheren_reputasi_pilar1','ket_inheren_reputasi_pilar2','ket_inheren_reputasi_pilar3','ket_inheren_reputasi_lainnya','keterangan_inheren2_reputasi','hasil_inheren_reputasi'],
            'kpmr'=>['kpmr_reputasi_pilar1','kpmr_reputasi_pilar2','kpmr_reputasi_pilar3','kpmr_reputasi_pilar4','respon_unit_kerja_reputasi_pil1','respon_unit_kerja_reputasi_pil2','respon_unit_kerja_reputasi_pil3','respon_unit_kerja_reputasi_pil4','keterangan_kpmr2_reputasi','hasil_kpmr_reputasi'],
            'profil'=>'keterangan_profil_reputasi'
        ],
        'stratejik' => [
            'label'=>'Stratejik', 'risk_name'=>'RISIKO STRATEJIK',
            'inheren'=>['inheren_stratejik_pilar1','inheren_stratejik_pilar2','inheren_stratejik_pilar3','inheren_stratejik_lainnya','ket_inheren_stratejik_pilar1','ket_inheren_stratejik_pilar2','ket_inheren_stratejik_pilar3','ket_inheren_stratejik_lainnya','keterangan_inheren2_stratejik','hasil_inheren_stratejik'],
            'kpmr'=>['kpmr_stratejik_pilar1','kpmr_stratejik_pilar2','kpmr_stratejik_pilar3','kpmr_stratejik_pilar4','respon_unit_kerja_stratejik_pil1','respon_unit_kerja_stratejik_pil2','respon_unit_kerja_stratejik_pil3','respon_unit_kerja_stratejik_pil4','keterangan_kpmr2_stratejik','hasil_kpmr_stratejik'],
            'profil'=>'keterangan_profil_stratejik'
        ],
    ];

    if (!isset($map[$risk])) return 0;
    // FIX: untuk rekap Profil Risiko Cabang, Inheren Kredit & Likuiditas wajib memakai hitungan yang sama dengan script kedua (progress per-ID).
    // Dengan ini jika halaman progress per-ID sudah 100%, rekap cabang juga ikut 100%.
    if (!$isDivisi && $part === 'inheren' && in_array($risk, ['kredit','likuiditas'], true)) {
        if ($risk === 'kredit') return pg_progress_script2_inheren_kredit($conn, $id);
        if ($risk === 'likuiditas') return pg_progress_script2_inheren_likuiditas($conn, $id);
    }

    if ($part === 'profil') {
        return pg_profile_pct($conn, $id, $map[$risk]['profil'], $isDivisi);
    }

    if ($part === 'kpmr') {
        if (!$isDivisi) return null;

        $legacyPct    = pg_pct_from_tables($conn, $id, $map[$risk]['kpmr'] ?? []);
        $dynChecklist = pg_dynamic_assessment_pct_checklist($conn, $id, 'kpmr', $map[$risk]['risk_name']);
        $dyn          = pg_dynamic_assessment_pct($conn, $id, 'kpmr', $map[$risk]['risk_name']);

        $vals = [pg_num($legacyPct)];
        if ($dynChecklist !== null) $vals[] = pg_num($dynChecklist);
        if ($dyn !== null) $vals[] = pg_num($dyn);

        return max($vals);
    }

    if ($part === 'inheren') {
        $legacyPct    = pg_pct_from_tables($conn, $id, $map[$risk]['inheren'] ?? []);
        $dynChecklist = pg_dynamic_assessment_pct_checklist($conn, $id, 'inheren', $map[$risk]['risk_name']);
        $dyn          = pg_dynamic_assessment_pct($conn, $id, 'inheren', $map[$risk]['risk_name']);

        /*
          FIX FINAL:
          Jangan return dynChecklist dulu, karena itulah penyebab Kredit 80% dan Likuiditas 87%.
          Ambil angka tertinggi dari legacy, checklist, dan assessment detail agar sama dengan
          halaman Progress Pengerjaan per id_profil_risiko.
        */
        $vals = [pg_num($legacyPct)];
        if ($dynChecklist !== null) $vals[] = pg_num($dynChecklist);
        if ($dyn !== null) $vals[] = pg_num($dyn);

        return max($vals);
    }

    return pg_pct_from_tables($conn, $id, $map[$risk][$part] ?? []);
}
function pg_cell($pct){
    if ($pct === null) return '<td class="pg-na">-</td>';
    $pct = pg_num($pct);
    $cls = $pct >= 100 ? 'done' : ($pct >= 50 ? 'warn' : 'bad');
    return '<td class="pg-cell '.$cls.'"><span class="pg-bar" style="width:'.$pct.'%"></span><span class="pg-val">'.$pct.'%</span></td>';
}
function pg_get_latest_frame($conn, $where){
    $sql = "SELECT f.*, jc.cabang, jc.id_cabang, upr.tipe_user
            FROM frame_laporan_profil_risiko f
            LEFT JOIN jenis_cabang jc ON f.kantor_cabang = jc.id_cabang
            LEFT JOIN user_profil_risiko upr ON f.`user` = upr.id_user_profil_risiko
            WHERE $where
            ORDER BY f.id_profil_risiko DESC LIMIT 1";
    return pg_one($conn, $sql);
}

$tahunList = [];
$qTahun = mysqli_query($conn, "SELECT DISTINCT tahun FROM frame_laporan_profil_risiko WHERE tahun IS NOT NULL AND TRIM(tahun)<>'' ORDER BY CAST(tahun AS UNSIGNED) DESC, tahun DESC");
if ($qTahun) while($r = mysqli_fetch_assoc($qTahun)) $tahunList[] = $r['tahun'];
if (!$tahunList) $tahunList[] = date('Y');

$periodeList = pg_rows($conn, "SELECT id_periode, periode_laporan FROM periode_laporan_profil_risiko ORDER BY id_periode ASC");
$selectedTahun = isset($_GET['tahun']) && $_GET['tahun'] !== '' ? trim((string)$_GET['tahun']) : (string)$tahunList[0];
$selectedPeriode = isset($_GET['periode']) ? (int)$_GET['periode'] : 0;
if ($selectedPeriode <= 0 && $periodeList) $selectedPeriode = (int)$periodeList[0]['id_periode'];

$risks = ['kredit'=>'Kredit','operasional'=>'Operasional','kepatuhan'=>'Kepatuhan','likuiditas'=>'Likuiditas','reputasi'=>'Reputasi','stratejik'=>'Stratejik'];
$tahunSql = mysqli_real_escape_string($conn, $selectedTahun);
$periodeSql = (int)$selectedPeriode;
$periodeRow = $periodeSql > 0 ? pg_one($conn, "SELECT periode_laporan FROM periode_laporan_profil_risiko WHERE id_periode='$periodeSql' LIMIT 1") : [];
$periodeLabel = trim((string)($periodeRow['periode_laporan'] ?? ''));
$periodeTitle = $periodeLabel !== '' ? (' - ' . $periodeLabel) : '';

$cabangRows = pg_rows($conn, "SELECT id_cabang, cabang FROM jenis_cabang WHERE id_cabang BETWEEN 1 AND 28 ORDER BY id_cabang ASC");
$divisiCandidates = [
    ['id_user_profil_risiko'=>132, 'tipe_user'=>'Divisi Pemasaran'],
    ['id_user_profil_risiko'=>133, 'tipe_user'=>'Divisi Operasional'],
    ['id_user_profil_risiko'=>134, 'tipe_user'=>'Divisi SDM'],
    ['id_user_profil_risiko'=>135, 'tipe_user'=>'Satker Kepatuhan'],
    ['id_user_profil_risiko'=>136, 'tipe_user'=>'Sekretaris Perusahaan'],
    ['id_user_profil_risiko'=>137, 'tipe_user'=>'Divisi Litbang'],
    ['id_user_profil_risiko'=>140, 'tipe_user'=>'Divisi Penyelesaian Kredit'],
    ['id_user_profil_risiko'=>143, 'tipe_user'=>'SKAI'],
];

/* =========================================================
   CETAK EXCEL REKAP PROGRESS
   Export format Excel XML 2003 (.xls) agar bisa berisi 2 sheet:
   1) Profil Risiko Cabang
   2) Profil Risiko Divisi
   ========================================================= */
function pg_xls_text($v){
    return htmlspecialchars((string)$v, ENT_QUOTES | ENT_XML1, 'UTF-8');
}
function pg_xls_cell($value, $style='Data', $type='String'){
    if ($type === 'Number') {
        $num = is_numeric($value) ? (float)$value : 0;
        return '<Cell ss:StyleID="'.pg_xls_text($style).'"><Data ss:Type="Number">'.$num.'</Data></Cell>';
    }
    return '<Cell ss:StyleID="'.pg_xls_text($style).'"><Data ss:Type="String">'.pg_xls_text($value).'</Data></Cell>';
}
function pg_xls_row($cells, $height=null){
    $h = $height ? ' ss:Height="'.((float)$height).'"' : '';
    return '<Row'.$h.'>'.implode('', $cells).'</Row>';
}
function pg_xls_pct_cell($pct){
    $pct = pg_num($pct);
    $style = $pct >= 100 ? 'PctGreen' : ($pct >= 50 ? 'PctYellow' : 'PctRed');
    return pg_xls_cell($pct.'%', $style, 'String');
}
function pg_xls_worksheet($name, $rows, $colWidths){
    $xml = '<Worksheet ss:Name="'.pg_xls_text(substr($name,0,31)).'"><Table>';
    foreach($colWidths as $w){
        $xml .= '<Column ss:AutoFitWidth="0" ss:Width="'.((float)$w).'"/>';
    }
    $xml .= implode('', $rows);
    $xml .= '</Table></Worksheet>';
    return $xml;
}
function pg_xls_download($filename, $worksheets){
    if (ob_get_level()) { @ob_end_clean(); }
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
    echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';
    echo '<Styles>';
    echo '<Style ss:ID="Title"><Font ss:Bold="1" ss:Size="14"/><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Interior ss:Color="#EAF7FF" ss:Pattern="Solid"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HeaderDark"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#2F3542" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HeaderYellow"><Font ss:Bold="1" ss:Color="#111111"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#FFF200" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HGreen"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#0F8B4C" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HBlue"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#2F69C8" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HPurple"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#6D34B5" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HPink"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#EC1477" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HOrange"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#FFB000" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HNavy"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#17345E" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="HGray"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Interior ss:Color="#6B7280" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="Data"><Alignment ss:Vertical="Center"/><Interior ss:Color="#E2E8F0" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="DataCenter"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Interior ss:Color="#E2E8F0" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="PctGreen"><Font ss:Bold="1"/><Alignment ss:Horizontal="Right" ss:Vertical="Center"/><Interior ss:Color="#86EFAC" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="PctYellow"><Font ss:Bold="1"/><Alignment ss:Horizontal="Right" ss:Vertical="Center"/><Interior ss:Color="#FDE68A" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '<Style ss:ID="PctRed"><Font ss:Bold="1"/><Alignment ss:Horizontal="Right" ss:Vertical="Center"/><Interior ss:Color="#FCA5A5" ss:Pattern="Solid"/><Borders><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
    echo '</Styles>';
    echo implode('', $worksheets);
    echo '</Workbook>';
    exit;
}
function pg_build_excel_cabang_sheet($conn, $cabangRows, $risks, $selectedTahun, $periodeSql, $periodeTitle, $tahunSql){
    $rows = [];
    $rows[] = '<Row><Cell ss:MergeAcross="14" ss:StyleID="Title"><Data ss:Type="String">PROGRESS PENGISIAN PROFIL RISIKO KANTOR CABANG TAHUN '.pg_xls_text($selectedTahun.$periodeTitle).'</Data></Cell></Row>';
    $rows[] = '<Row></Row>';
    $rows[] = '<Row>'.'<Cell ss:MergeDown="1" ss:StyleID="HeaderYellow"><Data ss:Type="String">Kode Cabang</Data></Cell>'.'<Cell ss:MergeDown="1" ss:StyleID="HeaderYellow"><Data ss:Type="String">Nama Cabang</Data></Cell>'.'<Cell ss:MergeAcross="12" ss:StyleID="HeaderDark"><Data ss:Type="String">Profil Risiko Kantor Cabang Tahun '.pg_xls_text($selectedTahun.$periodeTitle).'</Data></Cell>'.'</Row>';
    $riskStyle = ['kredit'=>'HGreen','operasional'=>'HBlue','kepatuhan'=>'HPurple','likuiditas'=>'HPink','reputasi'=>'HOrange','stratejik'=>'HNavy'];
    $cells = [];
    foreach($risks as $rk=>$rl){
        $style = $riskStyle[$rk] ?? 'HeaderDark';
        $cells[] = pg_xls_cell('Inheren '.$rl, $style);
        $cells[] = pg_xls_cell('Profil '.$rl, $style);
    }
    $cells[] = pg_xls_cell('Profil Nilai', 'HGray');
    $rows[] = pg_xls_row($cells, 32);
    foreach($cabangRows as $cb){
        $cid = (int)$cb['id_cabang'];
        $where = "f.kantor_cabang='$cid' AND f.tahun='$tahunSql' AND f.periode='$periodeSql' AND (f.`user`='3' OR UPPER(COALESCE(upr.tipe_user,'')) LIKE '%KANTOR CABANG%' OR UPPER(COALESCE(upr.tipe_user,'')) LIKE '%CABANG%')";
        $fr = pg_get_latest_frame($conn, $where);
        $idp = (int)($fr['id_profil_risiko'] ?? 0);
        $cells = [pg_xls_cell(str_pad((string)$cid, 3, '0', STR_PAD_LEFT), 'DataCenter'), pg_xls_cell($cb['cabang'], 'Data')];
        foreach($risks as $rk=>$rl){
            $cells[] = pg_xls_pct_cell($idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'inheren', false) : 0);
            $cells[] = pg_xls_pct_cell($idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'profil', false) : 0);
        }
        $cells[] = pg_xls_pct_cell($idp > 0 ? pg_profile_nilai_pct($conn, $idp) : 0);
        $rows[] = pg_xls_row($cells);
    }
    return pg_xls_worksheet('Profil Risiko Cabang', $rows, [70,190,75,75,75,75,75,75,75,75,75,75,75,75,75]);
}
function pg_build_excel_divisi_sheet($conn, $divisiCandidates, $risks, $selectedTahun, $periodeSql, $periodeTitle, $tahunSql){
    $rows = [];
    $rows[] = '<Row><Cell ss:MergeAcross="20" ss:StyleID="Title"><Data ss:Type="String">PROGRESS PENGISIAN PROFIL RISIKO DIVISI TAHUN '.pg_xls_text($selectedTahun.$periodeTitle).'</Data></Cell></Row>';
    $rows[] = '<Row></Row>';
    $rows[] = '<Row>'.'<Cell ss:MergeDown="1" ss:StyleID="HeaderYellow"><Data ss:Type="String">Kode</Data></Cell>'.'<Cell ss:MergeDown="1" ss:StyleID="HeaderYellow"><Data ss:Type="String">Nama Divisi / Unit</Data></Cell>'.'<Cell ss:MergeAcross="18" ss:StyleID="HeaderDark"><Data ss:Type="String">Profil Risiko Divisi Tahun '.pg_xls_text($selectedTahun.$periodeTitle).'</Data></Cell>'.'</Row>';
    $riskStyle = ['kredit'=>'HGreen','operasional'=>'HBlue','kepatuhan'=>'HPurple','likuiditas'=>'HPink','reputasi'=>'HOrange','stratejik'=>'HNavy'];
    $cells = [];
    foreach($risks as $rk=>$rl){
        $style = $riskStyle[$rk] ?? 'HeaderDark';
        $cells[] = pg_xls_cell('Inheren '.$rl, $style);
        $cells[] = pg_xls_cell('KPMR '.$rl, $style);
        $cells[] = pg_xls_cell('Profil '.$rl, $style);
    }
    $cells[] = pg_xls_cell('Profil Nilai', 'HGray');
    $rows[] = pg_xls_row($cells, 32);
    foreach($divisiCandidates as $dv){
        $uid = (int)$dv['id_user_profil_risiko'];
        $label = trim((string)$dv['tipe_user']);
        $where = "f.`user`='$uid' AND f.tahun='$tahunSql' AND f.periode='$periodeSql'";
        $fr = pg_get_latest_frame($conn, $where);
        $idp = (int)($fr['id_profil_risiko'] ?? 0);
        if ($idp <= 0 && stripos($label, 'Divisi') !== false) {
            $labelEsc = mysqli_real_escape_string($conn, $label);
            $fr = pg_get_latest_frame($conn, "f.tahun='$tahunSql' AND f.periode='$periodeSql' AND UPPER(COALESCE(upr.tipe_user,''))=UPPER('$labelEsc')");
            $idp = (int)($fr['id_profil_risiko'] ?? 0);
        }
        $cells = [pg_xls_cell($uid, 'DataCenter'), pg_xls_cell($label, 'Data')];
        foreach($risks as $rk=>$rl){
            $cells[] = pg_xls_pct_cell($idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'inheren', true) : 0);
            $cells[] = pg_xls_pct_cell($idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'kpmr', true) : 0);
            $cells[] = pg_xls_pct_cell($idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'profil', true) : 0);
        }
        $cells[] = pg_xls_pct_cell($idp > 0 ? pg_profile_nilai_pct($conn, $idp) : 0);
        $rows[] = pg_xls_row($cells);
    }
    return pg_xls_worksheet('Profil Risiko Divisi', $rows, [70,210,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75,75]);
}

if (isset($_GET['cetak_excel']) && $_GET['cetak_excel'] == '1') {
    $filename = 'progress_pengisian_profil_risiko_'.$selectedTahun.'_periode_'.$selectedPeriode.'_'.date('Ymd_His').'.xls';
    $worksheets = [];
    $worksheets[] = pg_build_excel_cabang_sheet($conn, $cabangRows, $risks, $selectedTahun, $periodeSql, $periodeTitle, $tahunSql);
    $worksheets[] = pg_build_excel_divisi_sheet($conn, $divisiCandidates, $risks, $selectedTahun, $periodeSql, $periodeTitle, $tahunSql);
    pg_xls_download($filename, $worksheets);
}

?>

<div class="content-page">
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <div class="page-title-box">
            <div class="page-title-right">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Simpro</a></li>
                <li class="breadcrumb-item active">Progress Pengisian</li>
              </ol>
            </div>
            <h4 class="page-title">Progress Pengisian Profil Risiko</h4>
          </div>
        </div>
      </div>

      <style>
        .pg-hero{border-radius:22px;background:linear-gradient(135deg,#f7f7ff 0%,#ffffff 44%,#dcfff9 100%);border:1px solid #dbeafe;box-shadow:0 18px 45px rgba(15,23,42,.08);padding:24px 28px;margin-bottom:20px;position:relative;overflow:hidden}.pg-hero:before{content:"";position:absolute;right:-70px;top:-80px;width:240px;height:240px;background:radial-gradient(circle,#21c6b8 0%,rgba(33,198,184,0) 65%);opacity:.32}.pg-kicker{display:inline-flex;padding:8px 14px;border-radius:999px;background:#eef2ff;color:#4f46e5;font-weight:800;font-size:12px;margin-bottom:12px}.pg-title{font-size:24px;font-weight:900;color:#111827;margin:0 0 5px}.pg-sub{font-size:14px;color:#64748b;margin:0}.pg-filter-card{border-radius:18px;background:#fff;border:1px solid #e5e7eb;box-shadow:0 12px 35px rgba(15,23,42,.07);padding:18px 20px;margin-bottom:18px}.pg-filter-card label{font-weight:800;color:#475569;font-size:13px}.pg-filter-card .form-select{border-radius:11px;min-height:42px}.pg-btn{border:0;border-radius:12px;padding:11px 20px;font-weight:900;background:linear-gradient(135deg,#6366f1,#14b8a6);color:#fff;box-shadow:0 9px 20px rgba(99,102,241,.25)}.pg-btn-excel{background:linear-gradient(135deg,#22c55e,#16a34a)!important;color:#fff!important;}.pg-tabs{border:0;background:#f8fafc;border-radius:16px;padding:7px;margin-bottom:16px}.pg-tabs .nav-link{border:0;border-radius:12px;color:#64748b;font-weight:900;padding:11px 18px}.pg-tabs .nav-link.active{background:#6366f1;color:#fff;box-shadow:0 10px 20px rgba(99,102,241,.25)}.pg-table-card{border-radius:22px;background:#fff;border:1px solid #e5e7eb;box-shadow:0 18px 45px rgba(15,23,42,.08);padding:14px;overflow:hidden}.pg-scroll{overflow:auto;max-height:calc(100vh - 310px);border-radius:15px;border:1px solid #dbe3ef}.pg-excel{width:100%;border-collapse:separate;border-spacing:0;font-size:12px;min-width:1680px}.pg-excel th,.pg-excel td{border-right:1px solid #94a3b8;border-bottom:1px solid #94a3b8;padding:7px 8px;vertical-align:middle}.pg-excel thead th{position:sticky;top:0;z-index:4;text-align:center;color:#fff;font-weight:900;text-transform:none;line-height:1.15}.pg-excel .sticky-1{position:sticky;left:0;z-index:5}.pg-excel .sticky-2{position:sticky;left:64px;z-index:5}.pg-excel thead .sticky-1,.pg-excel thead .sticky-2{z-index:7}.pg-code{background:#fff200!important;color:#111!important;min-width:64px;text-align:center;font-weight:900}.pg-name{background:#fff200!important;color:#111!important;min-width:210px;text-align:left!important}.pg-top{background:#2f3542!important;color:#fff!important;font-size:13px}.pg-h-kredit{background:#0f8b4c!important}.pg-h-operasional{background:#2f69c8!important}.pg-h-kepatuhan{background:#6d34b5!important}.pg-h-likuiditas{background:#ec1477!important}.pg-h-reputasi{background:#ffb000!important}.pg-h-stratejik{background:#17345e!important}.pg-h-nilai{background:#6b7280!important}.pg-excel tbody tr:nth-child(even) .pg-name,.pg-excel tbody tr:nth-child(even) .pg-code{background:#e2e8f0!important}.pg-excel tbody tr:hover td{background:#fff7ed}.pg-excel tbody tr:hover .pg-name,.pg-excel tbody tr:hover .pg-code{background:#fef3c7!important}.pg-cell{position:relative;text-align:right;font-weight:900;background:#ecfdf5;min-width:82px;overflow:hidden}.pg-cell .pg-bar{position:absolute;left:0;top:0;bottom:0;background:linear-gradient(90deg,#bbf7d0,#22c55e);z-index:0}.pg-cell .pg-val{position:relative;z-index:1;color:#0f172a}.pg-cell.good .pg-bar{background:linear-gradient(90deg,#d9f99d,#84cc16)}.pg-cell.warn .pg-bar{background:linear-gradient(90deg,#fef3c7,#f59e0b)}.pg-cell.bad .pg-bar{background:linear-gradient(90deg,#fee2e2,#f43f5e)}.pg-cell.done{background:#dcfce7}.pg-na{text-align:center;background:#f1f5f9;color:#94a3b8;font-weight:900}.pg-empty{color:#ef4444;font-weight:900;text-align:center}.pg-summary{display:flex;gap:10px;flex-wrap:wrap;margin-top:12px}.pg-chip{border-radius:999px;background:#f8fafc;border:1px solid #e5e7eb;padding:8px 12px;font-weight:900;color:#475569}.pg-chip b{color:#111827}.pg-table-title{font-weight:900;color:#111827;margin:0 0 10px;font-size:16px}.pg-note{font-size:12px;color:#64748b;margin-top:8px}.pg-status-dot{display:inline-block;width:9px;height:9px;border-radius:50%;margin-right:6px}.dot-ok{background:#22c55e}.dot-warn{background:#f59e0b}.dot-bad{background:#ef4444}@media(max-width:768px){.pg-hero{padding:18px}.pg-title{font-size:19px}.pg-scroll{max-height:none}.pg-filter-card .row>div{margin-bottom:10px}}
      
        /* === FIX REQUEST: sticky header tabel tetap tampil saat scroll === */
        .pg-excel thead tr:first-child th{position:sticky!important;top:0!important;z-index:30!important}
        .pg-excel thead tr:nth-child(2) th{position:sticky!important;top:34px!important;z-index:29!important}
        .pg-excel thead tr:first-child .sticky-1,.pg-excel thead tr:first-child .sticky-2{z-index:35!important}
        .pg-excel thead tr:nth-child(2) .sticky-1,.pg-excel thead tr:nth-child(2) .sticky-2{z-index:34!important}

        /* === FIX REQUEST: kolom Kode Cabang/Nama Cabang tetap kuning, tidak berubah abu-abu saat selang-seling/hover === */
        .pg-code,.pg-name,
        .pg-excel tbody tr:nth-child(even) .pg-name,
        .pg-excel tbody tr:nth-child(even) .pg-code,
        .pg-excel tbody tr:hover .pg-name,
        .pg-excel tbody tr:hover .pg-code{
            background:#fff200!important;
            color:#111!important;
        }
        .pg-excel tbody tr:hover td{background:#f8fafc}

        /* === FIX FINAL: header Kode/Nama Cabang tetap kuning dan header hitam tidak hilang saat scroll === */
        .pg-excel thead th.pg-code,
        .pg-excel thead th.pg-name{
            background:#fff200!important;
            color:#111!important;
        }
        .pg-excel thead tr:first-child th{top:0!important;z-index:40!important;box-shadow:0 2px 0 rgba(15,23,42,.18)}
        .pg-excel thead tr:nth-child(2) th{top:36px!important;z-index:39!important;box-shadow:0 2px 0 rgba(15,23,42,.12)}
        .pg-excel thead tr:first-child .sticky-1,.pg-excel thead tr:first-child .sticky-2{z-index:45!important}
        .pg-excel thead tr:nth-child(2) .sticky-1,.pg-excel thead tr:nth-child(2) .sticky-2{z-index:44!important}


        /* === FIX FINAL USER: header Kode/Nama tetap kuning, baris bawah abu-abu, header hitam tetap sticky === */
        .pg-excel thead th.pg-code,
        .pg-excel thead th.pg-name{
            background:#fff200!important;
            color:#111!important;
        }
        .pg-excel tbody td.pg-code,
        .pg-excel tbody td.pg-name,
        .pg-excel tbody tr:nth-child(even) td.pg-code,
        .pg-excel tbody tr:nth-child(even) td.pg-name,
        .pg-excel tbody tr:hover td.pg-code,
        .pg-excel tbody tr:hover td.pg-name{
            background:#e2e8f0!important;
            color:#111!important;
        }
        .pg-excel thead .pg-top{background:#2f3542!important;color:#fff!important;z-index:50!important;}
        .pg-excel thead tr:first-child th{position:sticky!important;top:0!important;z-index:48!important;}
        .pg-excel thead tr:nth-child(2) th{position:sticky!important;top:36px!important;z-index:47!important;}
        .pg-excel thead tr:first-child th.sticky-1,
        .pg-excel thead tr:first-child th.sticky-2{z-index:60!important;}
        .pg-excel thead tr:nth-child(2) th.sticky-1,
        .pg-excel thead tr:nth-child(2) th.sticky-2{z-index:59!important;}

      </style>

      <div class="pg-hero">
        <span class="pg-kicker">Progress Monitoring Profil Risiko</span>
        <h2 class="pg-title">Progress Pengisian Profil Risiko Tahun <?= pg_esc($selectedTahun) ?><?= $selectedPeriode ? ' - '.pg_esc(pg_one($conn, "SELECT periode_laporan FROM periode_laporan_profil_risiko WHERE id_periode='$periodeSql' LIMIT 1")['periode_laporan'] ?? '') : '' ?></h2>
        <p class="pg-sub">Tampilan rekap seperti Excel dengan filter tahun dan periode. Profil Risiko Cabang tidak menampilkan KPMR, sedangkan Profil Risiko Divisi menampilkan KPMR.</p>
      </div>

      <form method="GET" class="pg-filter-card">
        <input type="hidden" name="page" value="<?= pg_esc($_GET['page'] ?? 'progress_pengisian') ?>">
        <div class="row align-items-end">
          <div class="col-md-3">
            <label>Tahun</label>
            <select name="tahun" class="form-select">
              <?php foreach($tahunList as $th): ?>
                <option value="<?= pg_esc($th) ?>" <?= ((string)$th === (string)$selectedTahun ? 'selected' : '') ?>><?= pg_esc($th) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Periode</label>
            <select name="periode" class="form-select">
              <?php foreach($periodeList as $p): ?>
                <option value="<?= (int)$p['id_periode'] ?>" <?= ((int)$p['id_periode'] === (int)$selectedPeriode ? 'selected' : '') ?>><?= pg_esc($p['periode_laporan']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <button type="submit" class="pg-btn w-100">Tampilkan Progress</button>
          </div>
          <div class="col-md-3">
            <a class="pg-btn pg-btn-excel w-100 d-inline-flex align-items-center justify-content-center text-decoration-none" href="?<?= pg_esc(http_build_query(['page' => ($_GET['page'] ?? 'progress_pengisian'), 'tahun' => $selectedTahun, 'periode' => $selectedPeriode, 'cetak_excel' => 1])) ?>">Cetak Excel</a>
          </div>
        </div>
      </form>

      <ul class="nav nav-tabs pg-tabs" id="pgTabs" role="tablist">
        <li class="nav-item" role="presentation"><button class="nav-link active" id="tab-cabang" data-bs-toggle="tab" data-bs-target="#pane-cabang" type="button" role="tab">Profil Risiko Cabang</button></li>
        <li class="nav-item" role="presentation"><button class="nav-link" id="tab-divisi" data-bs-toggle="tab" data-bs-target="#pane-divisi" type="button" role="tab">Profil Risiko Divisi</button></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade show active" id="pane-cabang" role="tabpanel">
          <div class="pg-table-card">
            <h5 class="pg-table-title">Profil Risiko Kantor Cabang</h5>
            <div class="pg-scroll">
              <table class="pg-excel">
                <thead>
                  <tr><th class="pg-code sticky-1" rowspan="2">Kode<br>Cabang</th><th class="pg-name sticky-2" rowspan="2">Nama Cabang</th><th class="pg-top" colspan="13">Profil Risiko Kantor Cabang Tahun <?= pg_esc($selectedTahun) ?><?= $selectedPeriode ? ' - '.pg_esc(pg_one($conn, "SELECT periode_laporan FROM periode_laporan_profil_risiko WHERE id_periode='$periodeSql' LIMIT 1")['periode_laporan'] ?? '') : '' ?></th></tr>
                  <tr>
                    <?php foreach($risks as $rk=>$rl): ?>
                      <th class="pg-h-<?= pg_esc($rk) ?>">Inheren<br><?= pg_esc($rl) ?></th>
                      <th class="pg-h-<?= pg_esc($rk) ?>">Profil<br><?= pg_esc($rl) ?></th>
                    <?php endforeach; ?>
                    <th class="pg-h-nilai">Profil Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $sumCabang = array_fill_keys(array_keys($risks), 0); $nCabangWithData = 0; foreach($cabangRows as $cb):
                    $cid = (int)$cb['id_cabang'];
                    $where = "f.kantor_cabang='$cid' AND f.tahun='$tahunSql' AND f.periode='$periodeSql' AND (f.`user`='3' OR UPPER(COALESCE(upr.tipe_user,'')) LIKE '%KANTOR CABANG%' OR UPPER(COALESCE(upr.tipe_user,'')) LIKE '%CABANG%')";
                    $fr = pg_get_latest_frame($conn, $where);
                    $idp = (int)($fr['id_profil_risiko'] ?? 0);
                    if ($idp > 0) $nCabangWithData++;
                  ?>
                  <tr>
                    <td class="pg-code sticky-1"><?= str_pad((string)$cid, 3, '0', STR_PAD_LEFT) ?></td>
                    <td class="pg-name sticky-2"><?= pg_esc($cb['cabang']) ?></td>
                    <?php foreach($risks as $rk=>$rl):
                      $pi = $idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'inheren', false) : 0;
                      $pp = $idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'profil', false) : 0;
                      echo pg_cell($pi); echo pg_cell($pp);
                    endforeach; ?>
                    <?= pg_cell($idp > 0 ? pg_profile_nilai_pct($conn, $idp) : 0) ?>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="pg-summary"><span class="pg-chip"><span class="pg-status-dot dot-ok"></span>Hijau: 100%</span><span class="pg-chip"><span class="pg-status-dot dot-warn"></span>Kuning: 50% - 99%</span><span class="pg-chip"><span class="pg-status-dot dot-bad"></span>Merah: di bawah 50%</span><span class="pg-chip">Laporan ditemukan: <b><?= (int)$nCabangWithData ?></b> cabang</span></div>
            <div class="pg-note">Catatan: progress cabang hanya menampilkan Inheren, Profil per risiko, dan Profil Nilai. Kolom KPMR sengaja dihilangkan untuk Profil Risiko Kantor Cabang.</div>
          </div>
        </div>

        <div class="tab-pane fade" id="pane-divisi" role="tabpanel">
          <div class="pg-table-card">
            <h5 class="pg-table-title">Profil Risiko Divisi</h5>
            <div class="pg-scroll">
              <table class="pg-excel">
                <thead>
                  <tr><th class="pg-code sticky-1" rowspan="2">Kode</th><th class="pg-name sticky-2" rowspan="2">Nama Divisi / Unit</th><th class="pg-top" colspan="19">Profil Risiko Divisi Tahun <?= pg_esc($selectedTahun) ?><?= $selectedPeriode ? ' - '.pg_esc(pg_one($conn, "SELECT periode_laporan FROM periode_laporan_profil_risiko WHERE id_periode='$periodeSql' LIMIT 1")['periode_laporan'] ?? '') : '' ?></th></tr>
                  <tr>
                    <?php foreach($risks as $rk=>$rl): ?>
                      <th class="pg-h-<?= pg_esc($rk) ?>">Inheren<br><?= pg_esc($rl) ?></th>
                      <th class="pg-h-<?= pg_esc($rk) ?>">KPMR<br><?= pg_esc($rl) ?></th>
                      <th class="pg-h-<?= pg_esc($rk) ?>">Profil<br><?= pg_esc($rl) ?></th>
                    <?php endforeach; ?>
                    <th class="pg-h-nilai">Profil Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $nDivisiWithData = 0; foreach($divisiCandidates as $dv):
                    $uid = (int)$dv['id_user_profil_risiko'];
                    $label = trim((string)$dv['tipe_user']);
                    $where = "f.`user`='$uid' AND f.tahun='$tahunSql' AND f.periode='$periodeSql'";
                    $fr = pg_get_latest_frame($conn, $where);
                    $idp = (int)($fr['id_profil_risiko'] ?? 0);
                    if ($idp <= 0 && stripos($label, 'Divisi') !== false) {
                        $labelEsc = mysqli_real_escape_string($conn, $label);
                        $fr = pg_get_latest_frame($conn, "f.tahun='$tahunSql' AND f.periode='$periodeSql' AND UPPER(COALESCE(upr.tipe_user,''))=UPPER('$labelEsc')");
                        $idp = (int)($fr['id_profil_risiko'] ?? 0);
                    }
                    if ($idp > 0) $nDivisiWithData++;
                  ?>
                  <tr>
                    <td class="pg-code sticky-1"><?= pg_esc($uid) ?></td>
                    <td class="pg-name sticky-2"><?= pg_esc($label) ?></td>
                    <?php foreach($risks as $rk=>$rl):
                      $pi = $idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'inheren', true) : 0;
                      $pk = $idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'kpmr', true) : 0;
                      $pp = $idp > 0 ? pg_risk_progress($conn, $idp, $rk, 'profil', true) : 0;
                      echo pg_cell($pi); echo pg_cell($pk); echo pg_cell($pp);
                    endforeach; ?>
                    <?= pg_cell($idp > 0 ? pg_profile_nilai_pct($conn, $idp) : 0) ?>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="pg-summary"><span class="pg-chip"><span class="pg-status-dot dot-ok"></span>Hijau: 100%</span><span class="pg-chip"><span class="pg-status-dot dot-warn"></span>Kuning: 50% - 99%</span><span class="pg-chip"><span class="pg-status-dot dot-bad"></span>Merah: di bawah 50%</span><span class="pg-chip">Laporan ditemukan: <b><?= (int)$nDivisiWithData ?></b> divisi/unit</span></div>
            <div class="pg-note">Catatan: progress divisi menampilkan Inheren, KPMR, Profil per risiko, dan Profil Nilai.</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
