# Dashboard Monitoring

Halaman admin: `index.php?page=dashboard_monitoring`, pada menu Dashboards sebelum
Dashboard Kantor Pusat. Akses data dan Gemini dibatasi untuk sesi admin.

## Data dan metode

- Filter: jenis profil, rentang tahun/triwulan, wilayah, dan penerimaan laporan KC.
  Filter penerimaan hanya berlaku untuk laporan KC, bukan laporan pusat.
- Nilai profil memakai `nilai_profil` yang tersimpan. Jika jenis profil memuat
  beberapa laporan, angka ringkasan adalah rata-rata laporan periode fokus.
- Enam risiko membaca `keterangan_profil_*`, lalu hasil inheren/KPMR atau header
  assessment jika ringkasan tersebut belum diisi. Tidak ada pembentukan komposit
  baru, pengubahan nilai, atau persetujuan otomatis.
- Wilayah memetakan cabang 1–7 Semarang, 8–14 Solo, 15–21 Banyumas, dan
  22–28 Pekalongan, mengikuti pengelompokan aplikasi yang sudah ada.
  Rata-rata KC per wilayah bukan penetapan konsolidasi resmi.
- Satu laporan terbaru per jenis profil/kantor/triwulan dipakai agar revisi dan
  duplikasi tidak menggandakan jumlah cabang. Nilai profil duplikat mengambil
  baris terbaru. Tahun/triwulan tanpa nilai tetap kosong pada grafik.
- Skor valid 1–5. Nol, kosong, atau angka di luar skala tidak dianggap sebagai
  risiko rendah. Kelengkapan KC mengukur enam nilai risiko inheren yang tersedia.
- Parameter perhatian dikelompokkan per identitas parameter dan wilayah/profil:
  nilai tertinggi ≥3 atau kenaikan ≥0,25; prioritas tinggi ≥4. Ini aturan triase
  analisis, bukan batas peringkat resmi. Perubahan memakai sampel laporan yang
  memiliki parameter pembanding sama, dengan satu triwulan tambahan sebelum
  awal rentang untuk mencari pembanding.
- Kredit/likuiditas memakai pemetaan label formulir aktif pada
  `includes/monitoring_parameter_labels.json`. Assessment dinamis menggunakan
  identitas hierarki master parameter/subparameter. Referensi master yang hilang
  dilaporkan sebagai catatan kualitas data dan tidak diberi nama rekaan.
- Drawer detail menunjukkan nilai, pembanding, status, dan tautan laporan sumber.
  CSV mengekspor hasil pencarian/filter parameter yang sedang aktif.

## Gemini

Konfigurasi server membaca `GEMINI_API_KEY` dan `GEMINI_MODEL` dari environment.
Untuk instalasi Laragon lokal tersedia fallback `.local/gemini.json` dengan
format `{"api_key":"ISI_DI_SERVER","model":"gemini-2.5-flash"}`.
Folder `.local` diabaikan Git dan dilindungi `Require all denied` pada Apache.
Gunakan environment untuk deployment lain; jangan menyajikan konfigurasi rahasia
sebagai berkas statis. Kunci tidak dikirim ke browser.

Tombol **Analisis dengan Gemini** mengirim ringkasan agregat, nilai risiko,
parameter prioritas, dan catatan cakupan; tidak mengirim kredensial, nama akun,
komentar laporan, atau data nasabah. Server membangun ulang konteks dari filter,
bukan menerima angka analisis dari browser. POST memakai CSRF, batas 30 detik,
dan cache sesi 10 menit untuk konteks yang sama. Hasil tervalidasi ditampilkan
sebagai teks, bukan HTML yang dapat dieksekusi. Usulan PIC/tenggat perlu ditinjau.

Integrasi memakai [Gemini generateContent REST API](https://ai.google.dev/api/generate-content)
dan [structured JSON output](https://ai.google.dev/gemini-api/docs/structured-output).
Model dapat diganti di konfigurasi server sesuai model yang tersedia pada akun.
Kegagalan/kuota API ditampilkan jelas; panduan berbasis indikator tetap tersedia
dan tidak dilabeli sebagai hasil Gemini.

## Verifikasi

```powershell
php tests/monitoring_data_test.php
node tests/monitoring_browser_test.cjs
node tests/monitoring_browser_test.cjs --gemini
```

Uji browser memerlukan Node 22+ dan Chrome lokal (`CHROME_PATH` opsional).
Uji memakai akun admin/admin KC yang sudah ada, tanpa menampilkan password atau
kunci. `--gemini` membuat satu permintaan AI nyata. Screenshot dan CSV hasil uji
disimpan di `.local/monitoring-review/`, yang tidak dapat diakses melalui HTTP.


## Penelusuran parameter dan dugaan penyebab

Detail prioritas kini menampilkan hierarki parameter/subparameter tersimpan dalam pilar yang sama, nilai sebelum/sesudah, periode serta ID dan tautan kedua laporan. Untuk formulir lama, hubungan subparameter mengikuti kode field formulir; untuk assessment dinamis, hubungan mengikuti master parameter/subparameter. Identitas tabel, field, dan baris detail tersedia untuk penelusuran teknis. Data master yang tidak dapat dipetakan tetap tidak diberi nama buatan.

Perubahan wilayah memakai pasangan parameter dari cabang yang sama. Kontribusi tiap cabang adalah `(skor sekarang - skor sebelumnya) / jumlah pasangan`. Total kontribusi mendekati perubahan rata-rata, dengan selisih pembulatan. Ini bukan bobot subparameter atau dekomposisi nilai konsolidasi resmi. Skor subparameter tidak otomatis menjumlah menjadi skor induk.

Tombol **Bedah dugaan penyebab dengan Gemini** mengirim bukti parameter terpilih yang dihitung ulang di server: hierarki skor, cabang, sumber laporan, periode dan kontribusi. Server memvalidasi parameter terhadap filter dan mempertahankan autentikasi admin, CSRF, cache dan batas permintaan yang sama. Gemini diminta membedakan fakta perubahan dari hipotesis penyebab dan menyarankan bukti yang harus diperiksa. Nominal pembilang/penyebut, koreksi penilai dan bukti operasional belum tercakup; penyebab operasional tidak diperlakukan sebagai fakta.

Verifikasi tambahan: `node tests/monitoring_browser_test.cjs --explain` menjalankan satu permintaan Gemini nyata untuk rincian parameter.


## Prioritas per cabang

Panel parameter perhatian menyediakan pilihan per wilayah (bawaan) atau per cabang, serta pilihan semua cabang atau satu KC. Mode cabang menggunakan laporan KC terakhir pada periode fokus, tanpa memasukkan profil pusat. Setiap baris berasal dari satu cabang; perubahan dibandingkan dengan parameter pada laporan sebelumnya dari cabang yang sama. Filter wilayah/periode/status utama tetap berlaku. Grafik ringkasan tetap mengikuti filter utama; pengelompokan ini membatasi parameter perhatian, detail sumber, CSV, dan konteks rekomendasi Gemini. Filter disimpan pada URL sebagai `priority_scope` dan `priority_branch`, divalidasi kembali di server untuk overview maupun permintaan AI.


## Filter cabang utama dan kartu enam risiko

Filter utama `branch` membatasi laporan KC untuk grafik, penerimaan, kelengkapan, peta wilayah, dan parameter perhatian. Cabang harus termasuk wilayah terpilih; opsi cabang di UI mengikuti wilayah. Saat satu cabang dipilih, cakupan parameter otomatis mengikuti cabang tersebut. Laporan profil pilihan tetap tersedia sebagai pembanding dengan label yang terpisah.

Kartu enam risiko menggunakan `selectedMetrics` dan perubahan pasangan laporan `selectedChanges`: profil pilihan bila wilayah/cabang belum dibatasi, rata-rata KC pada wilayah terpilih, atau skor KC individual bila cabang dipilih. Nilai kosong pada cakupan terpilih tidak diganti dengan nilai profil pusat. Bagian atas dashboard menggunakan latar putih tanpa ornamen lingkaran.
