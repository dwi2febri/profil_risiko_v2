<?php
/** Read-only weights and composite calculation matching the KC Profile Value page. */
function hasil_kc_weight_column_exists(mysqli $db, string $table, string $column): bool
{
    static $cache;
    $cache ??= new WeakMap();
    $columns = $cache[$db] ?? [];
    $key = $table . '|' . $column;
    if (array_key_exists($key, $columns)) return $columns[$key];
    if (!hasil_kc_source_table_exists($db, $table)) return false;
    $table = mysqli_real_escape_string($db, $table);
    $column = mysqli_real_escape_string($db, $column);
    $query = mysqli_query($db, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    $columns[$key] = $query && mysqli_num_rows($query) > 0;
    $cache[$db] = $columns;
    return $columns[$key];
}
function hasil_kc_weight_query(mysqli $db, string $sql, string $label = '')
{
    return mysqli_query($db, $sql);
}
function hasil_kc_weights($conn, $tahun_frame, $user_profil = 0){
    $default = [
        'kredit' => 30.00,
        'operasional' => 30.00,
        'kepatuhan' => 20.00,
        'likuiditas' => 10.00,
        'reputasi' => 5.00,
        'stratejik' => 5.00,
    ];

    $info = [
        'tahun' => $tahun_frame,
        'aktif' => false,
        'total' => 100.00,
        'bobot' => $default,
        'id_setting' => 0,
        'user' => (int)$user_profil,
        'source' => 'default'
    ];

    if (!hasil_kc_source_table_exists($conn, 'setting_bobot_profil_risiko') || !hasil_kc_source_table_exists($conn, 'setting_bobot_profil_risiko_detail')) {
        return $info;
    }

    $tahun = mysqli_real_escape_string($conn, (string)$tahun_frame);
    $userProfil = (int)$user_profil;

    // FIX: Profil Nilai harus memakai bobot sesuai settingan user profil risiko yang sedang dibuka.
    // Sebelumnya query hanya mengambil setting aktif global, sehingga untuk user=3 (Profil Risiko Kantor Cabang)
    // bisa salah mengambil bobot milik SKMR/user lain.
    $userCol = '';
    foreach (['user','user_id','id_user_profil_risiko','id_user'] as $c) {
        if (hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko', $c)) { $userCol = $c; break; }
    }

    $aktifCol = '';
    foreach (['is_aktif','is_active','aktif'] as $c) {
        if (hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko', $c)) { $aktifCol = $c; break; }
    }

    $idCol = 'id_setting';
    if (!hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko', $idCol)) {
        foreach (['id','id_bobot_profil','id_frame_bobot_profil'] as $c) {
            if (hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko', $c)) { $idCol = $c; break; }
        }
    }

    $order = "ORDER BY `$idCol` DESC LIMIT 1";
    $head = [];

    // 1) Prioritas utama: tahun + user yang sama + aktif.
    if ($userCol !== '' && $userProfil > 0 && $aktifCol !== '') {
        $head = hasil_kc_source_db_one($conn, "
            SELECT *
            FROM setting_bobot_profil_risiko
            WHERE tahun = '$tahun'
              AND `$userCol` = '$userProfil'
              AND `$aktifCol` = '1'
            $order
        ", 'READ BOBOT AKTIF TAHUN USER');
    }

    // 2) Fallback: tahun + user yang sama, walaupun belum aktif.
    if (!$head && $userCol !== '' && $userProfil > 0) {
        $head = hasil_kc_source_db_one($conn, "
            SELECT *
            FROM setting_bobot_profil_risiko
            WHERE tahun = '$tahun'
              AND `$userCol` = '$userProfil'
            $order
        ", 'READ BOBOT TAHUN USER');
    }

    // 3) Fallback lama: aktif global pada tahun yang sama.
    if (!$head && $aktifCol !== '') {
        $head = hasil_kc_source_db_one($conn, "
            SELECT *
            FROM setting_bobot_profil_risiko
            WHERE tahun = '$tahun'
              AND `$aktifCol` = '1'
            $order
        ", 'READ BOBOT AKTIF TAHUN GLOBAL');
    }

    // 4) Fallback lama: setting tahun terakhir.
    if (!$head) {
        $head = hasil_kc_source_db_one($conn, "
            SELECT *
            FROM setting_bobot_profil_risiko
            WHERE tahun = '$tahun'
            $order
        ", 'READ BOBOT TAHUN GLOBAL');
    }

    if (!$head) return $info;

    $idSetting = (int)($head[$idCol] ?? 0);
    if ($idSetting <= 0) return $info;

    $map = $default;

    $detailFk = 'id_setting';
    if (!hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko_detail', $detailFk)) {
        foreach (['setting_id','id_bobot_profil','id_frame_bobot_profil'] as $c) {
            if (hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko_detail', $c)) { $detailFk = $c; break; }
        }
    }

    $jenisCol = 'jenis_risiko';
    foreach (['jenis_risiko','nama_risiko','risiko'] as $c) {
        if (hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko_detail', $c)) { $jenisCol = $c; break; }
    }

    $bobotCol = 'bobot';
    foreach (['bobot','bobot_penetapan','bobot_penetapan_persen','bobot_persen','nilai_bobot'] as $c) {
        if (hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko_detail', $c)) { $bobotCol = $c; break; }
    }

    $q = hasil_kc_weight_query($conn, "
        SELECT *
        FROM setting_bobot_profil_risiko_detail
        WHERE `$detailFk` = '$idSetting'
        ORDER BY ".(hasil_kc_weight_column_exists($conn, 'setting_bobot_profil_risiko_detail', 'urutan') ? 'urutan ASC,' : '')." id_detail ASC
    ", 'READ DETAIL BOBOT PROFIL USER');

    while($r = mysqli_fetch_assoc($q)){
        $nama = strtolower(trim((string)($r[$jenisCol] ?? '')));
        $key = '';
        if (strpos($nama, 'kredit') !== false) $key = 'kredit';
        elseif (strpos($nama, 'operasional') !== false) $key = 'operasional';
        elseif (strpos($nama, 'kepatuhan') !== false) $key = 'kepatuhan';
        elseif (strpos($nama, 'likuiditas') !== false) $key = 'likuiditas';
        elseif (strpos($nama, 'reputasi') !== false) $key = 'reputasi';
        elseif (strpos($nama, 'stratejik') !== false || strpos($nama, 'strategik') !== false) $key = 'stratejik';
        if ($key !== '') $map[$key] = (float)str_replace(',', '.', (string)($r[$bobotCol] ?? 0));
    }

    $info['tahun'] = $head['tahun'] ?? $tahun_frame;
    $info['aktif'] = ($aktifCol !== '' && (int)($head[$aktifCol] ?? 0) === 1);
    $info['total'] = array_sum($map);
    $info['bobot'] = $map;
    $info['id_setting'] = $idSetting;
    $info['user'] = ($userCol !== '') ? (int)($head[$userCol] ?? 0) : 0;
    $info['source'] = 'setting_bobot_profil_risiko';
    return $info;
}

/** Preserve the profile's denominator and final rounding; never renormalize available risks. */
function hasil_kc_composite(array $risks, array $weights): array
{
    $total = 0.0; $missing = [];
    foreach ($weights as $risk=>$weight) {
        $value = $risks[$risk]['_profile_score'] ?? $risks[$risk]['hasil_tingkat_risiko'] ?? null;
        if (!hasil_kc_valid_score($value) && (float)$weight != 0.0) $missing[] = $risk;
        $total += (float)($value ?? 0) * (float)$weight / 100;
    }
    $total = round($total, 2);
    $label = match (true) {
        $total < 1 || $total > 5 => '',
        $total < 1.25 => 'Sangat Rendah',
        $total < 2.25 => 'Rendah',
        $total < 3.25 => 'Sedang',
        $total < 4.25 => 'Tinggi',
        default => 'Sangat Tinggi',
    };
    return ['total_nilai'=>number_format($total,2,'.',''), 'ket_total_nilai'=>$label,
        '_source'=>'Profil Nilai KC - bobot inheren', '_missing'=>$missing];
}
