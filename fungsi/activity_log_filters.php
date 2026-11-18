<?php
function simpro_activity_filters(array $input, array $actor): array
{
    $text = static fn(string $key): string => is_string($input[$key] ?? null) ? trim($input[$key]) : '';
    $filters = ['mulai'=>$text('mulai'), 'sampai'=>$text('sampai'), 'aktivitas'=>$text('aktivitas'), 'cari'=>mb_substr($text('cari'), 0, 100)];
    $actions = ['Login', 'Login gagal', 'Logout', 'Buka halaman', 'Kirim data', 'Permintaan hapus', 'Cetak / unduh', 'Akses AJAX'];
    $where = []; $params = [];
    if (($actor['tipe'] ?? '') !== 'admin') { $where[] = 'user_id = ?'; $params[] = (int)$actor['user_id']; }
    foreach (['mulai'=>'>=', 'sampai'=>'<='] as $key=>$operator) {
        $value = $filters[$key];
        $date = preg_match('/^\d{4}-\d{2}-\d{2}$/D', $value) ? DateTimeImmutable::createFromFormat('!Y-m-d', $value) : false;
        if ($date && $date->format('Y-m-d') === $value) {
            $where[] = "waktu $operator ?"; $params[] = $value.($key === 'mulai' ? ' 00:00:00' : ' 23:59:59');
        } else $filters[$key] = '';
    }
    if (in_array($filters['aktivitas'], $actions, true)) {
        $where[] = 'aktivitas = ?'; $params[] = $filters['aktivitas'];
    } else $filters['aktivitas'] = '';
    if ($filters['cari'] !== '') {
        $where[] = '(LOCATE(?, nama) > 0 OR LOCATE(?, halaman) > 0 OR LOCATE(?, id_data) > 0)';
        array_push($params, ...array_fill(0, 3, $filters['cari']));
    }
    return [$filters, $actions, $where ? ' WHERE '.implode(' AND ', $where) : '', $params];
}
