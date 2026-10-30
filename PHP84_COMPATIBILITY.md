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
- Dashboard dan rekap cabang/divisi menangani hasil query serta data pembanding
  yang kosong. Nilai yang belum tersedia ditampilkan sebagai `-`; nilai nol
  yang tersimpan tetap ditampilkan. Filter angka dinormalisasi sebelum digunakan
  dalam perhitungan, dan data grafik yang kosong dikirim sebagai JSON `null`.
- Format angka pada dashboard wilayah memeriksa nilai `null` sebelum memanggil
  `number_format()`, termasuk hasil agregasi untuk periode tanpa laporan.
- Query tren yang menggabungkan 14 tabel memakai `SELECT STRAIGHT_JOIN` agar
  perencanaan urutan join tidak menyebabkan halaman menunggu lama.
- Pencarian tren mempertahankan filter antarformulir dan memakai `LEFT JOIN`
  untuk bagian laporan yang opsional. Periode laporan tetap tampil meskipun
  sebagian parameter belum diisi. Jenis profil tanpa laporan diberi keterangan
  beserta pilihan jenis profil yang tersedia untuk kantor dan rentang yang sama.
- Perhitungan slope menggunakan angka (`round()`), sehingga nilai besar tidak
  berubah menjadi string dengan pemisah ribuan sebelum dihitung kembali.
- Formulir inheren kredit dan likuiditas KC memakai pembagian aman untuk data
  master yang masih kosong atau bernilai nol, termasuk pembanding pertumbuhan.
  Perhitungan antara yang sebelumnya tidak dibulatkan tetap memakai presisi
  aslinya. Kasus ini sebelumnya menyebabkan halaman kosong pada PHP 8.4.
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
php tests/php84_reporting_test.php pic_area_solo/home.php empty
php tests/php84_reporting_test.php pic_area_solo/laporan/rekap_cabang.php missing
php tests/php84_reporting_test.php admin/laporan/hasil_laporan_cabang.php populated
php tests/php84_reporting_test.php admin/laporan/rekap_divisi.php empty
php tests/php84_reporting_test.php admin/home.php trend
php tests/php84_reporting_test.php pic_area_solo/tren.php trend
php tests/inheren_ratio_test.php
php tests/kc_inheren_http_test.php 610
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

Uji `php84_reporting_test.php` hanya membaca database. Argumen pertama memilih
template dashboard/rekap; argumen kedua menerima `empty` (tanpa filter),
`missing` (periode tanpa laporan), atau `populated` (laporan cabang lokal yang
tersedia). Uji ini menangkap warning, notice, deprecation, dan exception meskipun
template menonaktifkan pelaporan error. Dibutuhkan akun lokal untuk role folder
yang diuji. Argumen ketiga opsional menyimpan HTML hasil render untuk pemeriksaan
grafik. Sesi uji memakai direktori sementara dan dihapus setelah render.

Skenario `trend` memilih laporan lokal yang tersedia, mengisi filter rentang
triwulan, lalu memeriksa bahwa kolom periode dan nilai kredit hasil render sesuai
dengan laporan di database, termasuk saat tabel parameter lainnya belum lengkap.

Uji `inheren_ratio_test.php` tidak mengakses database. Uji
`kc_inheren_http_test.php` membuka halaman KC melalui HTTP lokal sebagai admin
dan admin KC dengan ID laporan cabang pada argumen pertama. Uji ini menjalankan
inisialisasi normal formulir, termasuk pembuatan baris awal jika belum tersedia.

Referensi migrasi: [PHP 8.4 deprecated features](https://www.php.net/manual/en/migration84.deprecated.php)
dan [perubahan kompatibilitas](https://www.php.net/manual/en/migration84.incompatible.php).
