<?php

if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';
    $lokasi_kerja = $_POST['lokasi_kerja'];
    $tahun = $_POST['tahun'];
    $bulan = $_POST['bulan'];
    $modal_inti = $_POST['modal_inti'];
    $total_aset = $_POST['total_aset'];
    $keterangan = $_POST['keterangan'];

    $dibuat_at = date('Y-m-d');
    $dibuat_by = $_SESSION['user_id'];
    $query = simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND bulan = ? ", [$lokasi_kerja, $tahun, $bulan]);
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
        <script>$.NotificationApp.send("Gagal","Your awesome message text","Position","Background color","Icon")</script>
        ';
    } else {
        simpro_db_query($conn, "INSERT INTO frame_laporan_profil_risiko(id_profil_risiko,kantor_cabang,tahun,bulan,modal_inti,total_aset,keterangan,dibuat_at,dibuat_by)
        VALUES ('0',?,?,?,?,?,?,?,?)", [$lokasi_kerja, $tahun, $bulan, $modal_inti, $total_aset, $keterangan, $dibuat_at, $dibuat_by]);
        echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

        header("Location: index.php?page=menulapawal");
        exit();
    }
}
