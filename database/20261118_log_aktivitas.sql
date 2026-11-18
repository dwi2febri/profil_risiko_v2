-- Jalankan pada database aplikasi sebelum menggunakan menu Log Aktivitas.
-- Tidak mengubah tabel user atau data laporan. Waktu log memakai Asia/Jakarta.
CREATE TABLE IF NOT EXISTS log_aktivitas (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    waktu DATETIME NOT NULL,
    user_id BIGINT NULL,
    username VARCHAR(191) NOT NULL DEFAULT '',
    nama VARCHAR(191) NOT NULL DEFAULT '',
    role VARCHAR(100) NOT NULL DEFAULT '',
    aktivitas VARCHAR(50) NOT NULL,
    halaman VARCHAR(512) NOT NULL DEFAULT '',
    id_data VARCHAR(100) NOT NULL DEFAULT '',
    metode VARCHAR(10) NOT NULL,
    status_http SMALLINT UNSIGNED NOT NULL,
    alamat_ip VARCHAR(45) NOT NULL DEFAULT '',
    PRIMARY KEY (id),
    KEY idx_log_waktu (waktu, id),
    KEY idx_log_user_waktu (user_id, waktu, id),
    KEY idx_log_aktivitas_waktu (aktivitas, waktu)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
