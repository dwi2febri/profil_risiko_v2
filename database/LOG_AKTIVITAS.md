Log Aktivitas tersedia di Menu User pada seluruh folder role, termasuk controller kompr yang memakai akun admin.

Pemasangan server:

1. Impor `20261118_log_aktivitas.sql` ke database aplikasi sebelum memperbarui file aplikasi. Query dapat dijalankan ulang dan tidak mengubah tabel yang sudah ada.
2. Unggah file koneksi, login/logout, kedua helper `fungsi/activity_log*.php`, dan controller `index.php` role yang berubah.
3. Login ulang, buka Menu User > Log Aktivitas, lalu periksa aktivitas yang baru dilakukan.

Admin melihat seluruh pengguna; role lainnya hanya melihat riwayat akun sendiri. Filter tanggal memakai WIB. Halaman menampilkan maksimal 50 catatan per halaman.

Tombol Export Excel mengunduh file `.xlsx` berisi seluruh hasil filter, dengan pembatasan pengguna yang sama seperti halaman log. Export memerlukan ekstensi PHP `zip` (ZipArchive). Nama pengguna ditampilkan tanpa username, baik pada tabel maupun file Excel. Kolom password pada seluruh halaman List User dihapus. Pembaruan ini tidak memerlukan perubahan tabel database.

Catatan merekam permintaan aplikasi yang melewati koneksi database: login berhasil/gagal, logout, akses halaman, POST/PUT/PATCH/DELETE, cetak/unduh yang teridentifikasi dari rute, dan AJAX. Pencatatan dilakukan sekali di akhir permintaan, termasuk respons gagal. File statis, aktivitas sebelum fitur dipasang, klik yang tidak mengirim permintaan, dan proses CLI tidak dicatat. Permintaan iframe cetak dapat menghasilkan catatan terpisah untuk setiap halaman sumber.

Log menyimpan identitas akun saat aktivitas berlangsung, waktu, rute tanpa query string, ID data numerik, metode HTTP, status respons, dan alamat IP koneksi. Password, cookie, token, dan isi formulir tidak disimpan. Log bukan riwayat perubahan nilai sebelum/sesudah; HTTP 200 juga dapat berisi pesan validasi gagal dari aplikasi lama. Label “Kirim data” dan “Permintaan hapus” menjelaskan permintaan, bukan memastikan transaksi berhasil.

Jika tabel belum dipasang atau insert log gagal, aktivitas aplikasi tetap berjalan dan server menulis pesan kesalahan generik ke error log. Halaman log menampilkan petunjuk pemasangan. Tidak ada menu untuk mengubah atau menghapus log; pengelolaan retensi dilakukan oleh administrator database.

Pengujian PHP 8.4:

```
php tests/activity_log_test.php
php tests/activity_log_http_test.php
```

Tes pertama memakai tabel sementara tanpa meninggalkan data. Tes HTTP memakai sesi sementara akun role lokal yang tersedia; tidak mengubah akun/laporan, namun permintaan pengujiannya tetap tercatat di log. Jalankan di lingkungan lokal, bukan server produksi.
