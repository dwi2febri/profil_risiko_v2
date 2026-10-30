<?php
require_once __DIR__.'/database_security.php';

function simpro_role_folder(string $role): ?string
{
    $roles = ['admin'=>'admin', 'kepala cabang'=>'kepala_cabang', 'admin kc'=>'admin_kc',
        'kepala wilayah semarang'=>'kepala_wilayah_semarang', 'kepala wilayah solo'=>'kepala_wilayah_solo',
        'kepala wilayah banyumas'=>'kepala_wilayah_banyumas', 'kepala wilayah pekalongan'=>'kepala_wilayah_pekalongan',
        'kepala divisi pemasaran'=>'kadiv_pemasaran', 'kepala divisi penyelesaian kredit'=>'kadiv_penyelesaian_kredit',
        'kepala divisi operasional'=>'kadiv_operasional', 'kepala divisi sdm'=>'kadiv_sdm',
        'kepala divisi kepatuhan'=>'kadiv_kepatuhan', 'kepala divisi sekper'=>'kadiv_sekper',
        'kepala divisi litbang'=>'kadiv_litbang', 'kepala divisi skai'=>'satker_skai', 'direksi'=>'direksi',
        'pic semarang'=>'pic_area_semarang', 'pic solo'=>'pic_area_solo',
        'pic pekalongan'=>'pic_area_pekalongan', 'pic banyumas'=>'pic_area_banyumas'];
    return $roles[$role] ?? null;
}

function simpro_authenticate(mysqli $conn, string $username, string $password): ?array
{
    $result = simpro_db_query($conn, 'SELECT * FROM user WHERE username = ? LIMIT 1', [$username]);
    $user = $result ? mysqli_fetch_assoc($result) : null;
    if (!$user || !simpro_role_folder((string)$user['tipe'])) return null;
    $stored = (string)$user['password'];
    $hash = password_get_info($stored);
    $valid = !empty($hash['algo']) ? password_verify($password, $stored) : hash_equals($stored, $password);
    return $valid ? $user : null;
}
