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

### Filter rekap divisi / hasil laporan KC pada PHP-FPM

Form filter memakai GET ke alias `rekap_dvs` dan `hasil_lapkc`, sehingga tahun,
periode, dan status laporan langsung menjadi parameter URL. Tag form ganda pada
rekap divisi juga dihapus. Kiriman POST dari form versi lama ditangani di awal
`simpro_routes_bootstrap()` dengan redirect 303 ke GET sebelum layout dikeluarkan.

Sebelumnya controller memuat HTML layout, kemudian file laporan memanggil
`header('Location: ...')` dan `exit`. Pada PHP-FPM dengan output buffer kecil,
header HTTP bisa sudah terkirim; redirect gagal dan layout berhenti sebelum
JavaScript tema menghapus keadaan loading. Gejalanya dapat berupa layar gelap.

Untuk deployment admin, unggah bersama:

- `fungsi/pretty_routes.php`
- `admin/laporan/rekap_divisi.php`
- `admin/laporan/hasil_laporan_cabang.php`

Perubahan form yang sama juga diterapkan pada role lain yang mempunyai halaman
tersebut. Jika OPcache production tidak memeriksa perubahan file, reload PHP 8.4
setelah upload. Aturan rewrite Nginx tetap digunakan.

Pengujian HTTP `tests/report_filter_http_test.php` memeriksa redirect POST 303,
URL filter, form GET tunggal, pilihan tahun/periode, dan HTML sampai penutup serta
script layout; mencakup status semua/diterima dan periode tanpa data. Pengujian
lokal juga dijalankan pada server PHP dengan `output_buffering=4096` dan
`short_open_tag=1` untuk meniru perbedaan konfigurasi production.

### Ekspor tabel hasil KC dan rekap Korwil

Kedua halaman admin memakai komponen tabel bersama
`admin/includes/hasil_laporan_cabang_table.php`. Tombol Excel, PDF, dan Cetak
menyalin warna peringkat dari sel tabel, sesuai kolom yang terlihat, hasil
pencarian, pilihan area dan urutan saat ekspor. Sel kosong tidak diberi warna
peringkat. Legenda lima warna disertakan; batas pilar/inheren dan komposit
dituliskan terpisah mengikuti aturan yang sudah dipakai pada tampilan web.

PDF/cetak dengan lebih dari 18 kolom dibagi per jenis risiko. Identitas cabang,
status laporan, nilai risiko dan peringkat komposit diulang pada masing-masing
bagian, sehingga kolom terakhir tidak terpotong. Ekspor Excel tetap satu tabel
utuh, dengan legenda di bawahnya dan pengaturan cetak landscape selebar satu
halaman.

File deployment untuk fitur ini:

- `admin/index.php`
- `admin/includes/hasil_laporan_cabang_table.php`
- `assets/js/risk-table-export.js`
- `assets/js/vendor/jszip.min.js` (JSZip 3.10.1)
- `assets/js/vendor/pdfmake.min.js` (pdfmake 0.2.20)
- `assets/js/vendor/pdfmake-vfs-fonts.js` (font bawaan pdfmake 0.2.20)

Library disimpan lokal dan versinya dikunci agar fitur tidak bergantung pada
ketersediaan CDN di browser production. Semua file di atas perlu diunggah
bersama. Pengujian berkas hasil ekspor:

```text
node tests/risk_export_browser_test.cjs
python tests/risk_export_files_test.py
```

### Tren Profil KC (admin)

Submenu Rekap → Tren Profil KC memakai rute `/admin/tren_profil_kc`.
Filter GET `start_year`, `start_quarter`, `end_year`, `end_quarter`, dan
`wilayah` mencakup rentang triwulan inklusif, maksimum 40 triwulan. Wilayah
yang tersedia sama dengan rekap Korwil: Semarang, Solo, Banyumas, Pekalongan.
Rute generik Apache/Nginx yang sudah ada tidak memerlukan aturan tambahan.

Halaman menampilkan semua cabang wilayah terpilih tanpa paging, enam nilai
inheren per periode dengan sparkline, lalu nilai komposit di kelompok paling
kanan. Pemilihan laporan terbaru per cabang/periode dan sumber nilai memakai
loader yang sama dengan Hasil Laporan KC. Nilai kosong tidak menjadi nol dan
memutus garis tren. Delta hanya tersedia jika kedua ujung rentang memiliki
nilai. Rata-rata wilayah hanya menghitung nilai yang tersedia, dengan jumlah
sampel per periode; angka ini bukan penetapan risiko wilayah.

File untuk deployment halaman baru:

- `admin/index.php`
- `admin/laporan/tren_profil_kc.php`
- `admin/includes/tren_profil_kc_data.php`
- `assets/css/tren-profil-kc.css`
- `assets/js/tren-profil-kc.js`

Memerlukan komponen `admin/includes/hasil_laporan_cabang_data.php` yang sudah
dipakai halaman Hasil Laporan KC. Pengujian baca saja:

```text
php tests/tren_kc_data_test.php
node tests/tren_kc_browser_test.cjs
```

### Konsistensi nilai inheren KC

Ketiga halaman admin (Hasil Laporan KC, Rekap per Korwil, Tren Profil KC)
memakai `hasil_kc_load_results()`. Untuk kredit, operasional, kepatuhan,
reputasi, dan stratejik, skor dihitung saat dibaca dengan aturan Profil KC:
checklist parameter, rata-rata subparameter, rumus per pilar, serta metode
risiko tertinggi/terendah/rata-rata atau pembobotan. Hasil tersimpan dipakai
sebagai cadangan jika data perhitungan dinamis belum tersedia. Likuiditas
mengikuti hasil inheren yang dibaca halaman Profil Likuiditas. Komposit
dihitung dari enam nilai inheren dan bobot yang sama dengan Profil Nilai KC
(tahun dan user profil 3), dengan pembulatan akhir dua desimal. Rumus tidak
menormalkan ulang bobot ketika input belum lengkap; kelengkapan disertakan
dalam metadata `_missing` dan tooltip nilai pada tabel. Tidak ada penulisan
ulang hasil maupun nilai komposit tersimpan saat membuka rekap.

Perbaikan ini mencegah skor lama, misalnya Stratejik Wonogiri laporan 613
tersimpan 4,22, mengalahkan hasil Profil KC yang berlaku 4,07.
Rata-rata wilayah dan ekspor otomatis mengikuti sumber nilai yang sama.

Unggah bersama:

- `admin/includes/hasil_laporan_cabang_data.php`
- `admin/includes/hasil_laporan_cabang_dynamic_result.php` (baru)
- `admin/includes/hasil_laporan_cabang_composite.php` (baru)
- `admin/includes/hasil_laporan_cabang_table.php`
- `admin/kc/nilai_peringkat/nilai_profil.php` (pemilihan rumus operasional
  disamakan dengan Profil Operasional)

`php tests/hasil_kc_data_test.php` membandingkan empat kalkulator secara
independen dengan fungsi asli halaman profil, tanpa merender/menyimpan form.
`node tests/tren_kc_browser_test.cjs` juga mencocokkan keenam nilai di ketiga
halaman pada periode yang sama.

Pemeriksaan lengkap `php tests/kc_all_scores_composite_test.php` membandingkan
keenam kalkulator, bobot, pembulatan dan peringkat komposit dengan fungsi asli
halaman profil. Pada data lokal: 67 laporan, 402 nilai risiko; 29 komposit
tersimpan kosong/tertinggal kini ditampilkan dari hasil perhitungan terkini.

### Excel dan PDF Tren Profil KC

Tombol Excel/PDF mengekspor rentang dan kantor wilayah yang sudah diterapkan,
risiko yang sedang ditampilkan (komposit tetap terakhir), serta hasil pencarian
cabang. Rata-rata wilayah mengikuti filter wilayah seperti pada web. Legenda,
warna sel, nilai kosong, delta dan grafik tren kecil disertakan pada kedua
format. Excel berupa XLSX asli, dengan angka numerik, kode cabang sebagai teks,
header gabungan, kolom identitas beku, jumlah sampel rata-rata dan gambar tren.

PDF landscape dibagi per risiko dan maksimum delapan triwulan per bagian.
Grafik pada setiap bagian tetap mencakup seluruh rentang terpilih. A3 dipakai
untuk lebih dari 12 baris, A4 untuk tabel lebih pendek. Baris tidak dipecah
antarhalaman dan legenda diulang pada setiap bagian.

Unggah:

- `admin/laporan/tren_profil_kc.php`
- `assets/css/tren-profil-kc.css`
- `assets/js/tren-kc-export.js` (baru)

Memakai library lokal yang sudah dipakai ekspor Hasil Laporan KC:
`assets/js/vendor/jszip.min.js`, `assets/js/vendor/pdfmake.min.js`, dan
`assets/js/vendor/pdfmake-vfs-fonts.js`. Pastikan ketiganya tersedia di server.

```text
node tests/tren_kc_export_browser_test.cjs
python tests/tren_kc_export_files_test.py
```

Pengujian mencakup seluruh cabang, pencarian/risiko terpilih, rentang lintas
tahun yang panjang dan periode kosong. XLSX hasil uji juga dibuka melalui
Microsoft Excel untuk memeriksa keterbacaan dan jumlah grafik tren.

### Rekap per Risiko KC

Submenu Rekap admin memakai rute `/admin/rekap_risiko_kc`, dengan filter GET
`tahun`, `periode`, dan `wilayah`. Enam tabel menampilkan pilar, tingkat risiko,
peringkat, pilar tertinggi dan parameter tertinggi pada pilar tersebut. Semua
cabang pada wilayah terpilih ditampilkan tanpa paging. Filter risiko dan
pencarian cabang bekerja di browser dan diikuti oleh ekspor.

Nilai risiko memakai loader KC yang sama dengan tiga halaman rekap/tren.
Pilar dinamis mengikuti checklist tahun terpilih. Nilai parameter utama
dihitung dari rata-rata subparameter terpilih, atau nilai parameter langsung
jika tidak memiliki subparameter terpilih. Kredit/likuiditas menggunakan nilai
parameter utama tersimpan di isian inheren. Bila beberapa pilar atau parameter
seri, seluruhnya dicantumkan. Pilar kosong tidak dimasukkan sebagai nol;
peringkat tertinggi hanya dibandingkan dari nilai pilar yang tersedia.

Web dan Excel mengikuti format rekap contoh: satu laporan dengan keenam tabel
risiko tersusun vertikal, judul bank/periode di atas, serta header tiga tingkat
Risiko → Inheren → Pilar/Tingkat Risiko. Warna dibedakan per risiko: Kredit
hijau, Operasional biru, Kepatuhan ungu, Likuiditas oranye, Reputasi merah muda,
dan Stratejik abu-abu. Seluruh header dalam satu tabel (termasuk Kode/Nama
Cabang) dan baris rata-rata memakai warna risiko yang sama dengan teks putih;
tidak ada lagi header identitas kuning. Identitas cabang pada badan tabel tetap
hijau muda. Teks tingkat risiko, peringkat, pilar tertinggi dan parameter
tertinggi mengikuti warna risiko di web, Excel dan PDF. Nilai pilar dan
identitas tetap hitam agar mudah dibaca. Angka badan tabel berlatar putih.

Excel menghasilkan satu sheet `Rekap per Risiko KC` dengan header gabungan,
identitas cabang beku di kiri, serta jeda cetak antarjenis risiko. Kolom
parameter tertinggi tetap di paling kanan. PDF landscape A3 mengulang judul,
legenda dan header kolom di setiap halaman serta menjaga baris tetap utuh.
Kolom deskripsi membungkus teks panjang. Rata-rata mengikuti wilayah, sedangkan
pencarian menyaring cabang saja, sama dengan tampilan web.

File deployment:

- `admin/index.php`
- `admin/laporan/rekap_risiko_kc.php` (baru)
- `admin/includes/rekap_risiko_kc_data.php` (baru)
- `admin/includes/hasil_laporan_cabang_pillars.php` (tambahan nama dan nilai
  parameter untuk pelacakan sumber)
- `assets/css/rekap-risiko-kc.css` (baru)
- `assets/js/rekap-risiko-kc.js` (baru)

Memerlukan loader KC terbaru dan library lokal JSZip/pdfmake yang dijelaskan
pada bagian sebelumnya. Tidak memerlukan tabel atau kolom database baru.

```text
php tests/rekap_risiko_kc_data_test.php
node tests/rekap_risiko_kc_browser_test.cjs
python tests/rekap_risiko_kc_files_test.py
```

Untuk perubahan format ini, unggah `admin/laporan/rekap_risiko_kc.php`,
`assets/css/rekap-risiko-kc.css`, dan `assets/js/rekap-risiko-kc.js` bersama.
Versi URL CSS/JS dinaikkan agar browser mengambil tampilan terbaru.

### Scroll horizontal Tren Profil KC

Scroll tabel tetap native. Sinkronisasi scrollbar atas/bawah menandai posisi
hasil penulisan program, lalu mengabaikan event balasan pada posisi tersebut.
Selisih subpixel di bawah satu CSS pixel tidak dikoreksi bolak-balik, sehingga
scrollbar asal tidak ditulis ulang saat pengguna menggeser atau memakai wheel.
Pengukuran ukuran digabung per frame hanya saat layout/filter berubah;
pergerakan scroll sendiri disalin langsung tanpa animasi tambahan.

Gutter scrollbar vertikal dicadangkan agar rentang horizontal tidak berubah
saat jumlah baris berubah. Batas kolom tetap memakai garis, menggantikan
bayangan yang perlu digambar ulang saat tabel bergerak.

Unggah bersama:

- `admin/laporan/tren_profil_kc.php`
- `assets/js/tren-profil-kc.js` (versi URL `20261105-02`)
- `assets/css/tren-profil-kc.css` (versi URL `20261105-03`)

`node tests/tren_kc_scroll_test.cjs` memeriksa kedua scrollbar pada zoom
90/100/110/125%, pergerakan maju/mundur, pembulatan fractional, kolom tetap,
akhir tabel, wheel horizontal native dan alur event pointer saat drag. Pemeriksaan
filter/data tetap tersedia di `node tests/tren_kc_browser_test.cjs`.

### Kop cetak laporan profil risiko

Cetak laporan lengkap dan tindak lanjut memakai kop logo BKK, judul kantor,
alamat, dan garis ganda. Kop berada pada header tabel pembungkus sehingga
berulang pada setiap halaman fisik, termasuk halaman lanjutan tabel panjang.
Jenis Profil Risiko dan Tanggal Cetak dihapus dari identitas halaman awal;
Kantor, Tahun, dan Periode tetap ditampilkan. Uraian tetap di bawah ringkasan.

Unggah `fungsi/cetak_ringkas.php`, `assets/css/print-cover-summary.css`, dan
`laporan/cetak_laporan_profil_risiko.php` pada seluruh folder role bersama-sama.
CSS dibaca inline sehingga tidak memerlukan penggantian versi URL cache.
Pemeriksaan: `php tests/compact_print_test.php`,
`node tests/compact_print_browser_test.cjs --letterhead`, lalu
`python tests/print_letterhead_pdf_test.py` untuk memeriksa setiap halaman
PDF F4 vertikal dan horizontal.

Perbaikan garis subparameter cetak memakai tinggi relatif tabel di dalam
kelompok parameter, sehingga garis terakhir mengikuti tinggi keterangan
setelah pemisahan halaman. Pengukuran dilakukan pada lebar isi F4 dan
dikembalikan sesudah dialog cetak ditutup. Unggah `assets/js/print-risk-compact.js`,
`assets/css/print-table-grid.css`, serta controller cetak pada 20 folder role
(versi script `20261105-06`). Setelah tes browser `--summaries`, jalankan
`python tests/print_parameter_grid_test.py` untuk memeriksa garis PDF pada
subparameter TI Operasional dan batasnya terhadap rekap serta kop.

Lebar sel lama di salinan cetak dinetralkan supaya colgroup mengatur header
serta isi secara konsisten. Pembatas vertikal subparameter digambar sekali
pada latar sel pembungkus dan dipotong per fragmen halaman; latar grid dalam
transparan agar pembatas tetap utuh saat keterangannya lebih panjang. Baris
parameter utama menutup pembatas huruf karena kolomnya digabung. Garis tidak
menggunakan posisi absolut agar tidak melewati kop halaman berikutnya.
Tes browser `--summaries` juga membandingkan posisi kolom nilai dengan header
pada empat Inheren dan enam KPMR. Tes garis PDF membaca raster untuk mencakup
batas asli dan pengisi garis pada bagian lanjutan.
