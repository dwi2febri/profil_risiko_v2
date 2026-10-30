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
