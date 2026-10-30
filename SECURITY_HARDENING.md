# Penguatan login dan akses database

Tanggal: 30 Oktober 2026.

## Perubahan

- Halaman login awal memakai URL folder aplikasi, misalnya `/profil_risiko_v2/`.
  Akses GET ke `index.php` dialihkan ke alamat tersebut dengan parameter tetap
  dipertahankan. POST login lama tetap diproses tanpa membuang body request.
- Tombol dari `login.php`, proses `auto_login.php`, dan logout mengarah ke URL
  bersih. Logout menghapus session dan cookie session.
- Login memakai prepared statement untuk pencarian username dan pemeriksaan
  password terpisah. Session ID diperbarui setelah login berhasil. Password lama
  tetap didukung tanpa mengubah data akun; hash standar PHP juga dapat diverifikasi.
- `simpro_db_query()` memisahkan SQL dan nilai menggunakan native MySQLi prepared
  statements. Migrasi mencakup 51.678 call site pada source; paket query/koneksi
  mengubah 2.627 file, dengan pemeriksaan sintaks sebelum penerapan.
  Helper mempertahankan statistik affected rows dan insert ID bagi pemanggil
  lama. Placeholder dipisahkan dari keyword tanpa mengubah literal/komentar SQL;
  agregat progres disesuaikan untuk pemeriksaan ONLY_FULL_GROUP_BY pada prepare.
- Parameter record ID divalidasi dengan allow-list angka, termasuk ID pada bulk
  POST. Nilai teks seperti keterangan tidak diubah atau diperiksa dengan blacklist
  kata SQL; nilai tersebut dikirim sebagai data pada prepared statement.
- Koneksi memakai charset `utf8mb4`. Include koneksi diseragamkan memakai path
  absolut dan endpoint database memerlukan session, kecuali form login awal dan CLI.
- Display error dinonaktifkan pada konfigurasi aplikasi dan koneksi bersama;
  logging tetap aktif. Endpoint yang menulis pesan error sendiri tetap perlu
  ditinjau terpisah saat audit production.
- jQuery/Bootstrap pada controller role memakai bundle lokal sebelum initializer
  halaman. Duplikasi pemuatan vendor dan ekspor DataTables dari CDN dihapus.

## Batas audit

Ini penguatan kode, bukan pernyataan bahwa seluruh aplikasi kebal SQL injection.
Sebanyak 1.019 call site dengan fragmen SQL dinamis dan 105 call site dengan nilai
yang sudah di-escape tidak dikonversi otomatis, untuk mencegah perubahan semantik
dan double escaping. Nama tabel/kolom tidak dapat di-bind sebagai parameter;
query semacam itu perlu memakai pemetaan identifier yang diizinkan.

Pemeriksaan lanjutan terhadap pola dinamis yang memakai assignment langsung dari
GET/POST menemukan dua pola pada helper master kredit: nilai ID sudah di-cast ke
integer dan nama tabel berasal dari konstanta pemanggil. Detail inventaris dan
cadangan kode ada di `.local/sql-security/`, yang tidak dibuka melalui HTTP.

Tidak dilakukan migrasi schema, perubahan akun/password database, ataupun
penggantian password pengguna. Konfigurasi database lama masih memakai akun
`root`; deployment production perlu memakai akun khusus dengan hak minimum yang
sesuai kebutuhan aplikasi. Password pengguna yang masih berupa plaintext juga
perlu migrasi hash tersendiri, bukan hanya perubahan query.

## Pemeriksaan

```text
php tests/sql_security_test.php
node tests/compact_print_browser_test.cjs --security
node tests/compact_print_browser_test.cjs --routes
node tests/monitoring_browser_test.cjs --hasil-kc --rekap
node tests/compact_print_browser_test.cjs --summaries
```

Uji database memakai tabel TEMPORARY untuk SELECT/INSERT/UPDATE/DELETE, tanpa
mengubah tabel pengguna. Payload login dan ID yang mengandung operator SQL,
komentar, UNION, serta input array tidak lolos autentikasi/validasi.

Audit statis 51.678 query hasil konversi tidak menemukan perbedaan jumlah
placeholder dan parameter. Uji login/logout, 52 tautan menu terautentikasi,
alias routing 20 role, serta cetak Inheren/KPMR dan PDF lulus. Pengulangan terakhir
suite monitoring lulus sampai pemeriksaan desktop, rekap KC dan wilayah, lalu
berhenti karena timeout Chrome DevTools; sisa pengulangan responsif tersebut
belum dinyatakan lulus pada run terakhir.

Acuan: [OWASP SQL Injection Prevention](https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html)
dan [PHP MySQLi prepared statements](https://www.php.net/mysqli.prepare.php).
