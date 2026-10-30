# Route halaman

Setiap role tetap memakai `index.php` sebagai controller dan tetap menjalankan
pemeriksaan session serta hak akses yang sudah ada. Apache `mod_rewrite`
memetakan URL baru ke controller tersebut; tidak ada include file dari path URL.

Contoh untuk role `admin`:

| URL lama | URL baru |
| --- | --- |
| `index.php?page=dashboard` | `dashboard` |
| `index.php?page=dashboard_monitoring` | `dashboard_monitoring` |
| `index.php?page=menulapawal` | `laporan/` |
| `index.php?page=pembanding` | `pembanding/` |
| `index.php?page=menulapawal&id=556&tab=final` | `laporan/556/final` |
| `index.php?page=hasil_lapkc&tahun=2026&periode=2` | `hasil_lapkc?tahun=2026&periode=2` |
| `index.php?page=kre_inhern&id=545` | `kre_inhern?id=545` |

Aturan yang sama berlaku pada 20 folder role. Folder dan file PHP yang diakses
langsung, termasuk endpoint API dan cetak, tetap didukung. Link lama memakai
redirect sementara 302 agar bookmark tetap bekerja tanpa menyimpan redirect
permanen di browser. Redirect kanonis tidak dijalankan untuk POST atau XHR.

## Implementasi

- `.htaccess`: pemetaan alias ke controller role yang sudah ada.
- `fungsi/pretty_routes.php`: membaca alias sebagai parameter GET, membuat URL
  kanonis, dan menjaga redirect relatif tetap menuju lokasi yang benar.
- `assets/js/pretty-routes.js`: mengubah tautan menu lama, membaca page dari path,
  dan mempertahankan parameter id/tab untuk tab laporan.
- `<base>` pada controller role menjaga aset, action form, dan tautan relatif
  tetap mengacu pada folder role meskipun URL laporan bertingkat.

Nomor laporan dan tab dimasukkan ke path khusus halaman laporan. Parameter filter
lain tetap menggunakan query string. Nama page internal tetap sama sehingga
switch controller tidak perlu diubah.

## Pemeriksaan

```text
php tests/pretty_routes_test.php
node tests/pretty_routes_http_test.cjs
node tests/compact_print_browser_test.cjs --routes
node tests/monitoring_browser_test.cjs
node tests/compact_print_browser_test.cjs --summaries
```

Pastikan `mod_rewrite` dan izin membaca `.htaccess` aktif saat aplikasi dipindahkan
ke server Apache lain. URL diturunkan dari folder aplikasi, sehingga tidak
bergantung pada nama `profil_risiko_v2` atau host `localhost`.

Folder fisik `laporan/` dan `pembanding/` mempertahankan garis miring terakhir
agar kanonisasi Apache dan aplikasi tidak saling mengarahkan kembali.

## Production Nginx / aaPanel

Nginx memerlukan aturan tersendiri; aturan Apache dalam `.htaccess` tidak
dijalankan oleh Nginx. Untuk aplikasi pada root domain `simpro.bkkjateng.co.id`:

1. Pastikan `/www/wwwroot/simpro.bkkjateng.co.id/admin/index.php` ada, bersama
   folder `fungsi/`, `assets/`, dan role lain. Konfigurasi ini untuk root domain,
   bukan aplikasi di subfolder `/profil_risiko_v2/`.
2. Buka **Website > simpro.bkkjateng.co.id > URL Rewrite** di aaPanel. Simpan
   cadangan aturan lama, lalu isi dengan `deploy/nginx-aapanel-rewrite.conf`.
   Jangan membungkusnya lagi dengan `server {}` dan jangan menambah `location /`
   atau handler PHP lain. Include `enable-php-84.conf` yang ada tetap dipakai.
3. Simpan aturan tersebut ke file rewrite yang sudah di-include oleh vhost:
   `/www/server/panel/vhost/rewrite/simpro.bkkjateng.co.id.conf`.
4. Cek konfigurasi dan reload melalui terminal server:

   ```sh
   /www/server/nginx/sbin/nginx -t
   /www/server/nginx/sbin/nginx -s reload
   ```

   Jalankan reload hanya setelah pemeriksaan pertama berhasil.
5. Buka `/admin/dashboard_monitoring`, `/admin/laporan/`,
   `/admin/laporan/556/final`, serta halaman dengan filter seperti
   `/admin/hasil_lapkc?tahun=2026&periode=2`. Sebelum login, pengalihan ke login
   adalah normal; 404 bawaan Nginx pada route tersebut tidak normal.

Aturan rewrite diterapkan secara internal dengan `last`, tanpa menambahkan
`?page=` atau redirect baru. PHP membaca alias dari `REQUEST_URI`; query filter
tetap dipertahankan. Endpoint PHP dan aset fisik tetap dilayani seperti biasa.
Folder lokal pengujian juga ditutup secara eksplisit, karena perlindungan
`.local/.htaccess` tidak berlaku pada Nginx. Jangan mengunggah cadangan database
atau artefak lokal ke document root production.

Konfigurasi production perlu diuji di Nginx server tujuan; lingkungan lokal
pengembangan memakai Apache.

### Diagnosis halaman laporan kosong

Aturan deployment juga sudah diperiksa memakai Nginx 1.29.4 lokal dengan handler
PHP tiruan: `/admin/laporan/`, `/admin/laporan/556/final`, route monitoring,
filter query, serta endpoint cetak diteruskan ke controller/path yang benar.
Ini memverifikasi rewrite, bukan eksekusi PHP/database pada production.

Jika halaman tetap kosong setelah aturan terpasang, buka URL dari browser yang
sudah login, kemudian periksa pesan baru di:

```sh
tail -n 60 /www/wwwlogs/simpro.bkkjateng.co.id.error.log
```

Baris `PHP Fatal error`, `Uncaught`, atau `upstream` menentukan apakah masalahnya
berasal dari PHP, database, FastCGI, atau konfigurasi vhost. Jika log Nginx kosong,
periksa juga error log PHP 8.4 di aaPanel. Status HTTP dan header `Content-Type`
di Network browser membantu membedakan respons kosong, error 500, redirect
berulang, dan dokumen yang dikirim dengan tipe konten keliru. Jangan mengubah
handler FastCGI atau rewrite lagi tanpa membandingkan bukti tersebut.

### Parse error `unexpected identifier "version"` pada menu laporan

Log production 30 Oktober 2026 menunjukkan `menu_laporan_awal.php` baris 2796
berhenti pada deklarasi XML ekspor Excel di dalam JavaScript. Masalah yang sama
berhasil direproduksi dengan `php -d short_open_tag=1 -l` pada source sebelum
perbaikan. Teks pembuka deklarasi kini memakai escape JavaScript `\x3c?xml`
dan `\x3c?mso-application`, sehingga PHP tidak menganggapnya pembuka short tag.
XML yang dihasilkan browser tetap identik.

Unggah ulang `*/laporan/menu_laporan_awal.php` yang diperbaiki (16 folder role),
terutama `admin/laporan/menu_laporan_awal.php`, ke lokasi yang sama di production.
Aturan Nginx tidak perlu diubah untuk parse error ini. Pada aaPanel, cek source
yang terunggah dengan:

```sh
/www/server/php/84/bin/php -d short_open_tag=1 -l /www/wwwroot/simpro.bkkjateng.co.id/admin/laporan/menu_laporan_awal.php
```

Setelah unggah, buka ulang `/admin/laporan/`. Jika OPcache tidak memeriksa
perubahan file secara otomatis, lakukan reload PHP 8.4 melalui aaPanel.

Regresi lokal:

```text
php -d short_open_tag=1 tests/php_short_tags_test.php
php -d short_open_tag=0 tests/php_short_tags_test.php
```
