# Menjalankan aplikasi dengan PHP 8.4

Versi yang diuji: **PHP 8.4.27 x64 Thread Safe**, Apache 2.4, dan MySQL lokal.

Aktifkan ekstensi `mysqli`, `mbstring`, `gd`, `curl`, `intl`, `openssl`, `sodium`,
`pdo_mysql`, `pdo_sqlite`, `sqlite3`, `fileinfo`, `xsl`, dan `zip`.
Sesuaikan koneksi database pada `conn/conn.php` dengan lingkungan tujuan.
Pastikan folder sesi dan unggahan dapat ditulis oleh PHP.

Pada Laragon dengan Apache, pilih paket PHP **Thread Safe**. Konfigurasi Apache,
`extension_dir`, dan PATH harus mengarah ke versi PHP yang sama. DLL dependensi
yang tersalin di folder Apache juga harus sesuai agar `curl` dan `sodium` termuat.
Konfigurasi `.htaccess` saat ini memakai `php_value` untuk Apache dengan mod_php.

Perubahan kompatibilitas mencakup:

- Pemeriksaan jumlah data sebelum pembagian pada analisis tren dashboard.
  Data yang belum cukup ditampilkan sebagai `-`.
- Perbaikan sintaks pada salinan profil likuiditas dan cadangan operasional.
- Konstruktor FPDF lama, penggantian `each()`, pemeriksaan fungsi magic quotes,
  konversi metadata Latin-1 ke UTF-8, dan penanganan PDF tanpa rotasi pada FPDI.
- Parameter escape CSV ditentukan secara eksplisit, mempertahankan perilaku
  impor/ekspor sebelumnya dan menghindari deprecation PHP 8.4.
- Pemeriksaan peran pada endpoint CSV mengikuti peran halaman utama foldernya;
  pemeriksaan sesi admin KC menerima peran `admin kc`.

## Pemeriksaan

Jalankan dari direktori proyek dengan PHP 8.4:

```powershell
python tools/check_php_compatibility.py --php C:\laragon\bin\php\php-8.4.27-Win32-vs17-x64\php.exe
php tests/php84_pdf_test.php admin/laporan/fpdf/fpdf.php
php tests/php84_pdf_test.php admin/laporan/fpdf182/fpdf.php admin/laporan/fpdi
php tests/pembanding_parameter_test.php 543 555
php tests/php84_http_smoke.php
```

Pemeriksaan sintaks mencakup semua file PHP, termasuk salinan yang identik.
Uji PDF mengaktifkan seluruh error dan deprecation untuk pembuatan dokumen,
metadata, gambar, dan impor halaman PDF.

Uji HTTP hanya menargetkan `127.0.0.1`, memakai akun admin dan admin KC yang
sudah tersedia, serta laporan lokal ID 555. Uji pembanding memakai laporan
543 dan 555. Sesuaikan fixture tersebut untuk database lain. Uji CSV mengirim
field yang tidak dikenal sehingga tidak memperbarui master data. Uji HTTP
menjalankan inisialisasi normal halaman pengisian; gunakan database pengujian.

Semua script PHP di `tests/` hanya dapat dijalankan melalui CLI.

Referensi migrasi: [PHP 8.4 deprecated features](https://www.php.net/manual/en/migration84.deprecated.php)
dan [perubahan kompatibilitas](https://www.php.net/manual/en/migration84.incompatible.php).
