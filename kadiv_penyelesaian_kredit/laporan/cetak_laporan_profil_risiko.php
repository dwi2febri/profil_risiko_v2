<?php
/*
  CETAK LAPORAN PROFIL RISIKO LENGKAP - CLEAN HITAM PUTIH
  Letakkan sebagai page: cetak_laporan_profil_risiko.php
  Akses: index.php?page=cetak_laporan_profil_risiko&id=ID_PROFIL_RISIKO

  Perbaikan:
  - Tidak menampilkan sidebar/topbar karena isi halaman diambil dari .content-page saja.
  - Semua tampilan dibuat hitam putih/grayscale untuk PDF.
  - Textarea/input/select dikonversi menjadi teks biasa agar keterangan ikut tercetak.
  - Select/input/textarea dikonversi lebih dulu menjadi teks agar kolom PENILAIAN tidak kosong; option/dropdown/list pilihan tidak ikut tampil berderet saat PDF.
  - Kolom Keterangan dibuat rowspan otomatis sampai akhir sub parameter.
  - Route/fallback Stratejik KPMR dan Profil diperbaiki.
*/

/*
  FIX PATH CETAK DIRECT DARI FOLDER laporan/
  File ini dipanggil langsung dari: pic_area_semarang/laporan/cetak_laporan_profil_risiko.php
  Struktur project user:
    profil_risiko/conn/conn.php
    profil_risiko/fungsi/fungsi.php
    profil_risiko/pic_area_semarang/index.php
    profil_risiko/pic_area_semarang/laporan/cetak_laporan_profil_risiko.php

  Catatan penting:
  - Jangan include ../fungsi/fungsi.php dari file ini, karena fungsi.php milik project
    masih punya include relatif ../conn/conn.php. Saat dipanggil dari folder laporan/,
    include relatif itu akan salah arah dan memunculkan warning.
  - File cetak ini sudah punya helper function sendiri, jadi cukup include koneksi database.
*/
$__projectRoot = realpath(__DIR__ . '/../../');
$__connFile = $__projectRoot ? ($__projectRoot . DIRECTORY_SEPARATOR . 'conn' . DIRECTORY_SEPARATOR . 'conn.php') : '';

if ($__connFile === '' || !file_exists($__connFile)) {
    die('<div style="font-family:Arial;padding:20px;color:#b00020;">
        <b>Koneksi database tidak ditemukan.</b><br>
        Pastikan file cetak berada di folder <b>pic_area_semarang/laporan/</b><br>
        dan file koneksi berada di <b>profil_risiko/conn/conn.php</b>.
    </div>');
}

include_once $__connFile;

if (!isset($conn) || !$conn) {
    die('<div style="font-family:Arial;padding:20px;color:#b00020;">
        <b>Koneksi database gagal dibaca.</b><br>
        Variabel <b>$conn</b> tidak tersedia dari file <b>conn/conn.php</b>.
    </div>');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
  FIX LOGO COVER:
  Logo dibuat otomatis terbaca dari beberapa lokasi umum lalu di-embed base64,
  sehingga tetap muncul baik file dibuka langsung dari folder laporan/ maupun lewat index.php.
*/
function pdf_logo_cover_src($projectRoot){
    $candidates = [
        __DIR__ . DIRECTORY_SEPARATOR . 'logo.png',
        __DIR__ . DIRECTORY_SEPARATOR . 'logo.jpg',
        __DIR__ . DIRECTORY_SEPARATOR . 'logo.jpeg',
        __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'logo.png',
        __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'logo.jpg',
        $projectRoot . DIRECTORY_SEPARATOR . 'logo.png',
        $projectRoot . DIRECTORY_SEPARATOR . 'logo.jpg',
        $projectRoot . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'logo.png',
        $projectRoot . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo.png',
        $projectRoot . DIRECTORY_SEPARATOR . 'pic_area_semarang' . DIRECTORY_SEPARATOR . 'logo.png',
        $projectRoot . DIRECTORY_SEPARATOR . 'pic_area_semarang' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'logo.png',
    ];

    foreach ($candidates as $file) {
        if ($file && file_exists($file) && is_file($file)) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : 'image/png';
            $data = @file_get_contents($file);
            if ($data !== false && $data !== '') {
                return 'data:' . $mime . ';base64,' . base64_encode($data);
            }
        }
    }

    return 'logo.png';
}
$__logoCoverSrc = pdf_logo_cover_src($__projectRoot);

function esc_pdf($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function pdf_tgl_indo_long($tanggal){
    $tanggal = trim((string)$tanggal);
    if ($tanggal === '') $tanggal = date('Y-m-d');
    $ts = strtotime($tanggal);
    if (!$ts) $ts = time();
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $d = (int)date('d', $ts);
    $m = (int)date('m', $ts);
    $y = date('Y', $ts);
    return sprintf('%02d %s %s', $d, $bulan[$m] ?? date('F', $ts), $y);
}

function pdf_pick_name_from_row($row){
    if (!$row || !is_array($row)) return '';
    foreach(['nama','name','nama_lengkap','fullname','full_name'] as $k){
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') return trim((string)$row[$k]);
    }
    return '';
}

function pdf_pernyataan_ttd_html($conn, $frame){
    $isCabang = ((int)($frame['user'] ?? 0) === 3 || stripos((string)($frame['tipe_user'] ?? ''), 'Kantor Cabang') !== false);
    $idCabang = (int)($frame['kantor_cabang'] ?? 0);
    $dibuatBy = (int)($frame['dibuat_by'] ?? 0);

    $namaKacab = '';
    if ($isCabang && $idCabang > 0 && pdf_table_exists($conn, 'user')) {
        $qKacab = pdf_one($conn, "SELECT * FROM `user` WHERE lokasi_kerja='".$idCabang."' ORDER BY user_id ASC LIMIT 1");
        $namaKacab = pdf_pick_name_from_row($qKacab);
    }

    $namaRisk = '';
    if ($isCabang && $dibuatBy > 0 && pdf_table_exists($conn, 'user')) {
        $qRisk = pdf_one($conn, "SELECT * FROM `user` WHERE user_id='".$dibuatBy."' LIMIT 1");
        $namaRisk = pdf_pick_name_from_row($qRisk);
    }
    if ($isCabang && $namaRisk === '') $namaRisk = trim((string)($frame['nama'] ?? ''));

    $statusKorwil = ((int)($frame['status_korwil'] ?? 0) === 1) ? 'V' : 'X';
    $statusMr     = ((int)($frame['status_skmr'] ?? 0) === 1) ? 'V' : 'X';
    $tanggalCetak = pdf_tgl_indo_long(date('Y-m-d'));

    $pelaksana = $isCabang ? 'Kantor Cabang' : 'Kantor Pusat dan RTU';
    $jabatanKiri = $isCabang ? 'Kepala Cabang' : 'Kepala Bidang';
    $jabatanKanan = $isCabang ? 'Risk Residence Area' : 'Kepala Divisi';

    return '<section class="pernyataan-page">'
        . '<div class="pernyataan-line"></div>'
        . '<p>Dengan ini menyatakan bahwa seluruh informasi dalam pengisian profil risiko di BPR BKK Jateng adalah akurat dan sesuai dengan kondisi sebenarnya. Dengan Tindak lanjut atas profil risiko dan hasil perbaikan oleh '.esc_pdf($pelaksana).' dilakukan sebelum periode penilaian selanjutnya dan akan di evaluasi secara berkala</p>'
        . ($isCabang ? '<div class="status-konfirmasi"><b>Status Konfirmasi (V/X)</b><br><b>Kepala Wilayah : '.esc_pdf($statusKorwil).'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Manrisk Kantor Pusat : '.esc_pdf($statusMr).'</b></div>' : '')
        . '<div class="tanggal-ttd"><b>Semarang, '.esc_pdf($tanggalCetak).'</b></div>'
        . '<table class="ttd-table"><thead><tr><th>'.esc_pdf($jabatanKiri).'</th><th>'.esc_pdf($jabatanKanan).'</th></tr></thead>'
        . '<tbody><tr><td class="ttd-space"></td><td class="ttd-space"></td></tr>'
        . '<tr><td><b>Nama : '.esc_pdf($namaKacab).'</b></td><td><b>Nama : '.esc_pdf($namaRisk).'</b></td></tr></tbody></table>'
        . '</section>';
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isModalView = (isset($_GET['modal_view']) && $_GET['modal_view'] == '1');
$printScale = isset($_GET['print_scale']) ? (int)$_GET['print_scale'] : 100;
if ($printScale < 80) { $printScale = 80; }
if ($printScale > 200) { $printScale = 200; }

$onlyTindakLanjut = (isset($_GET['only_tindak_lanjut']) && $_GET['only_tindak_lanjut'] == '1');
$onlyProfilPerRisiko = (isset($_GET['only_profil_per_risiko']) && $_GET['only_profil_per_risiko'] == '1');
$cetakProfilPerRisikoOnly = ($onlyTindakLanjut || $onlyProfilPerRisiko);

if ($id <= 0) {
    die('<div style="font-family:Arial;padding:20px;color:#b00020;"><b>ID laporan tidak valid.</b></div>');
}

$frame = mysqli_fetch_assoc(simpro_db_query($conn, "
    SELECT
        f.*,
        p.periode_laporan,
        jc.cabang,
        upr.tipe_user
    FROM frame_laporan_profil_risiko f
    LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
    LEFT JOIN jenis_cabang jc ON f.kantor_cabang = jc.id_cabang
    LEFT JOIN user_profil_risiko upr ON f.user = upr.id_user_profil_risiko
    WHERE f.id_profil_risiko = ?
    LIMIT 1
", [$id]));

if (!$frame) {
    die('<div style="font-family:Arial;padding:20px;color:#b00020;"><b>Data laporan tidak ditemukan.</b></div>');
}

$isProfilCabangCetak = ((int)($frame['user'] ?? 0) === 3 || stripos((string)($frame['tipe_user'] ?? ''), 'Kantor Cabang') !== false);

$sections = [
    /* Kredit: hanya Inheren 1, KPMR 1 + KPMR 2 */
    ['title' => '1. Risiko Kredit - Inheren',       'pages' => ['kre_inhern', 'kre_inheren', 'kre_inheren1', 'maskre']],
    ['title' => '2. Risiko Kredit - KPMR 1',        'pages' => ['kre_kpmr1', 'kredit_kpmr1', 'kre_kpmr']],
    ['title' => '3. Risiko Kredit - KPMR 2',        'pages' => ['kre_kpmr2', 'kredit_kpmr2', 'kre_kpmr_2', 'kredit_kpmr_2']],
    ['title' => '4. Risiko Kredit - Profil',        'pages' => ['kre_profil']],

    /* Operasional: Inheren 1 + Inheren 2, KPMR 1 + KPMR 2 */
    ['title' => '5. Risiko Operasional - Inheren 1','pages' => ['op_inhern1', 'op_inheren1', 'operasional_inhern1', 'operasional_inheren1', 'inheren1_operasional']],
    ['title' => '6. Risiko Operasional - Inheren 2','pages' => ['op_inhern2', 'op_inheren2', 'operasional_inhern2', 'operasional_inheren2', 'op_inheren_dinamis', 'inheren2_operasional']],
    ['title' => '7. Risiko Operasional - KPMR 1',   'pages' => ['op_kpmr1', 'operasional_kpmr1', 'op_kpmr']],
    ['title' => '8. Risiko Operasional - KPMR 2',   'pages' => ['op_kpmr2', 'operasional_kpmr2', 'op_kpmr_2']],
    ['title' => '9. Risiko Operasional - Profil',   'pages' => ['op_profil']],

    /* Kepatuhan: Inheren 1 + Inheren 2, KPMR 1 + KPMR 2 */
    ['title' => '10. Risiko Kepatuhan - Inheren 1', 'pages' => []],
    ['title' => '11. Risiko Kepatuhan - Inheren 2', 'pages' => []],
    ['title' => '12. Risiko Kepatuhan - KPMR 1',    'pages' => ['kep_kpmr1', 'kp_kpmr1', 'kepatuhan_kpmr1', 'kep_kpmr']],
    ['title' => '13. Risiko Kepatuhan - KPMR 2',    'pages' => ['kep_kpmr2', 'kp_kpmr2', 'kepatuhan_kpmr2', 'kep_kpmr_2']],
    ['title' => '14. Risiko Kepatuhan - Profil',    'pages' => ['kep_profil', 'kp_profil']],

    /* Likuiditas: hanya Inheren 1, KPMR 1 + KPMR 2 */
    ['title' => '15. Risiko Likuiditas - Inheren',  'pages' => ['lik_inhern', 'lik_inheren', 'lik_inheren1']],
    ['title' => '16. Risiko Likuiditas - KPMR 1',   'pages' => ['lik_kpmr1', 'likuiditas_kpmr1', 'lik_kpmr']],
    ['title' => '17. Risiko Likuiditas - KPMR 2',   'pages' => ['lik_kpmr2', 'likuiditas_kpmr2', 'lik_kpmr_2']],
    ['title' => '18. Risiko Likuiditas - Profil',   'pages' => ['lik_profil']],

    /* Reputasi: Inheren 1 + Inheren 2, KPMR 1 + KPMR 2 */
    ['title' => '19. Risiko Reputasi - Inheren 1',  'pages' => ['rep_inhern1', 'rep_inheren1', 'reputasi_inhern1', 'reputasi_inheren1', 'inheren1_reputasi']],
    ['title' => '20. Risiko Reputasi - Inheren 2',  'pages' => ['rep_inhern2', 'rep_inheren2', 'reputasi_inhern2', 'reputasi_inheren2', 'rep_inheren_dinamis', 'inheren2_reputasi']],
    ['title' => '21. Risiko Reputasi - KPMR 1',     'pages' => ['rep_kpmr1', 'reputasi_kpmr1', 'rep_kpmr']],
    ['title' => '22. Risiko Reputasi - KPMR 2',     'pages' => ['rep_kpmr2', 'reputasi_kpmr2', 'rep_kpmr_2']],
    ['title' => '23. Risiko Reputasi - Profil',     'pages' => ['rep_profil']],

    /* Stratejik: Inheren 1 + Inheren 2, KPMR 1 + KPMR 2 */
    ['title' => '24. Risiko Stratejik - Inheren 1', 'pages' => ['stra_inhern1', 'stra_inheren1', 'str_inhern1', 'str_inheren1', 'stratejik_inhern1', 'stratejik_inheren1', 'strategik_inhern1', 'strategik_inheren1', 'inheren1_stratejik']],
    ['title' => '25. Risiko Stratejik - Inheren 2', 'pages' => ['stra_inhern2', 'stra_inheren2', 'str_inhern2', 'str_inheren2', 'stratejik_inhern2', 'stratejik_inheren2', 'strategik_inhern2', 'strategik_inheren2', 'str_inheren_dinamis', 'inheren2_stratejik']],
    ['title' => '26. Risiko Stratejik - KPMR 1',    'pages' => ['stra_kpmr1', 'str_kpmr1', 'stratejik_kpmr1', 'strategik_kpmr1', 'kpmr_stratejik', 'stra_kpmr']],
    ['title' => '27. Risiko Stratejik - KPMR 2',    'pages' => ['stra_kpmr2', 'str_kpmr2', 'stratejik_kpmr2', 'strategik_kpmr2', 'kpmr2_stratejik', 'kpmr2_strategik', 'stra_kpmr_2']],
    ['title' => '28. Risiko Stratejik - Profil',    'pages' => ['stra_profil', 'str_profil', 'stratejik_profil', 'strategik_profil', 'profil_stratejik', 'profil_strategik']],

    ['title' => '29. Profil Nilai Konsolidasi',     'pages' => ['nilpro']],
    ['title' => '30. Profil Peringkat',             'pages' => ['nilpro']],
];

require_once dirname(__DIR__, 2) . '/fungsi/cetak_ringkas.php';
$sections = cetak_ringkas_sections($sections, $isProfilCabangCetak);

if ($onlyTindakLanjut) {
    // Cetak tindak lanjut khusus: tampilkan nomor per risiko dan isi mulai dari Analisis Risiko sampai Respon Cabang.
    $sections = [
        ['title' => '1. Risiko Kredit - Tindak Lanjut',      'pages' => []],
        ['title' => '2. Risiko Operasional - Tindak Lanjut', 'pages' => []],
        ['title' => '3. Risiko Kepatuhan - Tindak Lanjut',   'pages' => []],
        ['title' => '4. Risiko Likuiditas - Tindak Lanjut',  'pages' => []],
        ['title' => '5. Risiko Reputasi - Tindak Lanjut',    'pages' => []],
        ['title' => '6. Risiko Stratejik - Tindak Lanjut',   'pages' => []],
    ];
} elseif ($cetakProfilPerRisikoOnly) {
    $sections = array_values(array_filter($sections, function($s){
        $title = trim((string)($s['title'] ?? ''));
        return (bool)preg_match('/^\d+\.\s+Risiko\s+.+\s+-\s+Profil$/i', $title);
    }));
}


function pdf_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}
function pdf_col_exists($conn, $table, $column){
    if (!pdf_table_exists($conn, $table)) return false;
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}
function pdf_one($conn, $sql){
    $q = mysqli_query($conn, $sql);
    return ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : [];
}
function pdf_num($v){ return number_format((float)str_replace(',', '.', (string)$v), 2, '.', ''); }
function pdf_label_inheren($nilai){
    $nilai=(float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai < 1.25) return 'Sangat Rendah';
    if ($nilai < 2.25) return 'Rendah';
    if ($nilai < 3.25) return 'Sedang';
    if ($nilai < 4.25) return 'Tinggi';
    if ($nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}
function pdf_label_kpmr($nilai){
    $nilai=(float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai < 1.25) return 'Sangat Memadai';
    if ($nilai < 2.25) return 'Memadai';
    if ($nilai < 3.25) return 'Cukup Memadai';
    if ($nilai < 4.25) return 'Kurang Memadai';
    if ($nilai <= 5.00) return 'Tidak Memadai';
    return '';
}
function pdf_pick_result($row, $jenis='inheren'){
    $out=['nilai'=>0,'peringkat'=>''];
    if (!$row) return $out;
    foreach(['hasil_tingkat_risiko','tingkat_risiko','hasil_kpmr','hasil_penilaian_kpmr','nilai_kpmr','total_nilai','hasil_rata_rata','rata_rata','nilai','hasil'] as $k){
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') { $out['nilai']=(float)str_replace(',', '.', (string)$row[$k]); break; }
    }
    foreach(['hasil_peringkat','peringkat','predikat','hasil_predikat','ket_tingkat_risiko'] as $k){
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') { $out['peringkat']=trim((string)$row[$k]); break; }
    }
    if ($out['peringkat']==='') $out['peringkat'] = ($jenis==='kpmr') ? pdf_label_kpmr($out['nilai']) : pdf_label_inheren($out['nilai']);
    return $out;
}
function pdf_result_from_table($conn, $table, $id, $jenis='inheren'){
    if ((int)$id <= 0 || !pdf_table_exists($conn, $table)) return ['nilai'=>0,'peringkat'=>''];
    $row = pdf_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    return pdf_pick_result($row, $jenis);
}
function pdf_matrix_stratejik($inherenRank, $kpmrRank){
    $m = [
        'Sangat Rendah' => ['Sangat Memadai'=>1.00,'Memadai'=>1.10,'Cukup Memadai'=>1.15,'Kurang Memadai'=>1.20,'Tidak Memadai'=>1.25],
        'Rendah' => ['Sangat Memadai'=>1.05,'Memadai'=>1.72,'Cukup Memadai'=>1.85,'Kurang Memadai'=>1.92,'Tidak Memadai'=>2.25],
        'Sedang' => ['Sangat Memadai'=>1.58,'Memadai'=>1.78,'Cukup Memadai'=>3.00,'Kurang Memadai'=>2.67,'Tidak Memadai'=>3.25],
        'Tinggi' => ['Sangat Memadai'=>1.65,'Memadai'=>2.58,'Cukup Memadai'=>3.50,'Kurang Memadai'=>4.00,'Tidak Memadai'=>4.25],
        'Sangat Tinggi' => ['Sangat Memadai'=>2.50,'Memadai'=>2.75,'Cukup Memadai'=>3.75,'Kurang Memadai'=>4.63,'Tidak Memadai'=>5.00],
    ];
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}
function pdf_fallback_stratejik_html($conn, $id, $type){
    $id=(int)$id;
    $hin = pdf_result_from_table($conn, 'hasil_inheren_stratejik', $id, 'inheren');
    $hk  = pdf_result_from_table($conn, 'hasil_kpmr_stratejik', $id, 'kpmr');
    $ket = pdf_table_exists($conn, 'keterangan_profil_stratejik') ? pdf_one($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko='$id' LIMIT 1") : [];
    $nilaiIn = isset($ket['inheren_stratejik']) && trim((string)$ket['inheren_stratejik'])!=='' ? (float)$ket['inheren_stratejik'] : (float)$hin['nilai'];
    $nilaiKp = isset($ket['kpmr_stratejik']) && trim((string)$ket['kpmr_stratejik'])!=='' ? (float)$ket['kpmr_stratejik'] : (float)$hk['nilai'];
    $rankIn = $hin['peringkat'] ?: pdf_label_inheren($nilaiIn);
    $rankKp = $hk['peringkat'] ?: pdf_label_kpmr($nilaiKp);
    $nilaiT = isset($ket['tingkat_risiko']) && trim((string)$ket['tingkat_risiko'])!=='' ? (float)$ket['tingkat_risiko'] : pdf_matrix_stratejik($rankIn, $rankKp);
    $rankT = trim((string)($ket['peringkat_tingkat_risiko'] ?? '')) ?: pdf_label_inheren($nilaiT);
    // Untuk cetak Profil Peringkat, Tingkat Kualitas Manajemen Risiko wajib mengikuti matriks OJK
    // berdasarkan kombinasi Risiko Inheren x KPMR, bukan hanya mengambil teks lama dari tabel keterangan.
    $kualitasMatrix = pdf_matrix_kualitas_mr($rankIn, $rankKp);
    $kualitasLama = trim((string)($ket['tingkat_kualitas_mr'] ?? ''));
    $kualitas = ($kualitasMatrix !== '') ? $kualitasMatrix : $kualitasLama;
    $uraianKpmr = trim((string)($ket['ket_profil_kpmr'] ?? ''));
    $uraianProfil = trim((string)($ket['ket_profil_risiko'] ?? ''));
    if ($type === 'kpmr') {
        return '<div class="clean-page"><h4>Risiko Stratejik - KPMR</h4><table class="table table-bordered" style="width:100%;border-collapse:collapse;"><thead><tr><th>Komponen</th><th>Nilai</th><th>Peringkat</th><th>Keterangan</th></tr></thead><tbody><tr><td>KPMR Stratejik</td><td>'.esc_pdf(pdf_num($nilaiKp)).'</td><td>'.esc_pdf($rankKp).'</td><td>'.esc_pdf($uraianKpmr).'</td></tr></tbody></table></div>';
    }
    return '<div class="clean-page"><h4>Profil Risiko Stratejik</h4><table class="table table-bordered" style="width:100%;border-collapse:collapse;"><thead><tr><th>Jenis Risiko</th><th>Tingkat Risiko Inheren</th><th>Tingkat KPMR</th><th>Tingkat Risiko</th><th>Tingkat Kualitas Manajemen Risiko</th></tr></thead><tbody><tr><td>Risiko Stratejik</td><td>'.esc_pdf(pdf_num($nilaiIn)).'<br>'.esc_pdf($rankIn).'</td><td>'.esc_pdf(pdf_num($nilaiKp)).'<br>'.esc_pdf($rankKp).'</td><td>'.esc_pdf(pdf_num($nilaiT)).'<br>'.esc_pdf($rankT).'</td><td>'.esc_pdf($kualitas ?: $uraianProfil).'</td></tr></tbody></table></div>';
}


function pdf_norm_rank_mr($v){
    $v = trim((string)$v);
    $v = preg_replace('/\s+/', ' ', $v);
    $map = [
        'sangat rendah' => 'Sangat Rendah',
        'rendah' => 'Rendah',
        'sedang' => 'Sedang',
        'tinggi' => 'Tinggi',
        'sangat tinggi' => 'Sangat Tinggi',
        'sangat memadai' => 'Sangat Memadai',
        'memadai' => 'Memadai',
        'cukup memadai' => 'Cukup Memadai',
        'kurang memadai' => 'Kurang Memadai',
        'tidak memadai' => 'Tidak Memadai',
    ];
    $key = strtolower($v);
    return isset($map[$key]) ? $map[$key] : $v;
}

function pdf_matrix_kualitas_mr($inherenRank, $kpmrRank){
    $inherenRank = pdf_norm_rank_mr($inherenRank);
    $kpmrRank    = pdf_norm_rank_mr($kpmrRank);

    // Matriks Penetapan Tingkat Risiko OJK:
    // baris = Risiko Inheren, kolom = Tingkat Kualitas Manajemen Risiko/KPMR.
    $m = [
        'Sangat Rendah' => [
            'Sangat Memadai' => 'Risiko Sangat Rendah',
            'Memadai' => 'Risiko Sangat Rendah',
            'Cukup Memadai' => 'Risiko Sangat Rendah',
            'Kurang Memadai' => 'Risiko Sangat Rendah',
            'Tidak Memadai' => 'Risiko Sangat Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
        ],
        'Rendah' => [
            'Sangat Memadai' => 'Risiko Sangat Rendah',
            'Memadai' => 'Risiko Rendah',
            'Cukup Memadai' => 'Risiko Rendah',
            'Kurang Memadai' => 'Risiko Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
            'Tidak Memadai' => 'Risiko Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        ],
        'Sedang' => [
            'Sangat Memadai' => 'Risiko Rendah',
            'Memadai' => 'Risiko Rendah',
            'Cukup Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
            'Kurang Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
            'Tidak Memadai' => 'Risiko Sedang (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)',
        ],
        'Tinggi' => [
            'Sangat Memadai' => 'Risiko Rendah',
            'Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
            'Cukup Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
            'Kurang Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)',
            'Tidak Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)',
        ],
        'Sangat Tinggi' => [
            'Sangat Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
            'Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)',
            'Cukup Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)',
            'Kurang Memadai' => 'Risiko Sangat Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)',
            'Tidak Memadai' => 'Risiko Sangat Tinggi (Dilakukan pengawasan melekat, membutuhkan pemantauan lebih mendalam)',
        ],
    ];

    return isset($m[$inherenRank][$kpmrRank]) ? $m[$inherenRank][$kpmrRank] : '';
}

function pdf_matrix_general($riskKey, $inherenRank, $kpmrRank){
    $riskKey = strtolower((string)$riskKey);
    $inherenRank = trim((string)$inherenRank);
    $kpmrRank = trim((string)$kpmrRank);

    $matrix_kredit_likuiditas = [
        'Sangat Rendah' => ['Sangat Memadai'=>1.00,'Memadai'=>1.10,'Cukup Memadai'=>1.15,'Kurang Memadai'=>1.20,'Tidak Memadai'=>1.25],
        'Rendah' => ['Sangat Memadai'=>1.05,'Memadai'=>1.68,'Cukup Memadai'=>1.96,'Kurang Memadai'=>2.11,'Tidak Memadai'=>2.25],
        'Sedang' => ['Sangat Memadai'=>1.39,'Memadai'=>1.82,'Cukup Memadai'=>2.92,'Kurang Memadai'=>3.08,'Tidak Memadai'=>3.25],
        'Tinggi' => ['Sangat Memadai'=>1.54,'Memadai'=>2.58,'Cukup Memadai'=>3.50,'Kurang Memadai'=>4.00,'Tidak Memadai'=>4.25],
        'Sangat Tinggi' => ['Sangat Memadai'=>2.42,'Memadai'=>2.75,'Cukup Memadai'=>3.75,'Kurang Memadai'=>4.63,'Tidak Memadai'=>5.00],
    ];
    $matrix_lain = [
        'Sangat Rendah' => ['Sangat Memadai'=>1.00,'Memadai'=>1.10,'Cukup Memadai'=>1.15,'Kurang Memadai'=>1.20,'Tidak Memadai'=>1.25],
        'Rendah' => ['Sangat Memadai'=>1.05,'Memadai'=>1.72,'Cukup Memadai'=>1.85,'Kurang Memadai'=>1.92,'Tidak Memadai'=>2.25],
        'Sedang' => ['Sangat Memadai'=>1.58,'Memadai'=>1.78,'Cukup Memadai'=>3.00,'Kurang Memadai'=>2.67,'Tidak Memadai'=>3.25],
        'Tinggi' => ['Sangat Memadai'=>1.65,'Memadai'=>2.58,'Cukup Memadai'=>3.50,'Kurang Memadai'=>4.00,'Tidak Memadai'=>4.25],
        'Sangat Tinggi' => ['Sangat Memadai'=>2.50,'Memadai'=>2.75,'Cukup Memadai'=>3.75,'Kurang Memadai'=>4.63,'Tidak Memadai'=>5.00],
    ];
    $m = in_array($riskKey, ['kredit','likuiditas'], true) ? $matrix_kredit_likuiditas : $matrix_lain;
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}
function pdf_get_profil_risk($conn, $id, $key){
    $defs = [
        'kredit'      => ['label'=>'Risiko kredit',      'ket'=>'keterangan_profil_kredit',      'in'=>'hasil_inheren_kredit',      'kp'=>'hasil_kpmr_kredit',      'cin'=>'inheren_kredit',      'ckp'=>'kpmr_kredit'],
        'operasional' => ['label'=>'Risiko operasional', 'ket'=>'keterangan_profil_operasional', 'in'=>'hasil_inheren_operasional', 'kp'=>'hasil_kpmr_operasional', 'cin'=>'inheren_operasional', 'ckp'=>'kpmr_operasional'],
        'kepatuhan'   => ['label'=>'Risiko kepatuhan',   'ket'=>'keterangan_profil_kepatuhan',   'in'=>'hasil_inheren_kepatuhan',   'kp'=>'hasil_kpmr_kepatuhan',   'cin'=>'inheren_kepatuhan',   'ckp'=>'kpmr_kepatuhan'],
        'likuiditas'  => ['label'=>'Risiko likuiditas',  'ket'=>'keterangan_profil_likuiditas',  'in'=>'hasil_inheren_likuiditas',  'kp'=>'hasil_kpmr_likuiditas',  'cin'=>'inheren_likuiditas',  'ckp'=>'kpmr_likuiditas'],
        'reputasi'    => ['label'=>'Risiko reputasi',    'ket'=>'keterangan_profil_reputasi',    'in'=>'hasil_inheren_reputasi',    'kp'=>'hasil_kpmr_reputasi',    'cin'=>'inheren_reputasi',    'ckp'=>'kpmr_reputasi'],
        'stratejik'   => ['label'=>'Risiko stratejik',   'ket'=>'keterangan_profil_stratejik',   'in'=>'hasil_inheren_stratejik',   'kp'=>'hasil_kpmr_stratejik',   'cin'=>'inheren_stratejik',   'ckp'=>'kpmr_stratejik'],
    ];
    if (!isset($defs[$key])) return [];
    $d = $defs[$key];
    $ket = pdf_table_exists($conn, $d['ket']) ? pdf_one($conn, "SELECT * FROM `{$d['ket']}` WHERE id_profil_risiko='".(int)$id."' LIMIT 1") : [];
    $hin = pdf_result_from_table($conn, $d['in'], $id, 'inheren');
    $hkp = pdf_result_from_table($conn, $d['kp'], $id, 'kpmr');

    $nilaiIn = 0.00;
    if (isset($ket[$d['cin']]) && trim((string)$ket[$d['cin']]) !== '') $nilaiIn = (float)str_replace(',', '.', (string)$ket[$d['cin']]);
    elseif ((float)$hin['nilai'] > 0) $nilaiIn = (float)$hin['nilai'];

    $nilaiKp = 0.00;
    if (isset($ket[$d['ckp']]) && trim((string)$ket[$d['ckp']]) !== '') $nilaiKp = (float)str_replace(',', '.', (string)$ket[$d['ckp']]);
    elseif ((float)$hkp['nilai'] > 0) $nilaiKp = (float)$hkp['nilai'];

    $rankIn = trim((string)($hin['peringkat'] ?? '')) ?: pdf_label_inheren($nilaiIn);
    $rankKp = trim((string)($hkp['peringkat'] ?? '')) ?: pdf_label_kpmr($nilaiKp);

    $nilaiT = 0.00;
    if (isset($ket['tingkat_risiko']) && trim((string)$ket['tingkat_risiko']) !== '') $nilaiT = (float)str_replace(',', '.', (string)$ket['tingkat_risiko']);
    if ($nilaiT <= 0) $nilaiT = pdf_matrix_general($key, $rankIn, $rankKp);

    $rankT = trim((string)($ket['peringkat_tingkat_risiko'] ?? '')) ?: pdf_label_inheren($nilaiT);
    // Untuk cetak Profil Peringkat, Tingkat Kualitas Manajemen Risiko wajib mengikuti matriks OJK
    // berdasarkan kombinasi Risiko Inheren x KPMR, bukan hanya mengambil teks lama dari tabel keterangan.
    $kualitasMatrix = pdf_matrix_kualitas_mr($rankIn, $rankKp);
    $kualitasLama = trim((string)($ket['tingkat_kualitas_mr'] ?? ''));
    $kualitas = ($kualitasMatrix !== '') ? $kualitasMatrix : $kualitasLama;

    return [
        'label'=>$d['label'],
        'nilai_in'=>round($nilaiIn,2), 'nilai_kp'=>round($nilaiKp,2), 'nilai_t'=>round($nilaiT,2),
        'rank_in'=>$rankIn, 'rank_kp'=>$rankKp, 'rank_t'=>$rankT, 'kualitas'=>$kualitas
    ];
}

function pdf_profile_per_risk_html($conn, $id, $frame, $key){
    global $isProfilCabangCetak;
    $r = pdf_get_profil_risk($conn, $id, $key);
    if (!$r) return '';
    $dp = isset($frame['data_pembanding']) ? (int)$frame['data_pembanding'] : 0;
    $rp = $dp > 0 ? pdf_get_profil_risk($conn, $dp, $key) : [];
    $title = strtoupper($r['label'] ?? ('Risiko '.$key));
    $title = str_replace('RISIKO ', 'RISIKO ', $title);

    $mk = static function($row, $caption) use ($isProfilCabangCetak) {
        return cetak_ringkas_profile_table($row, $caption, (bool)$isProfilCabangCetak);
    };
    if (!$rp) $rp = ['label'=>$r['label'] ?? '', 'nilai_in'=>0, 'nilai_kp'=>0, 'nilai_t'=>0, 'rank_in'=>'', 'rank_kp'=>'', 'rank_t'=>'', 'kualitas'=>''];
    return '<div class="clean-page profil-risk-direct"><h4>HASIL PROFIL '.esc_pdf(strtoupper($r['label'] ?? '')).'</h4>'
        .'<table class="profile-risk-title"><tr><th>'.esc_pdf(strtoupper($r['label'] ?? '')).'</th></tr></table>'
        .'<div class="profil-pair-direct"><div>'.$mk($r, 'Penilaian Profil Risiko').'</div><div>'.$mk($rp, 'Penilaian Profil Risiko Periode Sebelumnya').'</div></div></div>';
}


function pdf_lookup_definisi_tingkat_risiko($conn, $key, $rank){
    $rank = trim((string)$rank);
    if ($rank === '') return '';
    $key = strtolower((string)$key);
    $tables = [
        $key === 'kredit' ? 'matrik_ojk_kredit' : '',
        $key === 'kredit' ? 'matrik_ojk_kredit1' : '',
        $key === 'operasional' ? 'matrik_ojk_operasional' : '',
        $key === 'operasional' ? 'matrik_ojk_operasional1' : '',
        $key === 'kepatuhan' ? 'matrik_ojk_kepatuhan' : '',
        $key === 'kepatuhan' ? 'matrik_ojk_kepatuhan1' : '',
        $key === 'likuiditas' ? 'matrik_ojk_likuiditas' : '',
        $key === 'likuiditas' ? 'matrik_ojk_likuiditas1' : '',
        $key === 'reputasi' ? 'matrik_ojk_reputasi' : '',
        $key === 'reputasi' ? 'matrik_ojk_reputasi1' : '',
        $key === 'stratejik' ? 'matrik_ojk_stratejik' : '',
        $key === 'stratejik' ? 'matrik_ojk_stratejik1' : '',
    ];
    $rankEsc = mysqli_real_escape_string($conn, $rank);
    foreach ($tables as $tb) {
        if ($tb === '' || !pdf_table_exists($conn, $tb)) continue;
        $row = pdf_one($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko = '$rankEsc' LIMIT 1");
        if (!$row) continue;
        foreach(['definisi_tingkat_risiko','definisi','keterangan','uraian','tingkat_risiko'] as $col){
            if (isset($row[$col]) && trim((string)$row[$col]) !== '') return trim((string)$row[$col]);
        }
    }
    return '';
}

function pdf_tindak_lanjut_per_risk_html($conn, $id, $frame, $key, $nomor){
    $defs = [
        'kredit'      => ['label'=>'Risiko Kredit',      'table'=>'keterangan_profil_kredit',      'judul'=>'Kredit'],
        'operasional' => ['label'=>'Risiko Operasional', 'table'=>'keterangan_profil_operasional', 'judul'=>'Operasional'],
        'kepatuhan'   => ['label'=>'Risiko Kepatuhan',   'table'=>'keterangan_profil_kepatuhan',   'judul'=>'Kepatuhan'],
        'likuiditas'  => ['label'=>'Risiko Likuiditas',  'table'=>'keterangan_profil_likuiditas',  'judul'=>'Likuiditas'],
        'reputasi'    => ['label'=>'Risiko Reputasi',    'table'=>'keterangan_profil_reputasi',    'judul'=>'Reputasi'],
        'stratejik'   => ['label'=>'Risiko Stratejik',   'table'=>'keterangan_profil_stratejik',   'judul'=>'Stratejik'],
    ];
    if (!isset($defs[$key])) return '';
    $d = $defs[$key];
    $id = (int)$id;
    $ket = pdf_table_exists($conn, $d['table']) ? pdf_one($conn, "SELECT * FROM `{$d['table']}` WHERE id_profil_risiko='$id' LIMIT 1") : [];
    $r = pdf_get_profil_risk($conn, $id, $key);

    $analisis = trim((string)($ket['ket_profil_inheren'] ?? ''));
    $usulan = trim((string)($ket['ket_profil_risiko'] ?? ''));
    $respon = trim((string)($ket['ket_respon_cabang'] ?? ''));
    $nilai = isset($r['nilai_in']) ? pdf_num($r['nilai_in']) : '0.00';
    $peringkat = trim((string)($r['rank_in'] ?? ''));
    $definisi = pdf_lookup_definisi_tingkat_risiko($conn, $key, $peringkat);
    if ($definisi === '') {
        $definisi = 'Definisi tingkat risiko belum tersedia pada tabel matrik OJK '.strtolower($d['judul']).'.';
    }

    $html = '<div class="clean-page tindak-lanjut-direct">';
    $html .= '<h3>'.(int)$nomor.'. '.esc_pdf(strtoupper($d['label'])).'</h3>';
    $html .= '<table class="tl-info"><tr><td><b>Kantor</b></td><td>'.esc_pdf($frame['cabang'] ?? '-').'</td><td><b>Tahun</b></td><td>'.esc_pdf($frame['tahun'] ?? '-').'</td><td><b>Periode</b></td><td>'.esc_pdf($frame['periode_laporan'] ?? '-').'</td></tr></table>';
    $html .= '<table class="tl-table">';
    $html .= '<tr><th style="width:22%;">Komponen</th><th>Uraian</th></tr>';
    $html .= '<tr><td><b>Analisis Risiko '.esc_pdf($d['judul']).'</b></td><td class="tl-text">'.nl2br(esc_pdf($analisis !== '' ? $analisis : '-')).'</td></tr>';
    $html .= '<tr><td><b>Analisa Nilai Tertinggi Risiko '.esc_pdf($d['judul']).'</b></td><td class="tl-text">Nilai risiko inheren '.esc_pdf($d['label']).' ditetapkan sebesar <b>'.esc_pdf($nilai).'</b>'.($peringkat !== '' ? ' dengan peringkat <b>'.esc_pdf($peringkat).'</b>' : '').'.</td></tr>';
    $html .= '<tr><td><b>Definisi Tingkat Risiko '.esc_pdf($d['judul']).' (Matrik OJK)</b><br><small>'.esc_pdf($peringkat).'</small></td><td class="tl-text">'.nl2br(esc_pdf($definisi)).'</td></tr>';
    $html .= '<tr><td><b>Usulan Perbaikan &amp;<br>Tindak Lanjut</b><br><small>note. diisi oleh residence dan korwil</small></td><td class="tl-text">'.nl2br(esc_pdf($usulan !== '' ? $usulan : '-')).'</td></tr>';
    $html .= '<tr><td><b>Respon Cabang &amp;<br>Hasil Perbaikan</b><br><small>note. diisi oleh cabang</small></td><td class="tl-text">'.nl2br(esc_pdf($respon !== '' ? $respon : '-')).'</td></tr>';
    $html .= '</table>';
    $html .= '</div>';
    return $html;
}

function pdf_peringkat_konsolidasi_html($conn, $id, $frame){
    $risks = ['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik'];
    $rows = [];
    foreach($risks as $rk){ $rows[$rk] = pdf_get_profil_risk($conn, $id, $rk); }
    $dp = isset($frame['data_pembanding']) ? (int)$frame['data_pembanding'] : 0;
    $rowsPem = [];
    foreach($risks as $rk){ $rowsPem[$rk] = $dp > 0 ? pdf_get_profil_risk($conn, $dp, $rk) : ['label'=>$rows[$rk]['label'] ?? ('Risiko '.$rk), 'rank_in'=>'', 'rank_kp'=>'', 'rank_t'=>'', 'kualitas'=>'']; }

    $mkTable = function($rows, $title, $isPem=false){
        $html = '<table class="pdf-profile-table"><thead><tr><th colspan="5">'.esc_pdf($title).'</th></tr><tr><th>Jenis Risiko</th><th>Tingkat Risiko Inheren</th><th>Tingkat KPMR</th><th>Tingkat Risiko</th><th>Tingkat Kualitas Manajemen Risiko</th></tr></thead><tbody>';
        foreach($rows as $r){
            $html .= '<tr>';
            $html .= '<td><b>'.esc_pdf($r['label'] ?? '').'</b></td>';
            $html .= '<td>'.esc_pdf($r['rank_in'] ?? '').'</td>';
            $html .= '<td>'.esc_pdf($r['rank_kp'] ?? '').'</td>';
            $html .= '<td>'.esc_pdf($r['rank_t'] ?? '').'</td>';
            $html .= '<td class="quality-cell">'.esc_pdf($r['kualitas'] ?? '').'</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        return $html;
    };
    return '<div class="clean-page profil-peringkat-direct"><h4>HASIL PERINGKAT PROFIL RISIKO</h4><div class="profil-pair-direct">'.
        '<div>'.$mkTable($rows, 'Penilaian Profil Risiko<br><small>('.esc_pdf($frame['tipe_user'] ?? '').' '.esc_pdf($frame['cabang'] ?? '').' Tahun '.esc_pdf($frame['tahun'] ?? '').' - '.esc_pdf($frame['periode_laporan'] ?? '').')</small>').'</div>'.
        '<div>'.$mkTable($rowsPem, 'Pembanding<br><small>( Tahun - )</small>', true).'</div>'.
        '</div></div>';
}



function pdf_cover_profil_nilai_peringkat_html($conn, $id, $frame){
    $risks = ['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik'];
    $rows = [];
    foreach($risks as $rk){ $rows[$rk] = pdf_get_profil_risk($conn, $id, $rk); }

    $isCabang = ((int)($frame['user'] ?? 0) === 3 || stripos((string)($frame['tipe_user'] ?? ''), 'Kantor Cabang') !== false);

    /*
      Khusus Profil Risiko Kantor Cabang:
      - ringkasan halaman depan hanya tampil Jenis Risiko + Tingkat Risiko Inheren
      - nilai komposit dihitung dari Nilai Inheren x Bobot Profil Risiko
      - tidak menampilkan KPMR, Tingkat Risiko, dan Tingkat Kualitas MR.
    */
    $total = 0;
    $bobotTotal = 0;
    $map = [];

    if (pdf_table_exists($conn, 'setting_bobot_profil_risiko') && pdf_table_exists($conn, 'setting_bobot_profil_risiko_detail')) {
        $tahun = mysqli_real_escape_string($conn, (string)($frame['tahun'] ?? ''));
        $user  = (int)($frame['user'] ?? 0);

        /* Ambil bobot sesuai tahun + user jika kolomnya tersedia, fallback ke setting aktif terakhir */
        $where = " WHERE 1=1 ";
        if (pdf_col_exists($conn, 'setting_bobot_profil_risiko', 'tahun') && $tahun !== '') {
            $where .= " AND tahun = '$tahun' ";
        }
        if (pdf_col_exists($conn, 'setting_bobot_profil_risiko', 'user') && $user > 0) {
            $where .= " AND user = '$user' ";
        } elseif (pdf_col_exists($conn, 'setting_bobot_profil_risiko', 'id_user_profil_risiko') && $user > 0) {
            $where .= " AND id_user_profil_risiko = '$user' ";
        }
        if (pdf_col_exists($conn, 'setting_bobot_profil_risiko', 'is_aktif')) {
            $where .= " AND is_aktif = 1 ";
        }

        $idCol = pdf_col_exists($conn, 'setting_bobot_profil_risiko', 'id_setting') ? 'id_setting' : 'id';
        $setting = pdf_one($conn, "SELECT `$idCol` AS id_setting FROM setting_bobot_profil_risiko $where ORDER BY `$idCol` DESC LIMIT 1");
        if (!$setting || empty($setting['id_setting'])) {
            $setting = pdf_one($conn, "SELECT `$idCol` AS id_setting FROM setting_bobot_profil_risiko ORDER BY `$idCol` DESC LIMIT 1");
        }

        if ($setting && !empty($setting['id_setting'])) {
            $fkCol = pdf_col_exists($conn, 'setting_bobot_profil_risiko_detail', 'id_setting') ? 'id_setting' : 'id_bobot';
            $q = mysqli_query($conn, "SELECT jenis_risiko,bobot FROM setting_bobot_profil_risiko_detail WHERE `$fkCol`='".(int)$setting['id_setting']."'");
            if ($q) {
                while($r = mysqli_fetch_assoc($q)){
                    $key = strtolower(trim((string)$r['jenis_risiko']));
                    $key = str_replace('risiko ', '', $key);
                    $map[$key] = (float)str_replace(',', '.', (string)$r['bobot']);
                }
            }
        }
    }

    foreach($rows as $rk => $r){
        $bobot = isset($map[$rk]) ? (float)$map[$rk] : 0;
        $nilaiDasar = $isCabang ? (float)($r['nilai_in'] ?? 0) : (float)($r['nilai_t'] ?? 0);
        $total += $nilaiDasar * $bobot;
        $bobotTotal += $bobot;
    }
    if ($bobotTotal > 0) {
        $total = $total / $bobotTotal;
    } else {
        $vals = [];
        foreach($rows as $r){
            $v = $isCabang ? (float)($r['nilai_in'] ?? 0) : (float)($r['nilai_t'] ?? 0);
            if ($v > 0) $vals[] = $v;
        }
        $total = count($vals) ? array_sum($vals)/count($vals) : 0;
    }
    $totalRank = pdf_label_inheren($total);

    $html = '<div class="cover-summary"><div class="cover-summary-title">RINGKASAN PROFIL NILAI DAN PERINGKAT</div>';

    if ($isCabang) {
        $html .= '<table class="cover-summary-inheren-only"><thead><tr><th>Jenis Risiko</th><th>Tingkat Risiko Inheren</th></tr></thead><tbody>';
        foreach($rows as $r){
            $html .= '<tr>';
            $html .= '<td><b>'.esc_pdf($r['label'] ?? '').'</b></td>';
            $html .= '<td>'.esc_pdf(pdf_num($r['nilai_in'] ?? 0)).'<br><b>'.esc_pdf($r['rank_in'] ?? '').'</b></td>';
            $html .= '</tr>';
        }
        $html .= '<tr class="cover-summary-total"><td><b>Peringkat Risiko Inheren ditetapkan berdasarkan pertimbangan BPR</b></td><td><b>'.esc_pdf(pdf_num($total)).'</b><br><b>'.esc_pdf($totalRank).'</b></td></tr>';
        $html .= '</tbody></table></div>';
        return $html;
    }

    $html .= '<table><thead><tr><th>Jenis Risiko</th><th>Tingkat Risiko Inheren</th><th>Tingkat KPMR</th><th>Tingkat Risiko</th><th>Tingkat Kualitas Manajemen Risiko</th></tr></thead><tbody>';
    foreach($rows as $r){
        $html .= '<tr>';
        $html .= '<td><b>'.esc_pdf($r['label'] ?? '').'</b></td>';
        $html .= '<td>'.esc_pdf(pdf_num($r['nilai_in'] ?? 0)).'<br><b>'.esc_pdf($r['rank_in'] ?? '').'</b></td>';
        $html .= '<td>'.esc_pdf(pdf_num($r['nilai_kp'] ?? 0)).'<br><b>'.esc_pdf($r['rank_kp'] ?? '').'</b></td>';
        $html .= '<td>'.esc_pdf(pdf_num($r['nilai_t'] ?? 0)).'<br><b>'.esc_pdf($r['rank_t'] ?? '').'</b></td>';
        $html .= '<td class="quality">'.esc_pdf($r['kualitas'] ?? '').'</td>';
        $html .= '</tr>';
    }
    $html .= '<tr class="cover-summary-total"><td colspan="3"><b>Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR</b></td><td><b>'.esc_pdf(pdf_num($total)).'</b></td><td><b>'.esc_pdf($totalRank).'</b></td></tr>';
    $html .= '</tbody></table></div>';
    return $html;
}

function pdf_inheren_simple_fallback_html($conn, $id, $frame, $key, $judul){
    $defs = [
        'kepatuhan' => ['label'=>'Risiko Kepatuhan', 'table'=>'hasil_inheren_kepatuhan', 'ket'=>'keterangan_profil_kepatuhan', 'ket_col'=>'ket_profil_inheren'],
    ];
    if (!isset($defs[$key])) return '';
    $d = $defs[$key];

    /*
      Fallback ini sengaja dibuat lebih besar dan stabil.
      Tujuannya: jika route halaman Kepatuhan Inheren 1/2 tidak ketemu, hasil cetak tidak lagi hanya tabel kecil 1 baris.
      Data utama tetap diambil dari hasil_inheren_kepatuhan dan keterangan_profil_kepatuhan.
      Kalau di database ada kolom hasil_pilar*, kolom tersebut akan ditampilkan sebagai rekap pilar.
    */
    $resRow = [];
    if (pdf_table_exists($conn, $d['table'])) {
        $resRow = pdf_one($conn, "SELECT * FROM `{$d['table']}` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    }
    $res = pdf_pick_result($resRow, 'inheren');

    $ket = [];
    if (pdf_table_exists($conn, $d['ket'])) {
        $ket = pdf_one($conn, "SELECT * FROM `{$d['ket']}` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    }
    $uraian = trim((string)($ket[$d['ket_col']] ?? ''));
    $nilai = (float)($res['nilai'] ?? 0);
    $peringkat = trim((string)($res['peringkat'] ?? '')) ?: pdf_label_inheren($nilai);

    $pilarRows = [];
    if ($resRow) {
        $labels = [
            'hasil_pilar1' => 'Hasil Penilaian Pilar 1',
            'hasil_pilar_1' => 'Hasil Penilaian Pilar 1',
            'pilar1' => 'Hasil Penilaian Pilar 1',
            'nilai_pilar1' => 'Hasil Penilaian Pilar 1',
            'hasil_pilar2' => 'Hasil Penilaian Pilar 2',
            'hasil_pilar_2' => 'Hasil Penilaian Pilar 2',
            'pilar2' => 'Hasil Penilaian Pilar 2',
            'nilai_pilar2' => 'Hasil Penilaian Pilar 2',
            'hasil_pilar3' => 'Hasil Penilaian Pilar 3',
            'hasil_pilar_3' => 'Hasil Penilaian Pilar 3',
            'pilar3' => 'Hasil Penilaian Pilar 3',
            'nilai_pilar3' => 'Hasil Penilaian Pilar 3',
            'hasil_pilar4' => 'Hasil Penilaian Pilar 4',
            'hasil_pilar_4' => 'Hasil Penilaian Pilar 4',
            'pilar4' => 'Hasil Penilaian Pilar 4',
            'nilai_pilar4' => 'Hasil Penilaian Pilar 4',
            'hasil_lainnya' => 'Hasil Penilaian Lainnya',
            'lainnya' => 'Hasil Penilaian Lainnya',
        ];
        $used = [];
        foreach($labels as $col=>$label){
            if (array_key_exists($col, $resRow) && trim((string)$resRow[$col]) !== '' && !isset($used[$label])) {
                $pilarRows[] = ['label'=>$label, 'nilai'=>(float)str_replace(',', '.', (string)$resRow[$col])];
                $used[$label] = true;
            }
        }
    }

    $html = '<div class="clean-page fallback-inheren-page fallback-kepatuhan-detail">'
        . '<h4>'.esc_pdf($judul).' ['.esc_pdf($frame['cabang'] ?? '').' Tahun '.esc_pdf($frame['tahun'] ?? '').' - '.esc_pdf($frame['periode_laporan'] ?? '').']</h4>'
        . '<table class="table table-bordered rekap-inheren-center" style="width:100%;border-collapse:collapse;table-layout:fixed;">'
        . '<thead><tr><th colspan="2">'.esc_pdf(strtoupper($judul)).'</th></tr></thead><tbody>';

    if (!empty($pilarRows)) {
        foreach($pilarRows as $pr){
            $html .= '<tr><td style="width:75%;"><b>'.esc_pdf($pr['label']).'</b></td><td class="print-inheren-center" style="text-align:center;vertical-align:middle;">'.esc_pdf(pdf_num($pr['nilai'])).'<br><small>Tingkat risiko</small></td></tr>';
        }
    } else {
        $html .= '<tr><td style="width:75%;"><b>Rekap Penilaian Inheren Kepatuhan</b></td><td class="print-inheren-center" style="text-align:center;vertical-align:middle;">'.esc_pdf(pdf_num($nilai)).'<br><small>Tingkat risiko</small></td></tr>';
    }

    $html .= '<tr><td><b>Hasil Penilaian Inheren</b></td><td class="print-inheren-center" style="text-align:center;vertical-align:middle;">'.esc_pdf(pdf_num($nilai)).'<br><b>'.esc_pdf($peringkat).'</b></td></tr>'
        . '<tr><th colspan="2" style="text-align:center;">Uraian Untuk '.esc_pdf($judul).'</th></tr>'
        . '<tr><td colspan="2" style="white-space:pre-wrap;min-height:70px;vertical-align:top;">'.esc_pdf($uraian).'</td></tr>'
        . '</tbody></table>'
        . '<div style="font-size:9px;margin-top:6px;color:#000;">Catatan: halaman asli Kepatuhan Inheren tidak ditemukan oleh route cetak, sehingga bagian ini memakai fallback rekap dari tabel hasil/keterangan.</div>'
        . '</div>';
    return $html;
}


/* =========================================================
   FIX KHUSUS CETAK KEPATUHAN INHEREN 1 & 2
   - Tidak lagi mengandalkan route iframe yang sering tidak ketemu.
   - Dibangun langsung dari tabel assessment_inheren, assessment_inheren_detail,
     master parameter, dan checklist parameter.
   ========================================================= */

function pdf_kep_q($conn, $sql){
    $q = mysqli_query($conn, $sql);
    return $q ?: false;
}
function pdf_kep_one($conn, $sql){
    $q = pdf_kep_q($conn, $sql);
    return ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : [];
}
function pdf_kep_avg($arr){
    $nums = [];
    foreach((array)$arr as $v){
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(array_sum($nums) / count($nums), 2) : 0;
}
function pdf_kep_max($arr){
    $nums = [];
    foreach((array)$arr as $v){
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(max($nums), 2) : 0;
}
function pdf_kep_min($arr){
    $nums = [];
    foreach((array)$arr as $v){
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(min($nums), 2) : 0;
}
function pdf_kep_concat($arr){
    $out = [];
    foreach((array)$arr as $v){
        $v = trim((string)$v);
        if ($v !== '') $out[] = $v;
    }
    return implode("\n", array_values(array_unique($out)));
}
function pdf_kep_alpha($i){
    $letters = range('a','z');
    return isset($letters[$i]) ? $letters[$i] : (string)($i + 1);
}
function pdf_kep_detail_map($conn, $assessment_id){
    $map = [];
    if ((int)$assessment_id <= 0 || !pdf_table_exists($conn, 'assessment_inheren_detail')) return $map;
    $q = pdf_kep_q($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment_id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){
            $map[$r['ref_tipe'].'|'.$r['ref_id']] = $r;
        }
    }
    return $map;
}
function pdf_kep_skala_map($conn, $ref_tipe, $ref_id){
    $map = [];
    if (!pdf_table_exists($conn, 'pr_skala')) return $map;
    $rt = mysqli_real_escape_string($conn, (string)$ref_tipe);
    $rid = (int)$ref_id;
    $q = pdf_kep_q($conn, "SELECT skala, deskripsi FROM pr_skala WHERE ref_tipe='$rt' AND ref_id='$rid' ORDER BY skala ASC");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){
            $map[(int)$r['skala']] = $r['deskripsi'];
        }
    }
    return $map;
}
function pdf_kep_get_assessment($conn, $id_profil_risiko){
    if (!pdf_table_exists($conn, 'assessment_inheren')) return [];
    return pdf_kep_one($conn, "
        SELECT *
        FROM assessment_inheren
        WHERE id_profil_risiko='".(int)$id_profil_risiko."'
          AND jenis_risiko='RISIKO KEPATUHAN'
        LIMIT 1
    ");
}
function pdf_kep_load_group($conn, $frame){
    $group = [];
    if (!pdf_table_exists($conn, 'pr_pilih_parameter') ||
        !pdf_table_exists($conn, 'pr_inheren_periode') ||
        !pdf_table_exists($conn, 'pr_pilih_parameter_detail') ||
        !pdf_table_exists($conn, 'pr_jenis_risiko') ||
        !pdf_table_exists($conn, 'pr_pilar') ||
        !pdf_table_exists($conn, 'pr_parameter')) {
        return $group;
    }

    $tahun = mysqli_real_escape_string($conn, (string)($frame['tahun'] ?? ''));
    $user  = (int)($frame['user'] ?? 0);

    $pilihHeader = pdf_kep_one($conn, "
        SELECT pp.*, pi.tahun
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pi.tahun = '$tahun'
          AND pp.id_user_profil_risiko = '$user'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $group;

    $id_pilih = (int)$pilihHeader['id'];
    $periode_master_id = (int)$pilihHeader['pr_inheren_periode_id'];

    $checkedParam = [];
    $checkedSub = [];
    $qChecklist = pdf_kep_q($conn, "
        SELECT ref_tipe, ref_id
        FROM pr_pilih_parameter_detail
        WHERE pr_pilih_parameter_id = '$id_pilih'
    ");
    if ($qChecklist) {
        while($ck = mysqli_fetch_assoc($qChecklist)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $qData = pdf_kep_q($conn, "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan,
            sp.id AS sub_parameter_id,
            sp.nama_sub_parameter,
            sp.urutan AS sub_urutan
        FROM pr_jenis_risiko jr
        INNER JOIN pr_pilar p
            ON p.jenis_risiko_id = jr.id
           AND p.pr_inheren_periode_id = '$periode_master_id'
        INNER JOIN pr_parameter pm
            ON pm.pilar_id = p.id
           AND pm.pr_inheren_periode_id = '$periode_master_id'
        LEFT JOIN pr_sub_parameter sp
            ON sp.parameter_id = pm.id
           AND sp.pr_inheren_periode_id = '$periode_master_id'
        WHERE jr.nama_risiko = 'RISIKO KEPATUHAN'
          AND jr.pr_inheren_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, sp.urutan
    ");
    if (!$qData) return $group;

    while($r = mysqli_fetch_assoc($qData)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];

        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;

        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = [
                'pilar_id' => $pilar_id,
                'nama_pilar' => $r['nama_pilar'],
                'urutan' => (int)$r['pilar_urutan'],
                'parameters' => []
            ];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = [
                'parameter_id' => $parameter_id,
                'nomor_parameter' => $r['nomor_parameter'],
                'nama_parameter' => $r['nama_parameter'],
                'urutan' => (int)$r['parameter_urutan'],
                'show_parameter' => $showParameter,
                'subs' => []
            ];
        } else if ($showParameter) {
            $group[$pilar_id]['parameters'][$parameter_id]['show_parameter'] = true;
        }

        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = [
                'sub_parameter_id' => $sub_id,
                'nama_sub_parameter' => $r['nama_sub_parameter'],
                'urutan' => (int)$r['sub_urutan']
            ];
        }
    }
    return $group;
}
function pdf_kep_dynamic_notes($conn, $id){
    $map = [];
    if (!pdf_table_exists($conn, 'inheren2_kepatuhan_catatan_dinamis')) return $map;
    $q = pdf_kep_q($conn, "SELECT * FROM inheren2_kepatuhan_catatan_dinamis WHERE id_profil_risiko='".(int)$id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){
            $map[$r['scope_type'].'|'.(int)$r['scope_ref_id']] = $r;
        }
    }
    return $map;
}
function pdf_kep_inheren1_detail_html($conn, $id, $frame){
    $group = pdf_kep_load_group($conn, $frame);
    $assessment = pdf_kep_get_assessment($conn, $id);
    $detail = $assessment ? pdf_kep_detail_map($conn, (int)$assessment['id_assessment_inheren']) : [];

    $detailPrev = [];
    if (!empty($frame['data_pembanding'])) {
        $assPrev = pdf_kep_get_assessment($conn, (int)$frame['data_pembanding']);
        $detailPrev = $assPrev ? pdf_kep_detail_map($conn, (int)$assPrev['id_assessment_inheren']) : [];
    }

    if (empty($group)) {
        return pdf_inheren_simple_fallback_html($conn, $id, $frame, 'kepatuhan', 'Risiko Kepatuhan - Inheren 1');
    }

    $html = '<div class="clean-page kepatuhan-inheren-direct">'
        . '<h4>Risiko Kepatuhan Inheren 1 ['.esc_pdf($frame['cabang'] ?? '').' Tahun '.esc_pdf($frame['tahun'] ?? '').' - '.esc_pdf($frame['periode_laporan'] ?? '').']</h4>'
        . '<table class="table table-bordered inheren-lain-ket-wide rekap-inheren-center" style="width:100%;border-collapse:collapse;table-layout:fixed;">'
        . '<colgroup>'
        . '<col style="width:4%"><col style="width:18%"><col style="width:9%"><col style="width:9%"><col style="width:9%"><col style="width:9%"><col style="width:9%"><col style="width:7%"><col style="width:8%"><col style="width:18%">'
        . '</colgroup>'
        . '<thead>'
        . '<tr><th colspan="10">RISIKO KEPATUHAN INHEREN 1</th></tr>'
        . '<tr><th rowspan="2">NO</th><th rowspan="2">PARAMETER</th><th colspan="5">SKALA RISIKO</th><th rowspan="2">PENILAIAN</th><th rowspan="2">PENILAIAN PERIODE SEBELUMNYA</th><th rowspan="2">KETERANGAN</th></tr>'
        . '<tr><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th></tr>'
        . '</thead><tbody>';

    foreach($group as $pilar){
        $html .= '<tr><th colspan="10" style="text-align:left;">PILAR '.esc_pdf($pilar['urutan']).' : '.esc_pdf($pilar['nama_pilar']).'</th></tr>';
        foreach($pilar['parameters'] as $parameter_id => $param){
            if (!empty($param['show_parameter'])) {
                $ref = 'parameter|'.$parameter_id;
                $old = $detail[$ref] ?? [];
                $oldPrev = $detailPrev[$ref]['nilai'] ?? ($old['nilai_sebelumnya'] ?? 0);
                $skala = pdf_kep_skala_map($conn, 'parameter', $parameter_id);

                $html .= '<tr>';
                $html .= '<td class="print-inheren-center">'.esc_pdf($param['nomor_parameter']).'</td>';
                $html .= '<td><b>'.esc_pdf($param['nama_parameter']).'</b></td>';
                for($i=1;$i<=5;$i++) $html .= '<td>'.esc_pdf($skala[$i] ?? '-').'</td>';
                $html .= '<td class="print-inheren-center">'.esc_pdf($old['nilai'] ?? '').'</td>';
                $html .= '<td class="print-inheren-center">'.esc_pdf(pdf_num($oldPrev)).'</td>';
                $html .= '<td>'.nl2br(esc_pdf($old['keterangan'] ?? '')).'</td>';
                $html .= '</tr>';
            }

            if (!empty($param['subs'])) {
                $idx = 0;
                foreach($param['subs'] as $sub_id => $sub){
                    $ref = 'sub_parameter|'.$sub_id;
                    $old = $detail[$ref] ?? [];
                    $oldPrev = $detailPrev[$ref]['nilai'] ?? ($old['nilai_sebelumnya'] ?? 0);
                    $skala = pdf_kep_skala_map($conn, 'sub_parameter', $sub_id);
                    $html .= '<tr>';
                    $html .= '<td></td>';
                    $html .= '<td>'.esc_pdf(pdf_kep_alpha($idx)).'. '.esc_pdf($sub['nama_sub_parameter']).'</td>';
                    for($i=1;$i<=5;$i++) $html .= '<td>'.esc_pdf($skala[$i] ?? '-').'</td>';
                    $html .= '<td class="print-inheren-center">'.esc_pdf($old['nilai'] ?? '').'</td>';
                    $html .= '<td class="print-inheren-center">'.esc_pdf(pdf_num($oldPrev)).'</td>';
                    $html .= '<td>'.nl2br(esc_pdf($old['keterangan'] ?? '')).'</td>';
                    $html .= '</tr>';
                    $idx++;
                }
            }
        }
    }

    $res = pdf_result_from_table($conn, 'hasil_inheren_kepatuhan', $id, 'inheren');
    $ket = pdf_table_exists($conn, 'keterangan_profil_kepatuhan') ? pdf_one($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko='".(int)$id."' LIMIT 1") : [];
    $html .= '<tr><th colspan="7" style="text-align:left;">Hasil Penilaian Inheren Kepatuhan</th><td class="print-inheren-center" colspan="2">'.esc_pdf(pdf_num($res['nilai'] ?? 0)).'<br><b>'.esc_pdf($res['peringkat'] ?? '').'</b></td><td></td></tr>';
    $html .= '<tr><th colspan="10">Uraian Untuk Risiko Kepatuhan Inheren</th></tr>';
    $html .= '<tr><td colspan="10" style="white-space:pre-wrap;">'.esc_pdf($ket['ket_profil_inheren'] ?? '').'</td></tr>';
    $html .= '</tbody></table></div>';
    return $html;
}
function pdf_kep_inheren2_detail_html($conn, $id, $frame){
    $group = pdf_kep_load_group($conn, $frame);
    $assessment = pdf_kep_get_assessment($conn, $id);
    $detail = $assessment ? pdf_kep_detail_map($conn, (int)$assessment['id_assessment_inheren']) : [];

    $detailPrev = [];
    if (!empty($frame['data_pembanding'])) {
        $assPrev = pdf_kep_get_assessment($conn, (int)$frame['data_pembanding']);
        $detailPrev = $assPrev ? pdf_kep_detail_map($conn, (int)$assPrev['id_assessment_inheren']) : [];
    }

    if (empty($group)) {
        return pdf_inheren_simple_fallback_html($conn, $id, $frame, 'kepatuhan', 'Risiko Kepatuhan - Inheren 2');
    }

    $notes = pdf_kep_dynamic_notes($conn, $id);
    $results = [];
    $rekap = [];
    $idxPilar = 0;

    foreach($group as $pilar_id => $pilar){
        $idxPilar++;
        $rows = [];
        $scores = [];
        foreach($pilar['parameters'] as $parameter){
            $pKey = 'parameter|'.$parameter['parameter_id'];
            $pCur = $detail[$pKey] ?? [];
            $pPrev = $detailPrev[$pKey] ?? [];
            $subs = [];
            $subScores = [];
            $subPrevScores = [];
            $subKets = [];
            $subIdx = 0;

            foreach($parameter['subs'] as $sub){
                $sKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $sCur = $detail[$sKey] ?? [];
                $sPrev = $detailPrev[$sKey] ?? [];
                $n = (float)($sCur['nilai'] ?? 0);
                $np = (float)($sPrev['nilai'] ?? ($sCur['nilai_sebelumnya'] ?? 0));
                $k = trim((string)($sCur['keterangan'] ?? ''));
                $subScores[] = $n;
                $subPrevScores[] = $np;
                if ($k !== '') $subKets[] = $k;
                $subs[] = [
                    'letter' => pdf_kep_alpha($subIdx),
                    'name' => $sub['nama_sub_parameter'],
                    'nilai' => $n,
                    'nilai_prev' => $np
                ];
                $subIdx++;
            }

            if (count($subs) > 0) {
                $nilai = pdf_kep_avg($subScores);
                $nilaiPrev = pdf_kep_avg($subPrevScores);
                $ket = pdf_kep_concat($subKets);
            } else {
                $nilai = (float)($pCur['nilai'] ?? 0);
                $nilaiPrev = (float)($pPrev['nilai'] ?? ($pCur['nilai_sebelumnya'] ?? 0));
                $ket = trim((string)($pCur['keterangan'] ?? ''));
            }

            $scores[] = $nilai;
            $rows[] = [
                'no' => $parameter['nomor_parameter'] !== '' ? $parameter['nomor_parameter'] : count($rows)+1,
                'name' => $parameter['nama_parameter'],
                'nilai' => $nilai,
                'nilai_prev' => $nilaiPrev,
                'keterangan' => $ket,
                'subs' => $subs
            ];
        }

        $nilaiPilar = pdf_kep_avg($scores);
        $rekap[] = $nilaiPilar;
        $results[] = [
            'idx' => $idxPilar,
            'pilar_id' => $pilar_id,
            'nama_pilar' => $pilar['nama_pilar'],
            'rows' => $rows,
            'max' => pdf_kep_max($scores),
            'min' => pdf_kep_min($scores),
            'avg' => pdf_kep_avg($scores),
            'nilai_pilar' => $nilaiPilar,
            'catatan' => $notes['pilar|'.$pilar_id]['catatan'] ?? ''
        ];
    }

    $overallMax = pdf_kep_max($rekap);
    $overallMin = pdf_kep_min($rekap);
    $overallAvg = pdf_kep_avg($rekap);
    $method = trim((string)($notes['risiko|0']['metode'] ?? 'rata_rata'));
    if (!in_array($method, ['tertinggi','terendah','rata_rata'], true)) $method = 'rata_rata';
    $overall = ($method === 'tertinggi') ? $overallMax : (($method === 'terendah') ? $overallMin : $overallAvg);
    $peringkat = pdf_label_inheren($overall);
    $riskNote = trim((string)($notes['risiko|0']['catatan'] ?? ''));

    $html = '<div class="clean-page kepatuhan-inheren2-direct">'
        . '<h4>Risiko Kepatuhan Inheren 2 ['.esc_pdf($frame['cabang'] ?? '').' Tahun '.esc_pdf($frame['tahun'] ?? '').' - '.esc_pdf($frame['periode_laporan'] ?? '').']</h4>'
        . '<table class="table table-bordered inheren-lain-ket-wide rekap-inheren-center" style="width:100%;border-collapse:collapse;table-layout:fixed;">'
        . '<colgroup><col style="width:5%"><col style="width:5%"><col style="width:29%"><col style="width:10%"><col style="width:10%"><col style="width:27%"><col style="width:7%"><col style="width:7%"></colgroup>'
        . '<thead><tr><th colspan="8">RISIKO KEPATUHAN INHEREN 2</th></tr>'
        . '<tr><th>NO</th><th colspan="2">PARAMETER</th><th colspan="2">PERINGKAT RISIKO</th><th>KETERANGAN</th><th colspan="2">PERIODE SEBELUMNYA</th></tr></thead><tbody>';

    foreach($results as $pilar){
        $html .= '<tr><th colspan="8" style="text-align:left;">PILAR '.(int)$pilar['idx'].' : '.esc_pdf($pilar['nama_pilar']).'</th></tr>';
        foreach($pilar['rows'] as $param){
            $html .= '<tr>';
            $html .= '<td class="print-inheren-center">'.esc_pdf($param['no']).'</td>';
            $html .= '<td colspan="2"><b>'.esc_pdf($param['name']).'</b></td>';
            $html .= '<td></td><td class="print-inheren-center">Nilai<br>'.esc_pdf(pdf_num($param['nilai'])).'</td>';
            $html .= '<td>'.nl2br(esc_pdf($param['keterangan'])).'</td>';
            $html .= '<td></td><td class="print-inheren-center">Nilai periode sebelumnya<br>'.esc_pdf(pdf_num($param['nilai_prev'])).'</td>';
            $html .= '</tr>';
            foreach($param['subs'] as $sub){
                $html .= '<tr><td></td><td class="print-inheren-center">'.esc_pdf($sub['letter']).'.</td><td>'.esc_pdf($sub['name']).'</td><td class="print-inheren-center">'.esc_pdf(pdf_num($sub['nilai'])).'</td><td colspan="2"></td><td class="print-inheren-center">'.esc_pdf(pdf_num($sub['nilai_prev'])).'</td><td></td></tr>';
            }
        }
        $html .= '<tr><th colspan="4" style="text-align:left;">Hasil Penilaian Pilar '.(int)$pilar['idx'].' - '.esc_pdf($pilar['nama_pilar']).'</th>'
            . '<td class="print-inheren-center">Tertinggi<br>'.esc_pdf(pdf_num($pilar['max'])).'<br>Terendah<br>'.esc_pdf(pdf_num($pilar['min'])).'<br>Rata-rata<br>'.esc_pdf(pdf_num($pilar['avg'])).'<hr>Risiko ditetapkan<br>'.esc_pdf(pdf_num($pilar['nilai_pilar'])).'</td>'
            . '<td>'.nl2br(esc_pdf($pilar['catatan'])).'</td><td></td><td></td></tr>';
    }
    $html .= '</tbody></table><br>';

    $html .= '<table class="table table-bordered rekap-inheren-center" style="width:100%;border-collapse:collapse;table-layout:fixed;">'
        . '<thead><tr><th colspan="6">REKAP PENILAIAN INHEREN KEPATUHAN</th></tr></thead><tbody>';
    foreach($results as $pilar){
        $html .= '<tr><td colspan="5"><b>Hasil Penilaian Pilar '.(int)$pilar['idx'].' - '.esc_pdf($pilar['nama_pilar']).'</b></td><td class="print-inheren-center">Tingkat risiko<br>'.esc_pdf(pdf_num($pilar['nilai_pilar'])).'</td></tr>';
    }
    $metodeLabel = ($method === 'tertinggi' ? 'Tertinggi' : ($method === 'terendah' ? 'Terendah' : 'Rata-rata'));
    $html .= '<tr><td><b>Hasil Penilaian Inheren</b></td>'
        . '<td class="print-inheren-center">Tertinggi<br>'.esc_pdf(pdf_num($overallMax)).'</td>'
        . '<td class="print-inheren-center">Terendah<br>'.esc_pdf(pdf_num($overallMin)).'</td>'
        . '<td class="print-inheren-center">Rata-rata<br>'.esc_pdf(pdf_num($overallAvg)).'</td>'
        . '<td class="print-inheren-center">Metode Risiko<br>'.esc_pdf($metodeLabel).'</td>'
        . '<td class="print-inheren-center">Tingkat risiko<br>'.esc_pdf(pdf_num($overall)).'<br>Peringkat<br>'.esc_pdf($peringkat).'</td></tr>';
    $html .= '<tr><th colspan="6">Uraian Untuk Risiko Inheren Kepatuhan</th></tr>';
    $html .= '<tr><td colspan="6" style="white-space:pre-wrap;">'.esc_pdf($riskNote).'</td></tr>';
    $html .= '</tbody></table></div>';
    return $html;
}



$fallbacks = [
    '11. Risiko Kepatuhan - Inheren 2' => pdf_kep_inheren2_detail_html($conn, $id, $frame),
    '4. Risiko Kredit - Profil' => pdf_profile_per_risk_html($conn, $id, $frame, 'kredit'),
    '9. Risiko Operasional - Profil' => pdf_profile_per_risk_html($conn, $id, $frame, 'operasional'),
    '14. Risiko Kepatuhan - Profil' => pdf_profile_per_risk_html($conn, $id, $frame, 'kepatuhan'),
    '18. Risiko Likuiditas - Profil' => pdf_profile_per_risk_html($conn, $id, $frame, 'likuiditas'),
    '23. Risiko Reputasi - Profil' => pdf_profile_per_risk_html($conn, $id, $frame, 'reputasi'),
    '28. Risiko Stratejik - Profil' => pdf_profile_per_risk_html($conn, $id, $frame, 'stratejik'),
    '1. Risiko Kredit - Tindak Lanjut' => pdf_tindak_lanjut_per_risk_html($conn, $id, $frame, 'kredit', 1),
    '2. Risiko Operasional - Tindak Lanjut' => pdf_tindak_lanjut_per_risk_html($conn, $id, $frame, 'operasional', 2),
    '3. Risiko Kepatuhan - Tindak Lanjut' => pdf_tindak_lanjut_per_risk_html($conn, $id, $frame, 'kepatuhan', 3),
    '4. Risiko Likuiditas - Tindak Lanjut' => pdf_tindak_lanjut_per_risk_html($conn, $id, $frame, 'likuiditas', 4),
    '5. Risiko Reputasi - Tindak Lanjut' => pdf_tindak_lanjut_per_risk_html($conn, $id, $frame, 'reputasi', 5),
    '6. Risiko Stratejik - Tindak Lanjut' => pdf_tindak_lanjut_per_risk_html($conn, $id, $frame, 'stratejik', 6),
    '30. Profil Peringkat' => pdf_peringkat_konsolidasi_html($conn, $id, $frame),
];

function build_url_pdf($page, $id){
    global $onlyTindakLanjut, $onlyProfilPerRisiko;

    /*
      FIX ROUTE CETAK:
      File cetak ini kadang dibuka langsung dari folder laporan/:
        pic_area_semarang/laporan/cetak_laporan_profil_risiko.php
      dan kadang dibuka lewat index.php:
        pic_area_semarang/index.php?page=cetak_laporan_profil_risiko

      Kalau path iframe salah, hasilnya muncul:
      "Halaman tidak ditemukan / route belum sesuai".
      Maka kandidat URL dibuat dua arah: index.php dan ../index.php.
    */
    $script = str_replace('\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? ''));
    $prefixes = (stripos($script, '/laporan/') !== false)
        ? ['../index.php', 'index.php']
        : ['index.php', '../index.php'];

    $urls = [];
    foreach ($prefixes as $base) {
        $url = $base . '?page=' . rawurlencode($page) . '&id=' . (int)$id . '&mode_print=1&print_pdf=1&clean_print=1';
        if ($onlyTindakLanjut) $url .= '&only_tindak_lanjut=1';
        if ($onlyProfilPerRisiko) $url .= '&only_profil_per_risiko=1';
        $urls[] = $url;
    }
    return array_values(array_unique($urls));
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Cetak Laporan Profil Risiko</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{box-sizing:border-box!important;}
html,body{margin:0;padding:0;background:#fff;color:#000;font-family:Arial,Helvetica,sans-serif;font-size:10px;}
/* FIX MODAL: ketika file dibuka lewat index.php, sidebar/topbar template induk harus hilang */
.left-side-menu,.navbar-custom,.topnav,.button-menu-mobile,.app-menu,.side-nav,.vertical-menu,.sidebar,.leftbar,.page-title-right,.breadcrumb,.footer{display:none!important;}
.content-page,.content,.wrapper,.container-fluid{margin-left:0!important;left:0!important;padding-left:0!important;max-width:none!important;}
body{overflow:auto!important;}
.toolbar{position:sticky;top:0;z-index:99999;background:#111;color:#fff;padding:12px 18px;display:flex;align-items:center;justify-content:space-between;gap:14px;box-shadow:0 2px 8px rgba(0,0,0,.25);min-height:54px;} 
.toolbar-title{font-size:14px;font-weight:700;line-height:1.35;}
.toolbar-note{font-size:12px;color:#e5e5e5;margin-top:2px;}
.toolbar-actions{display:flex;gap:10px;align-items:center;}
.btn-print,.btn-back{border:1px solid #111;background:#fff;color:#000;border-radius:5px;padding:10px 18px;font-weight:800;text-decoration:none;cursor:pointer;font-size:14px;line-height:1;min-height:38px;display:inline-flex;align-items:center;justify-content:center;}
.btn-print{background:#222;color:#fff;border-color:#222;min-width:118px;} .btn-back{min-width:86px;}
.btn-print:disabled{opacity:.55;cursor:not-allowed;}
.status{font-size:12px;color:#f3f4f6;}
.report-wrap{width:215mm;max-width:215mm;margin:18px auto;padding:0;background:#fff;}
.cover,.print-section{background:#fff;border:1px solid #111;margin-bottom:14px;box-shadow:0 2px 10px rgba(0,0,0,.08);width:100%;} 
.cover{padding:28px 32px;page-break-after:always;break-after:page;}
.cover-title{position:relative;display:flex;align-items:center;justify-content:center;margin:0 0 14px 0;min-height:54px;}
.cover-logo{position:absolute;left:0;top:50%;transform:translateY(-50%);max-width:135px;max-height:52px;object-fit:contain;}
.cover-title-text{text-align:center;width:100%;padding:0 150px;}
.cover h1{font-size:12px;margin:0 0 8px;text-align:center;letter-spacing:.5px;color:#000;}
.cover table{width:100%;border-collapse:collapse;margin-top:22px;font-size:10px;}
.cover td{border:1px solid #111;padding:7px 8px;color:#000;}
.cover-summary{margin-top:18px;width:100%;}
.cover-summary-title{border:1px solid #111;background:#e6e6e6;text-align:center;font-weight:700;padding:6px;margin-bottom:0;}
.cover-summary table{margin-top:0!important;width:100%;border-collapse:collapse;table-layout:fixed;font-size:8px;}
.cover-summary th,.cover-summary td{border:1px solid #111;padding:4px 5px;text-align:center;vertical-align:middle;line-height:1.2;}
.cover-summary th{background:#e6e6e6;font-weight:700;}
.cover-summary td:first-child{text-align:left;width:17%;}
.cover-summary .quality{text-align:left;font-size:7.5px;line-height:1.18;}
.cover-summary-total td{text-align:center!important;background:#fff!important;}
.cover-summary-inheren-only th:first-child,.cover-summary-inheren-only td:first-child{width:50%!important;text-align:left!important;}
.cover-summary-inheren-only th:nth-child(2),.cover-summary-inheren-only td:nth-child(2){width:50%!important;text-align:center!important;}
/* Hilangkan border kotak luar/pinggir halaman cetak, border tabel tetap ada */
.cover,.print-section{border:0!important;}

.section-title{background:#d9d9d9;color:#000;text-align:center;font-size:10px;font-weight:700;padding:6px 8px;border-bottom:1px solid #111;}
.section-content{padding:6mm;background:#fff;min-height:120px;overflow:hidden;width:100%;}
.section-content.loading{color:#555;text-align:center;font-style:italic;padding:18px;}
.source-frame{display:none!important;width:0;height:0;border:0;visibility:hidden;}
.route-note{display:none;font-size:10px;text-align:right;color:#666;padding:3px 8px;border-top:1px solid #ddd;}

/* ======= STYLE CETAK HITAM PUTIH UNTUK HASIL CLONE ======= */
.clean-page,.clean-page *{font-family:Arial,Helvetica,sans-serif!important;color:#000!important;box-shadow:none!important;text-shadow:none!important;}
.clean-page{background:#fff!important;width:100%!important;max-width:100%!important;margin:0!important;padding:0!important;display:block!important;}
/* FIX: jika root yang dicloning adalah .content-page sendiri, selector descendant tidak kena.
   Ini penyebab preview hanya tampil setengah/kecil dan tidak memenuhi F4. */
.clean-page.content-page,.clean-page.content,.clean-page.container-fluid,
.clean-page .content-page,.clean-page .content,.clean-page .container-fluid{
    margin:0!important;
    padding:0!important;
    width:100%!important;
    max-width:100%!important;
    min-width:100%!important;
    min-height:0!important;
    left:auto!important;
    right:auto!important;
    transform:none!important;
}
.clean-page > .content,.clean-page > .container-fluid,.clean-page > .row,.section-content > .clean-page{width:100%!important;max-width:100%!important;}

/* Paksa tabel besar hasil clone memenuhi lebar halaman F4, bukan mengikuti lebar layout aplikasi/sidebar. */
.clean-page .table-responsive,
.clean-page .table,
.clean-page table,
.clean-page .card,
.clean-page .card-body,
.clean-page form{
    width:100%!important;
    max-width:100%!important;
    min-width:0!important;
}
.clean-page table[style],.clean-page div[style*="width"],.clean-page section[style*="width"]{
    max-width:100%!important;
}

.clean-page .row{display:flex!important;flex-wrap:wrap!important;margin:0!important;width:100%!important;}
.clean-page .col-12{display:block!important;width:100%!important;max-width:100%!important;flex:0 0 100%!important;padding:0!important;margin:0 0 6px 0!important;}
.clean-page .col-6{display:block!important;width:50%!important;max-width:50%!important;flex:0 0 50%!important;padding:0 6px!important;margin:0 0 6px 0!important;}
.clean-page .col-4{display:block!important;width:33.333%!important;max-width:33.333%!important;flex:0 0 33.333%!important;padding:0 5px!important;margin:0 0 6px 0!important;}
.clean-page .col-3{display:block!important;width:25%!important;max-width:25%!important;flex:0 0 25%!important;padding:0 5px!important;margin:0 0 6px 0!important;}
.clean-page [class*="col-"]{min-height:1px!important;}
.clean-page .card{border:0!important;background:#fff!important;margin:0 0 7px 0!important;padding:0!important;}
.clean-page .card-body{padding:0!important;background:#fff!important;}
.clean-page .card-header{background:#eee!important;border:1px solid #111!important;color:#000!important;padding:6px 8px!important;}
.clean-page h1,.clean-page h2,.clean-page h3,.clean-page h4,.clean-page h5{color:#000!important;margin:6px 0!important;font-weight:700!important;}
.clean-page .page-title-box{margin:0 0 5px 0!important;padding:0!important;}
.clean-page .page-title{font-size:10px!important;margin:4px 0!important;}
.clean-page hr{border:0!important;border-top:1px solid #111!important;margin:6px 0!important;}
.clean-page table{width:100%!important;max-width:100%!important;border-collapse:collapse!important;table-layout:fixed!important;background:#fff!important;margin:0 0 6px 0!important;page-break-inside:auto!important;}
.clean-page th,.clean-page td{border:1px solid #111!important;background:#fff!important;color:#000!important;padding:3px 4px!important;vertical-align:middle!important;font-size:8px!important;line-height:1.25!important;}
.clean-page table.print-close-page-cut{
    border-collapse:separate!important;
    border-spacing:0!important;
    border-left:1px solid #111!important;
    border-top:1px solid #111!important;
}
.clean-page table.print-close-page-cut th,
.clean-page table.print-close-page-cut td{
    border:0!important;
    border-right:1px solid #111!important;
    border-bottom:1px solid #111!important;
    -webkit-box-decoration-break:clone!important;
    box-decoration-break:clone!important;
    box-shadow:inset 0 -1px 0 #111, inset -1px 0 0 #111!important;
}
.clean-page table.print-close-page-cut tr > th:first-child,
.clean-page table.print-close-page-cut tr > td:first-child{
    box-shadow:inset 1px 0 0 #111, inset 0 -1px 0 #111, inset -1px 0 0 #111!important;
}
.clean-page thead th,.clean-page thead td{background:#e6e6e6!important;color:#000!important;font-weight:700!important;text-align:center!important;}
.clean-page tbody th{font-weight:700!important;}
.clean-page tr{page-break-inside:avoid!important;break-inside:avoid!important;break-inside:avoid-page!important;page-break-after:auto!important;}
.clean-page td,.clean-page th{page-break-inside:avoid!important;break-inside:avoid!important;break-inside:avoid-page!important;}
.clean-page table{orphans:3!important;widows:3!important;}
.clean-page thead{display:table-header-group!important;}
.clean-page tfoot{display:table-footer-group!important;}
.clean-page textarea,.clean-page input,.clean-page select,.clean-page option,.clean-page optgroup,.clean-page datalist{display:none!important;}
.print-field{display:block!important;min-height:16px;border:0!important;background:#fff!important;color:#000!important;white-space:pre-wrap!important;font-size:8px!important;line-height:1.25!important;padding:1px!important;}
.print-field.empty{color:#777!important;font-style:italic;}
.clean-page .table-responsive{overflow:visible!important;width:100%!important;}
.clean-page .quality-hidden{display:block!important;}
.clean-page .quality-scroll{max-height:none!important;overflow:visible!important;background:#fff!important;border:0!important;padding:0!important;margin:0!important;}
.clean-page .badge,.clean-page .alert{background:#fff!important;border:1px solid #111!important;color:#000!important;}
.clean-page .dropdown-menu,.clean-page .select2-container,.clean-page .select2-dropdown,.clean-page .select2-results,.clean-page .select2-results__options,.clean-page .select2-results__option,.clean-page .choices,.clean-page .choices__list,.clean-page .choices__list--dropdown,.clean-page .multiselect-container,.clean-page .bs-searchbox{display:none!important;}

/* Elemen aplikasi yang tidak boleh ikut tercetak */
.clean-page .left-side-menu,.clean-page .navbar-custom,.clean-page .topnav,.clean-page .button-menu-mobile,
.clean-page .footer,.clean-page .page-title-right,.clean-page .breadcrumb,.clean-page .modal,.clean-page .modal-backdrop,
.clean-page .btn,.clean-page button,.clean-page script,.clean-page style,.clean-page noscript,
.clean-page .dataTables_filter,.clean-page .dataTables_length,.clean-page .dataTables_info,.clean-page .dataTables_paginate,.clean-page .dt-buttons,
.clean-page .hide-print,.clean-page .no-print,.clean-page [data-bs-toggle="modal"]{display:none!important;}


/* Paksa semua kotak panjang tampil penuh tanpa scrollbar di preview/cetak */
.clean-page *{scrollbar-width:none!important;}
.clean-page *::-webkit-scrollbar{display:none!important;width:0!important;height:0!important;}
.clean-page [style*="overflow"],.clean-page [class*="scroll"],.clean-page .quality-scroll,.clean-page textarea,.clean-page .form-control{
    overflow:visible!important;max-height:none!important;height:auto!important;
}
.clean-page .quality-scroll,.clean-page .quality-scroll *{
    overflow:visible!important;max-height:none!important;height:auto!important;white-space:normal!important;
}
body.print-portrait .report-wrap{width:215mm!important;max-width:215mm!important;}
body.print-landscape .report-wrap{width:330mm!important;max-width:330mm!important;}
.profil-pair-direct{display:grid;grid-template-columns:1fr 1fr;gap:12px;width:100%;}
.pdf-profile-table{width:100%;border-collapse:collapse;table-layout:fixed;background:#fff;margin:0 0 6px 0;}
.pdf-profile-table th,.pdf-profile-table td{border:1px solid #111;padding:4px;font-size:8px;vertical-align:middle;text-align:center;}
.pdf-profile-table thead th{background:#e6e6e6;font-weight:700;}
.pdf-profile-table td:first-child{text-align:left;font-weight:700;width:20%;}
.pdf-profile-table .quality-cell{text-align:left;font-size:7.5px;line-height:1.2;white-space:normal;word-break:normal;}
.profile-risk-title{width:100%;border-collapse:collapse;table-layout:fixed;margin:0 0 8px 0!important;}
.profile-risk-title th{border:1px solid #111;background:#e6e6e6;text-align:center;padding:6px;font-weight:700;}
.pdf-profile-single{width:100%;border-collapse:collapse;table-layout:fixed;background:#fff;margin:0 0 8px 0!important;}

/* ===== FIX CETAK NILAI/PERINGKAT: gunakan isi tab asli dari halaman Profil Nilai ===== */
.clean-page .nav-tabs,.clean-page .nav,.clean-page .tab-nav,.clean-page [role="tablist"]{display:none!important;}
.clean-page .tab-pane{display:none!important;opacity:1!important;visibility:visible!important;}
.clean-page.print-tab-nilai #tab-nilai,
.clean-page.print-tab-peringkat #tab-peringkat,
.clean-page.print-tab-ojk #tab-peringkat-ojk,
.clean-page.print-tab-nilai .tab-nilai,
.clean-page.print-tab-peringkat .tab-peringkat,
.clean-page.print-tab-ojk .tab-peringkat-ojk{display:block!important;opacity:1!important;visibility:visible!important;}
.clean-page.print-tab-nilai #tab-peringkat,
.clean-page.print-tab-nilai #tab-peringkat-ojk,
.clean-page.print-tab-peringkat #tab-nilai,
.clean-page.print-tab-peringkat #tab-peringkat-ojk{display:none!important;}
.pdf-profile-single th,.pdf-profile-single td{border:1px solid #111;padding:4px;font-size:8px;vertical-align:middle;text-align:center;}
.pdf-profile-single thead th{background:#e6e6e6;font-weight:700;}
.pdf-profile-single td:first-child{text-align:center;font-weight:700;width:20%;}
.pdf-profile-single .valrank{text-align:center!important;vertical-align:middle!important;}
.pdf-profile-single .quality-cell{text-align:center!important;vertical-align:middle!important;font-size:7.5px;line-height:1.2;white-space:normal;word-break:normal;}
.clean-page table.rekap-risk-table td,.clean-page table.rekap-risk-table th{vertical-align:middle!important;}
.clean-page table.rekap-risk-table td:not(:first-child),.clean-page table.rekap-risk-table th:not(:first-child){text-align:center!important;}
.clean-page table.kpmr-ket-wide td:nth-last-child(2),.clean-page table.kpmr-ket-wide th:nth-last-child(2),
.clean-page table.kpmr-ket-wide td:nth-last-child(3),.clean-page table.kpmr-ket-wide th:nth-last-child(3){text-align:center!important;vertical-align:middle!important;}



/* ===== FIX FINAL F4 VERTIKAL: posisi tengah + lebar penuh ===== */
body.print-portrait{
    background:#fff!important;
}
body.print-portrait .report-wrap{
    width:215mm!important;
    max-width:215mm!important;
    min-width:215mm!important;
    margin-left:auto!important;
    margin-right:auto!important;
    padding:0!important;
}
body.print-portrait .cover,
body.print-portrait .print-section{
    width:100%!important;
    max-width:100%!important;
    margin-left:auto!important;
    margin-right:auto!important;
}
body.print-portrait .section-content{
    width:100%!important;
    max-width:100%!important;
    padding:4mm!important;
    overflow:visible!important;
}
body.print-portrait .clean-page,
body.print-portrait .section-content > .clean-page,
body.print-portrait .clean-page.content-page,
body.print-portrait .clean-page.content,
body.print-portrait .clean-page.container-fluid,
body.print-portrait .clean-page .content-page,
body.print-portrait .clean-page .content,
body.print-portrait .clean-page .container,
body.print-portrait .clean-page .container-fluid,
body.print-portrait .clean-page .card,
body.print-portrait .clean-page .card-body,
body.print-portrait .clean-page .table-responsive{
    width:100%!important;
    max-width:100%!important;
    min-width:0!important;
    margin-left:0!important;
    margin-right:0!important;
    padding-left:0!important;
    padding-right:0!important;
    left:auto!important;
    right:auto!important;
    transform:none!important;
    float:none!important;
    position:static!important;
}
body.print-portrait .clean-page .row{
    width:100%!important;
    max-width:100%!important;
    margin-left:0!important;
    margin-right:0!important;
    padding-left:0!important;
    padding-right:0!important;
}
body.print-portrait .clean-page table{
    width:100%!important;
    max-width:100%!important;
    margin-left:0!important;
    margin-right:0!important;
    table-layout:fixed!important;
}
body.print-portrait .clean-page th,
body.print-portrait .clean-page td{
    word-break:break-word!important;
    overflow-wrap:anywhere!important;
}
/* Hilangkan sisa offset bootstrap/tema yang sering membuat tabel hanya setengah halaman */
body.print-portrait .clean-page [style*="margin-left"],
body.print-portrait .clean-page [style*="left"],
body.print-portrait .clean-page [style*="transform"]{
    margin-left:0!important;
    left:auto!important;
    transform:none!important;
}


/* ===== MODAL PREVIEW MODE: dipakai ketika dibuka dari popup menu ===== */
body.modal-view{background:#fff!important;overflow:auto!important;margin:0!important;padding:0!important;}
body.modal-view .toolbar{display:flex!important;}
body.modal-view .report-wrap{width:215mm!important;max-width:215mm!important;min-width:215mm!important;margin:18px auto!important;padding:0!important;background:#fff!important;}
body.modal-view .cover, body.modal-view .print-section{box-shadow:none!important;margin:0 0 10px 0!important;border:0!important;width:100%!important;}
body.modal-view .section-content{padding:6px!important;background:#fff!important;width:100%!important;overflow:visible!important;}
body.modal-view .clean-page, body.modal-view .clean-page.content-page, body.modal-view .clean-page .content-page, body.modal-view .clean-page .container-fluid, body.modal-view .clean-page .card, body.modal-view .clean-page .card-body, body.modal-view .clean-page .table-responsive, body.modal-view .clean-page table{width:100%!important;max-width:100%!important;min-width:0!important;margin-left:0!important;margin-right:0!important;}
body.modal-view .clean-page table{table-layout:auto!important;}

/* ===== FIX KETERANGAN INHEREN KREDIT & LIKUIDITAS =====
   Kolom KETERANGAN dibuat lebih lebar dan tabel dipaksa sejajar
   dengan kotak judul RISIKO KREDIT/LIKUIDITAS INHEREN. */
.clean-page table.inheren-wide-keterangan,
body.modal-view .clean-page table.inheren-wide-keterangan{
    width:100%!important;
    max-width:100%!important;
    table-layout:fixed!important;
    margin-left:0!important;
    margin-right:0!important;
}
.clean-page table.inheren-wide-keterangan th,
.clean-page table.inheren-wide-keterangan td,
body.modal-view .clean-page table.inheren-wide-keterangan th,
body.modal-view .clean-page table.inheren-wide-keterangan td{
    overflow-wrap:break-word!important;
    word-break:normal!important;
    white-space:normal!important;
}
.clean-page table.inheren-wide-keterangan:not(.inheren-keterangan-rowspan) td:last-child,
.clean-page table.inheren-wide-keterangan:not(.inheren-keterangan-rowspan) th:last-child,
.clean-page table.inheren-keterangan-rowspan .inheren-keterangan-merged{
    width:24%!important;
    min-width:24%!important;
    max-width:24%!important;
    vertical-align:top!important;
}

/* Grid native menjaga batas bawah sel rowspan sejajar subparameter terakhir. */
.clean-page table.inheren-keterangan-rowspan.print-close-page-cut{
    border-collapse:collapse!important;
}
.clean-page table.inheren-keterangan-rowspan.print-close-page-cut td,
.clean-page table.inheren-keterangan-rowspan.print-close-page-cut th{
    border:1px solid #111!important;
    box-shadow:none!important;
}

/* Ruang akhir uraian menjaga teks rowspan tidak menyentuh parameter berikutnya
   ketika Chromium memecah sel gabungan ke halaman cetak berikutnya. */
.clean-page table.inheren-keterangan-rowspan .inheren-keterangan-merged > .print-field::after{
    content:"";
    display:block;
    height:24px;
}

/* Gabung visual kolom Keterangan Inheren Kredit/Likuiditas tanpa rowspan asli.
   Ini mencegah tabel pecah/kolom kosong tinggi saat print. */
.clean-page table.inheren-wide-keterangan td.ket-merge-start,
.clean-page table.inheren-wide-keterangan th.ket-merge-start{
    border-bottom:0!important;
    vertical-align:top!important;
}
.clean-page table.inheren-wide-keterangan td.ket-merge-mid,
.clean-page table.inheren-wide-keterangan th.ket-merge-mid{
    border-top:0!important;
    border-bottom:0!important;
    vertical-align:top!important;
}
.clean-page table.inheren-wide-keterangan td.ket-merge-end,
.clean-page table.inheren-wide-keterangan th.ket-merge-end{
    border-top:0!important;
    vertical-align:top!important;
}
.clean-page table.inheren-wide-keterangan td.ket-merge-single,
.clean-page table.inheren-wide-keterangan th.ket-merge-single{
    vertical-align:top!important;
}

.clean-page table.inheren-wide-keterangan td.ket-merge-start:empty::after,
.clean-page table.inheren-wide-keterangan th.ket-merge-start:empty::after,
.clean-page table.inheren-wide-keterangan td.ket-merge-mid:empty::after,
.clean-page table.inheren-wide-keterangan th.ket-merge-mid:empty::after,
.clean-page table.inheren-wide-keterangan td.ket-merge-end:empty::after,
.clean-page table.inheren-wide-keterangan th.ket-merge-end:empty::after,
.clean-page table.inheren-wide-keterangan td.ket-merge-single:empty::after,
.clean-page table.inheren-wide-keterangan th.ket-merge-single:empty::after{
    content:' ';
    white-space:pre;
}
.clean-page table.inheren-wide-keterangan td.ket-merge-start,
.clean-page table.inheren-wide-keterangan td.ket-merge-mid,
.clean-page table.inheren-wide-keterangan td.ket-merge-end,
.clean-page table.inheren-wide-keterangan td.ket-merge-single{
    border-left:1px solid #111!important;
    border-right:1px solid #111!important;
}
.clean-page table.inheren-wide-keterangan td[rowspan],
.clean-page table.inheren-wide-keterangan th[rowspan]{
    vertical-align:top!important;
}


.clean-page table.inheren-wide-keterangan tr,
.clean-page table.inheren-wide-keterangan td,
.clean-page table.inheren-wide-keterangan th{
    page-break-inside:auto!important;
    break-inside:auto!important;
}



/* ===== FIX REKAP KREDIT/LIKUIDITAS =====
   Nilai dan peringkat di rekap dibuat tepat tengah. */
.clean-page table.rekap-risk-table td,
.clean-page table.rekap-risk-table th,
body.modal-view .clean-page table.rekap-risk-table td,
body.modal-view .clean-page table.rekap-risk-table th{
    vertical-align:middle!important;
}
.clean-page table.rekap-risk-table td:not(:first-child),
.clean-page table.rekap-risk-table th:not(:first-child),
body.modal-view .clean-page table.rekap-risk-table td:not(:first-child),
body.modal-view .clean-page table.rekap-risk-table th:not(:first-child){
    text-align:center!important;
}
.clean-page table.rekap-risk-table .print-field,
body.modal-view .clean-page table.rekap-risk-table .print-field{
    text-align:center!important;
    margin:0 auto!important;
}





/* ===== FIX FALLBACK KEPATUHAN INHEREN ===== */
.clean-page.fallback-kepatuhan-detail table,
body.modal-view .clean-page.fallback-kepatuhan-detail table{
    width:100%!important;
    border-collapse:collapse!important;
    table-layout:fixed!important;
}
.clean-page.fallback-kepatuhan-detail th,
.clean-page.fallback-kepatuhan-detail td{
    border:1px solid #111!important;
    padding:5px!important;
    vertical-align:middle!important;
}
.clean-page.fallback-kepatuhan-detail thead th{
    background:#e6e6e6!important;
    text-align:center!important;
}
.clean-page.fallback-kepatuhan-detail .print-inheren-center{
    text-align:center!important;
    vertical-align:middle!important;
}

/* ===== FIX INHEREN NILAI CENTER =====
   Nilai/rekap pada tabel Inheren dibuat center tanpa mengubah struktur tabel. */
.clean-page .print-inheren-center,
body.modal-view .clean-page .print-inheren-center{
    text-align:center!important;
    vertical-align:middle!important;
}
.clean-page .print-inheren-center .print-field,
body.modal-view .clean-page .print-inheren-center .print-field,
.clean-page .print-inheren-center div,
.clean-page .print-inheren-center span,
.clean-page .print-inheren-center b,
.clean-page .print-inheren-center strong,
body.modal-view .clean-page .print-inheren-center div,
body.modal-view .clean-page .print-inheren-center span,
body.modal-view .clean-page .print-inheren-center b,
body.modal-view .clean-page .print-inheren-center strong{
    text-align:center!important;
    margin-left:auto!important;
    margin-right:auto!important;
}
.clean-page table.rekap-inheren-center td,
.clean-page table.rekap-inheren-center th,
body.modal-view .clean-page table.rekap-inheren-center td,
body.modal-view .clean-page table.rekap-inheren-center th{
    vertical-align:middle!important;
}
.clean-page table.rekap-inheren-center td:not(:first-child),
.clean-page table.rekap-inheren-center th:not(:first-child),
body.modal-view .clean-page table.rekap-inheren-center td:not(:first-child),
body.modal-view .clean-page table.rekap-inheren-center th:not(:first-child){
    text-align:center!important;
}

/* ===== FIX KPMR & INHEREN NON-KREDIT/LIKUIDITAS =====
   NO dipersempit, kolom KETERANGAN dilebarkan agar narasi tidak terlalu rapat. */
.clean-page table.kpmr-ket-wide,
.clean-page table.inheren-lain-ket-wide,
body.modal-view .clean-page table.kpmr-ket-wide,
body.modal-view .clean-page table.inheren-lain-ket-wide{
    width:100%!important;
    max-width:100%!important;
    table-layout:fixed!important;
    margin-left:0!important;
    margin-right:0!important;
}
.clean-page table.kpmr-ket-wide th,
.clean-page table.kpmr-ket-wide td,
.clean-page table.inheren-lain-ket-wide th,
.clean-page table.inheren-lain-ket-wide td,
body.modal-view .clean-page table.kpmr-ket-wide th,
body.modal-view .clean-page table.kpmr-ket-wide td,
body.modal-view .clean-page table.inheren-lain-ket-wide th,
body.modal-view .clean-page table.inheren-lain-ket-wide td{
    overflow-wrap:break-word!important;
    word-break:normal!important;
    white-space:normal!important;
    vertical-align:top!important;
}
.clean-page table.kpmr-ket-wide th:first-child,
.clean-page table.kpmr-ket-wide td:first-child{
    width:5%!important;
    min-width:5%!important;
    max-width:5%!important;
    text-align:center!important;
}
.clean-page table.inheren-lain-ket-wide th:first-child,
.clean-page table.inheren-lain-ket-wide td:first-child{
    width:3%!important;
    min-width:3%!important;
    max-width:3%!important;
    text-align:center!important;
}
.clean-page table.kpmr-ket-wide th:last-child,
.clean-page table.kpmr-ket-wide td:last-child,
.clean-page table.inheren-lain-ket-wide th:last-child,
.clean-page table.inheren-lain-ket-wide td:last-child{
    width:27%!important;
    min-width:27%!important;
    max-width:27%!important;
}

body.modal-view .clean-page th, body.modal-view .clean-page td{font-size:8px!important;padding:2px 3px!important;word-break:normal!important;overflow-wrap:break-word!important;}

/* ===== FIX CENTER AMAN NILAI / PERINGKAT =====
   Tidak mengubah struktur tabel, hanya text-align dan vertical-align. */
.clean-page .print-center-cell,
body.modal-view .clean-page .print-center-cell{
    text-align:center!important;
    vertical-align:middle!important;
}
.clean-page .print-center-cell .print-field,
body.modal-view .clean-page .print-center-cell .print-field,
.clean-page table.rekap-risk-table .print-field,
body.modal-view .clean-page table.rekap-risk-table .print-field{
    text-align:center!important;
    margin-left:auto!important;
    margin-right:auto!important;
}


/* FIX HEADER KPMR: struktur header dibuat ulang supaya angka 1-5 selalu tepat di bawah SKALA RISIKO */
.clean-page table.kpmr-ket-wide thead th,
body.modal-view .clean-page table.kpmr-ket-wide thead th{
    text-align:center!important;
    vertical-align:middle!important;
    white-space:normal!important;
    word-break:normal!important;
    overflow-wrap:break-word!important;
}
.clean-page table.kpmr-ket-wide thead tr,
body.modal-view .clean-page table.kpmr-ket-wide thead tr{
    page-break-inside:avoid!important;
}



/* ===== FIX FINAL CENTER NILAI KPMR =====
   Semua nilai/penilaian/peringkat pada tabel KPMR dan rekap KPMR dibuat tengah.
   Tidak mengubah rowspan/colspan agar layout tidak pecah. */
.clean-page table.kpmr-ket-wide td.print-kpmr-center,
.clean-page table.kpmr-ket-wide th.print-kpmr-center,
.clean-page table.rekap-kpmr-center td.print-kpmr-center,
.clean-page table.rekap-kpmr-center th.print-kpmr-center,
body.modal-view .clean-page table.kpmr-ket-wide td.print-kpmr-center,
body.modal-view .clean-page table.kpmr-ket-wide th.print-kpmr-center,
body.modal-view .clean-page table.rekap-kpmr-center td.print-kpmr-center,
body.modal-view .clean-page table.rekap-kpmr-center th.print-kpmr-center{
    text-align:center!important;
    vertical-align:middle!important;
}
.clean-page table.kpmr-ket-wide .print-kpmr-center .print-field,
.clean-page table.rekap-kpmr-center .print-kpmr-center .print-field,
body.modal-view .clean-page table.kpmr-ket-wide .print-kpmr-center .print-field,
body.modal-view .clean-page table.rekap-kpmr-center .print-kpmr-center .print-field{
    text-align:center!important;
    margin-left:auto!important;
    margin-right:auto!important;
    display:block!important;
}



/* ===== FIX INHEREN 2: PARAMETER DAN SUB PARAMETER RATA KIRI =====
   Berlaku untuk Operasional/Kepatuhan/Reputasi/Stratejik Inheren 2.
   Kolom nilai, nomor, periode sebelumnya, dan rekap tetap center. */
.clean-page table.inheren-lain-ket-wide td.print-param-left,
.clean-page table.inheren-lain-ket-wide th.print-param-left,
body.modal-view .clean-page table.inheren-lain-ket-wide td.print-param-left,
body.modal-view .clean-page table.inheren-lain-ket-wide th.print-param-left{
    text-align:left!important;
    vertical-align:middle!important;
    padding-left:8px!important;
}
.clean-page table.inheren-lain-ket-wide td.print-param-left *,
.clean-page table.inheren-lain-ket-wide th.print-param-left *,
body.modal-view .clean-page table.inheren-lain-ket-wide td.print-param-left *,
body.modal-view .clean-page table.inheren-lain-ket-wide th.print-param-left *{
    text-align:left!important;
    margin-left:0!important;
    margin-right:0!important;
}
@media print{
    .clean-page table.inheren-lain-ket-wide td.print-param-left,
    .clean-page table.inheren-lain-ket-wide th.print-param-left{
        text-align:left!important;
        vertical-align:middle!important;
        padding-left:6px!important;
    }
}

@media print{
    body.modal-view .report-wrap{width:100%!important;max-width:none!important;margin:0!important;padding:0!important;background:#fff!important;}
}


/* Default print scale dibuat normal 100% agar margin F4 rapi dan tidak kepotong */
@media print{
    @page{size:215mm 330mm;margin:12mm!important;}
    body.print-portrait{--dummy:0;}
    body.print-landscape{--dummy:0;}
    html,body{background:#fff!important;font-size:10px!important;}
    .toolbar{display:none!important;height:0!important;min-height:0!important;overflow:hidden!important;padding:0!important;margin:0!important;border:0!important;}
    .report-wrap{width:100%!important;max-width:none!important;margin:0!important;padding:0!important;}
    .cover{box-shadow:none!important;border:0!important;margin:0!important;padding:0!important;page-break-after:always;break-after:page;}
    .cover-logo{max-width:120px!important;max-height:48px!important;}
    .cover-title-text{padding:0 130px!important;}
    .print-section{box-shadow:none!important;border:0!important;margin:0!important;page-break-after:always;break-after:page;}
    .section-title{border:1px solid #111!important;background:#d9d9d9!important;font-size:10px!important;padding:5px!important;}
    .section-content{padding:0!important;min-height:0!important;width:100%!important;}
    .route-note{display:none!important;}
    .clean-page th,.clean-page td{font-size:8px!important;padding:3px!important;page-break-inside:avoid!important;break-inside:avoid-page!important;}
    .clean-page tr{page-break-inside:avoid!important;break-inside:avoid-page!important;}
    .clean-page .page-title{font-size:10px!important;}
    .print-field{font-size:8px!important;}
}


/* ===== FIX KEPATUHAN INHEREN 1 & 2: PARAMETER/SUBPARAMETER/SKALA RATA KIRI =====
   Khusus bagian cetak Kepatuhan Inheren 1 dan 2 saja.
   Header, NO, Penilaian, dan Periode Sebelumnya tetap center. */
.clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide tbody td,
.clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide tbody th,
body.modal-view .clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide tbody td,
body.modal-view .clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide tbody th{
    text-align:left!important;
    vertical-align:top!important;
}
.clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide tbody td.print-inheren-center,
.clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide tbody th.print-inheren-center,
body.modal-view .clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide tbody td.print-inheren-center,
body.modal-view .clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide tbody th.print-inheren-center{
    text-align:center!important;
    vertical-align:middle!important;
}
.clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide thead th,
body.modal-view .clean-page.kepatuhan-inheren-direct table.inheren-lain-ket-wide thead th{
    text-align:center!important;
    vertical-align:middle!important;
}

.clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide tbody td,
.clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide tbody th,
body.modal-view .clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide tbody td,
body.modal-view .clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide tbody th{
    text-align:left!important;
    vertical-align:top!important;
}
.clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide tbody td.print-inheren-center,
.clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide tbody th.print-inheren-center,
body.modal-view .clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide tbody td.print-inheren-center,
body.modal-view .clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide tbody th.print-inheren-center{
    text-align:center!important;
    vertical-align:middle!important;
}
.clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide thead th,
body.modal-view .clean-page.kepatuhan-inheren2-direct table.inheren-lain-ket-wide thead th{
    text-align:center!important;
    vertical-align:middle!important;
}


.clean-page table.inheren-wide-keterangan td.ket-auto-fill{
    border-left:1px solid #111!important;
    border-right:1px solid #111!important;
    border-top:1px solid #111!important;
    border-bottom:1px solid #111!important;
    min-height:10px!important;
}
.clean-page table.inheren-wide-keterangan td.ket-merge-start,
.clean-page table.inheren-wide-keterangan td.ket-merge-mid,
.clean-page table.inheren-wide-keterangan td.ket-merge-end,
.clean-page table.inheren-wide-keterangan td.ket-merge-single{
    border-left:1px solid #111!important;
    border-right:1px solid #111!important;
}


/* ===== FIX TERBARU: URAIAN REKAP RATA KIRI & HILANGKAN WARNA HEADER REPUTASI ===== */
.clean-page .uraian-rekap-left,
body.modal-view .clean-page .uraian-rekap-left{
    text-align:left!important;
    vertical-align:top!important;
    white-space:pre-wrap!important;
}
.clean-page .uraian-rekap-left .print-field,
body.modal-view .clean-page .uraian-rekap-left .print-field{
    text-align:left!important;
    margin-left:0!important;
    margin-right:0!important;
}
/* Header/bar warna dari halaman sumber dibuat putih seperti Stratejik, bukan biru/abu blok. */
.clean-page .card-header,
.clean-page [class*="bg-"],
.clean-page div[style*="background"],
.clean-page div[style*="background-color"],
body.modal-view .clean-page .card-header,
body.modal-view .clean-page [class*="bg-"],
body.modal-view .clean-page div[style*="background"],
body.modal-view .clean-page div[style*="background-color"]{
    background:#fff!important;
    background-color:#fff!important;
    color:#000!important;
}
.clean-page .card-header,
body.modal-view .clean-page .card-header{
    border:0!important;
    padding:0!important;
}


/* ===== FIX FINAL PRINT F4 =====
   Toolbar tidak ikut tercetak dan margin PDF F4 dibuat normal. */
@media print{
    @page{size:215mm 330mm;margin:12mm!important;}
    html,body{margin:0!important;padding:0!important;background:#fff!important;}
    .toolbar{display:none!important;height:0!important;min-height:0!important;overflow:hidden!important;padding:0!important;margin:0!important;border:0!important;visibility:hidden!important;}
    .report-wrap{width:100%!important;max-width:100%!important;margin:0!important;padding:0!important;zoom:1!important;}
    .cover,.print-section{border:0!important;box-shadow:none!important;margin:0!important;}
    .cover{padding:0!important;}
    .section-content{padding:0!important;}
}



/* ===== FIX FINAL: KETERANGAN INHEREN KREDIT/LIKUIDITAS JANGAN TERBUKA ===== */
.clean-page table.inheren-wide-keterangan td.ket-merge-start,
.clean-page table.inheren-wide-keterangan th.ket-merge-start,
.clean-page table.inheren-wide-keterangan td.ket-merge-mid,
.clean-page table.inheren-wide-keterangan th.ket-merge-mid,
.clean-page table.inheren-wide-keterangan td.ket-merge-end,
.clean-page table.inheren-wide-keterangan th.ket-merge-end,
.clean-page table.inheren-wide-keterangan td.ket-merge-single,
.clean-page table.inheren-wide-keterangan th.ket-merge-single,
.clean-page table.inheren-wide-keterangan td.ket-auto-fill,
.clean-page table.inheren-wide-keterangan th.ket-auto-fill{
    border-top:1px solid #111!important;
    border-bottom:1px solid #111!important;
    border-left:1px solid #111!important;
    border-right:1px solid #111!important;
    vertical-align:top!important;
}
.clean-page table.inheren-wide-keterangan td.ket-auto-fill:empty::after{
    content:' ';
    white-space:pre;
}


/* ===== HALAMAN PERNYATAAN & TANDA TANGAN PALING BAWAH ===== */
.pernyataan-page{
    page-break-before:always;
    break-before:page;
    width:100%;
    max-width:100%;
    margin:0;
    padding:0 4mm;
    color:#000;
    background:#fff;
    font-size:10px;
    line-height:1.45;
}
.pernyataan-page .pernyataan-line{
    border-top:2px solid #111;
    border-bottom:1px solid #111;
    height:4px;
    margin:0 0 22px 0;
}
.pernyataan-page p{
    margin:0 0 18px 0;
    text-align:left;
    font-size:10px;
    line-height:1.45;
}
.pernyataan-page .status-konfirmasi{
    margin:0 0 72px 0;
    font-size:8px;
    line-height:1.5;
}
.pernyataan-page .tanggal-ttd{
    margin:0 0 22px 0;
    font-size:8px;
}
.pernyataan-page .ttd-table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
    font-size:8px;
}
.pernyataan-page .ttd-table th,
.pernyataan-page .ttd-table td{
    border:1px solid #111;
    padding:5px 8px;
    vertical-align:middle;
}
.pernyataan-page .ttd-table th{
    text-align:center;
    font-weight:700;
}
.pernyataan-page .ttd-table td{
    text-align:left;
}
.pernyataan-page .ttd-table .ttd-space{
    height:120px;
}

.tindak-lanjut-direct{padding:10px 12px!important;font-size:8px!important;}
.tindak-lanjut-direct h3{margin:0 0 8px 0;text-align:left;font-size:10px;font-weight:800;border-bottom:2px solid #111;padding-bottom:5px;}
.tl-info{width:100%;border-collapse:collapse;margin-bottom:8px;font-size:8px;}
.tl-info td{border:1px solid #111;padding:4px 6px;vertical-align:top;}
.tl-table{width:100%;border-collapse:collapse;table-layout:fixed;font-size:8px;}
.tl-table th,.tl-table td{border:1px solid #111;padding:6px 7px;vertical-align:top;color:#000;}
.tl-table th{background:#e5e5e5;text-align:center;font-weight:800;}
.tl-table td:first-child{background:#f2f2f2;text-align:center;font-weight:700;}
.tl-table small{font-size:7px;color:#333;}
.tl-text{min-height:48px;white-space:normal;line-height:1.45;text-align:left!important;}
@media print{
    .tindak-lanjut-direct{padding:0!important;font-size:8px!important;}
    .tindak-lanjut-direct h3{font-size:10px!important;margin-bottom:6px!important;}
    .tl-table th,.tl-table td{padding:5px 6px!important;}
    .tl-text{line-height:1.35!important;}
}
@media print{
    .pernyataan-page{padding:0!important;font-size:10px!important;page-break-before:always!important;break-before:page!important;}
    .pernyataan-page p{font-size:10px!important;line-height:1.45!important;}
    .pernyataan-page .status-konfirmasi,.pernyataan-page .tanggal-ttd,.pernyataan-page .ttd-table{font-size:8px!important;}
    .pernyataan-page .ttd-table .ttd-space{height:115px!important;}
}



/* ===== FINAL FONT CETAK SEUKURAN FILE FPDF LEGACY =====
   Tabel utama mengikuti SetFont('Arial','',8), judul bagian 10,
   paragraf/pernyataan 10, dan header laporan 12. */
.clean-page th,.clean-page td{font-size:8px!important;line-height:1.25!important;padding:3px!important;}
.print-field{font-size:8px!important;line-height:1.25!important;padding:1px!important;}
.clean-page h4,.clean-page h5{font-size:10px!important;}
.clean-page h3{font-size:10px!important;}
.section-title{font-size:10px!important;padding:5px 6px!important;}
.pdf-profile-table th,.pdf-profile-table td,
.pdf-profile-single th,.pdf-profile-single td{font-size:8px!important;padding:3px!important;line-height:1.25!important;}
.pdf-profile-table .quality-cell,
.pdf-profile-single .quality-cell,
.cover-summary .quality{font-size:7.5px!important;line-height:1.18!important;}
.cover h1{font-size:12px!important;}
.cover table{font-size:10px!important;}
.cover-summary table{font-size:8px!important;}
.tindak-lanjut-direct,.tl-info,.tl-table{font-size:8px!important;}
.tindak-lanjut-direct h3{font-size:10px!important;}
.tl-table small{font-size:7px!important;}
.pernyataan-page,.pernyataan-page p{font-size:10px!important;line-height:1.45!important;}
.pernyataan-page .status-konfirmasi,
.pernyataan-page .tanggal-ttd,
.pernyataan-page .ttd-table{font-size:8px!important;}
body.modal-view .clean-page th,
body.modal-view .clean-page td{font-size:8px!important;padding:2px 3px!important;}
@media print{
    html,body{font-size:10px!important;}
    .clean-page th,.clean-page td{font-size:8px!important;line-height:1.25!important;padding:3px!important;}
    .print-field{font-size:8px!important;line-height:1.25!important;}
    .section-title{font-size:10px!important;}
    .cover table{font-size:10px!important;}
    .pernyataan-page,.pernyataan-page p{font-size:10px!important;}
    .pernyataan-page .status-konfirmasi,.pernyataan-page .tanggal-ttd,.pernyataan-page .ttd-table{font-size:8px!important;}
}



/* =========================================================
   OAI FIX FINAL - FONT CETAK DIPERBESAR SEPERTI PDF FPDF KANAN
   Berlaku untuk cetak profil risiko dan cetak tindak lanjut.
   Patokan FPDF: Arial 8pt/10pt/12pt => CSS dibuat sekitar 11px/13px/16px.
   ========================================================= */
html,body{font-size:12px!important;}
.cover h1{font-size:16px!important;line-height:1.25!important;}
.cover table{font-size:12px!important;}
.cover td{font-size:12px!important;padding:7px 8px!important;}
.cover-summary-title{font-size:12px!important;padding:6px!important;}
.cover-summary table{font-size:11px!important;}
.cover-summary th,.cover-summary td{font-size:11px!important;line-height:1.25!important;padding:5px 6px!important;}
.cover-summary .quality{font-size:10px!important;line-height:1.25!important;}
.section-title{font-size:13px!important;padding:7px 8px!important;}
.clean-page .page-title{font-size:13px!important;}
.clean-page h1{font-size:18px!important;line-height:1.25!important;}
.clean-page h2{font-size:16px!important;line-height:1.25!important;}
.clean-page h3{font-size:14px!important;line-height:1.25!important;}
.clean-page h4,.clean-page h5{font-size:13px!important;line-height:1.25!important;}
.clean-page th,.clean-page td{font-size:11px!important;line-height:1.32!important;padding:4px 5px!important;}
.print-field{font-size:11px!important;line-height:1.32!important;padding:2px!important;}
.pdf-profile-table th,.pdf-profile-table td,
.pdf-profile-single th,.pdf-profile-single td{font-size:11px!important;line-height:1.32!important;padding:4px 5px!important;}
.pdf-profile-table .quality-cell,
.pdf-profile-single .quality-cell{font-size:10px!important;line-height:1.28!important;}
body.modal-view .clean-page th,
body.modal-view .clean-page td{font-size:11px!important;line-height:1.32!important;padding:4px 5px!important;}
body.modal-view .clean-page .print-field{font-size:11px!important;line-height:1.32!important;}
.tindak-lanjut-direct{font-size:11px!important;line-height:1.35!important;}
.tindak-lanjut-direct h3{font-size:14px!important;line-height:1.25!important;}
.tl-info{font-size:11px!important;}
.tl-table{font-size:11px!important;}
.tl-table th,.tl-table td{font-size:11px!important;line-height:1.35!important;padding:6px 7px!important;}
.tl-table small{font-size:9px!important;}
.tl-text{font-size:11px!important;line-height:1.38!important;}
.pernyataan-page,.pernyataan-page p{font-size:12px!important;line-height:1.5!important;}
.pernyataan-page .status-konfirmasi,
.pernyataan-page .tanggal-ttd,
.pernyataan-page .ttd-table{font-size:10px!important;}
.pernyataan-page .ttd-table th,
.pernyataan-page .ttd-table td{font-size:10px!important;}
@media print{
    html,body{font-size:12px!important;}
    .cover h1{font-size:16px!important;}
    .cover table{font-size:12px!important;}
    .cover td{font-size:12px!important;padding:7px 8px!important;}
    .cover-summary-title{font-size:12px!important;}
    .cover-summary table{font-size:11px!important;}
    .cover-summary th,.cover-summary td{font-size:11px!important;line-height:1.25!important;padding:5px 6px!important;}
    .cover-summary .quality{font-size:10px!important;line-height:1.25!important;}
    .section-title{font-size:13px!important;padding:7px 8px!important;}
    .clean-page .page-title{font-size:13px!important;}
    .clean-page h3{font-size:14px!important;}
    .clean-page h4,.clean-page h5{font-size:13px!important;}
    .clean-page th,.clean-page td{font-size:11px!important;line-height:1.32!important;padding:4px 5px!important;}
    .print-field{font-size:11px!important;line-height:1.32!important;padding:2px!important;}
    .pdf-profile-table th,.pdf-profile-table td,
    .pdf-profile-single th,.pdf-profile-single td{font-size:11px!important;line-height:1.32!important;padding:4px 5px!important;}
    .pdf-profile-table .quality-cell,
    .pdf-profile-single .quality-cell{font-size:10px!important;line-height:1.28!important;}
    .tindak-lanjut-direct,.tl-info,.tl-table{font-size:11px!important;}
    .tindak-lanjut-direct h3{font-size:14px!important;}
    .tl-table th,.tl-table td{font-size:11px!important;line-height:1.35!important;padding:6px 7px!important;}
    .tl-table small{font-size:9px!important;}
    .pernyataan-page,.pernyataan-page p{font-size:12px!important;line-height:1.5!important;}
    .pernyataan-page .status-konfirmasi,
    .pernyataan-page .tanggal-ttd,
    .pernyataan-page .ttd-table{font-size:10px!important;}
}



/* =========================================================
   OAI FIX FINAL 2 - FONT DIPERBESAR LAGI SEPERTI CETAK FPDF KANAN
   Berlaku untuk cetak profil risiko lengkap dan cetak tindak lanjut.
   Diletakkan paling akhir agar menimpa semua ukuran font sebelumnya.
   ========================================================= */
html,body{font-size:14px!important;}
.report-wrap{font-size:14px!important;}
.cover h1{font-size:18px!important;line-height:1.25!important;font-weight:800!important;}
.cover table{font-size:14px!important;}
.cover td{font-size:14px!important;line-height:1.35!important;padding:8px 9px!important;}
.cover-summary-title{font-size:14px!important;padding:7px 8px!important;font-weight:800!important;}
.cover-summary table{font-size:13px!important;}
.cover-summary th,.cover-summary td{font-size:13px!important;line-height:1.32!important;padding:6px 7px!important;}
.cover-summary .quality{font-size:12px!important;line-height:1.3!important;}
.section-title{font-size:15px!important;line-height:1.25!important;padding:8px 9px!important;font-weight:800!important;}
.clean-page .page-title{font-size:15px!important;}
.clean-page h1{font-size:22px!important;line-height:1.25!important;}
.clean-page h2{font-size:20px!important;line-height:1.25!important;}
.clean-page h3{font-size:17px!important;line-height:1.25!important;}
.clean-page h4,.clean-page h5{font-size:16px!important;line-height:1.25!important;}
.clean-page th,.clean-page td{font-size:13px!important;line-height:1.38!important;padding:5px 6px!important;}
.clean-page thead th,.clean-page thead td{font-size:13px!important;line-height:1.3!important;}
.print-field{font-size:13px!important;line-height:1.38!important;padding:2px!important;}
.pdf-profile-table th,.pdf-profile-table td,
.pdf-profile-single th,.pdf-profile-single td{font-size:13px!important;line-height:1.35!important;padding:5px 6px!important;}
.pdf-profile-table .quality-cell,
.pdf-profile-single .quality-cell{font-size:12px!important;line-height:1.3!important;}
.profile-risk-title th{font-size:14px!important;padding:7px!important;}
body.modal-view .clean-page th,
body.modal-view .clean-page td{font-size:13px!important;line-height:1.38!important;padding:5px 6px!important;}
body.modal-view .clean-page .print-field{font-size:13px!important;line-height:1.38!important;}
.tindak-lanjut-direct{font-size:13px!important;line-height:1.42!important;}
.tindak-lanjut-direct h3{font-size:17px!important;line-height:1.25!important;}
.tl-info{font-size:13px!important;}
.tl-info td{font-size:13px!important;line-height:1.38!important;padding:6px 7px!important;}
.tl-table{font-size:13px!important;}
.tl-table th,.tl-table td{font-size:13px!important;line-height:1.42!important;padding:7px 8px!important;}
.tl-table small{font-size:11px!important;}
.tl-text{font-size:13px!important;line-height:1.45!important;}
.pernyataan-page,.pernyataan-page p{font-size:14px!important;line-height:1.55!important;}
.pernyataan-page .status-konfirmasi,
.pernyataan-page .tanggal-ttd,
.pernyataan-page .ttd-table{font-size:12px!important;}
.pernyataan-page .ttd-table th,
.pernyataan-page .ttd-table td{font-size:12px!important;padding:6px 9px!important;}
@media print{
    html,body{font-size:14px!important;}
    .cover h1{font-size:18px!important;}
    .cover table{font-size:14px!important;}
    .cover td{font-size:14px!important;line-height:1.35!important;padding:8px 9px!important;}
    .cover-summary-title{font-size:14px!important;}
    .cover-summary table{font-size:13px!important;}
    .cover-summary th,.cover-summary td{font-size:13px!important;line-height:1.32!important;padding:6px 7px!important;}
    .cover-summary .quality{font-size:12px!important;line-height:1.3!important;}
    .section-title{font-size:15px!important;padding:8px 9px!important;}
    .clean-page .page-title{font-size:15px!important;}
    .clean-page h3{font-size:17px!important;}
    .clean-page h4,.clean-page h5{font-size:16px!important;}
    .clean-page th,.clean-page td{font-size:13px!important;line-height:1.38!important;padding:5px 6px!important;}
    .clean-page thead th,.clean-page thead td{font-size:13px!important;}
    .print-field{font-size:13px!important;line-height:1.38!important;padding:2px!important;}
    .pdf-profile-table th,.pdf-profile-table td,
    .pdf-profile-single th,.pdf-profile-single td{font-size:13px!important;line-height:1.35!important;padding:5px 6px!important;}
    .pdf-profile-table .quality-cell,
    .pdf-profile-single .quality-cell{font-size:12px!important;line-height:1.3!important;}
    .tindak-lanjut-direct,.tl-info,.tl-table{font-size:13px!important;}
    .tindak-lanjut-direct h3{font-size:17px!important;}
    .tl-info td{font-size:13px!important;line-height:1.38!important;padding:6px 7px!important;}
    .tl-table th,.tl-table td{font-size:13px!important;line-height:1.42!important;padding:7px 8px!important;}
    .tl-table small{font-size:11px!important;}
    .pernyataan-page,.pernyataan-page p{font-size:14px!important;line-height:1.55!important;}
    .pernyataan-page .status-konfirmasi,
    .pernyataan-page .tanggal-ttd,
    .pernyataan-page .ttd-table{font-size:12px!important;}
}



/* =========================================================
   OAI FIX FINAL - MARGIN DISAMAKAN DENGAN FILE CONTOH
   Margin cetak F4 dikunci 12mm, area isi 100%, tanpa padding tambahan saat print.
   Font tetap memakai versi besar sebelumnya.
   ========================================================= */
@media print{
    @page{size:215mm 330mm;margin:12mm!important;}
    html,body{
        margin:0!important;
        padding:0!important;
        background:#fff!important;
    }
    .toolbar{
        display:none!important;
        height:0!important;
        min-height:0!important;
        overflow:hidden!important;
        padding:0!important;
        margin:0!important;
        border:0!important;
        visibility:hidden!important;
    }
    .report-wrap{
        width:100%!important;
        max-width:100%!important;
        min-width:0!important;
        margin:0!important;
        padding:0!important;
        zoom:1!important;
        background:#fff!important;
    }
    .cover,
    .print-section{
        width:100%!important;
        max-width:100%!important;
        margin:0!important;
        padding:0!important;
        border:0!important;
        box-shadow:none!important;
        background:#fff!important;
    }
    .cover{
        page-break-after:always!important;
        break-after:page!important;
    }
    .section-content{
        width:100%!important;
        max-width:100%!important;
        margin:0!important;
        padding:0!important;
        min-height:0!important;
        overflow:visible!important;
        background:#fff!important;
    }
    .clean-page,
    .section-content > .clean-page,
    .clean-page.content-page,
    .clean-page.content,
    .clean-page.container-fluid,
    .clean-page .content-page,
    .clean-page .content,
    .clean-page .container,
    .clean-page .container-fluid,
    .clean-page .card,
    .clean-page .card-body,
    .clean-page .table-responsive{
        width:100%!important;
        max-width:100%!important;
        min-width:0!important;
        margin-left:0!important;
        margin-right:0!important;
        padding-left:0!important;
        padding-right:0!important;
        left:auto!important;
        right:auto!important;
        transform:none!important;
        float:none!important;
        position:static!important;
    }
}
body.modal-view .report-wrap{
    width:215mm!important;
    max-width:215mm!important;
    min-width:215mm!important;
    margin:18px auto!important;
    padding:0!important;
    background:#fff!important;
}
body.modal-view .section-content{
    padding:6px!important;
    background:#fff!important;
    width:100%!important;
    overflow:visible!important;
}


/* =========================================================
   OAI FIX FINAL 3 - MARGIN COVER SEPERTI CONTOH + LOGO DEPAN
   Tampilan cover diberi ruang kiri/kanan seperti screenshot, tabel tidak menempel pinggir.
   Saat print F4, margin browser tetap 12mm dan isi cover diberi padding internal tipis.
   ========================================================= */
.cover{
    padding:18mm 13mm 0 13mm!important;
}
.cover-title{
    margin:0 0 10mm 0!important;
    min-height:18mm!important;
}
.cover-logo{
    display:block!important;
    left:2mm!important;
    max-width:16mm!important;
    max-height:16mm!important;
}
.cover-title-text{
    padding:0 22mm!important;
}
.cover table,
.cover-summary{
    width:100%!important;
    max-width:100%!important;
}
@media print{
    @page{size:215mm 330mm;margin:12mm!important;}
    .cover{
        padding:0!important;
    }
    .cover-title{
        margin:0 0 10mm 0!important;
        min-height:18mm!important;
    }
    .cover-logo{
        display:block!important;
        left:2mm!important;
        max-width:16mm!important;
        max-height:16mm!important;
    }
    .cover-title-text{
        padding:0 22mm!important;
    }
}
body.modal-view .cover{
    padding:18mm 13mm 0 13mm!important;
}
body.modal-view .cover-logo{
    display:block!important;
    left:2mm!important;
    max-width:16mm!important;
    max-height:16mm!important;
}



/* ===== FIX CETAK: KETERANGAN INLINE DI FORM DIKEMBALIKAN KE KOLOM KANAN ===== */
.clean-page table.print-keterangan-kanan,
body.modal-view .clean-page table.print-keterangan-kanan{
    width:100%!important;
    max-width:100%!important;
    table-layout:fixed!important;
    border-collapse:collapse!important;
}
.clean-page table.print-keterangan-kanan th.print-ket-right,
.clean-page table.print-keterangan-kanan td.print-ket-right,
body.modal-view .clean-page table.print-keterangan-kanan th.print-ket-right,
body.modal-view .clean-page table.print-keterangan-kanan td.print-ket-right{
    width:27%!important;
    min-width:27%!important;
    max-width:27%!important;
    text-align:left!important;
    vertical-align:top!important;
    white-space:pre-wrap!important;
    word-break:normal!important;
    overflow-wrap:break-word!important;
    border:1px solid #111!important;
}
.clean-page table.print-keterangan-kanan thead th.print-ket-right,
body.modal-view .clean-page table.print-keterangan-kanan thead th.print-ket-right{
    text-align:center!important;
    vertical-align:middle!important;
    background:#e6e6e6!important;
    font-weight:700!important;
}
.clean-page table.print-keterangan-kanan .ket-toggle-wrap,
.clean-page table.print-keterangan-kanan .row-ket-detail,
body.modal-view .clean-page table.print-keterangan-kanan .ket-toggle-wrap,
body.modal-view .clean-page table.print-keterangan-kanan .row-ket-detail{
    display:none!important;
}

</style>
<style><?= file_get_contents($__projectRoot . "/assets/css/print-cover-summary.css") ?></style>
<style><?= file_get_contents($__projectRoot . "/assets/css/print-table-grid.css") ?></style>
</head>
<body class="print-portrait<?= $isModalView ? ' modal-view' : '' ?>">
<div class="toolbar">
    <div>
        <div class="toolbar-title"><?= $cetakProfilPerRisikoOnly ? ($onlyTindakLanjut ? 'Cetak Tindak Lanjut - Analisis sampai Respon Cabang' : 'Cetak Tindak Lanjut - Halaman Profil Per Risiko') : 'Cetak Laporan Profil Risiko Lengkap - Format PDF Hitam Putih F4' ?></div>
        <div class="toolbar-note"><?= $cetakProfilPerRisikoOnly ? ($onlyTindakLanjut ? 'Mode ini menampilkan Analisis Risiko, Analisa Nilai Tertinggi, Definisi, Usulan Perbaikan, dan Respon Cabang per risiko. Default cetak: F4 Vertikal.' : 'Mode ini hanya menampilkan halaman profil per risiko. Default cetak: F4 Vertikal.') : 'Default cetak: F4 Vertikal. Setelah status selesai, klik Cetak PDF lalu pilih Save as PDF / Microsoft Print to PDF.' ?></div>
    </div>
    <div class="toolbar-actions">
        <label style="font-size:12px;color:#fff;display:flex;align-items:center;gap:4px;"><input type="radio" name="orientasi_cetak" value="portrait" checked> Vertikal</label>
        <label style="font-size:12px;color:#fff;display:flex;align-items:center;gap:4px;"><input type="radio" name="orientasi_cetak" value="landscape"> Horizontal</label>
        <span class="status" id="loadStatus">Menyiapkan laporan...</span>
        <a class="btn-back" href="../index.php?page=menulapawal&id=<?= (int)$id ?>">Kembali</a>
        <button type="button" class="btn-print" id="btnPrint" onclick="prepareAndPrintF4()" disabled>Cetak PDF</button>
    </div>
</div>

<div class="report-wrap">
    <?php if (!$cetakProfilPerRisikoOnly || $onlyTindakLanjut): ?>
    <div class="cover">
        <div class="cover-title">
            <img src="<?= esc_pdf($__logoCoverSrc) ?>" class="cover-logo" alt="Logo" onerror="this.style.display='none'">
            <div class="cover-title-text">
                <h1>LAPORAN PROFIL RISIKO</h1>
                <h1>PT BPR BKK JATENG (PERSERODA)</h1>
            </div>
        </div>
        <table>
            <tr><td style="width:190px;"><b>Kantor</b></td><td><?= esc_pdf($frame['cabang'] ?? '-') ?></td></tr>
            <tr><td><b>Tahun</b></td><td><?= esc_pdf($frame['tahun'] ?? '-') ?></td></tr>
            <tr><td><b>Periode</b></td><td><?= esc_pdf($frame['periode_laporan'] ?? '-') ?></td></tr>
            <tr><td><b>Jenis Profil Risiko</b></td><td><?= esc_pdf($frame['tipe_user'] ?? '-') ?></td></tr>
            <tr><td><b>Tanggal Cetak</b></td><td><?= date('d-m-Y H:i') ?></td></tr>
        </table>
        <?= pdf_cover_profil_nilai_peringkat_html($conn, $id, $frame) ?>
        <?= cetak_ringkas_cover_uraian($conn, $id) ?>
    </div>
    <?php endif; ?>

    <?php foreach($sections as $idx => $s):
        $pages = array_values(array_unique($s['pages']));
        $urls = [];
        foreach($pages as $p){
            foreach ((array)build_url_pdf($p, $id) as $u) {
                $urls[] = $u;
            }
        }
        $urls = array_values(array_unique($urls));
    ?>
    <?php
        $fallbackHtml = $fallbacks[$s['title']] ?? '';
        $pakaiFallbackLangsung = (($cetakProfilPerRisikoOnly || $onlyTindakLanjut) && trim((string)$fallbackHtml) !== '');
    ?>
    <section class="print-section" data-section="<?= (int)$idx ?>" data-title="<?= esc_pdf($s['title']) ?>" data-fallback="<?= esc_pdf($fallbackHtml) ?>" data-direct-fallback="<?= $pakaiFallbackLangsung ? '1' : '0' ?>">
        <div class="section-title"><?= esc_pdf(strtoupper(preg_replace('/\b(KPMR|INHEREN)\s+2\b/i', '$1', preg_replace('/^\d+\./', ($idx + 1) . '.', $s['title'])))) ?></div>
        <?php if ($pakaiFallbackLangsung): ?>
            <div class="section-content"><?= $fallbackHtml ?></div>
            <iframe class="source-frame" data-candidates='[]' data-title="<?= esc_pdf($s['title']) ?>"></iframe>
            <div class="route-note">Mode tindak lanjut: tampil langsung dari data profil per risiko</div>
        <?php else: ?>
            <div class="section-content loading">Memuat dan membersihkan halaman laporan...</div>
            <iframe class="source-frame" data-candidates='<?= esc_pdf(json_encode($urls)) ?>' data-title="<?= esc_pdf($s['title']) ?>"></iframe>
            <div class="route-note">Route: <?= esc_pdf(implode(' / ', $pages)) ?></div>
        <?php endif; ?>
    </section>
    <?php endforeach; ?>

    <?php 
    /*
      TANDA TANGAN HALAMAN PALING AKHIR

      - Cetak laporan lengkap: tampil
      - Cetak tindak lanjut: tampil
      - Cetak profil per risiko saja: tidak tampil
    */
    if (!$cetakProfilPerRisikoOnly || $onlyTindakLanjut): 
    ?>
        <?= pdf_pernyataan_ttd_html($conn, $frame) ?>
    <?php endif; ?>
</div>

<script src="<?= stripos(str_replace('\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? '')), '/laporan/') !== false ? '../../' : '../' ?>assets/js/print-risk-compact.js?v=20261030-03"></script>
<script>
(function(){
    window.setPrintOrientation = function(mode){
        document.body.classList.remove('print-portrait','print-landscape');
        document.body.classList.add(mode === 'portrait' ? 'print-portrait' : 'print-landscape');
        let st = document.getElementById('dynamicPrintPageSize');
        if (!st) { st = document.createElement('style'); st.id='dynamicPrintPageSize'; document.head.appendChild(st); }
        // Print PDF default dibuat normal tanpa zoom agar margin F4 kiri/kanan/atas/bawah rapi.
        // Toolbar juga dipaksa hilang saat print supaya tidak ikut tercetak di bagian atas PDF.
        st.textContent = '@media print{@page{size:' + (mode === 'portrait' ? '215mm 330mm' : '330mm 215mm') + ';margin:12mm!important;} html,body{background:#fff!important;margin:0!important;padding:0!important;} .toolbar{display:none!important;height:0!important;min-height:0!important;overflow:hidden!important;padding:0!important;margin:0!important;border:0!important;} .report-wrap{zoom:1!important;width:100%!important;max-width:100%!important;margin:0!important;padding:0!important;} .cover{padding:0!important;margin:0!important;border:0!important;box-shadow:none!important;} .print-section{border:0!important;box-shadow:none!important;margin:0!important;}}';
    };
    window.setPrintScale = function(scale){
        window.__printScale = Math.max(80, Math.min(200, parseInt(scale,10) || 100));
        document.body.className = document.body.className.replace(/print-scale-\d+/g,'').trim() + ' print-scale-' + window.__printScale;
        var isLand = document.body.classList.contains('print-landscape');
        window.setPrintOrientation(isLand ? 'landscape' : 'portrait');
    };
    setPrintScale(<?= (int)$printScale ?>);
    setPrintOrientation(document.querySelector('input[name="orientasi_cetak"]:checked') ? document.querySelector('input[name="orientasi_cetak"]:checked').value : 'portrait');


    window.prepareAndPrintF4 = function(){
        const checked = document.querySelector('input[name="orientasi_cetak"]:checked');
        const mode = checked ? checked.value : 'portrait';
        setPrintScale(<?= (int)$printScale ?>);
        setPrintOrientation(mode);
        setTimeout(function(){
            window.print();
        }, 150);
    };
    document.querySelectorAll('input[name="orientasi_cetak"]').forEach(function(r){
        r.addEventListener('change', function(){ setPrintOrientation(this.value); });
        if (r.checked) setPrintOrientation(r.value);
    });

    const sections = Array.from(document.querySelectorAll('.print-section'));
    const statusEl = document.getElementById('loadStatus');
    const btnPrint = document.getElementById('btnPrint');
    let loadedCount = 0;

    if (sections.length === 0) {
        statusEl.textContent = 'Tidak ada halaman profil per risiko untuk dicetak.';
        btnPrint.disabled = false;
    }

    function setStatus(){
        statusEl.textContent = 'Memuat ' + loadedCount + ' / ' + sections.length + ' bagian...';
        if (loadedCount >= sections.length) {
            statusEl.textContent = 'Selesai. Siap dicetak.';
            if (window.applySmartPageBreaks) setTimeout(window.applySmartPageBreaks, 300);
            btnPrint.disabled = false;
        }
    }

    function textOfControl(el){
        const tag = (el.tagName || '').toLowerCase();
        if (tag === 'select') {
            let selected = [];
            if (el.selectedOptions && el.selectedOptions.length) {
                selected = Array.from(el.selectedOptions);
            } else if (el.options && el.selectedIndex >= 0 && el.options[el.selectedIndex]) {
                selected = [el.options[el.selectedIndex]];
            } else {
                const byAttr = el.querySelector('option[selected]');
                if (byAttr) selected = [byAttr];
            }
            let txt = selected.map(function(o){ return (o.textContent || o.value || '').trim(); }).filter(Boolean).join(', ');
            const val = (el.value || '').trim();
            const low = txt.toLowerCase();
            if (txt === '' || txt === '-' || low === 'pilih' || low === '- pilih -' || low.indexOf('pilih ') >= 0 || low.indexOf('- pilih') >= 0) txt = val;
            // Untuk kolom PENILAIAN, jika option text kosong/placeholder, pakai value angka.
            if ((txt === '' || /^-+$/.test(txt)) && val !== '') txt = val;
            return txt;
        }
        if (tag === 'textarea') return (el.value || el.textContent || '').trim();
        if (tag === 'input') {
            const type = (el.getAttribute('type') || 'text').toLowerCase();
            if (type === 'hidden') return null;
            if (type === 'checkbox' || type === 'radio') return el.checked ? '✓' : '';
            return (el.value || '').trim();
        }
        return '';
    }

    function replaceControls(root){
        removePrintSaveIndicators(root);
        root.querySelectorAll('textarea,input,select').forEach(function(el){
            const txt = textOfControl(el);
            if (txt === null) { el.remove(); return; }
            const div = document.createElement('div');
            div.className = 'print-field' + (txt === '' ? ' empty' : '') + (el.tagName === 'TEXTAREA' ? ' print-note' : '');
            div.textContent = txt === '' ? '' : txt;
            el.parentNode.insertBefore(div, el);
            el.remove();
        });
    }




    function restoreInlineKeteranganToRightColumn(root){
        if (!root) return;

        function tableNeedKetFix(tbl){
            if (!tbl) return false;
            const raw = (((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : '')).toUpperCase());
            const hasSkala = raw.indexOf('SKALA RISIKO') >= 0;
            const hasKet = raw.indexOf('KETERANGAN') >= 0 || tbl.querySelector('.ket-toggle-wrap,.row-ket-detail,[class*="ket-"]');
            const isRiskTable = raw.indexOf('KPMR') >= 0 || raw.indexOf('INHEREN') >= 0;
            return hasSkala && hasKet && isRiskTable;
        }

        function getCells(row){
            return Array.from(row.children || []).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
        }

        function cleanKetText(txt){
            return String(txt || '')
                .replace(/\u00a0/g, ' ')
                .replace(/\r/g, '')
                .replace(/^[\s\n]*(Keterangan\s*:\s*)?/i, '')
                .replace(/^[:\-]+\s*/,'')
                .trim();
        }

        function addKeteranganHeader(tbl){
            const thead = tbl.tHead || tbl.querySelector('thead');
            if (!thead) return;
            const thText = (thead.textContent || '').toUpperCase();
            if (thText.indexOf('KETERANGAN') >= 0) return;

            const rows = Array.from(thead.rows || thead.querySelectorAll('tr'));
            if (!rows.length) return;
            const firstCells = getCells(rows[0]);
            if (firstCells.length === 1) {
                const cs = parseInt(firstCells[0].getAttribute('colspan') || firstCells[0].colSpan || '1', 10) || 1;
                firstCells[0].setAttribute('colspan', String(cs + 1));
            }

            let headerRow = null;
            for (let i=0; i<rows.length; i++) {
                const t = (rows[i].textContent || '').toUpperCase();
                if (t.indexOf('NO') >= 0 && t.indexOf('PARAMETER') >= 0 && t.indexOf('PENILAIAN') >= 0) {
                    headerRow = rows[i];
                    break;
                }
            }
            if (!headerRow) headerRow = rows.length >= 2 ? rows[1] : rows[0];
            const th = document.createElement('th');
            th.textContent = 'KETERANGAN';
            th.className = 'col-keterangan print-ket-right';
            th.rowSpan = rows.length >= 3 ? 2 : 1;
            th.style.textAlign = 'center';
            th.style.verticalAlign = 'middle';
            headerRow.appendChild(th);
        }

        function getOrCreateRightKetCell(row){
            const cells = getCells(row);
            if (!cells.length) return null;

            // Baris judul/PILAR yang colspan penuh cukup dilebarkan, tidak ditambah isi keterangan.
            if (cells.length === 1 && (parseInt(cells[0].getAttribute('colspan') || cells[0].colSpan || '1', 10) || 1) >= 6) {
                const cs = parseInt(cells[0].getAttribute('colspan') || cells[0].colSpan || '1', 10) || 1;
                if (cs < 10) cells[0].setAttribute('colspan', String(cs + 1));
                return null;
            }

            // Jika tabel sumber sudah punya kolom KETERANGAN di kanan, pakai cell terakhir.
            // KPMR 1 sumber lama biasanya baru 9 kolom: NO, PARAMETER, 5 skala, PENILAIAN, PERIODE.
            // Pada kasus itu cell terakhir adalah "Penilaian Periode Sebelumnya", jadi harus append kolom baru.
            let ketCell = row.querySelector('td.print-ket-right, th.print-ket-right');
            if (!ketCell && cells.length >= 10) {
                ketCell = cells[cells.length - 1];
            }
            if (!ketCell) {
                ketCell = document.createElement(row.querySelector('th') && !row.querySelector('td') ? 'th' : 'td');
                row.appendChild(ketCell);
            }
            ketCell.classList.add('print-ket-right','col-keterangan');
            ketCell.style.textAlign = 'left';
            ketCell.style.verticalAlign = 'top';
            ketCell.style.whiteSpace = 'pre-wrap';
            return ketCell;
        }

        function readKetTextFromNode(node){
            if (!node) return '';
            const textarea = node.querySelector('textarea');
            if (textarea) {
                const text = cleanKetText(textarea.value || textarea.textContent || '');
                if (text) return text;
            }
            const field = node.querySelector('.print-field');
            if (field) {
                const text = cleanKetText(field.textContent || '');
                if (text) return text;
            }
            const box = node.querySelector('.ket-box,.auto-ket-box,.ket-panel,.ket-detail-panel,.ket-content,.ket-collapse,.collapse-keterangan');
            if (box) {
                const text = cleanKetText(box.value || box.textContent || '');
                if (text) return text;
            }
            return cleanKetText(node.textContent || '');
        }

        function isOnlyKetStatus(text){
            const normalized = cleanKetText(text).toLowerCase();
            return normalized === 'terisi' || normalized === 'kosong' || normalized === '';
        }

        function removeInlineKetTextFromCell(cell){
            if (!cell) return;
            cell.querySelectorAll('.ket-toggle-wrap,.ket-inline-wrap,.ket-inline-status,.ket-badge,.ket-status,.ket-open,.btn-ket,.btn-keterangan').forEach(function(el){
                if (el && el.parentNode) el.parentNode.removeChild(el);
            });
            cell.innerHTML = String(cell.innerHTML || '')
                .replace(/<br\s*\/?\s*>\s*Keterangan\s*:?\s*[^<]*/ig, '')
                .replace(/Keterangan\s*:?\s*[^<]*(?=<|$)/ig, '')
                .replace(/(&nbsp;|\s)+$/ig, '');
        }

        function extractKetFromRow(row){
            const cells = getCells(row);
            if (cells.length < 3) return;
            const ketCell = getOrCreateRightKetCell(row);
            if (!ketCell) return;

            let ketText = '';
            for (let i=0; i<cells.length - 1; i++) {
                const c = cells[i];
                const ta = c.querySelector('textarea');
                if (ta && cleanKetText(ta.value || ta.textContent || '') !== '') {
                    ketText = cleanKetText(ta.value || ta.textContent || '');
                }
                const box = c.querySelector('.row-ket-detail,.ket-dropdown-row,.ket-panel,.ket-detail-panel,.ket-box,.ket-content,.ket-collapse,.collapse-keterangan');
                if (!ketText && box && cleanKetText(box.textContent || '') !== '') {
                    ketText = cleanKetText(box.textContent || '');
                }
                const field = c.querySelector('.print-field');
                if (!ketText && field && cleanKetText(field.textContent || '') !== '') {
                    ketText = cleanKetText(field.textContent || '');
                }
                const wrap = c.querySelector('.ket-toggle-wrap,.ket-inline-wrap,.ket-inline-status,.ket-badge,.ket-status,.btn-ket,.btn-keterangan');
                if (!ketText && wrap && !isOnlyKetStatus(wrap.textContent || '')) {
                    ketText = cleanKetText(wrap.textContent || '');
                }
                const plain = c.textContent || '';
                if (!ketText && /Keterangan\s*:/i.test(plain)) {
                    const m = plain.match(/Keterangan\s*:\s*([\s\S]*)/i);
                    if (m && !isOnlyKetStatus(m[1])) ketText = cleanKetText(m[1]);
                }
                if (/Keterangan\s*:/i.test(plain) || wrap || box || ta) {
                    removeInlineKetTextFromCell(c);
                }
                if (ketText) break;
            }

            if (ketText && (cleanKetText(ketCell.textContent || '') === '' || isOnlyKetStatus(ketCell.textContent || ''))) {
                ketCell.textContent = ketText;
            }
        }

        root.querySelectorAll('table').forEach(function(tbl){
            if (!tableNeedKetFix(tbl)) return;

            tbl.classList.add('kpmr-ket-wide','inheren-lain-ket-wide','print-keterangan-kanan');
            addKeteranganHeader(tbl);

            // Pindahkan row detail keterangan ke cell kanan pada baris sebelumnya.
            const detailRows = Array.from(tbl.querySelectorAll('tr.row-ket-detail,tr.ket-dropdown-row,tr.ket-detail-row'));
            detailRows.forEach(function(detailRow){
                let text = readKetTextFromNode(detailRow);
                let target = detailRow.previousElementSibling;
                while (target && (
                    target.classList.contains('row-ket-detail') ||
                    target.classList.contains('ket-dropdown-row') ||
                    target.classList.contains('ket-detail-row') ||
                    !getCells(target).length
                )) {
                    target = target.previousElementSibling;
                }
                const ketCell = getOrCreateRightKetCell(target);
                if (ketCell) ketCell.textContent = cleanKetText(text);
                detailRow.remove();
            });

            // Pindahkan tulisan "Keterangan : Terisi/Kosong/isi lainnya" dari kolom parameter ke kolom kanan.
            Array.from(tbl.querySelectorAll('tbody tr')).forEach(function(row){
                if (row.classList.contains('row-ket-detail')) return;
                extractKetFromRow(row);
            });

            // Pastikan semua baris data tetap punya cell kanan agar kanan tidak kosong/bolong.
            Array.from(tbl.querySelectorAll('tbody tr')).forEach(function(row){
                const cells = getCells(row);
                if (!cells.length) return;
                if (cells.length === 1 && (parseInt(cells[0].getAttribute('colspan') || cells[0].colSpan || '1', 10) || 1) >= 6) {
                    const cs = parseInt(cells[0].getAttribute('colspan') || cells[0].colSpan || '1', 10) || 1;
                    if (cs < 10) cells[0].setAttribute('colspan', String(cs + 1));
                    return;
                }
                getOrCreateRightKetCell(row);
            });
        });
    }

    function removeDropdownArtifacts(root){
        const selectors = [
            'option','optgroup','datalist',
            '.dropdown-menu','.dropdown-item','.select2-container','.select2-dropdown','.dropdown-toggle','.bootstrap-select','.filter-option','.inner.show',
            '.select2-results','.select2-results__options','.select2-results__option',
            '.choices','.choices__list','.choices__list--dropdown',
            '.multiselect-container','.bs-searchbox','.bootstrap-select','.dropdown.bootstrap-select','.selectpicker'
        ];
        root.querySelectorAll(selectors.join(',')).forEach(function(el){ el.remove(); });

        // Hapus baris/cell kecil yang hanya berasal dari pilihan dropdown dan bukan data laporan.
        root.querySelectorAll('td,th,div,span').forEach(function(el){
            const txt = (el.textContent || '').trim();
            if (!txt) return;
            const cls = (el.className || '').toString().toLowerCase();
            if (cls.indexOf('dropdown') >= 0 || cls.indexOf('select2') >= 0 || cls.indexOf('choices') >= 0) {
                el.remove();
            }
        });
    }

    function isSectionBreakRow(row){
        const txt = (row.textContent || '').trim().toUpperCase();
        if (!txt) return false;
        if (/^PILAR\s*\d+|^LAINNYA|REKAP PENILAIAN|HASIL PENILAIAN|URAIAN UNTUK|RISIKO .* INHEREN|REKAPITULASI/.test(txt)) return true;
        const cells = row.children ? Array.from(row.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); }) : [];
        if (cells.length === 1 && (cells[0].getAttribute('colspan') || 0) > 1) return true;
        return false;
    }

    function cellHasRealText(cell){
        if (!cell) return false;
        const txt = (cell.textContent || '').replace(/\s+/g,' ').trim();
        if (!txt) return false;
        // tombol/label kecil bukan uraian
        if (/^(kosong|tampilkan|sembunyikan|✓)$/i.test(txt)) return false;
        return true;
    }

    function fixKeteranganRowspan(root){
        root.querySelectorAll('table').forEach(function(tbl){
            const headerText = (tbl.tHead ? tbl.tHead.textContent : tbl.textContent || '').toUpperCase();

            /*
              FIX STABIL:
              - Tabel KPMR jangan digabung karena setiap baris punya keterangan sendiri.
              - Inheren Kredit memakai rowspan asli sampai sub-parameter terakhir.
                Inheren Likuiditas mempertahankan susunan sel untuk variasi colspan sumber.
              - Normalisasi sel dilakukan sebelum penggabungan agar kolom kanan lengkap;
                kolom penilaian dan struktur tabel sumber tetap dipertahankan.
            */
            const isKpmrTable = headerText.indexOf('KPMR') >= 0;
            if (isKpmrTable) {
                tbl.querySelectorAll('td[rowspan],th[rowspan]').forEach(function(c){
                    c.removeAttribute('rowspan');
                    c.style.verticalAlign = 'top';
                });
                return;
            }

            const isAllowedInheren = (
                headerText.indexOf('RISIKO KREDIT INHEREN') >= 0 ||
                headerText.indexOf('RISIKO LIKUIDITAS INHEREN') >= 0 ||
                headerText.indexOf('LIKUIDITAS INHEREN') >= 0
            );
            if (!isAllowedInheren) return;
            if (headerText.indexOf('KETERANGAN') < 0 && headerText.indexOf('REFERENSI') < 0) return;

            // Kredit dan likuiditas: satu sel keterangan hingga subparameter terakhir.
            // Jangan normalisasi ulang sel sub yang sudah ditutup oleh rowspan.
            const isRowspanInheren = isAllowedInheren;
            if (isRowspanInheren && tbl.classList.contains('inheren-keterangan-rowspan')) return;

            // Hapus rowspan lama dari sumber/hasil fix sebelumnya agar tidak ada kolom tinggi kosong.
            tbl.querySelectorAll('td[rowspan],th[rowspan]').forEach(function(c){
                c.removeAttribute('rowspan');
                c.style.verticalAlign = 'top';
            });

            let group = [];

            function getCells(row){
                return Array.from(row.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
            }
            function countCols(row){
                return getCells(row).reduce(function(n,c){ return n + (parseInt(c.getAttribute('colspan') || '1', 10) || 1); }, 0);
            }
            function rowText(row){
                return (row.textContent || '').replace(/\s+/g,' ').trim();
            }
            function findExpectedCols(){
                // Ambil jumlah kolom dari header asli: NO PARAMETER ... KETERANGAN.
                // Untuk Kredit/Likuiditas Inheren normalnya 9 kolom.
                let expected = 0;
                const rows = Array.from(tbl.querySelectorAll('tr'));
                rows.forEach(function(r){
                    const t = rowText(r).toUpperCase();
                    if (t.indexOf('NO') >= 0 && t.indexOf('PARAMETER') >= 0 && t.indexOf('KETERANGAN') >= 0) {
                        const c = countCols(r);
                        if (c > expected) expected = c;
                    }
                });
                if (!expected || expected < 6) expected = 9;
                return expected;
            }
            function normalizeRightKeteranganCells(){
                const expected = findExpectedCols();
                const rows = Array.from(tbl.querySelectorAll('tbody tr'));
                rows.forEach(function(row){
                    const txt = rowText(row).toUpperCase();
                    if (!txt) {
                        if (isRowspanInheren) row.remove();
                        return;
                    }
                    // Header/separator yang sudah colspan penuh jangan ditambah kolom.
                    if (/^PILAR\s*\d+|^LAINNYA|^REKAP|^REKAPITULASI|^URAIAN|^HASIL PENILAIAN|^RISIKO .* INHEREN/.test(txt)) return;

                    let current = countCols(row);
                    // Rapikan kolom kosong berlebih dari markup sumber yang tidak seimbang.
                    // Isi parameter dan nilai tidak dibuang.
                    if (isRowspanInheren && current > expected) {
                        const extras = getCells(row).slice(2).reverse();
                        extras.forEach(function(cell){
                            if (current <= expected || cellHasRealText(cell)) return;
                            const remove = Math.min(current - expected, cell.colSpan);
                            if (remove === cell.colSpan) cell.remove();
                            else cell.colSpan -= remove;
                            current -= remove;
                        });
                    }
                    // Baris detail kualitatif memakai colspan hingga kolom keterangan.
                    // Sisakan kolom nilainya saat sel keterangan digabung ke atas.
                    const cells = getCells(row);
                    const tail = cells[cells.length - 1];
                    if (isRowspanInheren && current === expected && tail && tail.colSpan > 1) {
                        tail.colSpan -= 1;
                        current -= 1;
                    }
                    // Banyak baris sub-parameter dari sumber tidak punya cell kanan KETERANGAN.
                    // Tambahkan cell kosong sampai jumlah kolom sama dengan header, supaya sisi kanan tidak bolong.
                    while (current < expected) {
                        const td = document.createElement('td');
                        td.className = 'ket-auto-fill';
                        td.innerHTML = '';
                        row.appendChild(td);
                        current++;
                    }
                    if (isRowspanInheren) {
                        // Colspan kosong pada baris detail tidak boleh menghapus grid nilai.
                        // Colspan yang berisi teks/nilai tetap dipertahankan.
                        getCells(row).forEach(function(cell){
                            const span = cell.colSpan;
                            if (span <= 1 || cellHasRealText(cell)) return;
                            cell.colSpan = 1;
                            let previous = cell;
                            for (let i = 1; i < span; i++) {
                                const empty = cell.cloneNode(false);
                                empty.removeAttribute('id');
                                empty.colSpan = 1;
                                previous.after(empty);
                                previous = empty;
                            }
                        });
                    }
                });
            }
            normalizeRightKeteranganCells();
            const allRows = Array.from(tbl.querySelectorAll('tbody tr'));
            function isSeparator(row){
                const txt = rowText(row).toUpperCase();
                if (!txt) return true;
                if (/^PILAR\s*\d+/.test(txt)) return true;
                if (/^LAINNYA/.test(txt)) return true;
                if (/^REKAP/.test(txt) || /^REKAPITULASI/.test(txt)) return true;
                if (/^HASIL PENILAIAN/.test(txt) || /^URAIAN/.test(txt)) return true;
                if (/^RISIKO .* INHEREN/.test(txt)) return true;
                return false;
            }
            function isMainParameterRow(row){
                const cells = getCells(row);
                if (cells.length < 4) return false;
                const firstTxt = (cells[0].textContent || '').replace(/\s+/g,' ').trim();
                return /^\d+$/.test(firstTxt);
            }
            function lastCell(row){
                const cells = getCells(row);
                if (isRowspanInheren) {
                    if (cells.length < 2 || countCols(row) < 8) return null;
                } else if (cells.length < 4) return null;
                return cells[cells.length - 1];
            }
            function cleanKetClass(cell){
                if (!cell) return;
                cell.classList.remove('ket-merge-start','ket-merge-mid','ket-merge-end','ket-merge-single');
                cell.style.borderTop = '';
                cell.style.borderBottom = '';
                cell.style.verticalAlign = 'top';
            }

            // Bersihkan class merge lama kalau halaman direfresh/clone ulang.
            allRows.forEach(function(r){ cleanKetClass(lastCell(r)); });

            function processGroup(rows){
                if (!rows || rows.length <= 0) return;
                rows = rows.filter(function(r){ return (isRowspanInheren || getCells(r).length >= 4) && lastCell(r); });
                if (!rows.length) return;

                // Hanya gabungkan grup yang dimulai dari parameter utama angka.
                // Jadi keterangan parameter digabung sampai sub-parameter milik parameter itu saja,
                // lalu berhenti sebelum parameter utama berikutnya.
                if (!isMainParameterRow(rows[0])) return;

                const firstText = rowText(rows[0]).toUpperCase();
                // Keterangan kredit boleh memuat kata rekap/hasil penilaian/uraian.
                // Batas grup inheren ditentukan dari nomor parameter, bukan isi keterangannya.
                if (!isRowspanInheren && (firstText.indexOf('REKAP') >= 0 || firstText.indexOf('HASIL PENILAIAN') >= 0 || firstText.indexOf('URAIAN') >= 0)) return;

                let source = null;
                rows.forEach(function(r){
                    const lc = lastCell(r);
                    if (!source && lc && cellHasRealText(lc)) source = lc;
                });

                const first = lastCell(rows[0]);
                if (!first) return;

                /*
                  FIX LIKUIDITAS/KREDIT:
                  - Jika keterangan ada di baris sub-parameter, pindahkan ke baris parameter utama
                    lalu gabungkan sampai akhir sub-parameter parameter itu saja.
                  - Jika tidak ada isi keterangan, tetap buat sel keterangan kosong yang di-rowspan.
                    Ini menjadi "penutup" kanan, terutama pada bagian LAINNYA, supaya tabel tidak terbuka/bolong.
                */
                if (source && source !== first) {
                    first.innerHTML = source.innerHTML;
                }

                /*
                  FIX TERBARU LIKUIDITAS:
                  Jangan pakai rowspan asli dan jangan remove cell keterangan di baris sub-parameter.
                  Rowspan/remove cell membuat sisi kanan tabel terlihat bolong pada beberapa struktur baris
                  Likuiditas karena jumlah kolom/colspan tidak selalu konsisten. Kita gabungkan secara visual:
                  - isi keterangan hanya ditaruh di baris parameter utama,
                  - cell keterangan sub-parameter tetap ada sebagai penutup kanan,
                  - border horizontal internal dihilangkan supaya terlihat seperti satu kotak gabungan.
                */
                /*
                  FIX FINAL KETERANGAN INHEREN KREDIT:
                  Jangan hilangkan border horizontal kolom keterangan.
                  Versi sebelumnya memakai ket-merge-start/mid/end sehingga beberapa baris
                  terlihat terbuka/bolong pada hasil PDF. Sekarang setiap baris tetap punya
                  cell keterangan dengan border penuh, hanya isi keterangan utama yang
                  dipindahkan ke baris parameter utama.
                */
                if (isRowspanInheren) {
                    tbl.classList.add('inheren-keterangan-rowspan');
                    first.rowSpan = rows.length;
                    first.classList.add('inheren-keterangan-merged');
                    // Cetak uraian saja; penghitung karakter adalah kontrol editor.
                    const note = first.querySelector('.print-field');
                    if (note) first.replaceChildren(note);
                    first.style.verticalAlign = 'top';
                    // Sel kanan baris sub diwakili sel rowspan; kolom nilai tetap utuh.
                    for (let i = 1; i < rows.length; i++) {
                        const ketCell = lastCell(rows[i]);
                        if (ketCell) ketCell.remove();
                    }
                    return;
                }

                first.removeAttribute('rowspan');
                first.classList.add('ket-merge-single');
                first.style.verticalAlign = 'top';
                first.style.borderTop = '1px solid #111';
                first.style.borderBottom = '1px solid #111';
                first.style.borderLeft = '1px solid #111';
                first.style.borderRight = '1px solid #111';

                for (let i = 1; i < rows.length; i++) {
                    const lc = lastCell(rows[i]);
                    if (!lc) continue;
                    lc.removeAttribute('rowspan');
                    lc.innerHTML = '';
                    lc.classList.add('ket-merge-single');
                    lc.style.verticalAlign = 'top';
                    lc.style.borderTop = '1px solid #111';
                    lc.style.borderBottom = '1px solid #111';
                    lc.style.borderLeft = '1px solid #111';
                    lc.style.borderRight = '1px solid #111';
                }
            }

            allRows.forEach(function(row){
                if (isSeparator(row)) {
                    processGroup(group);
                    group = [];
                    return;
                }
                const cells = getCells(row);
                if (cells.length < 4 && !(isRowspanInheren && countCols(row) >= 8)) return;

                if (isMainParameterRow(row) && group.length > 0) {
                    processGroup(group);
                    group = [];
                }
                group.push(row);
            });
            processGroup(group);
        });
    }




    function fixInherenKeteranganWidth(root){
        if (!root) return;
        root.querySelectorAll('table').forEach(function(tbl){
            const txt = ((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : '')).toUpperCase();
            const isTarget = (txt.indexOf('RISIKO KREDIT INHEREN') >= 0 || txt.indexOf('RISIKO LIKUIDITAS INHEREN') >= 0 || txt.indexOf('LIKUIDITAS INHEREN') >= 0);
            if (!isTarget || txt.indexOf('KETERANGAN') < 0) return;

            tbl.classList.add('inheren-wide-keterangan');
            tbl.style.width = '100%';
            tbl.style.maxWidth = '100%';
            tbl.style.tableLayout = 'fixed';
            tbl.style.marginLeft = '0';
            tbl.style.marginRight = '0';

            // Buang colgroup lama dari halaman sumber agar tidak mengunci lebar sempit.
            tbl.querySelectorAll('colgroup').forEach(function(cg){ cg.remove(); });

            // Lebar 9 kolom: No, Parameter, Nominal, Rasio, Ambang, Rumus, Koreksi, Nilai, Keterangan.
            // Keterangan dibuat lebar agar sejajar penuh dengan kotak judul dan tidak terlalu sempit.
            const widths = ['5%','13%','13%','9%','12%','8%','8%','8%','24%'];
            const cg = document.createElement('colgroup');
            widths.forEach(function(w){
                const col = document.createElement('col');
                col.style.width = w;
                cg.appendChild(col);
            });
            tbl.insertBefore(cg, tbl.firstChild);
        });
    }





    function normalizeKpmrSkalaHeader(tbl){
        if (!tbl) return;
        const rawAll = (((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : '')).toUpperCase());
        if (rawAll.indexOf('KPMR') < 0 || rawAll.indexOf('SKALA RISIKO') < 0) return;
        if (tbl.getAttribute('data-kpmr-header-normalized') === '1') return;
        tbl.setAttribute('data-kpmr-header-normalized','1');

        function trText(tr){ return (tr.textContent || '').replace(/\s+/g,' ').trim(); }
        const rows = Array.from(tbl.rows || []);
        if (!rows.length) return;

        let titleText = 'KPMR';
        for (let i=0; i<Math.min(rows.length, 4); i++){
            const t = trText(rows[i]);
            if (/KPMR/i.test(t)) { titleText = t; break; }
        }
        // Bersihkan title agar tidak berisi gabungan NO/PARAMETER/SKALA.
        titleText = titleText.replace(/\s*(NO|PARAMETER|SKALA RISIKO|PENILAIAN|KETERANGAN).*$/i, '').trim() || 'KPMR';

        // Cari awal data: biasanya baris PILAR. Semua baris sebelum itu adalah header lama yang rawan pecah.
        let dataStart = -1;
        for (let i=0; i<rows.length; i++){
            const t = trText(rows[i]).toUpperCase();
            if (/^PILAR\s*\d+|^PILAR\b/.test(t)) { dataStart = i; break; }
        }
        if (dataStart < 0) dataStart = Math.min(3, rows.length);

        const oldHeaderRows = rows.slice(0, dataStart);
        oldHeaderRows.forEach(function(r){ if (r && r.parentNode) r.parentNode.removeChild(r); });

        let thead = tbl.tHead;
        if (!thead) thead = tbl.createTHead();
        thead.innerHTML = '';

        const r0 = thead.insertRow();
        const h0 = document.createElement('th');
        h0.colSpan = 10;
        h0.textContent = titleText;
        h0.style.textAlign = 'center';
        h0.style.verticalAlign = 'middle';
        r0.appendChild(h0);

        const r1 = thead.insertRow();
        const header1 = [
            ['NO',1,2], ['PARAMETER',1,2], ['SKALA RISIKO',5,1], ['PENILAIAN',1,2], ['PENILAIAN PERIODE SEBELUMNYA',1,2], ['KETERANGAN',1,2]
        ];
        header1.forEach(function(x){
            const th=document.createElement('th');
            th.textContent=x[0];
            th.colSpan=x[1];
            th.rowSpan=x[2];
            th.style.textAlign='center';
            th.style.verticalAlign='middle';
            r1.appendChild(th);
        });
        const r2 = thead.insertRow();
        ['1','2','3','4','5'].forEach(function(v){
            const th=document.createElement('th');
            th.textContent=v;
            th.style.textAlign='center';
            th.style.verticalAlign='middle';
            r2.appendChild(th);
        });
    }


    function fixKpmrDanInherenLainWidth(root){
        if (!root) return;
        root.querySelectorAll('table').forEach(function(tbl){
            const raw = ((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : '')).toUpperCase();
            if (raw.indexOf('KETERANGAN') < 0) return;

            const isKpmr = raw.indexOf('KPMR') >= 0 && raw.indexOf('SKALA RISIKO') >= 0;
            const isInherenLain = raw.indexOf('SKALA RISIKO') >= 0 && (
                raw.indexOf('RISIKO OPERASIONAL INHEREN') >= 0 ||
                raw.indexOf('OPERASIONAL INHEREN') >= 0 ||
                raw.indexOf('RISIKO KEPATUHAN INHEREN') >= 0 ||
                raw.indexOf('KEPATUHAN INHEREN') >= 0 ||
                raw.indexOf('RISIKO REPUTASI INHEREN') >= 0 ||
                raw.indexOf('REPUTASI INHEREN') >= 0 ||
                raw.indexOf('RISIKO STRATEJIK INHEREN') >= 0 ||
                raw.indexOf('STRATEJIK INHEREN') >= 0 ||
                raw.indexOf('STRATEGIK INHEREN') >= 0
            );
            if (!isKpmr && !isInherenLain) return;

            if (isKpmr) {
                normalizeKpmrSkalaHeader(tbl);
            }

            tbl.classList.add(isKpmr ? 'kpmr-ket-wide' : 'inheren-lain-ket-wide');
            tbl.style.width = '100%';
            tbl.style.maxWidth = '100%';
            tbl.style.tableLayout = 'fixed';
            tbl.style.marginLeft = '0';
            tbl.style.marginRight = '0';

            // Buang colgroup bawaan agar lebar kolom lama tidak mengunci tabel.
            tbl.querySelectorAll('colgroup').forEach(function(cg){ cg.remove(); });

            // Format tabel KPMR/Inheren dinamis umumnya 10 kolom:
            // NO, PARAMETER, SKALA 1, SKALA 2, SKALA 3, SKALA 4, SKALA 5, PENILAIAN, PENILAIAN PERIODE SEBELUMNYA, KETERANGAN.
            // KPMR diberi NO sedikit lebih lebar supaya header tidak pecah menjadi N/O.
            const widthsKpmr10 = ['5%','14%','8%','8%','8%','8%','8%','8%','9%','24%'];
            const widths10 = ['4%','14%','8%','8%','8%','8%','8%','8%','9%','25%'];
            const widths9  = ['4%','15%','9%','9%','9%','9%','9%','10%','26%'];
            const maxCells = Array.from(tbl.querySelectorAll('tr')).reduce(function(mx, tr){
                return Math.max(mx, Array.from(tr.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); }).reduce(function(sum,c){ return sum + (parseInt(c.getAttribute('colspan') || '1',10) || 1); }, 0));
            }, 0);
            const widths = isKpmr ? widthsKpmr10 : (maxCells >= 10 ? widths10 : widths9);
            const cg = document.createElement('colgroup');
            widths.forEach(function(w){
                const col = document.createElement('col');
                col.style.width = w;
                cg.appendChild(col);
            });
            tbl.insertBefore(cg, tbl.firstChild);
        });
    }


    function removeFaktorLainnyaEmptyRows(root){
        if (!root) return;
        root.querySelectorAll('table').forEach(function(tbl){
            // Jangan hapus baris yang menjadi jangkar/span keterangan kredit.
            if (tbl.classList.contains('inheren-keterangan-rowspan')) return;
            const raw = ((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : '')).toUpperCase();
            if (raw.indexOf('LAINNYA') < 0 || raw.indexOf('FAKTOR LAINNYA') < 0) return;

            Array.from(tbl.querySelectorAll('tr')).forEach(function(row){
                const txt = (row.textContent || '').replace(/\s+/g,' ').trim();
                const up = txt.toUpperCase();
                const cells = Array.from(row.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
                if (!cells.length) return;

                // Hapus baris utama kosong "1 Faktor Lainnya" agar langsung masuk ke sub-parameter a/b.
                // Baris sub-parameter a/b tetap dipertahankan.
                const hasFaktorLainnya = up.indexOf('FAKTOR LAINNYA') >= 0;
                const hasSubParam = /(^|\s)[A-Z]\./.test(up);
                const hasOnlyMainFaktor = hasFaktorLainnya && !hasSubParam;
                if (hasOnlyMainFaktor) {
                    row.remove();
                    return;
                }

                // Hapus baris benar-benar kosong yang tersisa setelah header LAINNYA.
                const compact = txt.replace(/[\s\u00a0\-0,.]/g,'');
                if (compact === '') row.remove();
            });
        });
    }

    function fixRekapRiskCenter(root){
        if (!root) return;
        root.querySelectorAll('table').forEach(function(tbl){
            const txt = ((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : '')).toUpperCase();
            const isRekap = txt.indexOf('REKAP PENILAIAN INHEREN KREDIT') >= 0 ||
                            txt.indexOf('REKAP PENILAIAN INHEREN LIKUIDITAS') >= 0 ||
                            txt.indexOf('HASIL PENILAIAN INHEREN') >= 0 && (txt.indexOf('INHEREN KREDIT') >= 0 || txt.indexOf('INHEREN LIKUIDITAS') >= 0);
            if (!isRekap) return;
            tbl.classList.add('rekap-risk-table');
            tbl.querySelectorAll('td,th').forEach(function(cell){
                cell.style.verticalAlign = 'middle';
            });
            tbl.querySelectorAll('tr').forEach(function(row){
                const cells = Array.from(row.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
                if (!cells.length) return;
                cells.forEach(function(cell, idx){
                    if (idx > 0 || /TINGKAT RISIKO|PERINGKAT|TERTINGGI|TERENDAH|RATA-RATA|NILAI DIAMBIL/i.test(cell.textContent || '')) {
                        cell.style.textAlign = 'center';
                    }
                });
            });
        });
    }


    function fixCenterNilaiPeringkatAman(root){
        if (!root) return;

        function cells(row){
            return Array.from(row.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
        }
        function clean(v){ return (v || '').replace(/\s+/g,' ').trim().toUpperCase(); }
        function center(cell){
            if (!cell) return;
            cell.classList.add('print-center-cell');
            cell.style.textAlign = 'center';
            cell.style.verticalAlign = 'middle';
            Array.from(cell.querySelectorAll('.print-field, span, b, strong, div')).forEach(function(el){
                el.style.textAlign = 'center';
                el.style.marginLeft = 'auto';
                el.style.marginRight = 'auto';
            });
        }
        function looksNumberOrRank(t){
            t = clean(t);
            return /^(NILAI\s*)?\d+([,.]\d+)?$/.test(t) ||
                   /^NILAI PERIODE SEBELUMNYA\s*\d+([,.]\d+)?$/.test(t) ||
                   /^(TERTINGGI|TERENDAH|RATA-RATA|NILAI DIAMBIL|PERINGKAT|TINGKAT RISIKO)$/.test(t) ||
                   /^(SANGAT RENDAH|RENDAH|SEDANG|TINGGI|SANGAT TINGGI|SANGAT MEMADAI|MEMADAI|CUKUP MEMADAI|KURANG MEMADAI|TIDAK MEMADAI)$/.test(t);
        }

        root.querySelectorAll('table').forEach(function(tbl){
            const raw = clean((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : ''));
            const isKpmr = raw.indexOf('KPMR') >= 0;
            const isRekap = raw.indexOf('REKAP PENILAIAN INHEREN KREDIT') >= 0 ||
                            raw.indexOf('REKAP PENILAIAN INHEREN LIKUIDITAS') >= 0 ||
                            (raw.indexOf('HASIL PENILAIAN INHEREN') >= 0 && (raw.indexOf('INHEREN KREDIT') >= 0 || raw.indexOf('INHEREN LIKUIDITAS') >= 0));

            if (!isKpmr && !isRekap) return;

            Array.from(tbl.querySelectorAll('tr')).forEach(function(row){
                const cs = cells(row);
                if (!cs.length) return;

                if (isKpmr) {
                    // Header kolom nilai/periode dibuat center.
                    cs.forEach(function(c){
                        const t = clean(c.textContent);
                        if (t === 'PENILAIAN' || t === 'NILAI' || t === 'PERINGKAT RISIKO' ||
                            t === 'PENILAIAN PERIODE SEBELUMNYA' || t === 'RISIKO PERIODE SEBELUMNYA' ||
                            t === 'NILAI PERIODE SEBELUMNYA') {
                            center(c);
                        }
                    });

                    // Model KPMR lama: NO | PARAMETER | SKALA 1-5 | PENILAIAN | PERIODE | KETERANGAN
                    if (cs.length >= 10) {
                        center(cs[7]);
                        center(cs[8]);
                    }
                    // Model KPMR 2: NO | PARAMETER | PERINGKAT RISIKO | KETERANGAN | RISIKO PERIODE SEBELUMNYA
                    if (cs.length === 5) {
                        center(cs[2]);
                        center(cs[4]);
                    }

                    // Baris variasi: center hanya cell pendek yang memang angka/rank, bukan narasi panjang.
                    cs.forEach(function(c, idx){
                        const t = clean(c.textContent);
                        if (idx > 0 && t.length <= 35 && looksNumberOrRank(t)) center(c);
                    });
                }

                if (isRekap) {
                    cs.forEach(function(c, idx){
                        const t = clean(c.textContent);
                        c.style.verticalAlign = 'middle';
                        // Di rekap, semua kolom selain label pertama adalah nilai/peringkat.
                        if (idx > 0 || looksNumberOrRank(t)) center(c);
                    });
                }
            });
        });
    }


    function fixAllNilaiPeringkatCenter(root){
        if (!root) return;
        function norm(t){ return (t || '').replace(/\s+/g,' ').trim().toUpperCase(); }
        root.querySelectorAll('table').forEach(function(tbl){
            const txt = norm((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : ''));
            const isKpmr = txt.indexOf('KPMR') >= 0;
            const isRekap = txt.indexOf('REKAP PENILAIAN') >= 0 || txt.indexOf('HASIL PENILAIAN') >= 0;
            if (!isKpmr && !isRekap) return;
            Array.from(tbl.rows || []).forEach(function(tr){
                const cells = Array.from(tr.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
                cells.forEach(function(c){
                    const t = norm(c.textContent);
                    const isShort = t.length <= 45;
                    const isNilai = /^\d+([,.]\d+)?$/.test(t) || /^NILAI\s*\d+([,.]\d+)?$/.test(t) || /^NILAI PERIODE SEBELUMNYA\s*\d+([,.]\d+)?$/.test(t);
                    const isRank = /^(SANGAT RENDAH|RENDAH|SEDANG|TINGGI|SANGAT TINGGI|SANGAT MEMADAI|MEMADAI|CUKUP MEMADAI|KURANG MEMADAI|TIDAK MEMADAI|TERTINGGI|TERENDAH|RATA-RATA|NILAI DIAMBIL|PERINGKAT|TINGKAT RISIKO|METODE RISIKO)$/.test(t);
                    const isHeader = /^(PENILAIAN|PERINGKAT RISIKO|RISIKO PERIODE SEBELUMNYA|PENILAIAN PERIODE SEBELUMNYA|NILAI|RUMUS|KOREKSI)$/.test(t);
                    if ((isNilai || isRank || isHeader) && isShort) {
                        c.classList.add('print-center-cell');
                        c.style.textAlign = 'center';
                        c.style.verticalAlign = 'middle';
                        c.querySelectorAll('.print-field,div,span,b,strong').forEach(function(el){
                            el.style.textAlign = 'center';
                            el.style.marginLeft = 'auto';
                            el.style.marginRight = 'auto';
                        });
                    }
                });
            });
        });
    }



    function fixKpmrNilaiCenterFinal(root){
        if (!root) return;
        function norm(t){ return (t || '').replace(/\s+/g,' ').trim().toUpperCase(); }
        function centerCell(cell){
            if (!cell) return;
            cell.classList.add('print-kpmr-center','print-center-cell');
            cell.style.textAlign = 'center';
            cell.style.verticalAlign = 'middle';
            cell.querySelectorAll('.print-field,div,span,b,strong').forEach(function(el){
                el.style.textAlign = 'center';
                el.style.marginLeft = 'auto';
                el.style.marginRight = 'auto';
            });
        }
        function isShortNilai(txt){
            txt = norm(txt);
            if (!txt) return false;
            if (txt.length > 70) return false;
            return /^\d+([,.]\d+)?$/.test(txt) ||
                   /^NILAI\s*\d+([,.]\d+)?$/.test(txt) ||
                   /^NILAI PERIODE SEBELUMNYA\s*\d+([,.]\d+)?$/.test(txt) ||
                   /^(TERTINGGI|TERENDAH|RATA-RATA|NILAI DIAMBIL|PERINGKAT|TINGKAT RISIKO|METODE RISIKO|PEMBOBOTAN|SANGAT RENDAH|RENDAH|SEDANG|TINGGI|SANGAT TINGGI|SANGAT MEMADAI|MEMADAI|CUKUP MEMADAI|KURANG MEMADAI|TIDAK MEMADAI)$/.test(txt);
        }
        root.querySelectorAll('table').forEach(function(tbl){
            const raw = norm((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : ''));
            const isKpmr = raw.indexOf('KPMR') >= 0;
            if (!isKpmr) return;

            const isRekapKpmr = raw.indexOf('REKAP PENILAIAN KPMR') >= 0 || raw.indexOf('HASIL PENILAIAN KPMR') >= 0;
            if (isRekapKpmr) tbl.classList.add('rekap-kpmr-center');

            Array.from(tbl.rows || []).forEach(function(tr){
                const cs = Array.from(tr.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
                if (!cs.length) return;

                // Rekap KPMR: semua kolom setelah label pertama adalah nilai/metode/peringkat, jadi wajib tengah.
                if (isRekapKpmr) {
                    cs.forEach(function(c, idx){
                        c.style.verticalAlign = 'middle';
                        if (idx > 0 || isShortNilai(c.textContent)) centerCell(c);
                    });
                    return;
                }

                // KPMR detail 10 kolom: kolom 8 dan 9 adalah Penilaian dan Penilaian Periode Sebelumnya.
                if (cs.length >= 10) {
                    centerCell(cs[7]);
                    centerCell(cs[8]);
                }

                // KPMR 2/format ringkas 5 kolom: kolom 3 dan 5 adalah nilai/periode sebelumnya.
                if (cs.length === 5) {
                    centerCell(cs[2]);
                    centerCell(cs[4]);
                }

                // Sel pendek berisi angka/ranking/metode juga dibuat center.
                cs.forEach(function(c, idx){
                    if (idx > 0 && isShortNilai(c.textContent)) centerCell(c);
                });
            });
        });
    }



    function fixInherenNilaiCenterFinal(root){
        if (!root) return;
        function norm(t){ return (t || '').replace(/\s+/g,' ').trim().toUpperCase(); }
        function centerCell(cell){
            if (!cell) return;
            cell.classList.add('print-inheren-center','print-center-cell');
            cell.style.textAlign = 'center';
            cell.style.verticalAlign = 'middle';
            cell.querySelectorAll('.print-field,div,span,b,strong').forEach(function(el){
                el.style.textAlign = 'center';
                el.style.marginLeft = 'auto';
                el.style.marginRight = 'auto';
            });
        }
        function isShortNilai(txt){
            txt = norm(txt);
            if (!txt) return false;
            if (txt.length > 80) return false;
            return /^\d+([,.]\d+)?$/.test(txt) ||
                   /^NILAI\s*\d+([,.]\d+)?$/.test(txt) ||
                   /^NILAI PERIODE SEBELUMNYA\s*\d+([,.]\d+)?$/.test(txt) ||
                   /^(TERTINGGI|TERENDAH|RATA-RATA|NILAI DIAMBIL|PERINGKAT|TINGKAT RISIKO|METODE RISIKO|PEMBOBOTAN|SANGAT RENDAH|RENDAH|SEDANG|TINGGI|SANGAT TINGGI|SANGAT MEMADAI|MEMADAI|CUKUP MEMADAI|KURANG MEMADAI|TIDAK MEMADAI)$/.test(txt);
        }
        root.querySelectorAll('table').forEach(function(tbl){
            const raw = norm((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : ''));
            const isInheren = raw.indexOf('INHEREN') >= 0;
            if (!isInheren) return;

            const isRekapInheren = raw.indexOf('REKAP PENILAIAN INHEREN') >= 0 || raw.indexOf('HASIL PENILAIAN INHEREN') >= 0;
            const isInherenRingkas = raw.indexOf('PERINGKAT RISIKO') >= 0 || raw.indexOf('PERIODE SEBELUMNYA') >= 0;
            if (isRekapInheren) tbl.classList.add('rekap-inheren-center');

            Array.from(tbl.rows || []).forEach(function(tr){
                const cs = Array.from(tr.children).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
                if (!cs.length) return;

                if (isRekapInheren) {
                    cs.forEach(function(c, idx){
                        c.style.verticalAlign = 'middle';
                        if (idx > 0 || isShortNilai(c.textContent)) centerCell(c);
                    });
                    return;
                }

                // Inheren dinamis/ringkas: NO | PARAMETER | PERINGKAT RISIKO | KETERANGAN | PERIODE SEBELUMNYA.
                if (isInherenRingkas && cs.length === 5) {
                    centerCell(cs[2]);
                    centerCell(cs[4]);
                }

                // Detail inheren kredit/likuiditas: kolom rumus/koreksi/nilai serta angka pendek dibuat center.
                if (cs.length >= 8) {
                    // Hindari kolom parameter/nominal/keterangan, fokus kolom angka pendek.
                    cs.forEach(function(c, idx){
                        const t = norm(c.textContent);
                        if (idx > 0 && idx < cs.length - 1 && isShortNilai(t)) centerCell(c);
                    });
                } else {
                    cs.forEach(function(c, idx){
                        if (idx > 0 && isShortNilai(c.textContent)) centerCell(c);
                    });
                }
            });
        });
    }




    function fixInheren2ParameterLeft(root){
        if (!root) return;
        function norm(t){ return (t || '').replace(/\s+/g,' ').trim().toUpperCase(); }
        function isShortNilai(txt){
            txt = norm(txt);
            if (!txt || txt.length > 45) return false;
            return /^\d+([,.]\d+)?$/.test(txt) ||
                   /^[A-Z]\.$/.test(txt) ||
                   /^(NILAI|NILAI PERIODE SEBELUMNYA|TERTINGGI|TERENDAH|RATA-RATA|RISIKO DITETAPKAN|PERINGKAT|TINGKAT RISIKO|METODE RISIKO)$/.test(txt) ||
                   /^(SANGAT RENDAH|RENDAH|SEDANG|TINGGI|SANGAT TINGGI|SANGAT MEMADAI|MEMADAI|CUKUP MEMADAI|KURANG MEMADAI|TIDAK MEMADAI)$/.test(txt);
        }
        function leftCell(cell){
            if (!cell) return;
            cell.classList.add('print-param-left');
            cell.classList.remove('print-center-cell','print-inheren-center','print-kpmr-center');
            cell.style.textAlign = 'left';
            cell.style.verticalAlign = 'middle';
            cell.querySelectorAll('.print-field,div,span,b,strong,p').forEach(function(el){
                el.style.textAlign = 'left';
                el.style.marginLeft = '0';
                el.style.marginRight = '0';
            });
        }
        root.querySelectorAll('table').forEach(function(tbl){
            const raw = norm((tbl.textContent || '') + ' ' + (tbl.tHead ? tbl.tHead.textContent : ''));
            const isInheren2 = raw.indexOf('INHEREN 2') >= 0 && raw.indexOf('KPMR') < 0 && (
                raw.indexOf('OPERASIONAL') >= 0 ||
                raw.indexOf('KEPATUHAN') >= 0 ||
                raw.indexOf('REPUTASI') >= 0 ||
                raw.indexOf('STRATEJIK') >= 0 ||
                raw.indexOf('STRATEGIK') >= 0
            );
            if (!isInheren2) return;
            tbl.classList.add('inheren-lain-ket-wide');

            Array.from(tbl.rows || []).forEach(function(tr){
                const cs = Array.from(tr.children || []).filter(function(c){ return /^(TD|TH)$/.test(c.tagName || ''); });
                if (!cs.length) return;
                const rowText = norm(tr.textContent || '');
                const isHeader = tr.parentElement && tr.parentElement.tagName === 'THEAD';
                if (isHeader) return;

                // Baris judul PILAR/HASIL PENILAIAN dibuat rata kiri pada labelnya.
                if (rowText.indexOf('PILAR ') >= 0 || rowText.indexOf('HASIL PENILAIAN PILAR') >= 0) {
                    leftCell(cs[0]);
                    return;
                }

                // Format Inheren 2 hasil fallback: NO | huruf | PARAMETER | NILAI | ...
                if (cs.length >= 8) {
                    // Parameter utama biasanya colspan=2 pada cell index 1, sedangkan sub parameter ada di index 2.
                    if (cs[1] && !isShortNilai(cs[1].textContent)) leftCell(cs[1]);
                    if (cs[2] && !isShortNilai(cs[2].textContent)) leftCell(cs[2]);
                    return;
                }

                // Format halaman asli/ringkas: NO | PARAMETER | PERINGKAT RISIKO | KETERANGAN | PERIODE SEBELUMNYA.
                if (cs.length >= 5) {
                    if (cs[1] && !isShortNilai(cs[1].textContent)) leftCell(cs[1]);
                    return;
                }

                // Fallback umum: sel panjang pertama setelah NO dianggap parameter/sub parameter.
                for (let i=1;i<cs.length;i++) {
                    const t = norm(cs[i].textContent || '');
                    if (t.length > 45 && !isShortNilai(t)) { leftCell(cs[i]); break; }
                }
            });
        });
    }

    function fixUraianRekapLeft(root){
        if (!root) return;
        function norm(t){ return (t || '').replace(/\s+/g,' ').trim().toUpperCase(); }
        root.querySelectorAll('table').forEach(function(tbl){
            const rows = Array.from(tbl.rows || []);
            rows.forEach(function(tr, idx){
                const text = norm(tr.textContent || '');
                if (text.indexOf('URAIAN UNTUK RISIKO INHEREN LIKUIDITAS') >= 0 ||
                    text.indexOf('URAIAN UNTUK RISIKO INHEREN KREDIT') >= 0 ||
                    text.indexOf('URAIAN UNTUK RISIKO INHEREN') >= 0 ||
                    text.indexOf('URAIAN UNTUK RISIKO KPMR') >= 0) {
                    const next = rows[idx + 1];
                    if (next) {
                        Array.from(next.children || []).forEach(function(td){
                            if (!/^(TD|TH)$/.test(td.tagName || '')) return;
                            td.classList.add('uraian-rekap-left');
                            td.style.textAlign = 'left';
                            td.style.verticalAlign = 'top';
                            td.querySelectorAll('.print-field,div,span,b,strong').forEach(function(el){
                                el.style.textAlign = 'left';
                                el.style.marginLeft = '0';
                                el.style.marginRight = '0';
                            });
                        });
                    }
                }
            });
        });
    }


    function forceProfilNilaiTabForCetak(clone, expectedTitle){
        if (!clone) return;
        const title = (expectedTitle || '').toLowerCase();
        const isNilai = title.indexOf('profil nilai') >= 0 || title.indexOf('nilai konsolidasi') >= 0;
        const isPeringkat = title.indexOf('profil peringkat') >= 0;
        if (!isNilai && !isPeringkat) return;

        const targetId = isPeringkat ? 'tab-peringkat' : 'tab-nilai';
        clone.classList.add(isPeringkat ? 'print-tab-peringkat' : 'print-tab-nilai');

        // Bersihkan tab menu supaya cetak hanya isi tabelnya saja.
        clone.querySelectorAll('.nav-tabs,.nav,[role="tablist"]').forEach(function(el){ el.remove(); });

        // Paksa hanya tab yang diminta tampil. Ini membuat hasil cetak sama dengan tampilan Profil Nilai/Peringkat di halaman asli.
        const panes = clone.querySelectorAll('.tab-pane, #tab-nilai, #tab-peringkat, #tab-peringkat-ojk');
        panes.forEach(function(pane){
            const id = pane.getAttribute('id') || '';
            if (id === targetId) {
                pane.classList.add('active','show');
                pane.style.display = 'block';
                pane.style.opacity = '1';
                pane.style.visibility = 'visible';
                pane.removeAttribute('aria-hidden');
            } else {
                pane.classList.remove('active','show');
                pane.style.display = 'none';
            }
        });

        // Kalau tab target berada di dalam wrapper, tampilkan juga semua parent-nya.
        const target = clone.querySelector('#' + targetId);
        if (target) {
            let p = target.parentElement;
            while (p && p !== clone) {
                p.style.display = '';
                p.style.opacity = '1';
                p.style.visibility = 'visible';
                p = p.parentElement;
            }
        }

        // Hilangkan tab OJK bila ikut terbawa saat cetak nilai/peringkat.
        if (isPeringkat) {
            const head = clone.querySelector('.profil-blue-head');
            if (head && /PROFIL NILAI/i.test(head.textContent || '')) head.textContent = 'PROFIL PERINGKAT';
        }
    }


    function removeProfilPeringkatUraian(root){
        if (!root) return;
        // Khusus cetak Profil Peringkat/Nilai dari halaman nilpro: bagian Uraian di bawah tabel tidak perlu dicetak.
        root.querySelectorAll('table').forEach(function(tbl){
            const txt = (tbl.textContent || '').replace(/\s+/g,' ').trim().toUpperCase();
            if (txt === 'URAIAN' || txt.indexOf('URAIAN') === 0) {
                tbl.remove();
            }
        });
        Array.from(root.querySelectorAll('tr')).forEach(function(tr){
            const txt = (tr.textContent || '').replace(/\s+/g,' ').trim().toUpperCase();
            if (txt === 'URAIAN' || txt.indexOf('URAIAN') === 0) {
                const tbl = tr.closest('table');
                if (tbl) tbl.remove(); else tr.remove();
            }
        });
        root.querySelectorAll('textarea').forEach(function(el){
            const labelTxt = (el.closest('table') ? el.closest('table').textContent : '').toUpperCase();
            if (labelTxt.indexOf('URAIAN') >= 0) {
                const tbl = el.closest('table');
                if (tbl) tbl.remove(); else el.remove();
            }
        });
    }

    function fixTablePageCutBorders(root){
        if (!root) return;
        root.querySelectorAll('table').forEach(function(tbl){
            const raw = (tbl.textContent || '').toUpperCase();
            if (
                raw.indexOf('RISIKO') >= 0 ||
                raw.indexOf('KPMR') >= 0 ||
                raw.indexOf('INHEREN') >= 0 ||
                raw.indexOf('REKAPITULASI') >= 0
            ) {
                tbl.classList.add('print-close-page-cut');
            }
        });
    }

    function cleanupClone(clone, expectedTitle){
        clone.classList.add('clean-page');
        forceProfilNilaiTabForCetak(clone, expectedTitle || '');
        if (/profil\s+(nilai|peringkat)|nilai\s+konsolidasi/i.test(expectedTitle || '')) {
            removeProfilPeringkatUraian(clone);
        }

        const removeSelectors = [
            '.left-side-menu','.navbar-custom','.topnav','.button-menu-mobile','.footer',
            '.page-title-right','.breadcrumb','.modal','.modal-backdrop','.btn','button',
            'script','style','noscript','.dataTables_filter','.dataTables_length','.dataTables_info',
            '.dataTables_paginate','.dt-buttons','.hide-print','.no-print','[data-bs-toggle="modal"]'
        ].join(',');
        clone.querySelectorAll(removeSelectors).forEach(function(el){ el.remove(); });

        // Hapus area kosong besar yang hanya berisi nav/sidebar jika masih terbawa.
        clone.querySelectorAll('nav, aside').forEach(function(el){ el.remove(); });

        // Pastikan box kualitas MR yang sebelumnya hidden muncul di PDF.
        clone.querySelectorAll('.quality-hidden').forEach(function(el){ el.classList.remove('quality-hidden'); });

        /*
           FIX PENTING:
           Jangan hapus <option> sebelum <select> dikonversi.
           Penyebab kolom PENILAIAN KPMR kosong adalah option sudah terhapus dulu,
           sehingga selected option tidak bisa dibaca. Urutannya wajib:
           1) ubah input/select/textarea menjadi teks biasa,
           2) baru bersihkan artifact dropdown.
        */
        replaceControls(clone);
        restoreInlineKeteranganToRightColumn(clone);
        removeDropdownArtifacts(clone);
        fixKeteranganRowspan(clone);
        fixInherenKeteranganWidth(clone);
        fixKpmrDanInherenLainWidth(clone);
        restoreInlineKeteranganToRightColumn(clone);
        removeFaktorLainnyaEmptyRows(clone);
        fixRekapRiskCenter(clone);
        fixCenterNilaiPeringkatAman(clone);
        fixAllNilaiPeringkatCenter(clone);
        fixKpmrNilaiCenterFinal(clone);
        fixInherenNilaiCenterFinal(clone);
        fixInheren2ParameterLeft(clone);
        fixUraianRekapLeft(clone);
        fixTablePageCutBorders(clone);

        // Hilangkan scrollbar/kotak scroll dari sumber asli agar isi tampil penuh di PDF.
        clone.querySelectorAll('*').forEach(function(el){
            const cs = (el.getAttribute('style') || '');
            if (cs.toLowerCase().indexOf('overflow') >= 0 || (el.className || '').toString().toLowerCase().indexOf('scroll') >= 0) {
                el.style.overflow = 'visible';
                el.style.maxHeight = 'none';
                el.style.height = 'auto';
            }
        });

        
        // Paksa container utama memenuhi lebar area cetak F4.
        clone.style.width = '100%';
        clone.style.maxWidth = '100%';
        clone.style.margin = '0';
        clone.style.padding = '0';
        clone.style.left = 'auto';
        clone.style.right = 'auto';
        clone.querySelectorAll('.content-page,.content,.container-fluid,.row,.card,.card-body,.table-responsive,table').forEach(function(el){
            el.style.width = '100%';
            el.style.maxWidth = '100%';
            el.style.marginLeft = '0';
            el.style.marginRight = '0';
            el.style.left = 'auto';
            el.style.right = 'auto';
        });

        // Bersihkan style inline warna agar hitam putih CSS utama menang.
        clone.querySelectorAll('*').forEach(function(el){
            el.style.color = '';
            el.style.background = '';
            el.style.backgroundColor = '';
            el.style.boxShadow = '';
            el.style.textShadow = '';
            el.style.borderColor = '';
            el.removeAttribute('bgcolor');
        });

        // Paksa root dan elemen pembungkus memenuhi area cetak. Ini mencegah tabel terpotong/geser ke kiri.
        forceFullWidthClone(clone);
        fixInherenKeteranganWidth(clone);
        removeFaktorLainnyaEmptyRows(clone);
        fixRekapRiskCenter(clone);
        fixCenterNilaiPeringkatAman(clone);
        fixAllNilaiPeringkatCenter(clone);
        fixKpmrNilaiCenterFinal(clone);
        fixInherenNilaiCenterFinal(clone);
        fixInheren2ParameterLeft(clone);
        fixUraianRekapLeft(clone);
        fixTablePageCutBorders(clone);
        compactRiskPrintColumns(clone, expectedTitle);
        return clone;
    }

    function forceFullWidthClone(root){
        if (!root) return;
        const fullSelectors = [
            '.content-page','.content','.container','.container-fluid','.row','.card','.card-body','.table-responsive','form','table'
        ];
        root.style.width = '100%';
        root.style.maxWidth = '100%';
        root.style.marginLeft = '0';
        root.style.marginRight = '0';
        root.style.paddingLeft = '0';
        root.style.paddingRight = '0';
        root.style.left = 'auto';
        root.style.right = 'auto';
        root.style.transform = 'none';
        root.querySelectorAll(fullSelectors.join(',')).forEach(function(el){
            el.style.width = '100%';
            el.style.maxWidth = '100%';
            el.style.minWidth = '0';
            el.style.marginLeft = '0';
            el.style.marginRight = '0';
            el.style.paddingLeft = '0';
            el.style.paddingRight = '0';
            el.style.left = 'auto';
            el.style.right = 'auto';
            el.style.transform = 'none';
            el.style.float = 'none';
            if (el.tagName && el.tagName.toLowerCase() === 'table') {
                el.style.tableLayout = 'fixed';
            }
        });
    }

    function choosePrintableRoot(doc){
        return doc.querySelector('.content-page') || doc.querySelector('.content') || doc.querySelector('.container-fluid') || doc.body;
    }

    function normalizeTxt(t){ return (t || '').toLowerCase().replace(/\s+/g,' ').trim(); }

    function expectedKeywords(title){
        const t = normalizeTxt(title);
        const keys = [];
        if (t.indexOf('kredit') >= 0) keys.push('kredit');
        if (t.indexOf('operasional') >= 0) keys.push('operasional');
        if (t.indexOf('kepatuhan') >= 0) keys.push('kepatuhan');
        if (t.indexOf('likuiditas') >= 0) keys.push('likuiditas');
        if (t.indexOf('reputasi') >= 0) keys.push('reputasi');
        if (t.indexOf('stratejik') >= 0 || t.indexOf('strategik') >= 0) keys.push('stratejik|strategik|strategis');
        if (t.indexOf('inheren') >= 0) keys.push('inheren|inhern');
        if (t.indexOf('kpmr') >= 0) keys.push('kpmr');
        if (t.indexOf('profil') >= 0 && t.indexOf('nilai') < 0 && t.indexOf('peringkat') < 0) keys.push('profil');
        if (t.indexOf('nilai') >= 0) keys.push('profil nilai|hasil nilai|nilai profil');
        if (t.indexOf('peringkat') >= 0) keys.push('profil peringkat|hasil peringkat|peringkat profil');
        return keys;
    }

    function pageLooksValid(doc, title){
        const root = choosePrintableRoot(doc);
        const txt = normalizeTxt(root ? root.innerText : (doc.body ? doc.body.innerText : ''));
        const bodyTxt = normalizeTxt(doc.body ? doc.body.innerText : '');
        if (!txt) return false;
        if (/404|not found|undefined index|fatal error|warning/.test(bodyTxt) && bodyTxt.length < 1200) return false;
        const keys = expectedKeywords(title || '');
        // Khusus Kepatuhan Inheren, beberapa page lama memakai judul singkat/berbeda.
        // Selama halaman memuat kata kepatuhan dan struktur tabel, jangan ditolak hanya karena label inheren tidak muncul persis.
        if (/kepatuhan/i.test(title || '') && /inheren/i.test(title || '') && txt.indexOf('kepatuhan') >= 0 && root && root.querySelector('table')) return true;
        for (let i=0;i<keys.length;i++){
            const alts = keys[i].split('|');
            let ok = false;
            for (let j=0;j<alts.length;j++){ if (txt.indexOf(alts[j]) >= 0) { ok = true; break; } }
            if (!ok) return false;
        }
        // kalau hanya footer/blank dashboard, jangan dianggap valid
        if (txt.length < 250 && /development by|coderthemes|dashboard/.test(txt)) return false;
        if (/development by|coderthemes/.test(txt) && txt.length < 600) return false;
        if (!root || !root.querySelector('table, .card, .page-title, .header-title')) return false;
        return true;
    }

    function loadCandidate(frame, urls, index, done, title){
        if (index >= urls.length) {
            done(null, null);
            return;
        }
        let settled = false;
        const candidateTimeout = /likuiditas/i.test(title || '') ? 20000 : 6000;
        const timer = setTimeout(function(){
            if (settled) return;
            settled = true;
            loadCandidate(frame, urls, index + 1, done, title);
        }, candidateTimeout);

        frame.onload = function(){
            if (settled) return;
            try{
                const doc = frame.contentDocument || frame.contentWindow.document;
                if (doc && pageLooksValid(doc, title)) {
                    settled = true;
                    clearTimeout(timer);
                    setTimeout(function(){ done(doc, urls[index]); }, 350);
                    return;
                }
            }catch(e){}
            settled = true;
            clearTimeout(timer);
            loadCandidate(frame, urls, index + 1, done, title);
        };
        frame.src = urls[index];
    }

    function renderSection(section, idx){
        const frame = section.querySelector('iframe.source-frame');
        const content = section.querySelector('.section-content');
        const directFallback = section.getAttribute('data-fallback') || '';
        const expectedTitle = section.getAttribute('data-title') || (frame ? frame.getAttribute('data-title') : '') || '';

        // FIX CETAK TINDAK LANJUT:
        // Untuk mode profil per risiko, jangan memuat index.php di dalam iframe lagi.
        // Sebelumnya iframe bisa menampilkan layout aplikasi lengkap (sidebar/topbar) dan isi cetak terlihat kosong.
        if (section.getAttribute('data-direct-fallback') === '1' || (/Risiko .* - Profil/i.test(expectedTitle) && directFallback.trim() !== '')) {
            content.classList.remove('loading');
            if (directFallback.trim() !== '') content.innerHTML = directFallback;
            compactRiskPrintColumns(content, expectedTitle);
            loadedCount++;
            setStatus();
            if (idx + 1 < sections.length) renderSection(sections[idx + 1], idx + 1);
            return;
        }

        let urls = [];
        try { urls = frame ? JSON.parse(frame.getAttribute('data-candidates') || '[]') : []; } catch(e) {}
        if (!urls.length) {
            content.classList.remove('loading');
            content.innerHTML = '';
            const fb0 = section.getAttribute('data-fallback') || '';
            content.innerHTML = fb0.trim() !== '' ? fb0 : '<div style="padding:12px;border:1px solid #111;color:#000;">Halaman tidak ditemukan / route belum sesuai. Silakan cek daftar page pada file cetak.</div>';
            compactRiskPrintColumns(content, expectedTitle);
            loadedCount++;
            setStatus();
            if (idx + 1 < sections.length) renderSection(sections[idx + 1], idx + 1);
            return;
        }
        loadCandidate(frame, urls, 0, function(doc, usedUrl){
            content.classList.remove('loading');
            content.innerHTML = '';
            if (!doc) {
                const fb = section.getAttribute('data-fallback') || '';
                if (fb.trim() !== '') {
                    content.innerHTML = fb;
                } else {
                    content.innerHTML = '<div style="padding:12px;border:1px solid #111;color:#000;">Halaman tidak ditemukan / route belum sesuai. Silakan cek daftar page pada file cetak.</div>';
                }
            } else {
                const root = choosePrintableRoot(doc);
                const clone = root.cloneNode(true);
                content.appendChild(cleanupClone(clone, expectedTitle));
            }
            compactRiskPrintColumns(content, expectedTitle);
            loadedCount++;
            setStatus();
            if (idx + 1 < sections.length) renderSection(sections[idx + 1], idx + 1);
        }, expectedTitle);
    }

    setStatus();
    if (sections.length) renderSection(sections[0], 0);
})();
</script>
</body>
</html>
