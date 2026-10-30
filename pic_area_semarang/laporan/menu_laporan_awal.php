<?php
include "../fungsi/fungsi.php";
require dirname(__DIR__, 2).'/conn/conn.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function esc_menu($str)
{
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function column_exists_menu($conn, $table, $column)
{
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}

function get_divisi_label_menu($id)
{
    $opts = [
        132 => 'Divisi Pemasaran',
        133 => 'Divisi Operasional',
        134 => 'Divisi SDM',
        135 => 'Satker Kepatuhan',
        136 => 'Sekretaris Perusahaan',
        137 => 'Divisi Litbang',
        140 => 'Divisi Penyelesaian Kredit',
        143 => 'SKAI'
    ];
    $id = (int)$id;
    return isset($opts[$id]) ? $opts[$id] : '';
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$notif = '';
$notif_type = 'success';
$showNotifModal = false;
$selectedTahun = isset($_POST['tahun']) ? trim((string)$_POST['tahun']) : '';
$selectedFrameId = isset($_POST['user']) ? (int)$_POST['user'] : 0;
$selectedLokasi = isset($_POST['lokasi_kerja']) ? (int)$_POST['lokasi_kerja'] : 0;

$profilRisikoByTahun = [];
$qProfilByTahun = mysqli_query($conn, "
    SELECT
        fp.id_frame_perumusan,
        fp.tahun,
        fp.user_id AS id_user_profil_risiko,
        fp.id_divisi_tetapan,
        COALESCE(fp.is_aktif,0) AS is_aktif,
        upr.tipe_user,
        (
            SELECT COUNT(1)
            FROM perumusan_inheren pi
            WHERE pi.id_frame_perumusan = fp.id_frame_perumusan
              AND (pi.perskalaan = 1 OR pi.pembobotan = 1)
        ) AS jml_inheren_setting,
        (
            SELECT COUNT(1)
            FROM perumusan_kpmr pk
            WHERE pk.id_frame_perumusan = fp.id_frame_perumusan
              AND (pk.perskalaan = 1 OR pk.pembobotan = 1)
        ) AS jml_kpmr_setting
    FROM frame_perumusan fp
    INNER JOIN user_profil_risiko upr
        ON fp.user_id = upr.id_user_profil_risiko
    WHERE UPPER(upr.tipe_user) LIKE '%KANTOR CABANG%'
    ORDER BY CAST(fp.tahun AS UNSIGNED) DESC, upr.tipe_user ASC, fp.id_divisi_tetapan ASC, fp.id_frame_perumusan ASC
");

if ($qProfilByTahun) {
    while ($r = mysqli_fetch_assoc($qProfilByTahun)) {
        $th = (string)$r['tahun'];
        $frameId = (int)$r['id_frame_perumusan'];
        $text = trim((string)$r['tipe_user']);
        $divisiLabel = get_divisi_label_menu((int)$r['id_divisi_tetapan']);
        if ($divisiLabel !== '') {
            $text .= ' - ' . $divisiLabel;
        }
        $sudahIsiSetting = ((int)($r['jml_inheren_setting'] ?? 0) > 0 || (int)($r['jml_kpmr_setting'] ?? 0) > 0);
        if ((int)($r['is_aktif'] ?? 0) !== 1) {
            $text .= ' - Belum Aktif';
        }
        if (!$sudahIsiSetting) {
            $text .= ' - Perumusan Belum Diisi';
        }
        if (!isset($profilRisikoByTahun[$th])) {
            $profilRisikoByTahun[$th] = [];
        }
        $profilRisikoByTahun[$th][$frameId] = [
            'frame_id' => $frameId,
            'user_id' => (int)$r['id_user_profil_risiko'],
            'is_aktif' => (int)($r['is_aktif'] ?? 0),
            'jml_inheren_setting' => (int)($r['jml_inheren_setting'] ?? 0),
            'jml_kpmr_setting' => (int)($r['jml_kpmr_setting'] ?? 0),
            'text' => $text
        ];
    }
}

$daftarTahun = array_keys($profilRisikoByTahun);
rsort($daftarTahun, SORT_NUMERIC);

if (isset($_POST['submit'])) {
    $lokasi_kerja = isset($_POST['lokasi_kerja']) ? (int)$_POST['lokasi_kerja'] : 0;
    $tahun = trim((string)($_POST['tahun'] ?? ''));
    $frame_perumusan_id = isset($_POST['user']) ? (int)$_POST['user'] : 0; // format input tetap: name="user"
    $periode = isset($_POST['periode']) ? (int)$_POST['periode'] : 0;
    $modal_inti = preg_replace('/[^0-9\-]/', '', (string)($_POST['modal_inti'] ?? '0'));
    $total_aset = preg_replace('/[^0-9\-]/', '', (string)($_POST['total_aset'] ?? '0'));
    $keterangan = mysqli_real_escape_string($conn, trim((string)($_POST['keterangan'] ?? '')));

    $dibuat_at = date('Y-m-d');
    $dibuat_by = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

    $frameDipilih = null;
    if ($frame_perumusan_id > 0) {
        $qFrameDipilih = simpro_db_query($conn, "
            SELECT
                fp.id_frame_perumusan,
                fp.tahun,
                fp.user_id,
                fp.id_divisi_tetapan,
                COALESCE(fp.is_aktif,0) AS is_aktif,
                upr.tipe_user,
                (
                    SELECT COUNT(1)
                    FROM perumusan_inheren pi
                    WHERE pi.id_frame_perumusan = fp.id_frame_perumusan
                      AND (pi.perskalaan = 1 OR pi.pembobotan = 1)
                ) AS jml_inheren_setting,
                (
                    SELECT COUNT(1)
                    FROM perumusan_kpmr pk
                    WHERE pk.id_frame_perumusan = fp.id_frame_perumusan
                      AND (pk.perskalaan = 1 OR pk.pembobotan = 1)
                ) AS jml_kpmr_setting
            FROM frame_perumusan fp
            INNER JOIN user_profil_risiko upr
                ON fp.user_id = upr.id_user_profil_risiko
            WHERE fp.id_frame_perumusan = ?
              AND UPPER(upr.tipe_user) LIKE '%KANTOR CABANG%'
            LIMIT 1
        ", [$frame_perumusan_id]);
        if ($qFrameDipilih && mysqli_num_rows($qFrameDipilih) > 0) {
            $frameDipilih = mysqli_fetch_assoc($qFrameDipilih);
        }
    }

    if ($lokasi_kerja <= 0 || $lokasi_kerja < 1 || $lokasi_kerja > 7 || $tahun === '' || $periode <= 0) {
        $notif = 'Data belum lengkap atau kantor cabang tidak sesuai. Menu ini hanya untuk id_cabang 1 s.d. 7.';
        $notif_type = 'danger';
        $showNotifModal = true;
    } elseif ($frame_perumusan_id <= 0) {
        $notif = 'Pilih perumusan belum diisi. Silakan pilih jenis profil risiko/perumusan terlebih dahulu pada form pembuatan laporan.';
        $notif_type = 'danger';
        $showNotifModal = true;
    } elseif (!$frameDipilih) {
        $notif = 'Perumusan belum ada atau belum tersedia untuk tahun yang dipilih. Silakan buat dan isi setting perumusan terlebih dahulu.';
        $notif_type = 'danger';
        $showNotifModal = true;
    } elseif ((int)($frameDipilih['is_aktif'] ?? 0) !== 1) {
        $notif = 'Perumusan yang dipilih belum aktif. Silakan aktifkan perumusan terlebih dahulu pada menu Setting Perumusan Risiko.';
        $notif_type = 'danger';
        $showNotifModal = true;
    } elseif (((int)($frameDipilih['jml_inheren_setting'] ?? 0) <= 0) && ((int)($frameDipilih['jml_kpmr_setting'] ?? 0) <= 0)) {
        $notif = 'Isi setting perumusan belum diisi. Silakan klik Lanjutkan pada menu Setting Perumusan Risiko, pilih risiko/metode perumusan, lalu aktifkan.';
        $notif_type = 'danger';
        $showNotifModal = true;
    } elseif ((string)$frameDipilih['tahun'] !== (string)$tahun) {
        $notif = 'Tahun dan jenis profil risiko tidak sinkron. Silakan pilih ulang.';
        $notif_type = 'danger';
        $showNotifModal = true;
    } else {
        $user = (int)$frameDipilih['user_id'];

        $cekSql = "
            SELECT id_profil_risiko
            FROM frame_laporan_profil_risiko
            WHERE kantor_cabang = '$lokasi_kerja'
              AND tahun = '$tahun'
              AND user = '$user'
              AND periode = '$periode'
        ";
        if (column_exists_menu($conn, 'frame_laporan_profil_risiko', 'id_frame_perumusan')) {
            $cekSql .= " AND id_frame_perumusan = '$frame_perumusan_id'";
        }
        $cekSql .= " LIMIT 1";
        $query = mysqli_query($conn, $cekSql);
        $cek_user = $query ? mysqli_num_rows($query) : 0;

        if ($cek_user > 0) {
            $rowDup = mysqli_fetch_assoc($query);
            header("Location: index.php?page=menulapawal&id=" . (int)$rowDup['id_profil_risiko']);
            exit();
        } else {
            if (column_exists_menu($conn, 'frame_laporan_profil_risiko', 'id_frame_perumusan')) {
                $insertFrame = mysqli_query($conn, "
                    INSERT INTO frame_laporan_profil_risiko
                    (kantor_cabang,tahun,user,periode,total_aset,keterangan,dibuat_at,dibuat_by,id_frame_perumusan)
                    VALUES
                    ('$lokasi_kerja','$tahun','$user','$periode','" . ($total_aset === '' ? 0 : $total_aset) . "','$keterangan','$dibuat_at','$dibuat_by','$frame_perumusan_id')
                ");
            } else {
                $insertFrame = mysqli_query($conn, "
                    INSERT INTO frame_laporan_profil_risiko
                    (kantor_cabang,tahun,user,periode,total_aset,keterangan,dibuat_at,dibuat_by)
                    VALUES
                    ('$lokasi_kerja','$tahun','$user','$periode','" . ($total_aset === '' ? 0 : $total_aset) . "','$keterangan','$dibuat_at','$dibuat_by')
                ");
            }

            if (!$insertFrame) {
                $notif = 'Gagal menyimpan data: ' . mysqli_error($conn);
                $notif_type = 'danger';
            } else {
                $newId = mysqli_insert_id($conn);

//kre
        mysqli_query($conn, "INSERT INTO master_kredit_pilar1(id_mk_pilar1,id_profil_risiko,dibuat_by,total_aset)
        VALUES ('0',$newId,'$dibuat_by','$total_aset')");

        mysqli_query($conn, "INSERT INTO master_kredit_pilar2(id_mk_pilar2,id_profil_risiko,dibuat_by,modal_inti)
        VALUES ('0',$newId,'$dibuat_by','$modal_inti')");

        mysqli_query($conn, "INSERT INTO master_kredit_pilar3(id_mk_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

      

        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar1(id_inheren_kredit_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar2(id_inheren_kredit_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar3(id_inheren_kredit_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar4(id_inheren_kredit_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_kredit_lainnya(id_inheren_kredit_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_inheren_kredit(id_hasil_inheren_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        

        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar1(id_kpmr_kredit_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar2(id_kpmr_kredit_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar3(id_kpmr_kredit_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar4(id_kpmr_kredit_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_kpmr_kredit(id_hasil_kpmr_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil1(id_respon_kredit_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil2(id_respon_kredit_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil3(id_respon_kredit_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil4(id_respon_kredit_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_kredit(id_kpmr2_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren_kredit(id_keterangan_inheren_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_profil_kredit(id_ket_profil_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        



        //op
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar1(id_inheren_operasional_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar2(id_inheren_operasional_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar3(id_inheren_operasional_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar4(id_inheren_operasional_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar5(id_inheren_operasional_pilar5,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_operasional_lainnya(id_inheren_operasional_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar1(id_ket_inheren_operasional_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar2(id_ket_inheren_operasional_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar3(id_ket_inheren_operasional_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar4(id_ket_inheren_operasional_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar5(id_ket_inheren_operasional_pilar5,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_lainnya(id_ket_inheren_operasional_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
    

        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar1(id_kpmr_operasional_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar2(id_kpmr_operasional_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar3(id_kpmr_operasional_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar4(id_kpmr_operasional_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
    
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil1(id_respon_operasional_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil2(id_respon_operasional_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil3(id_respon_operasional_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil4(id_respon_operasional_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        




        mysqli_query($conn, "INSERT INTO hasil_inheren_operasional(id_hasil_inheren_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_kpmr_operasional(id_hasil_kpmr_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren2_operasional(id_keterangan_inheren2_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_operasional(id_kpmr2_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_operasional(id_ket_profil_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        


        //kep
        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_pilar1(id_inheren_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_pilar2(id_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_lainnya(id_inheren_kepatuhan_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_pilar1(id_ket_inheren_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_pilar2(id_ket_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_lainnya(id_ket_inheren_kepatuhan_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar1(id_kpmr_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar2(id_kpmr_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar3(id_kpmr_kepatuhan_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar4(id_kpmr_kepatuhan_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil1(id_respon_kepatuhan_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil2(id_respon_kepatuhan_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil3(id_respon_kepatuhan_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil4(id_respon_kepatuhan_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        


        mysqli_query($conn, "INSERT INTO hasil_inheren_kepatuhan(id_hasil_inheren_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_kepatuhan(id_hasil_kpmr_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_kepatuhan(id_keterangan_inheren2_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_kepatuhan(id_kpmr2_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_kepatuhan(id_ket_profil_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");


        //lik
        mysqli_query($conn, "INSERT INTO master_likuiditas_pilar1(id_ml_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_likuiditas_pilar1(id_inheren_likuiditas_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_likuiditas_pilar2(id_inheren_likuiditas_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_likuiditas_lainnya(id_inheren_likuiditas_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_inheren_likuiditas(id_hasil_inheren_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren_likuiditas(id_keterangan_inheren_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        


       
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar1(id_kpmr_likuiditas_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar2(id_kpmr_likuiditas_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar3(id_kpmr_likuiditas_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar4(id_kpmr_likuiditas_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil1(id_respon_likuiditas_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil2(id_respon_likuiditas_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil3(id_respon_likuiditas_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil4(id_respon_likuiditas_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        


       
        mysqli_query($conn, "INSERT INTO hasil_kpmr_likuiditas(id_hasil_kpmr_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

      
        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_likuiditas(id_kpmr2_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_likuiditas(id_ket_profil_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");





        //rep
        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar1(id_inheren_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar2(id_inheren_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar3(id_inheren_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_lainnya(id_inheren_reputasi_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar1(id_ket_inheren_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar2(id_ket_inheren_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar3(id_ket_inheren_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_lainnya(id_ket_inheren_reputasi_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");



        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar1(id_kpmr_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar2(id_kpmr_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar3(id_kpmr_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar4(id_kpmr_reputasi_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil1(id_respon_reputasi_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil2(id_respon_reputasi_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil3(id_respon_reputasi_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil4(id_respon_reputasi_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");
        



        mysqli_query($conn, "INSERT INTO hasil_inheren_reputasi(id_hasil_inheren_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_reputasi(id_hasil_kpmr_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_reputasi(id_keterangan_inheren2_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_reputasi(id_kpmr2_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_reputasi(id_ket_profil_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");



        //stra
        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar1(id_inheren_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar2(id_inheren_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar3(id_inheren_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_lainnya(id_inheren_stratejik_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar1(id_ket_inheren_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar2(id_ket_inheren_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar3(id_ket_inheren_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_lainnya(id_ket_inheren_stratejik_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");



        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar1(id_kpmr_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar2(id_kpmr_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar3(id_kpmr_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar4(id_kpmr_stratejik_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");


        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil1(id_respon_stratejik_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil2(id_respon_stratejik_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil3(id_respon_stratejik_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil4(id_respon_stratejik_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_inheren_stratejik(id_hasil_inheren_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_stratejik(id_hasil_kpmr_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_stratejik(id_keterangan_inheren2_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_stratejik(id_kpmr2_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_stratejik(id_ket_profil_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");




        mysqli_query($conn, "INSERT INTO nilai_profil(id_nilai_profil,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO peringkat_profil(id_peringkat_profil,id_profil_risiko,dibuat_by)
        VALUES ('0',$newId,'$dibuat_by')");

                header("Location: index.php?page=menulapawal&id=" . $newId);
                exit();
            }
        }
    }
}
?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Simpro</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Buat laporan</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Menu Profil Risiko</h4>
                                </div>
                            </div>
                        </div>
            <?php if ($notif != '') { ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-<?= esc_menu($notif_type) ?> alert-dismissible fade show" role="alert">
                        <?= esc_menu($notif) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if ($showNotifModal && $notif != '') { ?>
            <div class="modal fade" id="modalNotifPerumusan" tabindex="-1" aria-labelledby="modalNotifPerumusanLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="modalNotifPerumusanLabel">Notifikasi Perumusan Risiko</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0" style="font-size:15px; line-height:1.6;">
                                <?= esc_menu($notif) ?>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="index.php?page=pilih_perumusan" class="btn btn-primary">Buka Setting Perumusan</a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function(){
                var el = document.getElementById('modalNotifPerumusan');
                if (!el) return;
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    new bootstrap.Modal(el).show();
                } else if (typeof $ !== 'undefined') {
                    $('#modalNotifPerumusan').modal('show');
                } else {
                    alert(<?= json_encode($notif) ?>);
                }
            });
            </script>
            <?php } ?>




            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Tabel Riwayat Laporan yang Dibuat</h4>
                            <p class="text-muted font-14">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh User

                            </p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signup-modal">Tambah Laporan</button>
                            <div id="signup-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-body">

                                            <div class="text-center mt-2 mb-4">

                                                <h4><b>PEMBUATAN LAPORAN BARU</b></h4>

                                            </div>
                                            <form class="ps-3 pe-3" action="" method="POST" enctype="multipart/form-data">

                                                <div class="mb-3">
                                                    <label for="kc" class="form-label">Kantor Cabang</label>
                                                    <select class="form-select mb-3" name="lokasi_kerja" id="kc" required="">
                                                        <?php
                                                        require dirname(__DIR__, 2).'/conn/conn.php';
                                                        $query_cabang = mysqli_query($conn, "SELECT * FROM jenis_cabang WHERE id_cabang BETWEEN 1 AND 7 ORDER BY id_cabang ASC");
                                                        while ($data = mysqli_fetch_array($query_cabang)) { ?>
                                                            <option value="<?= $data['id_cabang'] ?>" <?= ((int)$selectedLokasi === (int)$data['id_cabang'] ? 'selected' : (((int)$selectedLokasi === 0 && (int)$data['id_cabang'] === (int)($_SESSION['lokasi_kerja'] ?? 0)) ? 'selected' : '')) ?>><?= ucwords($data['cabang']) ?></option>
                                                        <?php
                                                        };
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tahun" class="form-label">Tahun</label>
                                                    <select class="form-select mb-3" name="tahun" id="tahun" required="">
                                                        <option value="">- pilih tahun -</option>
                                                        <?php foreach ($daftarTahun as $th) { ?>
                                                            <option value="<?= esc_menu($th) ?>" <?= ($selectedTahun === (string)$th ? 'selected' : '') ?>><?= esc_menu($th) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="user" class="form-label">Jenis Profil Risiko Cabang</label>

                                                    <select class="form-select mb-3" name="user" id="user" required="">
                                                        <option value="">- pilih jenis profil risiko -</option>
                                                    </select>
                                                    <small class="text-muted">Dropdown ini mengikuti setting opsi perumusan berdasarkan tahun yang dipilih.</small>

                                                </div>



                                                <div class="mb-3">
                                                    <label for="periode" class="form-label">Periode</label>
                                                    <select class="form-select mb-3" name="periode" id="periode" required="">
                                                    <option value=" " selected> </option>
                                                                <?php
                                                                require dirname(__DIR__, 2).'/conn/conn.php';
                                                                $query_periode = mysqli_query($conn, "SELECT * FROM periode_laporan_profil_risiko");
                                                                while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                                    <option value="<?= $data['id_periode'] ?>"><?= ucwords($data['periode_laporan']) ?></option>
                                                                <?php
                                                                };
                                                                ?>
                                                    </select>
                                                </div>

                                                

                                                <div class="mb-3">
                                                    <label for="total_aset" class="form-label">Total Aset</label>
                                                    <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" name="total_aset" class="form-control" id="total_aset" required="">
                                                </div>


                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea type="text" name="keterangan" class="form-control" id="keterangan" required=""></textarea>
                                                </div>



                                                <div class="mb-3 text-center">
                                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <hr>
                            </hr>










                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>

                                                <th>
                                                    <center>Aksi</center>
                                                </th>
                                                <th>
                                                    <center>Tindak Lanjut</center>
                                                </th>
                                                <th>
                                                    <center>Kantor Cabang</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Tahun</center>
                                                </th>
                                                <th>
                                                    <center>Jenis Profil Risiko Cabang</center>
                                                </th>
                                                <th>
                                                    <center>Periode</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Total Aset</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                                <th>
                                                    <center>Pembuat</center>
                                                </th>
                                                <th>
                                                    <center>Keterangan</center>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $id_user = $_SESSION['user_id'];
                                            $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE frame_laporan_profil_risiko.kantor_cabang BETWEEN 1 AND 7 order by id_profil_risiko desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=menulapawal&id=<?= $data['id_profil_risiko'] ?>"><i><input type="checkbox" form="my_form" id="selected_id"  name="selected_id" <?php if ($data['id_profil_risiko'] == $id) echo 'checked'; ?> disabled></i> aktifkan</a>
                                                            | <a href="javascript:void(0)" onclick="openCetakProfilModal(<?= (int)$data['id_profil_risiko'] ?>)"> cetak </a>|
                                                            <a href="index.php?page=delete_frame&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin menghapus data?');"><i class=" mdi mdi-delete"></i>hapus</a>
                                                        </center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                            <a href="javascript:void(0)" onclick="openCetakTindakLanjutModal(<?= (int)$data['id_profil_risiko'] ?>)"> cetak </a>
                                                           
                                                        </center>
                                                    </td>

                                                    <td>
                                                        <center><?= $data['cabang'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tipe_user'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['periode_laporan']) ?></center>
                                                    </td>
                                                   
                                                    <td>
                                                        Rp. <?= rupiah($data['total_aset']) ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <center><?= ucwords($data['dibuat_at']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['nama']) ?></center>
                                                    </td>
                                                    <td>
                                                        <?= ucwords($data['keterangan']) ?>
                                                    </td>

                                                   





                                                </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->


                            </div> <!-- end tab-content-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container -->

    </div>
    <!-- content -->
</div>

<script>
(function(){
    var profilRisikoByTahun = <?= json_encode($profilRisikoByTahun, JSON_UNESCAPED_UNICODE) ?>;
    var tahunEl = document.getElementById('tahun');
    var userEl = document.getElementById('user');
    var selectedFrameId = <?= (int)$selectedFrameId ?>;

    function renderUserOptions(){
        if (!tahunEl || !userEl) return;
        var tahun = tahunEl.value || '';
        var currentOptions = profilRisikoByTahun[tahun] || {};
        var html = '<option value="">- pilih jenis profil risiko -</option>';
        var keys = Object.keys(currentOptions);
        var autoCabangId = '';

        keys.forEach(function(frameId){
            var row = currentOptions[frameId] || {};
            var text = String(row.text || '');
            if (!autoCabangId && text.toLowerCase().indexOf('kantor cabang') !== -1) {
                autoCabangId = String(frameId);
            }
            var selected = (parseInt(frameId, 10) === parseInt(selectedFrameId, 10)) ? ' selected' : '';
            html += '<option value="' + frameId + '"' + selected + '>' + text + '</option>';
        });

        userEl.innerHTML = html;

        if (selectedFrameId && userEl.querySelector('option[value="' + selectedFrameId + '"]')) {
            userEl.value = String(selectedFrameId);
            return;
        }

        if (autoCabangId) {
            userEl.value = autoCabangId;
            selectedFrameId = autoCabangId;
            return;
        }

        if (keys.length === 1) {
            userEl.value = String(keys[0]);
            selectedFrameId = String(keys[0]);
        }
    }

    if (tahunEl) {
        tahunEl.addEventListener('change', function(){
            selectedFrameId = 0;
            renderUserOptions();
        });
    }
    renderUserOptions();
})();
</script>


<style id="oaiMenuLaporanActionAlign">
.table-action center{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:4px !important;
    white-space:nowrap !important;
    min-width:210px !important;
}
.table-action center a{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:3px !important;
    white-space:nowrap !important;
    line-height:1.2 !important;
}
.table-action center input[type="checkbox"]{
    flex:0 0 auto !important;
    margin:0 3px 0 0 !important;
    vertical-align:middle !important;
}
.table-action center i{
    display:inline-flex !important;
    align-items:center !important;
    line-height:1 !important;
}
</style>

<!-- MODAL CETAK LAPORAN PROFIL RISIKO -->
<div class="modal fade" id="modalCetakProfilRisiko" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog cetak-profil-modal-dialog">
        <div class="modal-content cetak-profil-modal-content">
            <div class="modal-header cetak-profil-modal-header">
                <div class="ms-auto d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-success btn-lg btn-cetak-modal-excel" onclick="exportCetakProfilExcel()">
                        <i class="mdi mdi-file-excel"></i> Cetak Excel
                    </button>
                    <button type="button" class="btn btn-light btn-lg btn-cetak-modal-close" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
            <div class="modal-body p-0 cetak-profil-modal-body">
                <div id="loadingCetakProfilRisiko" class="cetak-profil-loading">
                    <div class="cetak-loader-spinner" aria-hidden="true"></div>
                    <div class="cetak-loader-title">Loading...</div>
                    <div id="loadingCetakProfilRisikoText" class="cetak-loader-subtitle">Menyiapkan preview laporan...</div>
                </div>
                <iframe id="iframeCetakProfilRisiko" src="about:blank" style="width:100%;height:100%;border:0;background:#fff;display:block;"></iframe>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal cetak dibuat seperti modal Tambah Laporan: ada backdrop + blur */
#modalCetakProfilRisiko{background:transparent!important;}
.modal-backdrop.show{
    opacity:.45!important;
    background:#000!important;
    backdrop-filter:blur(3px);
    -webkit-backdrop-filter:blur(3px);
}
body.modal-open{overflow:hidden!important;padding-right:0!important;}
#modalCetakProfilRisiko .modal-content,
#modalCetakProfilRisiko .modal-body,
#modalCetakProfilRisiko iframe{background:#fff!important;}
#modalCetakProfilRisiko .modal-header{position:sticky;top:0;z-index:10;}
/* Modal dibuat benar-benar besar dan selalu tepat di tengah layar */
#modalCetakProfilRisiko .modal-dialog,
#modalCetakProfilRisiko .cetak-profil-modal-dialog{
    position:fixed!important;
    top:50%!important;
    left:50%!important;
    transform:translate(-50%,-50%)!important;
    -webkit-transform:translate(-50%,-50%)!important;
    max-width:none!important;
    /* Kompensasi body { zoom:0.6 }: hasil tampil kira-kira 75% layar */
    width:calc(125vw - 18px)!important;
    height:calc(125vh - 18px)!important;
    margin:0!important;
    padding:0!important;
}
#modalCetakProfilRisiko.fade .modal-dialog,
#modalCetakProfilRisiko.show .modal-dialog{
    transform:translate(-50%,-50%)!important;
    -webkit-transform:translate(-50%,-50%)!important;
}
#modalCetakProfilRisiko .cetak-profil-modal-content{
    background:#fff!important;
    border-radius:8px!important;
    overflow:hidden!important;
    width:100%!important;
    max-width:none!important;
    height:100%!important;
    box-shadow:0 10px 35px rgba(0,0,0,.28)!important;
}
#modalCetakProfilRisiko .cetak-profil-modal-header{
    background:#fff!important;
    border-bottom:1px solid #dee2e6!important;
    min-height:60px!important;
    height:60px!important;
    padding:9px 14px!important;
}
#modalCetakProfilRisiko .btn-cetak-modal-excel,
#modalCetakProfilRisiko .btn-cetak-modal-close{
    font-size:15px!important;
    font-weight:800!important;
    padding:10px 20px!important;
    border-radius:6px!important;
    min-height:40px!important;
    min-width:122px!important;
}
#modalCetakProfilRisiko .btn-cetak-modal-excel{min-width:145px!important;}
#modalCetakProfilRisiko .cetak-profil-modal-body{
    background:#fff!important;
    height:calc(125vh - 60px)!important;
    overflow:hidden!important;
    position:relative!important;
}
#modalCetakProfilRisiko #iframeCetakProfilRisiko{
    width:100%!important;
    height:100%!important;
    min-height:calc(125vh - 60px)!important;
}
@media (max-width: 768px){
    #modalCetakProfilRisiko .modal-dialog,
    #modalCetakProfilRisiko .cetak-profil-modal-dialog{
        width:calc(125vw - 8px)!important;
        height:calc(125vh - 8px)!important;
    }
    #modalCetakProfilRisiko .cetak-profil-modal-body{height:calc(125vh - 52px)!important;}
}
#modalCetakProfilRisiko .cetak-profil-loading{
    position:absolute;
    inset:0;
    z-index:50;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.94);
    color:#6c757d;
    font-size:14px;
}
#modalCetakProfilRisiko .cetak-profil-loading.is-hidden{display:none!important;}
#modalCetakProfilRisiko .cetak-loader-spinner{
    width:74px;
    height:74px;
    border-radius:50%;
    border:7px solid #e1e1e1;
    border-top-color:#777;
    animation:cetakProfilSpin .85s linear infinite;
}
#modalCetakProfilRisiko .cetak-loader-title{
    margin-top:12px;
    font-size:18px;
    font-weight:600;
    color:#777;
}
#modalCetakProfilRisiko .cetak-loader-subtitle{
    margin-top:4px;
    font-size:13px;
    color:#777;
}
@keyframes cetakProfilSpin{to{transform:rotate(360deg);}}
</style>

<script>

var currentCetakProfilId = 0;
var cetakProfilLoadingTimer = null;

function setCetakProfilLoading(show, text) {
    var loading = document.getElementById('loadingCetakProfilRisiko');
    var loadingText = document.getElementById('loadingCetakProfilRisikoText');
    if (loadingText && text) loadingText.textContent = text;
    if (!loading) return;
    if (show) loading.classList.remove('is-hidden');
    else loading.classList.add('is-hidden');
}

function startCetakProfilLoadingWatcher() {
    if (cetakProfilLoadingTimer) clearInterval(cetakProfilLoadingTimer);

    var iframe = document.getElementById('iframeCetakProfilRisiko');
    setCetakProfilLoading(true, 'Menyiapkan preview laporan...');

    cetakProfilLoadingTimer = setInterval(function(){
        try {
            if (!iframe || !iframe.contentWindow) return;
            var doc = iframe.contentDocument || iframe.contentWindow.document;
            if (!doc || !doc.body) return;

            var statusEl = doc.getElementById('loadStatus');
            var statusText = statusEl ? (statusEl.textContent || '').trim() : '';
            if (statusText) {
                setCetakProfilLoading(true, statusText);
                if (statusText.toLowerCase().indexOf('selesai') !== -1 || statusText.toLowerCase().indexOf('siap dicetak') !== -1) {
                    clearInterval(cetakProfilLoadingTimer);
                    cetakProfilLoadingTimer = null;
                    setTimeout(function(){ setCetakProfilLoading(false); }, 350);
                }
            } else if (doc.readyState === 'complete') {
                var sections = doc.querySelectorAll('.print-section');
                if (!sections.length) {
                    clearInterval(cetakProfilLoadingTimer);
                    cetakProfilLoadingTimer = null;
                    setTimeout(function(){ setCetakProfilLoading(false); }, 350);
                }
            }
        } catch(e) {
            setCetakProfilLoading(true, 'Memuat preview laporan...');
        }
    }, 350);
}

function openCetakProfilModal(idProfil) {
    currentCetakProfilId = idProfil;
    var iframe = document.getElementById('iframeCetakProfilRisiko');
    if (!iframe) return;

    if (cetakProfilLoadingTimer) {
        clearInterval(cetakProfilLoadingTimer);
        cetakProfilLoadingTimer = null;
    }

    setCetakProfilLoading(true, 'Menyiapkan preview laporan...');
    iframe.onload = function(){ startCetakProfilLoadingWatcher(); };
    iframe.src = 'about:blank';

    var el = document.getElementById('modalCetakProfilRisiko');
    if (window.bootstrap && bootstrap.Modal) {
        var modal = bootstrap.Modal.getOrCreateInstance(el, {backdrop:true, keyboard:true, focus:true});
        modal.show();
    } else if (window.$ && $('#modalCetakProfilRisiko').modal) {
        $('#modalCetakProfilRisiko').modal({backdrop:true, keyboard:true}).modal('show');
    }

    setTimeout(function(){
        iframe.src = 'laporan/cetak_laporan_profil_risiko.php?id=' + encodeURIComponent(idProfil) + '&modal_view=1&embed_modal=1&print_scale=300';
    }, 80);
}

function printCetakProfilModal() {
    var iframe = document.getElementById('iframeCetakProfilRisiko');
    if (!iframe || !iframe.contentWindow) return;

    var orientasi = 'portrait';

    try {
        var doc = iframe.contentDocument || iframe.contentWindow.document;
        if (doc && iframe.contentWindow.setPrintOrientation) {
            iframe.contentWindow.setPrintOrientation(orientasi);
        }
        if (doc && iframe.contentWindow.setPrintScale) {
            iframe.contentWindow.setPrintScale(160);
        } else if (doc) {
            var st = doc.getElementById('dynamicPrintPageSize');
            if (!st) {
                st = doc.createElement('style');
                st.id = 'dynamicPrintPageSize';
                doc.head.appendChild(st);
            }
            st.textContent = '@media print{@page{size:215mm 330mm;margin:6mm;} body{background:#fff!important;} .report-wrap{zoom:1.6!important;width:62.5%!important;max-width:62.5%!important;}}';
            doc.body.classList.remove('print-landscape');
            doc.body.classList.add('print-portrait');
        }
    } catch(e) {}

    setTimeout(function(){
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
    }, 250);
}



function cleanWorksheetName(name, index) {
    name = String(name || ('Sheet ' + index))
        .replace(/[\\\/\?\*\[\]\:]/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();
    if (!name) name = 'Sheet ' + index;
    return name.substring(0, 31);
}

function uniqueWorksheetName(baseName, used, index) {
    var base = cleanWorksheetName(baseName, index);
    var name = base;
    var n = 2;
    while (used[name.toLowerCase()]) {
        var suffix = ' ' + n;
        name = base.substring(0, 31 - suffix.length) + suffix;
        n++;
    }
    used[name.toLowerCase()] = true;
    return name;
}

function xmlEscapeExcel(v) {
    return String(v == null ? '' : v)
        .replace(/[\x00-\x08\x0B\x0C\x0E-\x1F]/g, '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&apos;');
}

function cellXml(text, extra, styleId) {
    extra = extra || '';
    styleId = styleId || '';
    text = excelTextClean(text);
    var styleAttr = styleId ? ' ss:StyleID="' + xmlEscapeExcel(styleId) + '"' : '';
    return '<Cell' + styleAttr + extra + '><Data ss:Type="String">' + xmlEscapeExcel(text) + '</Data></Cell>';
}

function normalizeExcelClone(cloned) {
    cloned.querySelectorAll('script, iframe, button, input[type="button"], input[type="submit"], .no-print, .print-toolbar, .modal, .modal-backdrop').forEach(function(el){
        if (el.parentNode) el.parentNode.removeChild(el);
    });
    cloned.querySelectorAll('input, textarea, select').forEach(function(el){
        var text = '';
        if (el.tagName === 'SELECT') text = el.options && el.options[el.selectedIndex] ? el.options[el.selectedIndex].text : '';
        else text = el.value || el.textContent || '';
        var div = cloned.ownerDocument.createElement('div');
        div.textContent = text;
        if (el.parentNode) el.parentNode.replaceChild(div, el);
    });
    cloned.querySelectorAll('[style]').forEach(function(el){
        var st = String(el.getAttribute('style') || '');
        st = st.replace(/background(?:-color)?\s*:[^;]+;?/gi, '');
        el.setAttribute('style', st);
    });
    return cloned;
}

function excelTextClean(v) {
    return String(v == null ? '' : v)
        .replace(/\u00a0/g, ' ')
        .replace(/[\x00-\x08\x0B\x0C\x0E-\x1F]/g, '')
        .replace(/([0-9]+(?:[\.,][0-9]+)?)(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)/gi, '$1\n$2')
        .replace(/(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)([0-9]+(?:[\.,][0-9]+)?)/gi, '$1\n$2')
        .replace(/[ \t]+/g, ' ')
        .replace(/\n\s*/g, '\n')
        .replace(/\n{3,}/g, '\n\n')
        .trim();
}

function guessCellStyle(td, trIndex) {
    var tag = (td.tagName || '').toLowerCase();
    var txt = excelTextClean(td.innerText || td.textContent || '');
    var bg = '';
    try { bg = window.getComputedStyle(td).backgroundColor || ''; } catch(e) {}

    if (trIndex <= 1 || tag === 'th' || /^(profil|risiko|rekap|hasil nilai|penilaian profil|pembanding)$/i.test(txt)) {
        return 'sHeader';
    }
    if (/^\d+(?:[\.,]\d+)?$/.test(txt) || /^(sangat rendah|rendah|sedang|tinggi|sangat tinggi|sangat memadai|memadai|cukup memadai|kurang memadai|tidak memadai)$/i.test(txt)) {
        return 'sCenter';
    }
    return 'sCell';
}

function htmlTableToExcelRows(table) {
    var rows = [];
    Array.from(table.rows || []).forEach(function(tr, rIndex){
        var cells = [];
        Array.from(tr.cells || []).forEach(function(td){
            var text = td.innerText || td.textContent || '';
            var colspan = parseInt(td.getAttribute('colspan') || td.colSpan || '1', 10);
            if (!colspan || colspan < 1) colspan = 1;
            var styleId = guessCellStyle(td, rIndex);

            // Hindari MergeAcross/MergeDown karena tabel HTML laporan sangat kompleks.
            // Kolom tetap dipisah agar Excel tidak error, tapi diberi border/width agar mirip PDF.
            cells.push(cellXml(text, '', styleId));
            for (var i = 1; i < colspan; i++) {
                cells.push(cellXml('', '', styleId));
            }
        });
        var height = 22;
        if ((tr.innerText || '').length > 160) height = 70;
        if ((tr.innerText || '').length > 350) height = 120;
        rows.push('<Row ss:AutoFitHeight="1" ss:Height="' + height + '">' + cells.join('') + '</Row>');
    });
    return rows;
}

function sectionToWorksheetXml(section, sheetName) {
    var rows = [];
    rows.push('<Row>' + cellXml(sheetName, '') + '</Row>');
    rows.push('<Row></Row>');

    var cloned = normalizeExcelClone(section.cloneNode(true));
    var tables = Array.from(cloned.querySelectorAll('table'));

    if (tables.length) {
        tables.forEach(function(tbl, i){
            if (i > 0) rows.push('<Row></Row>');
            rows = rows.concat(htmlTableToExcelRows(tbl));
        });
    } else {
        var text = (cloned.innerText || cloned.textContent || '').split(/\n+/).map(function(x){return x.trim();}).filter(Boolean);
        text.forEach(function(line){ rows.push('<Row>' + cellXml(line, '') + '</Row>'); });
    }

    return '<Worksheet ss:Name="' + xmlEscapeExcel(sheetName) + '"><Table>' + rows.join('') + '</Table></Worksheet>';
}

function getCetakProfilDoc() {
    var iframe = document.getElementById('iframeCetakProfilRisiko');
    if (!iframe || !iframe.contentWindow) return null;
    try {
        var doc = iframe.contentDocument || iframe.contentWindow.document;
        if (doc && doc.body && doc.body.innerText.trim() !== '') return doc;
    } catch(e) {}
    return null;
}

function downloadExcelXml(workbookXml, filename) {
    var blob = new Blob([workbookXml], {type: 'application/vnd.ms-excel;charset=utf-8;'});

    if (window.navigator && window.navigator.msSaveOrOpenBlob) {
        window.navigator.msSaveOrOpenBlob(blob, filename);
        return;
    }

    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    setTimeout(function(){
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }, 500);
}


function excelHtmlEscape(v) {
    return String(v == null ? '' : v)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function excelHtmlCleanText(v) {
    return String(v == null ? '' : v)
        .replace(/\u00a0/g, ' ')
        .replace(/\r/g, '')
        .replace(/[ \t]+\n/g, '\n')
        .replace(/\n[ \t]+/g, '\n')
        .replace(/[ \t]{2,}/g, ' ')
        .trim();
}

function makeExcelCellText(el) {
    if (!el) return '';

    var cloned = el.cloneNode(true);

    // Ubah form agar di Excel tampil sebagai teks, bukan input/textarea/select yang rusak.
    Array.from(cloned.querySelectorAll('textarea')).forEach(function(t){
        var div = cloned.ownerDocument.createElement('div');
        div.innerHTML = excelHtmlEscape(t.value || t.textContent || '').replace(/\n/g, '<br>');
        t.parentNode.replaceChild(div, t);
    });

    Array.from(cloned.querySelectorAll('input')).forEach(function(inp){
        var div = cloned.ownerDocument.createElement('div');
        div.innerHTML = excelHtmlEscape(inp.value || inp.getAttribute('value') || '');
        inp.parentNode.replaceChild(div, inp);
    });

    Array.from(cloned.querySelectorAll('select')).forEach(function(sel){
        var div = cloned.ownerDocument.createElement('div');
        var txt = '';
        if (sel.selectedIndex >= 0 && sel.options && sel.options[sel.selectedIndex]) {
            txt = sel.options[sel.selectedIndex].text || sel.options[sel.selectedIndex].value || '';
        }
        div.innerHTML = excelHtmlEscape(txt);
        sel.parentNode.replaceChild(div, sel);
    });

    var html = cloned.innerHTML || cloned.textContent || '';
    html = html
        .replace(/<script[\s\S]*?<\/script>/gi, '')
        .replace(/<style[\s\S]*?<\/style>/gi, '')
        .replace(/<(?!br\s*\/?)[^>]+>/gi, ' ')
        .replace(/<br\s*\/?\s*>/gi, '\n');

    var temp = document.createElement('textarea');
    temp.innerHTML = html;
    return excelHtmlCleanText(temp.value || html);
}

function cellToSimpleHtml(td) {
    var tag = (td.tagName || '').toLowerCase() === 'th' ? 'th' : 'td';
    var colspan = parseInt(td.getAttribute('colspan') || td.colSpan || '1', 10);
    var rowspan = parseInt(td.getAttribute('rowspan') || td.rowSpan || '1', 10);
    if (!colspan || colspan < 1) colspan = 1;
    if (!rowspan || rowspan < 1) rowspan = 1;

    var text = makeExcelCellText(td);
    var isHeader = tag === 'th';
    var style = '';

    try {
        var cs = window.getComputedStyle(td);
        var fw = cs.fontWeight || '';
        if (fw === 'bold' || parseInt(fw, 10) >= 600) isHeader = true;
    } catch(e) {}

    if (isHeader || /^(profil|risiko|rekap|hasil|penilaian|pembanding|no|parameter|nominal|rasio|ambang batas|rumus|koreksi|nilai|keterangan)$/i.test(text)) {
        style += 'font-weight:bold;background:#e6e6e6;text-align:center;';
    }

    if (/^\s*(\d+(?:[\.,]\d+)?|sangat rendah|rendah|sedang|tinggi|sangat tinggi|sangat memadai|memadai|cukup memadai|kurang memadai|tidak memadai)\s*$/i.test(text)) {
        style += 'text-align:center;vertical-align:middle;';
    }

    // Biar tidak nempel seperti 4.03Tinggi.
    text = text
        .replace(/([0-9]+(?:[\.,][0-9]+)?)(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)/gi, '$1\n$2')
        .replace(/(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)([0-9]+(?:[\.,][0-9]+)?)/gi, '$1\n$2');

    var attr = '';
    if (colspan > 1) attr += ' colspan="' + colspan + '"';
    if (rowspan > 1) attr += ' rowspan="' + rowspan + '"';

    return '<' + tag + attr + ' style="' + style + '">' + excelHtmlEscape(text).replace(/\n/g, '<br>') + '</' + tag + '>';
}

function tableToSimpleHtml(table) {
    var html = '<table>';
    Array.from(table.rows || []).forEach(function(tr){
        html += '<tr>';
        Array.from(tr.cells || []).forEach(function(td){
            html += cellToSimpleHtml(td);
        });
        html += '</tr>';
    });
    html += '</table>';
    return html;
}

function blockToSimpleExcelHtml(block, title) {
    var html = '';
    if (title) {
        html += '<h3>' + excelHtmlEscape(title) + '</h3>';
    }

    var tables = Array.from(block.querySelectorAll ? block.querySelectorAll('table') : []);
    if (tables.length) {
        tables.forEach(function(tbl){
            // Skip tabel kecil/hidden yang benar-benar kosong.
            var txt = excelHtmlCleanText(tbl.innerText || tbl.textContent || '');
            if (txt === '') return;
            html += tableToSimpleHtml(tbl);
            html += '<br>';
        });
    } else {
        var txt = excelHtmlCleanText(block.innerText || block.textContent || '');
        if (txt !== '') {
            html += '<p>' + excelHtmlEscape(txt).replace(/\n/g, '<br>') + '</p>';
        }
    }
    return html;
}

function exportCetakProfilExcel() {
    var doc = getCetakProfilDoc();
    if (!doc) {
        alert('Preview belum siap. Tunggu sampai tampilan laporan muncul dahulu.');
        return;
    }

    try {
        var root = doc.querySelector('.report-wrap') || doc.querySelector('.print-area') || doc.querySelector('#printArea') || doc.body;
        var usedNames = {};
        var sheets = [];

        function textOnly(el) {
            return excelHtmlCleanText((el && (el.innerText || el.textContent)) ? (el.innerText || el.textContent) : '');
        }

        function hasContent(el) {
            if (!el) return false;
            return textOnly(el) !== '' || (el.querySelectorAll && el.querySelectorAll('table').length > 0);
        }

        function getTitle(sec, idx) {
            var title = sec.getAttribute('data-title')
                || (sec.querySelector('.section-title') ? sec.querySelector('.section-title').textContent : '')
                || (sec.querySelector('h1,h2,h3,h4,.page-title') ? sec.querySelector('h1,h2,h3,h4,.page-title').textContent : '')
                || '';
            title = excelHtmlCleanText(title);
            if (!title) {
                var t = textOnly(sec);
                var m = t.match(/(?:^|\n)\s*(\d+\.\s*[^\n]{3,80})/);
                if (m) title = m[1];
            }
            if (!title) title = idx === 0 ? 'Cover' : 'Bagian ' + (idx + 1);
            if (/laporan profil risiko/i.test(title) && idx === 0) title = 'Cover';
            return title;
        }

        function makeCoverBlock(firstSection) {
            var box = doc.createElement('div');
            if (!root || !firstSection) return box;
            var children = Array.from(root.children || []);
            for (var i = 0; i < children.length; i++) {
                var el = children[i];
                if (el === firstSection || (el.contains && el.contains(firstSection))) break;
                if (hasContent(el)) box.appendChild(el.cloneNode(true));
            }
            return box;
        }

        function addSheet(name, block, fallback) {
            if (!block || !hasContent(block)) return;
            var sheetName = uniqueWorksheetName(name || fallback || ('Sheet ' + (sheets.length + 1)), usedNames, sheets.length + 1);
            sheets.push({name: sheetName, block: block.cloneNode(true)});
        }

        var rawSections = Array.from(doc.querySelectorAll('.print-section, section.print-section, .section-print'));
        var sections = rawSections.filter(function(sec){
            return sec && !(sec.parentElement && sec.parentElement.closest && sec.parentElement.closest('.print-section, section.print-section, .section-print')) && hasContent(sec);
        });

        if (sections.length) {
            var coverCandidate = doc.querySelector('.cover, .cover-page, #cover, .report-cover');
            var coverAdded = false;
            if (coverCandidate && hasContent(coverCandidate)) {
                addSheet('Cover', coverCandidate, 'Cover');
                coverAdded = sheets.length > 0;
            }
            if (!coverAdded) {
                var coverBox = makeCoverBlock(sections[0]);
                if (hasContent(coverBox)) addSheet('Cover', coverBox, 'Cover');
            }
            sections.forEach(function(sec, idx){
                var t = textOnly(sec);
                if (idx === 0 && /laporan profil risiko/i.test(t) && !/1\.\s*Risiko/i.test(t)) return;
                addSheet(getTitle(sec, idx), sec, 'Bagian ' + (idx + 1));
            });
        } else {
            addSheet('Cover', root, 'Cover');
        }

        if (!sheets.length) {
            alert('Data laporan belum terbaca untuk Excel. Tunggu preview selesai dimuat.');
            return;
        }

        function xmlClean(v) {
            return String(v == null ? '' : v)
                .replace(/\u00a0/g, ' ')
                .replace(/[\x00-\x08\x0B\x0C\x0E-\x1F]/g, '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function textForExcel(el) {
            var txt = makeExcelCellText(el);
            txt = txt
                .replace(/([0-9]+(?:[\.,][0-9]+)?)(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)/gi, '$1\n$2')
                .replace(/(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)([0-9]+(?:[\.,][0-9]+)?)/gi, '$1\n$2');
            return txt;
        }

        function styleForCell(td, rIndex) {
            var tag = (td.tagName || '').toLowerCase();
            var txt = excelHtmlCleanText(textForExcel(td));
            if (rIndex <= 1 || tag === 'th' || /^(profil|risiko|rekap|hasil|penilaian|pembanding|no|parameter|nominal|rasio|ambang batas|rumus|koreksi|nilai|keterangan)$/i.test(txt)) {
                return 'Header';
            }
            if (/^\s*(\d+(?:[\.,]\d+)?|sangat rendah|rendah|sedang|tinggi|sangat tinggi|sangat memadai|memadai|cukup memadai|kurang memadai|tidak memadai)\s*$/i.test(txt)) {
                return 'Center';
            }
            return 'Cell';
        }

        function cell(data, style, mergeAcross) {
            var ma = mergeAcross && mergeAcross > 0 ? ' ss:MergeAcross="' + mergeAcross + '"' : '';
            return '<Cell ss:StyleID="' + style + '"' + ma + '><Data ss:Type="String">' + xmlClean(data) + '</Data></Cell>';
        }

        function tableRows(tbl) {
            var out = [];
            Array.from(tbl.rows || []).forEach(function(tr, ri){
                var cells = [];
                Array.from(tr.cells || []).forEach(function(td){
                    var colspan = parseInt(td.getAttribute('colspan') || td.colSpan || '1', 10);
                    if (!colspan || colspan < 1) colspan = 1;
                    cells.push(cell(textForExcel(td), styleForCell(td, ri), colspan > 1 ? (colspan - 1) : 0));
                });
                var len = excelHtmlCleanText(tr.innerText || tr.textContent || '').length;
                var h = len > 450 ? 95 : (len > 220 ? 64 : (len > 90 ? 38 : 20));
                out.push('<Row ss:AutoFitHeight="1" ss:Height="' + h + '">' + cells.join('') + '</Row>');
            });
            return out;
        }

        function blockRows(block, title) {
            var rows = [];
            title = excelHtmlCleanText(title || '');
            if (title) {
                rows.push('<Row ss:Height="24">' + cell(title, 'Title', 7) + '</Row>');
                rows.push('<Row></Row>');
            }
            var cloned = normalizeExcelClone(block.cloneNode(true));
            var tables = Array.from(cloned.querySelectorAll('table'));
            if (tables.length) {
                tables.forEach(function(tbl, i){
                    var t = excelHtmlCleanText(tbl.innerText || tbl.textContent || '');
                    if (!t) return;
                    if (i > 0) rows.push('<Row></Row>');
                    rows = rows.concat(tableRows(tbl));
                });
            } else {
                var lines = textOnly(cloned).split(/\n+/).map(function(x){return x.trim();}).filter(Boolean);
                lines.forEach(function(line){ rows.push('<Row>' + cell(line, 'Cell', 7) + '</Row>'); });
            }
            return rows;
        }

        function worksheetXml(sh, idx) {
            var rows = blockRows(sh.block, sh.name === 'Cover' ? '' : sh.name);
            if (!rows.length) rows.push('<Row>' + cell('Tidak ada data', 'Cell', 2) + '</Row>');
            var cols = '';
            // Lebar dibuat mirip screenshot sederhana, bukan terlalu lebar seperti preview PDF.
            [90,150,150,150,180,135,135,135,160,160,160,160].forEach(function(w){ cols += '<Column ss:Width="' + w + '"/>'; });
            return '<Worksheet ss:Name="' + xmlClean(sh.name) + '"><Table>' + cols + rows.join('') + '</Table><WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel"><DisplayGridlines/></WorksheetOptions></Worksheet>';
        }

        var workbookXml = '<?xml version="1.0"?>' +
            '<?mso-application progid="Excel.Sheet"?>' +
            '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" ' +
            'xmlns:o="urn:schemas-microsoft-com:office:office" ' +
            'xmlns:x="urn:schemas-microsoft-com:office:excel" ' +
            'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" ' +
            'xmlns:html="http://www.w3.org/TR/REC-html40">' +
            '<Styles>' +
                '<Style ss:ID="Default" ss:Name="Normal"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="11"/><Interior/><NumberFormat ss:Format="@"/></Style>' +
                '<Style ss:ID="Cell"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders><Font ss:FontName="Calibri" ss:Size="11"/><NumberFormat ss:Format="@"/></Style>' +
                '<Style ss:ID="Center"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders><Font ss:FontName="Calibri" ss:Size="11"/><NumberFormat ss:Format="@"/></Style>' +
                '<Style ss:ID="Header"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders><Font ss:FontName="Calibri" ss:Size="11" ss:Bold="1"/><Interior ss:Color="#E6E6E6" ss:Pattern="Solid"/><NumberFormat ss:Format="@"/></Style>' +
                '<Style ss:ID="Title"><Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="13" ss:Bold="1"/><NumberFormat ss:Format="@"/></Style>' +
            '</Styles>' +
            sheets.map(worksheetXml).join('') +
            '</Workbook>';

        var blob = new Blob([workbookXml], {type:'application/vnd.ms-excel;charset=utf-8;'});
        var d = new Date();
        var pad = function(n){ return String(n).length < 2 ? '0' + n : String(n); };
        var filename = 'laporan_profil_risiko_' + (currentCetakProfilId || 'preview') + '_' + d.getFullYear() + pad(d.getMonth()+1) + pad(d.getDate()) + '.xls';

        if (window.navigator && window.navigator.msSaveOrOpenBlob) {
            window.navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = filename;
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            setTimeout(function(){
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 500);
        }
    } catch (e) {
        alert('Gagal membuat file Excel. Error: ' + (e && e.message ? e.message : e));
    }
}


function openCetakTindakLanjutModal(idProfil) {
    currentCetakProfilId = idProfil;
    var iframe = document.getElementById('iframeCetakProfilRisiko');
    if (!iframe) return;

    if (cetakProfilLoadingTimer) {
        clearInterval(cetakProfilLoadingTimer);
        cetakProfilLoadingTimer = null;
    }

    setCetakProfilLoading(true, 'Menyiapkan preview tindak lanjut profil per risiko...');
    iframe.onload = function(){ startCetakProfilLoadingWatcher(); };
    iframe.src = 'about:blank';

    var el = document.getElementById('modalCetakProfilRisiko');
    if (window.bootstrap && bootstrap.Modal) {
        var modal = bootstrap.Modal.getOrCreateInstance(el, {backdrop:true, keyboard:true, focus:true});
        modal.show();
    } else if (window.$ && $('#modalCetakProfilRisiko').modal) {
        $('#modalCetakProfilRisiko').modal({backdrop:true, keyboard:true}).modal('show');
    }

    /*
      Cetak tindak lanjut diarahkan ke halaman profil per risiko saja.
      Parameter only_tindak_lanjut / only_profil_per_risiko disiapkan agar halaman cetak bisa memfilter
      section yang ditampilkan menjadi Profil Kredit, Operasional, Kepatuhan, Likuiditas, Reputasi, dan Stratejik.
    */
    setTimeout(function(){
        iframe.src = 'laporan/cetak_laporan_profil_risiko.php?id=' + encodeURIComponent(idProfil)
            + '&modal_view=1&embed_modal=1&print_scale=300'
            + '&only_tindak_lanjut=1&only_profil_per_risiko=1';
    }, 80);
}

document.addEventListener('DOMContentLoaded', function() {
    var modalCetakEl = document.getElementById('modalCetakProfilRisiko');
    var iframeCetakEl = document.getElementById('iframeCetakProfilRisiko');
    var loadingCetakEl = document.getElementById('loadingCetakProfilRisiko');
    if (modalCetakEl) {
        modalCetakEl.addEventListener('hidden.bs.modal', function(){
            if (cetakProfilLoadingTimer) {
                clearInterval(cetakProfilLoadingTimer);
                cetakProfilLoadingTimer = null;
            }
            if (iframeCetakEl) iframeCetakEl.src = 'about:blank';
            if (loadingCetakEl) loadingCetakEl.classList.add('is-hidden');
        });
    }
});
</script>
