<?php require_once dirname(__DIR__) . '/fungsi/pretty_routes.php'; $simproRouteConfig = simpro_routes_bootstrap(); ?>
<?php error_reporting(E_ERROR | E_PARSE); ?>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<?php
session_start();
$cek = $_SESSION['tipe'];
if ($cek != "kepala wilayah semarang") {
    header("Location: ../login.php");
    exit();
}

?>

<?php
require dirname(__DIR__, 1).'/conn/conn.php';
$user_id = $_SESSION['user_id'];
$data_user = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM user WHERE user_id = ?", [$user_id]));


$id = $_GET['id'];
$get_data = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko = ?", [$id]));

date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= htmlspecialchars($simproRouteConfig['roleBase'], ENT_QUOTES, 'UTF-8') ?>">
    <script>window.simproRouteConfig = <?= json_encode($simproRouteConfig, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
    <script src="<?= htmlspecialchars($simproRouteConfig['projectBase'], ENT_QUOTES, 'UTF-8') ?>assets/js/pretty-routes.js?v=20261030-02"></script>
    <meta charset="utf-8">
    <title>Profil Risiko BKK Jateng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/11.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Load local jQuery/Bootstrap before page initializers. -->
    <script src="../assets/js/vendor.min.js"></script>
    <!-- third party css -->
    <link href="../assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/vendor/select.bootstrap5.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="../assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

</head>

<style>
body {
        zoom: 0.6;
       
    }
.modal-backdrop
{
    width: 100%;
    height: 100%;
}

.custom-wide-modal {
    max-width: 70%; /* Atur sesuai kebutuhan */
  }
  /* CSS tambahan untuk membuat modal lebih besar */
  .modal-full {
    max-width: 50% !important;
  }

  #pdf-frame {
    width: 100%;
    height: 120vh; /* 80% dari tinggi viewport */
  }
/* ߔ頓tyling badge khusus di sidebar (background lebih kelihatan, teks tetap hitam) */
.side-nav .badge-light-lighten {
  background-color: #dee2e6 !important; /* abu terang */
  color: #000 !important;
}

.side-nav .badge-danger-lighten {
  background-color: #ffb3b3 !important; /* merah pastel cerah */
  color: #000 !important;
}

.side-nav .badge-success-lighten {
  background-color: #b2f2bb !important; /* hijau pastel cerah */
  color: #000 !important;
}

.side-nav .badge-info-lighten {
  background-color: #a5d8ff !important; /* biru pastel cerah */
  color: #000 !important;
}

.side-nav .badge-warning-lighten {
  background-color: #ffe066 !important; /* kuning cerah */
  color: #000 !important;
}

.side-nav .badge-primary-lighten {
  background-color: #bac8ff !important; /* biru keunguan cerah */
  color: #000 !important;
}


/* Membesarkan menu utama (Dashboard, Rekap, Settingan) */
.side-nav-link span {
    font-size: 18px;
    font-weight: 600;
}

/* Membesarkan submenu (Dashboard KC, Rekap per divisi, dll.) */
.side-nav-second-level a {
    font-size: 16px;
}
/* ߔ頊udul sidebar seperti "Profil Risiko" */
.side-nav-title a {
    font-size: 18px;
    font-weight: bold;
}

/* ߔ頍enu utama (Profil Risiko SKMR, dll.) */
.side-nav-link span {
    font-size: 17px;
    font-weight: 600;
}

/* ߔ頓ubmenu (Menu Laporan SKMR, Progress, Master Data, dll.) */
.side-nav-second-level a,
.side-nav-third-level a,
.side-nav-forth-level a {
    font-size: 16px;
}

/* ߔ頋alau ada <p class="font-15 mb-0"> biar lebih besar */
.side-nav a p {
    font-size: 16px !important;
    margin: 0; /* rapikan biar ga melebar */
}


/* ================= SIDEBAR DISAMAKAN DENGAN SCRIPT KEDUA ================= */
body { font-family: 'Poppins', Arial, sans-serif; }
.leftside-menu{
    background:#ffffff !important;
    border-right:1px solid #eef0f6 !important;
    box-shadow:8px 0 24px rgba(15,23,42,.035) !important;
}
.leftside-menu .logo{
    background:#ffffff !important;
    border-bottom:1px solid #f1f3f8 !important;
}
.side-nav{padding:12px 10px 24px 10px !important;}
.side-nav-title,
.side-nav-title a{
    color:#6b7280 !important;
    font-size:13px !important;
    font-weight:700 !important;
    letter-spacing:.04em !important;
    text-transform:uppercase !important;
    margin-top:14px !important;
}
.side-nav .side-nav-link,
.side-nav-second-level a,
.side-nav-third-level a,
.side-nav-forth-level a{
    color:#314155 !important;
    border-radius:12px !important;
    transition:all .18s ease !important;
}
.side-nav .side-nav-link{
    display:flex !important;
    align-items:center !important;
    min-height:42px !important;
    padding:10px 14px !important;
    margin:2px 0 !important;
}
.side-nav .side-nav-link i{
    color:#5f6df4 !important;
    font-size:18px !important;
    margin-right:10px !important;
}
.side-nav .side-nav-link span{
    font-size:15px !important;
    font-weight:600 !important;
}
.side-nav .side-nav-link:hover,
.side-nav .side-nav-link.active,
.side-nav .side-nav-link[aria-expanded="true"]{
    background:#f0f3ff !important;
    color:#4656e8 !important;
}
.side-nav-second-level,
.side-nav-third-level,
.side-nav-forth-level{
    padding-left:12px !important;
}
.side-nav-second-level a,
.side-nav-third-level a,
.side-nav-forth-level a{
    display:block !important;
    padding:8px 12px !important;
    margin:2px 0 !important;
    font-size:14px !important;
    font-weight:500 !important;
}
.side-nav-second-level a:hover,
.side-nav-third-level a:hover,
.side-nav-forth-level a:hover,
.side-nav-second-level a.active,
.side-nav-third-level a.active,
.side-nav-forth-level a.active{
    background:#f6f8ff !important;
    color:#4656e8 !important;
}
.side-nav .badge{
    border-radius:999px !important;
    padding:5px 10px !important;
    box-shadow:0 3px 10px rgba(15,23,42,.06) !important;
}
.side-nav .badge p,
.side-nav .badge h5{
    margin:0 !important;
    font-size:13px !important;
    font-weight:700 !important;
    line-height:1.2 !important;
}
.side-nav .badge-light-lighten{background:#eef2f7 !important;color:#111827 !important;}
.side-nav .badge-danger-lighten{background:#ffd6d6 !important;color:#111827 !important;}
.side-nav .badge-success-lighten{background:#c9f7d5 !important;color:#111827 !important;}
.side-nav .badge-info-lighten{background:#c8eaff !important;color:#111827 !important;}
.side-nav .badge-warning-lighten{background:#ffe98a !important;color:#111827 !important;}
.side-nav .badge-primary-lighten{background:#d4dcff !important;color:#111827 !important;}
.menu-arrow{margin-left:auto !important;}



/* ========== FIX TAMPILAN PILL RISIKO SEPERTI SCREENSHOT ========== */
/* Parent risiko: hanya pill warna + arrow kanan, tidak full background */
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKreditSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarOperasionalSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKepatuhanSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarLikuiditasSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarReputasiSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarStratejikSKMR"]{
    display:flex !important;
    align-items:center !important;
    justify-content:space-between !important;
    width:100% !important;
    background:transparent !important;
    border-radius:0 !important;
    padding:7px 10px 7px 18px !important;
    margin:7px 0 !important;
    box-shadow:none !important;
}

#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKreditSKMR"]:hover,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarOperasionalSKMR"]:hover,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKepatuhanSKMR"]:hover,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarLikuiditasSKMR"]:hover,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarReputasiSKMR"]:hover,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarStratejikSKMR"]:hover,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKreditSKMR"][aria-expanded="true"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarOperasionalSKMR"][aria-expanded="true"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKepatuhanSKMR"][aria-expanded="true"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarLikuiditasSKMR"][aria-expanded="true"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarReputasiSKMR"][aria-expanded="true"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarStratejikSKMR"][aria-expanded="true"]{
    background:transparent !important;
    color:#314155 !important;
}

/* Ukuran badge parent risiko */
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKreditSKMR"] > .badge,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarOperasionalSKMR"] > .badge,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKepatuhanSKMR"] > .badge,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarLikuiditasSKMR"] > .badge,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarReputasiSKMR"] > .badge,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarStratejikSKMR"] > .badge{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    width:auto !important;
    min-width:0 !important;
    padding:8px 18px !important;
    border-radius:999px !important;
    box-shadow:0 5px 12px rgba(15,23,42,.12) !important;
}

#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKreditSKMR"] > .badge p,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarOperasionalSKMR"] > .badge p,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKepatuhanSKMR"] > .badge p,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarLikuiditasSKMR"] > .badge p,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarReputasiSKMR"] > .badge p,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarStratejikSKMR"] > .badge p{
    font-size:14px !important;
    font-weight:700 !important;
    line-height:1 !important;
    margin:0 !important;
}

/* Arrow parent risiko dibuat seperti screenshot */
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKreditSKMR"] .menu-arrow,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarOperasionalSKMR"] .menu-arrow,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarKepatuhanSKMR"] .menu-arrow,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarLikuiditasSKMR"] .menu-arrow,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarReputasiSKMR"] .menu-arrow,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href="#sidebarStratejikSKMR"] .menu-arrow{
    margin-left:auto !important;
    color:#3b6df6 !important;
    opacity:1 !important;
    width:24px !important;
    flex:0 0 24px !important;
    text-align:center !important;
}

/* Submenu risiko: ada garis vertikal kiri dan badge kecil per item */
#sidebarKreditSKMR,
#sidebarOperasionalSKMR,
#sidebarKepatuhanSKMR,
#sidebarLikuiditasSKMR,
#sidebarReputasiSKMR,
#sidebarStratejikSKMR{
    margin-left:24px !important;
    padding-left:14px !important;
    border-left:1px solid #dbe6f6 !important;
}

#sidebarKreditSKMR .side-nav-forth-level,
#sidebarOperasionalSKMR .side-nav-forth-level,
#sidebarKepatuhanSKMR .side-nav-forth-level,
#sidebarLikuiditasSKMR .side-nav-forth-level,
#sidebarReputasiSKMR .side-nav-forth-level,
#sidebarStratejikSKMR .side-nav-forth-level{
    padding-left:0 !important;
    margin:0 !important;
}

#sidebarKreditSKMR .side-nav-forth-level a,
#sidebarOperasionalSKMR .side-nav-forth-level a,
#sidebarKepatuhanSKMR .side-nav-forth-level a,
#sidebarLikuiditasSKMR .side-nav-forth-level a,
#sidebarReputasiSKMR .side-nav-forth-level a,
#sidebarStratejikSKMR .side-nav-forth-level a{
    display:inline-flex !important;
    align-items:center !important;
    width:auto !important;
    background:transparent !important;
    padding:7px 0 !important;
    margin:2px 0 7px 0 !important;
    border-radius:0 !important;
    box-shadow:none !important;
}

#sidebarKreditSKMR .side-nav-forth-level a:hover,
#sidebarOperasionalSKMR .side-nav-forth-level a:hover,
#sidebarKepatuhanSKMR .side-nav-forth-level a:hover,
#sidebarLikuiditasSKMR .side-nav-forth-level a:hover,
#sidebarReputasiSKMR .side-nav-forth-level a:hover,
#sidebarStratejikSKMR .side-nav-forth-level a:hover{
    background:transparent !important;
}

#sidebarKreditSKMR .side-nav-forth-level a .badge,
#sidebarOperasionalSKMR .side-nav-forth-level a .badge,
#sidebarKepatuhanSKMR .side-nav-forth-level a .badge,
#sidebarLikuiditasSKMR .side-nav-forth-level a .badge,
#sidebarReputasiSKMR .side-nav-forth-level a .badge,
#sidebarStratejikSKMR .side-nav-forth-level a .badge{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    width:auto !important;
    padding:8px 16px !important;
    border-radius:999px !important;
    box-shadow:0 5px 12px rgba(15,23,42,.12) !important;
}

#sidebarKreditSKMR .side-nav-forth-level a .badge p,
#sidebarOperasionalSKMR .side-nav-forth-level a .badge p,
#sidebarKepatuhanSKMR .side-nav-forth-level a .badge p,
#sidebarLikuiditasSKMR .side-nav-forth-level a .badge p,
#sidebarReputasiSKMR .side-nav-forth-level a .badge p,
#sidebarStratejikSKMR .side-nav-forth-level a .badge p{
    font-size:13px !important;
    font-weight:700 !important;
    line-height:1.1 !important;
    margin:0 !important;
}

/* Active link jangan jadi kotak biru penuh, cukup badge-nya tetap pill */
#sidebarKreditSKMR .side-nav-forth-level a.active,
#sidebarOperasionalSKMR .side-nav-forth-level a.active,
#sidebarKepatuhanSKMR .side-nav-forth-level a.active,
#sidebarLikuiditasSKMR .side-nav-forth-level a.active,
#sidebarReputasiSKMR .side-nav-forth-level a.active,
#sidebarStratejikSKMR .side-nav-forth-level a.active{
    background:transparent !important;
}
#sidebarKreditSKMR .side-nav-forth-level a.active .badge,
#sidebarOperasionalSKMR .side-nav-forth-level a.active .badge,
#sidebarKepatuhanSKMR .side-nav-forth-level a.active .badge,
#sidebarLikuiditasSKMR .side-nav-forth-level a.active .badge,
#sidebarReputasiSKMR .side-nav-forth-level a.active .badge,
#sidebarStratejikSKMR .side-nav-forth-level a.active .badge{
    outline:2px solid rgba(59,109,246,.18) !important;
    transform:translateX(2px) !important;
}


/* =========================================================
   FINAL SIDEBAR STYLE - DISAMAKAN DENGAN SCRIPT KEDUA
   Fokus: sidebar putih, menu modern, pill risiko kecil seperti SS.
   Tidak mengubah link, routing, id collapse, atau switch-case.
========================================================= */
body{font-family:'Poppins',Arial,sans-serif!important;}

.leftside-menu{
    background:#fff!important;
    border-right:1px solid #edf1f7!important;
    box-shadow:8px 0 24px rgba(15,23,42,.04)!important;
}
.leftside-menu .logo{
    background:#fff!important;
    border-bottom:1px solid #f1f3f8!important;
}
#leftside-menu-container,
.side-nav{
    background:#fff!important;
}
.side-nav{
    padding:12px 10px 24px 10px!important;
}
.side-nav-title,
.side-nav-title a{
    color:#637085!important;
    font-size:13px!important;
    font-weight:700!important;
    letter-spacing:.04em!important;
    text-transform:uppercase!important;
    margin-top:14px!important;
}
.side-nav .side-nav-link{
    display:flex!important;
    align-items:center!important;
    min-height:42px!important;
    padding:10px 14px!important;
    margin:2px 0!important;
    color:#1f2d3d!important;
    border-radius:12px!important;
    background:transparent!important;
    transition:all .18s ease!important;
}
.side-nav .side-nav-link i{
    color:#2563eb!important;
    font-size:18px!important;
    margin-right:10px!important;
}
.side-nav .side-nav-link span:not(.menu-arrow):not(.badge){
    font-size:15px!important;
    font-weight:600!important;
}
.side-nav .side-nav-link:hover,
.side-nav .side-nav-link.active,
.side-nav .side-nav-link[aria-expanded="true"]{
    background:#f3f6ff!important;
    color:#3159e8!important;
}
.side-nav-second-level,
.side-nav-third-level,
.side-nav-forth-level{
    padding-left:12px!important;
    margin:0!important;
}
.side-nav-second-level a,
.side-nav-third-level a,
.side-nav-forth-level a{
    color:#314155!important;
    font-size:14px!important;
    font-weight:500!important;
    border-radius:10px!important;
    transition:all .18s ease!important;
    background:transparent!important;
}
.side-nav-second-level a:hover,
.side-nav-third-level a:hover,
.side-nav-forth-level a:hover,
.side-nav-second-level a.active,
.side-nav-third-level a.active,
.side-nav-forth-level a.active{
    background:#f6f8ff!important;
    color:#3159e8!important;
}
.menu-arrow{
    margin-left:auto!important;
    color:#2563eb!important;
    opacity:1!important;
}

/* warna badge sama seperti script kedua */
.side-nav .badge-success-lighten{background:#b2f2bb!important;color:#111827!important;}
.side-nav .badge-primary-lighten{background:#bac8ff!important;color:#111827!important;}
.side-nav .badge-warning-lighten{background:#ffe066!important;color:#111827!important;}
.side-nav .badge-danger-lighten{background:#ffb3b3!important;color:#111827!important;}
.side-nav .badge-info-lighten{background:#a5d8ff!important;color:#111827!important;}
.side-nav .badge-light-lighten{background:#dee2e6!important;color:#111827!important;}

/* semua badge sidebar dibuat pill kecil */
.side-nav .badge{
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    width:auto!important;
    min-width:0!important;
    max-width:max-content!important;
    border-radius:999px!important;
    padding:8px 17px!important;
    line-height:1!important;
    box-shadow:0 5px 12px rgba(15,23,42,.13)!important;
}
.side-nav .badge p,
.side-nav .badge h5{
    margin:0!important;
    padding:0!important;
    line-height:1.05!important;
    font-size:14px!important;
    font-weight:700!important;
    color:#111827!important;
    white-space:nowrap!important;
}

/* PARENT RISIKO: a collapse yang isinya badge jangan jadi kotak full */
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[data-bs-toggle="collapse"]:has(.badge){
    display:flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    width:100%!important;
    background:transparent!important;
    border-radius:0!important;
    padding:7px 10px 7px 18px!important;
    margin:7px 0!important;
    box-shadow:none!important;
}
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[data-bs-toggle="collapse"]:has(.badge):hover,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[data-bs-toggle="collapse"]:has(.badge).active,
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[data-bs-toggle="collapse"]:has(.badge)[aria-expanded="true"]{
    background:transparent!important;
    color:#314155!important;
}
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[data-bs-toggle="collapse"]:has(.badge) .menu-arrow{
    width:24px!important;
    flex:0 0 24px!important;
    text-align:center!important;
    margin-left:auto!important;
}

/* fallback untuk browser lama kalau :has belum aktif */
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="KreditSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="OperasionalSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="KepatuhanSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="LikuiditasSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="ReputasiSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="StratejikSKMR"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="FourthLevel2"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="FourthLevel3"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="FourthLevel4"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="FourthLevel5"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="FourthLevel6"],
#sidebarskmr .side-nav-third-level > li.side-nav-item > a[href*="FourthLevel7"]{
    display:flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    width:100%!important;
    background:transparent!important;
    border-radius:0!important;
    padding:7px 10px 7px 18px!important;
    margin:7px 0!important;
    box-shadow:none!important;
}

/* SUBMENU RISIKO: garis kiri dan item pill kecil menjorok seperti SS */
#sidebarKreditSKMR,
#sidebarOperasionalSKMR,
#sidebarKepatuhanSKMR,
#sidebarLikuiditasSKMR,
#sidebarReputasiSKMR,
#sidebarStratejikSKMR,
#sidebarFourthLevel2skmr,
#sidebarFourthLevel3skmr,
#sidebarFourthLevel4skmr,
#sidebarFourthLevel5skmr,
#sidebarFourthLevel6skmr,
#sidebarFourthLevel7skmr{
    margin-left:24px!important;
    padding-left:14px!important;
    border-left:1px solid #dbe6f6!important;
}
#sidebarKreditSKMR .side-nav-forth-level,
#sidebarOperasionalSKMR .side-nav-forth-level,
#sidebarKepatuhanSKMR .side-nav-forth-level,
#sidebarLikuiditasSKMR .side-nav-forth-level,
#sidebarReputasiSKMR .side-nav-forth-level,
#sidebarStratejikSKMR .side-nav-forth-level,
#sidebarFourthLevel2skmr .side-nav-forth-level,
#sidebarFourthLevel3skmr .side-nav-forth-level,
#sidebarFourthLevel4skmr .side-nav-forth-level,
#sidebarFourthLevel5skmr .side-nav-forth-level,
#sidebarFourthLevel6skmr .side-nav-forth-level,
#sidebarFourthLevel7skmr .side-nav-forth-level{
    padding-left:0!important;
}
#sidebarKreditSKMR .side-nav-forth-level a,
#sidebarOperasionalSKMR .side-nav-forth-level a,
#sidebarKepatuhanSKMR .side-nav-forth-level a,
#sidebarLikuiditasSKMR .side-nav-forth-level a,
#sidebarReputasiSKMR .side-nav-forth-level a,
#sidebarStratejikSKMR .side-nav-forth-level a,
#sidebarFourthLevel2skmr .side-nav-forth-level a,
#sidebarFourthLevel3skmr .side-nav-forth-level a,
#sidebarFourthLevel4skmr .side-nav-forth-level a,
#sidebarFourthLevel5skmr .side-nav-forth-level a,
#sidebarFourthLevel6skmr .side-nav-forth-level a,
#sidebarFourthLevel7skmr .side-nav-forth-level a{
    display:inline-flex!important;
    align-items:center!important;
    width:auto!important;
    background:transparent!important;
    padding:7px 0!important;
    margin:2px 0 7px 0!important;
    border-radius:0!important;
    box-shadow:none!important;
}
#sidebarKreditSKMR .side-nav-forth-level a:hover,
#sidebarOperasionalSKMR .side-nav-forth-level a:hover,
#sidebarKepatuhanSKMR .side-nav-forth-level a:hover,
#sidebarLikuiditasSKMR .side-nav-forth-level a:hover,
#sidebarReputasiSKMR .side-nav-forth-level a:hover,
#sidebarStratejikSKMR .side-nav-forth-level a:hover,
#sidebarFourthLevel2skmr .side-nav-forth-level a:hover,
#sidebarFourthLevel3skmr .side-nav-forth-level a:hover,
#sidebarFourthLevel4skmr .side-nav-forth-level a:hover,
#sidebarFourthLevel5skmr .side-nav-forth-level a:hover,
#sidebarFourthLevel6skmr .side-nav-forth-level a:hover,
#sidebarFourthLevel7skmr .side-nav-forth-level a:hover,
#sidebarKreditSKMR .side-nav-forth-level a.active,
#sidebarOperasionalSKMR .side-nav-forth-level a.active,
#sidebarKepatuhanSKMR .side-nav-forth-level a.active,
#sidebarLikuiditasSKMR .side-nav-forth-level a.active,
#sidebarReputasiSKMR .side-nav-forth-level a.active,
#sidebarStratejikSKMR .side-nav-forth-level a.active,
#sidebarFourthLevel2skmr .side-nav-forth-level a.active,
#sidebarFourthLevel3skmr .side-nav-forth-level a.active,
#sidebarFourthLevel4skmr .side-nav-forth-level a.active,
#sidebarFourthLevel5skmr .side-nav-forth-level a.active,
#sidebarFourthLevel6skmr .side-nav-forth-level a.active,
#sidebarFourthLevel7skmr .side-nav-forth-level a.active{
    background:transparent!important;
}
#sidebarKreditSKMR .side-nav-forth-level a.active .badge,
#sidebarOperasionalSKMR .side-nav-forth-level a.active .badge,
#sidebarKepatuhanSKMR .side-nav-forth-level a.active .badge,
#sidebarLikuiditasSKMR .side-nav-forth-level a.active .badge,
#sidebarReputasiSKMR .side-nav-forth-level a.active .badge,
#sidebarStratejikSKMR .side-nav-forth-level a.active .badge,
#sidebarFourthLevel2skmr .side-nav-forth-level a.active .badge,
#sidebarFourthLevel3skmr .side-nav-forth-level a.active .badge,
#sidebarFourthLevel4skmr .side-nav-forth-level a.active .badge,
#sidebarFourthLevel5skmr .side-nav-forth-level a.active .badge,
#sidebarFourthLevel6skmr .side-nav-forth-level a.active .badge,
#sidebarFourthLevel7skmr .side-nav-forth-level a.active .badge{
    outline:2px solid rgba(37,99,235,.18)!important;
    transform:translateX(2px)!important;
}

</style>


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
        <!-- Begin page -->
        <div class="wrapper">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topbar-menu float-end mb-0">



                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="../assets/images/users/avatar.png" alt="user-image" class="rounded-circle">
                            </span>
                            <span>
                                <span class="account-user-name"><?= $data_user['nama'] ?></span>
                                <span class="account-position"><?= $data_user['jabatan'] ?></span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">


                            <!-- item-->
                            <a href="index.php?page=profile" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle me-1"></i>
                                <span>Profile</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-edit me-1"></i>
                                <span>Settings</span>
                            </a>



                            <!-- item-->
                            <a href="logout.php" class="dropdown-item notify-item">
                                <i class="mdi mdi-logout me-1"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>

                </ul>
                <button class="button-menu-mobile open-left">
                    <i class="mdi mdi-menu"></i>
                </button>
                <ul class="list-unstyled topbar-menu float-end mb-2">
                    <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <button class="btn btn-primary" onclick="window.print()"><span>Cetak Halaman Ini</span></button>
                    </a>
                    </li>
                </ul>
            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="leftside-menu">

                <!-- LOGO -->
                <a href="#" class="logo text-center logo-light">
                    <span class="logo-lg">
                        <img src="../assets/images/SIMPRO_2gd.png" alt="" height="60">
                    </span>
                    <span class="logo-sm">
                        <img src="../assets/images/SIMPRO_2.png" alt="" height="50">
                    </span>
                </a>

                <a href="#" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="../assets/images/SIMPRO_2gd.png" alt="" height="60">
                    </span>
                    <span class="logo-sm">
                        <img src="../assets/images/SIMPRO_2.png" alt="" height="50">
                    </span>
                </a>

                <div class="h-100" id="leftside-menu-container" data-simplebar="">
                    <ul class="side-nav">

                        <li class="side-nav-title side-nav-item">Navigation</li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                                <i class="uil-home-alt"></i>
                                <span> Dashboards </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarDashboards">
                                <ul class="side-nav-second-level">
                                    <li><a href="index.php?page=dashboard&id=<?= $get_data['id_profil_risiko'] ?>">Dashboard Korwil</a></li>
                                    <li><a href="index.php?page=dashboard_korwil&id=<?= $get_data['id_profil_risiko'] ?>">Dashboard Cabang</a></li>
                                    <li><a href="index.php?page=rekap_cbg&id=<?= $get_data['id_profil_risiko'] ?>">Rekap Cabang</a></li>
                                    
                                </ul>
                            </div>
                        </li>

                        

                        <li class="side-nav-title side-nav-item"><a href="#">Profil Risiko</a></li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarskmr" aria-expanded="false" aria-controls="sidebarskmr" class="side-nav-link">
                                <i class="dripicons-duplicate"></i>
                                <span> Profil Risiko Cabang</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarskmr">
                                <ul class="side-nav-third-level">
                                    <li><a href="index.php?page=laporan_masuk&id=<?= $get_data['id_profil_risiko'] ?>"><p class="font-15 mb-0">Menu Laporan Profil</p></a></li>
                                    <li><a href="index.php?page=progress&id=<?= $get_data['id_profil_risiko'] ?>"><p class="font-15 mb-0">Progress</p></a></li>

                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarMasterDataSKMR" aria-expanded="false" aria-controls="sidebarMasterDataSKMR">
                                            <span> Master Data </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarMasterDataSKMR">
                                            <ul class="side-nav-forth-level">
                                                <li><a href="index.php?page=maskre&id=<?= $get_data['id_profil_risiko'] ?>"><p class="font-15 mb-0">Master Kredit</p></a></li>
                                                <li><a href="index.php?page=maslik&id=<?= $get_data['id_profil_risiko'] ?>"><p class="font-15 mb-0">Master Likuiditas</p></a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li><a href="index.php?page=pembanding&id=<?= $get_data['id_profil_risiko'] ?>"><p class="font-15 mb-0">Pembanding</p></a></li>

                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarKreditSKMR" aria-expanded="false" aria-controls="sidebarKreditSKMR">
                                            <span class="badge badge-success-lighten rounded-pill"><p class="font-15 mb-0">Kredit</p></span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarKreditSKMR">
                                            <ul class="side-nav-forth-level">
                                                <li><a href="index.php?page=kre_inhern&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-success-lighten rounded-pill"><p class="font-15 mb-0">Inhern Kredit</p></span></a></li>

                                                <li><a href="index.php?page=kre_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-success-lighten rounded-pill"><p class="font-15 mb-0">Profil Kredit</p></span></a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarOperasionalSKMR" aria-expanded="false" aria-controls="sidebarOperasionalSKMR">
                                            <span class="badge badge-primary-lighten rounded-pill"><p class="font-15 mb-0">Operasional</p></span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarOperasionalSKMR">
                                            <ul class="side-nav-forth-level">
                                                <li><a href="index.php?page=op_inhern1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-primary-lighten rounded-pill"><p class="font-15 mb-0">Inhern Operasional</p></span></a></li>
                                                <li><a href="index.php?page=op_inhern2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-primary-lighten rounded-pill"><p class="font-15 mb-0">Inhern Operasional 2</p></span></a></li>

                                                <li><a href="index.php?page=op_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-primary-lighten rounded-pill"><p class="font-15 mb-0">Profil Operasional</p></span></a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarKepatuhanSKMR" aria-expanded="false" aria-controls="sidebarKepatuhanSKMR">
                                            <span class="badge badge-warning-lighten rounded-pill"><p class="font-15 mb-0">Kepatuhan</p></span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarKepatuhanSKMR">
                                            <ul class="side-nav-forth-level">
                                                <li><a href="index.php?page=kep_inhern1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-warning-lighten rounded-pill"><p class="font-15 mb-0">Inhern Kepatuhan</p></span></a></li>
                                                <li><a href="index.php?page=kep_inhern2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-warning-lighten rounded-pill"><p class="font-15 mb-0">Inhern Kepatuhan 2</p></span></a></li>
                                                
                                                <li><a href="index.php?page=kep_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-warning-lighten rounded-pill"><p class="font-15 mb-0">Profil Kepatuhan</p></span></a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarLikuiditasSKMR" aria-expanded="false" aria-controls="sidebarLikuiditasSKMR">
                                            <span class="badge badge-danger-lighten rounded-pill"><p class="font-15 mb-0">Likuiditas</p></span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarLikuiditasSKMR">
                                            <ul class="side-nav-forth-level">
                                                <li><a href="index.php?page=lik_inhern&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-danger-lighten rounded-pill"><p class="font-15 mb-0">Inhern Likuiditas</p></span></a></li>

                                                <li><a href="index.php?page=lik_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-danger-lighten rounded-pill"><p class="font-15 mb-0">Profil Likuiditas</p></span></a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarReputasiSKMR" aria-expanded="false" aria-controls="sidebarReputasiSKMR">
                                            <span class="badge badge-info-lighten rounded-pill"><p class="font-15 mb-0">Reputasi</p></span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarReputasiSKMR">
                                            <ul class="side-nav-forth-level">
                                                <li><a href="index.php?page=rep_inhern1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-info-lighten rounded-pill"><p class="font-15 mb-0">Inhern Reputasi</p></span></a></li>
                                                <li><a href="index.php?page=rep_inhern2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-info-lighten rounded-pill"><p class="font-15 mb-0">Inhern Reputasi 2</p></span></a></li>

                                                <li><a href="index.php?page=rep_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-info-lighten rounded-pill"><p class="font-15 mb-0">Profil Reputasi</p></span></a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarStratejikSKMR" aria-expanded="false" aria-controls="sidebarStratejikSKMR">
                                            <span class="badge badge-light-lighten rounded-pill"><p class="font-15 mb-0">Stratejik</p></span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarStratejikSKMR">
                                            <ul class="side-nav-forth-level">
                                                <li><a href="index.php?page=stra_inhern1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-light-lighten rounded-pill"><p class="font-15 mb-0">Inhern Stratejik</p></span></a></li>
                                                <li><a href="index.php?page=stra_inhern2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-light-lighten rounded-pill"><p class="font-15 mb-0">Inhern Stratejik 2</p></span></a></li>

                                                <li><a href="index.php?page=stra_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-light-lighten rounded-pill"><p class="font-15 mb-0">Profil Stratejik</p></span></a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#sidebarProfilNilaiSKMR" aria-expanded="false" aria-controls="sidebarProfilNilaiSKMR">
                                            <span> Profil Nilai </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarProfilNilaiSKMR">
                                            <ul class="side-nav-forth-level">
                                                <li><a href="index.php?page=nilpro&id=<?= $get_data['id_profil_risiko'] ?>"><span>Profil Nilai</span></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-title side-nav-item"><a href="#">Menu User</a></li>
                        <li class="side-nav-item">
                            <a href="index.php?page=profile&id=<?= $get_data['id_profil_risiko'] ?>" class="side-nav-link">
                                <i class="uil-user"></i>
                                <span> Info User </span>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->













            <!--start page wrapper -->
            <div class="page-wrapper">
                <div class="page-content">
                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];

                        switch ($page) {
                            case 'dashboard':
                                include "home.php";
                                break;
                            
                            case 'dashboard_korwil':
                                include "dashboard_korwil.php";
                                break;

                            case 'cetak_laporan_profil_risiko':
                                include "laporan/cetak_laporan_profil_risiko.php";
                                break;

                            case 'konfirm':
                                include "laporan/konfirmasi.php";
                                break;
                            case 'rekap_cbg':
                                    include "laporan/rekap_cabang.php";
                                    break;
                            case 'hasil_lapkc':
                                    include "laporan/hasil_laporan_cabang.php";
                                    break;
                            case 'menulapawal':
                                include "laporan/menu_laporan_awal.php";
                                break;

                            case 'laporan_masuk':
                                include "laporan/laporan_proris.php";
                                break;
                            
                            case 'progress':
                                include "laporan/persentase_pengerjaan.php";
                                break;

                            case 'pembanding':
                                include "laporan/isian_pembanding.php";
                                break;

                            case 'delete_frame':
                                include "laporan/delete_frame.php";
                                break;

                            case 'profile':
                                include "profile.php";
                                break;

                            case 'logout':
                                include "logout.php";
                                break;
                            
                          
                                case 'tren':
                                    include "tren.php";
                                    break;

                                //User
                            case 'list_user':
                                include "user/list_user.php";
                                break;
                            case 'edit_user':
                                include "user/edit_user.php";
                                break;
                            case 'add_user':
                                include "user/add_user.php";
                                break;


                                //data master
                            case 'maskre':
                                include "data_master/master_kredit.php";
                                break;
                            case 'maslik':
                                include "data_master/master_likuiditas.php";
                                break;


                                //Isian
                            case 'setris':
                                include "isian/penetapan_tingkat_risiko.php";
                                break;
                            case 'set_pentapan':
                                include "isian/setting_penetapan.php";
                                break;
                            case 'bobot':
                                include "isian/frame_pembobotan.php";
                                break;
                            case 'bobot_kre':
                                include "isian/bobot_kredit.php";
                                break;
                            case 'bobot_op':
                                include "isian/bobot_operasional.php";
                                break;
                            case 'bobot_kep':
                                include "isian/bobot_kepatuhan.php";
                                break;
                            case 'bobot_lik':
                                include "isian/bobot_likuiditas.php";
                                break;
                            case 'bobot_rep':
                                include "isian/bobot_reputasi.php";
                                break;
                            case 'bobot_stra':
                                include "isian/bobot_stratejik.php";
                                break;
                            case 'delete_bobot':
                                include "isian/delete_bobot.php";
                                break;
                            case 'delete_set_dit':
                                include "isian/delete_settingan_ditetapkan.php";
                                break;

                            case 'frame_ambang':
                                include "isian/frame_ambang_batas.php";
                                break;
                            case 'ambang':
                                include "isian/ambang_batas.php";
                                break;
                            case 'delete_ambang':
                                include "isian/delete_ambang.php";
                                break;
                            case 'progress':
                                include "laporan/persentase_pengerjaan.php";
                                break;


                                //nilai Peringkat
                            case 'nilpro':
                                include "nilai_peringkat/nilai_profil.php";
                                break;
                            case 'perpro':
                                include "nilai_peringkat/peringkat_profil.php";
                                break;

                                //profil risiko kepatuhan
                            case 'kep_inhern1':
                                include "profil_risiko_kepatuhan/kepatuhan_inhern1.php";
                                break;
                            case 'kep_inhern2':
                                include "profil_risiko_kepatuhan/kepatuhan_inhern2.php";
                                break;
                            case 'kep_kpmr1':
                                include "profil_risiko_kepatuhan/kepatuhan_kpmr1.php";
                                break;
                            case 'kep_kpmr2':
                                include "profil_risiko_kepatuhan/kepatuhan_kpmr2.php";
                                break;
                            case 'kep_profil':
                                include "profil_risiko_kepatuhan/kepatuhan_profil.php";
                                break;


                                //profil risiko kredit
                            case 'kre_inhern':
                                include "profil_risiko_kredit/kredit_inhern.php";
                                break;
                            case 'kre_kpmr1':
                                include "profil_risiko_kredit/kredit_kpmr1.php";
                                break;
                            case 'kre_kpmr2':
                                include "profil_risiko_kredit/kredit_kpmr2.php";
                                break;
                            case 'kre_profil':
                                include "profil_risiko_kredit/kredit_profil.php";
                                break;


                                //profil risiko Operasional
                            case 'op_inhern1':
                                include "profil_risiko_operasional/operasional_inhern1.php";
                                break;
                            case 'op_inhern2':
                                include "profil_risiko_operasional/operasional_inhern2.php";
                                break;
                            case 'op_kpmr1':
                                include "profil_risiko_operasional/operasional_kpmr1.php";
                                break;
                            case 'op_kpmr2':
                                include "profil_risiko_operasional/operasional_kpmr2.php";
                                break;
                            case 'op_profil':
                                include "profil_risiko_operasional/operasional_profil.php";
                                break;



                                //profil risiko Likuiditas
                            case 'lik_inhern':
                                include "profil_risiko_likuiditas/likuiditas_inhern.php";
                                break;
                            case 'lik_kpmr1':
                                include "profil_risiko_likuiditas/likuiditas_kpmr1.php";
                                break;
                            case 'lik_kpmr2':
                                include "profil_risiko_likuiditas/likuiditas_kpmr2.php";
                                break;
                            case 'lik_profil':
                                include "profil_risiko_likuiditas/likuiditas_profil.php";
                                break;



                                //profil risiko reputasi
                            case 'rep_inhern1':
                                include "profil_risiko_reputasi/reputasi_inhern1.php";
                                break;
                            case 'rep_inhern2':
                                include "profil_risiko_reputasi/reputasi_inhern2.php";
                                break;
                            case 'rep_kpmr1':
                                include "profil_risiko_reputasi/reputasi_kpmr1.php";
                                break;
                            case 'rep_kpmr2':
                                include "profil_risiko_reputasi/reputasi_kpmr2.php";
                                break;
                            case 'rep_profil':
                                include "profil_risiko_reputasi/reputasi_profil.php";
                                break;

                                //profil risiko stratejik
                            case 'stra_inhern1':
                                include "profil_risiko_stratejik/stratejik_inhern1.php";
                                break;
                            case 'stra_inhern2':
                                include "profil_risiko_stratejik/stratejik_inhern2.php";
                                break;
                            case 'stra_kpmr1':
                                include "profil_risiko_stratejik/stratejik_kpmr1.php";
                                break;
                            case 'stra_kpmr2':
                                include "profil_risiko_stratejik/stratejik_kpmr2.php";
                                break;
                            case 'stra_profil':
                                include "profil_risiko_stratejik/stratejik_profil.php";
                                break;




                            default:
                                echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                                break;
                        }
                    } else {
                        include "home.php";
                    }

                    ?>

<script>
                        // Simpan menu yang dibuka ke localStorage saat diklik
                        document.querySelectorAll('.side-nav-link[data-bs-toggle="collapse"]').forEach(link => {
                            link.addEventListener('click', function () {
                                const target = this.getAttribute('href');
                                localStorage.setItem('activeSidebarMenu', target);
                            });
                        });

                        // Saat halaman dimuat, cek apakah ada menu yang disimpan di localStorage
                        document.addEventListener('DOMContentLoaded', function () {
                            const activeMenu = localStorage.getItem('activeSidebarMenu');
                            if (activeMenu) {
                                const targetCollapse = document.querySelector(activeMenu);
                                const targetToggle = document.querySelector(`[href="${activeMenu}"]`);

                                if (targetCollapse && targetToggle) {
                                    // Tambahkan class 'show' ke menu yang disimpan
                                    targetCollapse.classList.add('show');
                                    // Tambahkan class 'active' ke parent nav link-nya
                                    targetToggle.classList.add('active');
                                }
                            }
                        });
                    </script>
                </div>
            </div>


















            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Development by.Febri and ui by.Coderthemes.com
                        </div>

                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>
        <!-- END wrapper -->






        <!-- Right Sidebar -->
        <div class="end-bar">

            <div class="rightbar-title">
                <a href="javascript:void(0);" class="end-bar-toggle float-end">
                    <i class="dripicons-cross noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <div class="rightbar-content h-100" data-simplebar="">

                <div class="p-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                    </div>

                    <!-- Settings -->
                    <h5 class="mt-3">Color Scheme</h5>
                    <hr class="mt-1">

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="light" id="light-mode-check" checked="">
                        <label class="form-check-label" for="light-mode-check">Light Mode</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="dark" id="dark-mode-check">
                        <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                    </div>


                    <!-- Width -->
                    <h5 class="mt-4">Width</h5>
                    <hr class="mt-1">
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="width" value="fluid" id="fluid-check" checked="">
                        <label class="form-check-label" for="fluid-check">Fluid</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="width" value="boxed" id="boxed-check">
                        <label class="form-check-label" for="boxed-check">Boxed</label>
                    </div>


                    <!-- Left Sidebar-->
                    <h5 class="mt-4">Left Sidebar</h5>
                    <hr class="mt-1">
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="theme" value="default" id="default-check">
                        <label class="form-check-label" for="default-check">Default</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="theme" value="light" id="light-check" checked="">
                        <label class="form-check-label" for="light-check">Light</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="theme" value="dark" id="dark-check">
                        <label class="form-check-label" for="dark-check">Dark</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="fixed" id="fixed-check" checked="">
                        <label class="form-check-label" for="fixed-check">Fixed</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="condensed" id="condensed-check">
                        <label class="form-check-label" for="condensed-check">Condensed</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="scrollable" id="scrollable-check">
                        <label class="form-check-label" for="scrollable-check">Scrollable</label>
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
                    </div>
                </div> <!-- end padding-->

            </div>
        </div>

        <div class="rightbar-overlay"></div>
        <!-- /End-bar -->


        <!-- bundle -->
        
        <script src="../assets/js/app.min.js"></script>

        <!-- third party js -->
        <script src="../assets/js/vendor/apexcharts.min.js"></script>
        <script src="../assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="../assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
        <!-- third party js ends -->

        <!-- demo app -->
        <script src="../assets/js/pages/demo.dashboard.js"></script>
        <!-- end demo js-->








        <!-- third party js -->


        <script src="../assets/js/vendor/jquery.dataTables.min.js"></script>
        <script src="../assets/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="../assets/js/vendor/dataTables.responsive.min.js"></script>
        <script src="../assets/js/vendor/responsive.bootstrap5.min.js"></script>
        <script src="../assets/js/vendor/dataTables.buttons.min.js"></script>
        <script src="../assets/js/vendor/buttons.bootstrap5.min.js"></script>
        <script src="../assets/js/vendor/buttons.html5.min.js"></script>
        <script src="../assets/js/vendor/buttons.flash.min.js"></script>
        <script src="../assets/js/vendor/buttons.print.min.js"></script>
        <script src="../assets/js/vendor/dataTables.keyTable.min.js"></script>
        <script src="../assets/js/vendor/dataTables.select.min.js"></script>
        <!-- third party js ends -->

        <!-- jQuery 
        <script src='https://code.jquery.com/jquery-3.7.0.js'></script> -->

        <!-- Data Table JS -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- App css -->















        <!-- demo app -->
        <script src="../assets/js/pages/demo.datatable-init.js"></script>

        <!-- end demo js-->


    
<script>
document.addEventListener('DOMContentLoaded', function(){
    var current = new URLSearchParams(window.location.search).get('page') || '';
    if (!current) return;
    document.querySelectorAll('.side-nav a[href*="page="]').forEach(function(a){
        var href = a.getAttribute('href') || '';
        if (href.indexOf('page=' + current) !== -1) {
            a.classList.add('active');
            var parent = a.closest('.collapse');
            while (parent) {
                parent.classList.add('show');
                var trigger = document.querySelector('[href="#' + parent.id + '"]');
                if (trigger) {
                    trigger.classList.add('active');
                    trigger.setAttribute('aria-expanded','true');
                }
                parent = parent.parentElement ? parent.parentElement.closest('.collapse') : null;
            }
        }
    });
});
</script>



<!-- OAI MODERN SIDEBAR UI - hanya CSS/JS, struktur menu tetap -->
<style id="oaiModernSidebarStyle">
:root{
    --oai-side-bg-1:#ffffff;
    --oai-side-bg-2:#f8fafc;
    --oai-side-line:#e5e7eb;
    --oai-side-text:#1f2937;
    --oai-side-muted:#64748b;
    --oai-side-hover:#eef4ff;
    --oai-side-active:#f0f6ff;
    --oai-side-active-line:#2563eb;
    --oai-side-shadow:0 14px 38px rgba(15,23,42,.10);
}

body.oai-modern-sidebar .leftside-menu{
    background:linear-gradient(180deg,var(--oai-side-bg-1),var(--oai-side-bg-2)) !important;
    box-shadow:var(--oai-side-shadow) !important;
    border-right:1px solid var(--oai-side-line) !important;
}
body.oai-modern-sidebar .leftside-menu .logo,
body.oai-modern-sidebar .leftside-menu .logo-light,
body.oai-modern-sidebar .leftside-menu .logo-dark{
    background:#ffffff !important;
    border-bottom:1px solid var(--oai-side-line) !important;
    backdrop-filter:none;
    -webkit-backdrop-filter:none;
}
body.oai-modern-sidebar #leftside-menu-container{
    padding:10px 10px 14px 10px !important;
    background:#ffffff !important;
}
body.oai-modern-sidebar .side-nav{
    padding-left:0 !important;
    padding-right:0 !important;
}
body.oai-modern-sidebar .side-nav-title{
    color:#64748b !important;
    letter-spacing:.08em !important;
    text-transform:uppercase !important;
    font-size:11px !important;
    font-weight:800 !important;
    padding:16px 12px 8px 12px !important;
    opacity:1;
}
body.oai-modern-sidebar .side-nav-title a{
    color:#334155 !important;
    font-size:12px !important;
    font-weight:800 !important;
}
body.oai-modern-sidebar .side-nav .side-nav-item{
    margin:3px 0 !important;
}
body.oai-modern-sidebar .side-nav-link,
body.oai-modern-sidebar .side-nav-second-level a,
body.oai-modern-sidebar .side-nav-third-level a,
body.oai-modern-sidebar .side-nav-forth-level a{
    color:var(--oai-side-text) !important;
    border-radius:10px !important;
    transition:background .16s ease, color .16s ease !important;
    position:relative;
}
body.oai-modern-sidebar .side-nav-link{
    min-height:42px !important;
    padding:10px 12px !important;
    margin:2px 0 !important;
}
body.oai-modern-sidebar .side-nav-link i{
    color:#2563eb !important;
    font-size:18px !important;
    margin-right:8px !important;
}
body.oai-modern-sidebar .side-nav-link span{
    color:var(--oai-side-text) !important;
    font-size:15px !important;
    font-weight:700 !important;
}
body.oai-modern-sidebar .side-nav-second-level,
body.oai-modern-sidebar .side-nav-third-level,
body.oai-modern-sidebar .side-nav-forth-level{
    margin:3px 0 6px 0 !important;
    padding-left:10px !important;
    border-left:1px solid #dbe4f0 !important;
}
body.oai-modern-sidebar .side-nav-second-level a,
body.oai-modern-sidebar .side-nav-third-level a,
body.oai-modern-sidebar .side-nav-forth-level a{
    display:block !important;
    padding:8px 10px !important;
    margin:2px 0 !important;
    font-size:13.5px !important;
    line-height:1.35 !important;
    color:#334155 !important;
}
body.oai-modern-sidebar .side-nav a p{
    color:inherit !important;
    font-size:13.5px !important;
    line-height:1.35 !important;
}
body.oai-modern-sidebar .side-nav-link:hover,
body.oai-modern-sidebar .side-nav-second-level a:hover,
body.oai-modern-sidebar .side-nav-third-level a:hover,
body.oai-modern-sidebar .side-nav-forth-level a:hover{
    background:var(--oai-side-hover) !important;
    transform:translateX(3px);
    color:#0f172a !important;
}
body.oai-modern-sidebar .side-nav-link:hover span,
body.oai-modern-sidebar .side-nav-link:hover i{
    color:#1d4ed8 !important;
}
body.oai-modern-sidebar .side-nav-link[aria-expanded="true"],
body.oai-modern-sidebar .side-nav-link.oai-open-parent,
body.oai-modern-sidebar .side-nav a.oai-active-menu{
    background:var(--oai-side-active) !important;
    color:#0f172a !important;
    box-shadow:none !important;
}
body.oai-modern-sidebar .side-nav-link[aria-expanded="true"] span,
body.oai-modern-sidebar .side-nav-link.oai-open-parent span,
body.oai-modern-sidebar .side-nav a.oai-active-menu,
body.oai-modern-sidebar .side-nav a.oai-active-menu p{
    color:#0f172a !important;
    font-weight:700 !important;
}
body.oai-modern-sidebar .side-nav a.oai-active-menu{
    background:#edf5ff !important;
    border-left:0 !important;
    border-radius:10px !important;
    color:#1746a2 !important;
    font-weight:700 !important;
}
body.oai-modern-sidebar .side-nav a.oai-active-menu::after{
    display:none !important;
}
body.oai-modern-sidebar .menu-arrow{
    transition:transform .18s ease !important;
    color:#64748b !important;
}
body.oai-modern-sidebar a[aria-expanded="true"] .menu-arrow,
body.oai-modern-sidebar .side-nav-link[aria-expanded="true"] .menu-arrow{
    transform:rotate(90deg) !important;
    color:#2563eb !important;
}
body.oai-modern-sidebar .side-nav .badge,
body.oai-modern-sidebar .side-nav .badge-light-lighten,
body.oai-modern-sidebar .side-nav .badge-danger-lighten,
body.oai-modern-sidebar .side-nav .badge-success-lighten,
body.oai-modern-sidebar .side-nav .badge-info-lighten,
body.oai-modern-sidebar .side-nav .badge-warning-lighten,
body.oai-modern-sidebar .side-nav .badge-primary-lighten{
    border:1px solid rgba(15,23,42,.12) !important;
    box-shadow:0 3px 10px rgba(15,23,42,.08) !important;
    padding:5px 10px !important;
    color:#111827 !important;
}
body.oai-modern-sidebar .oai-sidebar-tools{
    padding:10px 2px 10px 2px;
    position:sticky;
    top:0;
    background:linear-gradient(180deg,#ffffff,#f8fafc);
    z-index:5;
    border-bottom:1px solid #e5e7eb;
    margin-bottom:6px;
}
body.oai-modern-sidebar .oai-sidebar-search-wrap{
    position:relative;
}
body.oai-modern-sidebar .oai-sidebar-search-wrap i{
    position:absolute;
    left:12px;
    top:50%;
    transform:translateY(-50%);
    color:#64748b;
    font-size:15px;
}
body.oai-modern-sidebar #oaiSidebarSearch{
    width:100%;
    height:36px;
    border:1px solid #d8e1ee;
    border-radius:12px;
    background:#f8fafc;
    color:#111827;
    outline:none;
    padding:7px 12px 7px 35px;
    font-size:13px;
}
body.oai-modern-sidebar #oaiSidebarSearch:focus{
    border-color:#93c5fd;
    background:#ffffff;
    box-shadow:0 0 0 3px rgba(37,99,235,.10);
}
body.oai-modern-sidebar #oaiSidebarSearch::placeholder{
    color:#94a3b8;
}
body.oai-modern-sidebar .oai-sidebar-empty{
    color:#64748b;
    padding:12px;
    font-size:13px;
    display:none;
}
body.oai-modern-sidebar .oai-sidebar-empty.show{
    display:block;
}
body.oai-modern-sidebar .oai-highlight-menu{
    outline:1px solid rgba(37,99,235,.35);
    background:#eaf2ff !important;
}
body.oai-modern-sidebar .simplebar-content-wrapper{
    scroll-behavior:smooth;
}
@media (max-width: 991.98px){
    body.oai-modern-sidebar .leftside-menu{
        box-shadow:0 20px 45px rgba(15,23,42,.16) !important;
    }
}
</style>

<script id="oaiModernSidebarScript">
(function(){
    function ready(fn){
        if(document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }
    ready(function(){
        document.body.classList.add('oai-modern-sidebar');

        var container = document.getElementById('leftside-menu-container');
        var sideNav = container ? container.querySelector('.side-nav') : null;
        if(!container || !sideNav) return;

        if(!document.getElementById('oaiSidebarSearch')){
            var tools = document.createElement('div');
            tools.className = 'oai-sidebar-tools';
            tools.innerHTML = '<div class="oai-sidebar-search-wrap"><i class="mdi mdi-magnify"></i><input type="text" id="oaiSidebarSearch" autocomplete="off" placeholder="Cari menu..."></div><div class="oai-sidebar-empty" id="oaiSidebarEmpty">Menu tidak ditemukan</div>';
            sideNav.parentNode.insertBefore(tools, sideNav);
        }

        var currentUrl = window.location.href;
        var currentPage = window.simproRoutePage ? window.simproRoutePage() : (new URLSearchParams(window.location.search).get('page') || '');
        var activeLink = null;
        var links = Array.prototype.slice.call(sideNav.querySelectorAll('a[href]'));

        links.forEach(function(a){
            var href = a.getAttribute('href') || '';
            if(!href || href.charAt(0) === '#' || /^javascript:/i.test(href)) return;
            try{
                var u = new URL(href, document.baseURI);
                if(u.origin !== window.location.origin || u.pathname.indexOf(window.simproRouteConfig.roleBase) !== 0) return;
                var p = window.simproRoutePage ? window.simproRoutePage(u.href) : (u.searchParams.get('page') || '');
                if(currentPage && p === currentPage && !activeLink){
                    activeLink = a;
                }else if(!currentPage && currentUrl.indexOf(href) !== -1 && !activeLink){
                    activeLink = a;
                }
            }catch(e){}
        });

        if(activeLink){
            activeLink.classList.add('oai-active-menu');
            activeLink.setAttribute('aria-current', 'page');
            var parent = activeLink.parentElement;
            while(parent && parent !== sideNav){
                if(parent.classList && parent.classList.contains('collapse')){
                    parent.classList.add('show');
                    var id = parent.getAttribute('id');
                    if(id){
                        var trigger = sideNav.querySelector('a[href="#'+id+'"]');
                        if(trigger){
                            trigger.setAttribute('aria-expanded','true');
                            trigger.classList.add('oai-open-parent');
                        }
                    }
                }
                parent = parent.parentElement;
            }
            setTimeout(function(){
                try{ activeLink.scrollIntoView({block:'center', behavior:'smooth'}); }catch(e){}
            }, 250);
        }

        // Simpan menu collapse yang dibuka user agar tetap rapi setelah reload.
        sideNav.querySelectorAll('a[data-bs-toggle="collapse"][href^="#"]').forEach(function(trigger){
            var targetId = trigger.getAttribute('href');
            var target = targetId ? document.querySelector(targetId) : null;
            if(!target) return;
            var key = 'oai_sidebar_open_' + targetId.replace('#','');
            if(localStorage.getItem(key) === '1'){
                target.classList.add('show');
                trigger.setAttribute('aria-expanded','true');
            }
            target.addEventListener('shown.bs.collapse', function(){ localStorage.setItem(key,'1'); });
            target.addEventListener('hidden.bs.collapse', function(){ localStorage.removeItem(key); });
        });

        var search = document.getElementById('oaiSidebarSearch');
        var empty = document.getElementById('oaiSidebarEmpty');
        if(search){
            search.addEventListener('input', function(){
                var q = (this.value || '').toLowerCase().trim();
                var shown = 0;
                var allItems = Array.prototype.slice.call(sideNav.querySelectorAll('li.side-nav-item, li:not(.side-nav-title)'));

                if(!q){
                    allItems.forEach(function(li){ li.style.display = ''; });
                    sideNav.querySelectorAll('.oai-highlight-menu').forEach(function(el){ el.classList.remove('oai-highlight-menu'); });
                    if(empty) empty.classList.remove('show');
                    return;
                }

                allItems.forEach(function(li){ li.style.display = 'none'; });
                sideNav.querySelectorAll('.oai-highlight-menu').forEach(function(el){ el.classList.remove('oai-highlight-menu'); });

                links.forEach(function(a){
                    var text = (a.innerText || a.textContent || '').toLowerCase();
                    if(text.indexOf(q) !== -1){
                        shown++;
                        a.classList.add('oai-highlight-menu');
                        var li = a.closest('li');
                        if(li) li.style.display = '';
                        var parent = a.parentElement;
                        while(parent && parent !== sideNav){
                            if(parent.tagName === 'LI') parent.style.display = '';
                            if(parent.classList && parent.classList.contains('collapse')){
                                parent.classList.add('show');
                                var id = parent.getAttribute('id');
                                if(id){
                                    var trigger = sideNav.querySelector('a[href="#'+id+'"]');
                                    if(trigger){
                                        trigger.setAttribute('aria-expanded','true');
                                        var tri = trigger.closest('li');
                                        if(tri) tri.style.display = '';
                                    }
                                }
                            }
                            parent = parent.parentElement;
                        }
                    }
                });
                if(empty) empty.classList.toggle('show', shown === 0);
            });
        }
    });
})();
</script>


<!-- OAI FIX PILL SIDEBAR - samakan bentuk pill risiko seperti screenshot -->
<style id="oaiSidebarPillFixStyle">
body.oai-modern-sidebar .side-nav .oai-pill-link,
body.oai-modern-sidebar .side-nav .oai-risk-parent-link{
    background:transparent !important;
    box-shadow:none !important;
    border-radius:0 !important;
    transform:none !important;
}

body.oai-modern-sidebar .side-nav .oai-risk-parent-link{
    display:flex !important;
    align-items:center !important;
    justify-content:space-between !important;
    gap:8px !important;
    padding:7px 10px 7px 8px !important;
    margin:5px 0 4px 0 !important;
    min-height:unset !important;
}

body.oai-modern-sidebar .side-nav .oai-pill-link{
    display:inline-flex !important;
    width:auto !important;
    max-width:100% !important;
    padding:6px 8px !important;
    margin:5px 0 !important;
}

body.oai-modern-sidebar .side-nav .oai-risk-parent-link:hover,
body.oai-modern-sidebar .side-nav .oai-pill-link:hover{
    background:transparent !important;
    transform:none !important;
}

body.oai-modern-sidebar .side-nav .oai-risk-parent-link .badge,
body.oai-modern-sidebar .side-nav .oai-pill-link .badge{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    width:auto !important;
    max-width:185px !important;
    min-width:0 !important;
    border-radius:999px !important;
    padding:8px 16px !important;
    line-height:1 !important;
    border:1px solid rgba(15,23,42,.10) !important;
    box-shadow:0 6px 13px rgba(15,23,42,.12) !important;
    white-space:nowrap !important;
}

body.oai-modern-sidebar .side-nav .oai-risk-parent-link .badge p,
body.oai-modern-sidebar .side-nav .oai-pill-link .badge p,
body.oai-modern-sidebar .side-nav .oai-risk-parent-link .badge h5,
body.oai-modern-sidebar .side-nav .oai-pill-link .badge h5{
    margin:0 !important;
    padding:0 !important;
    font-size:13.5px !important;
    font-weight:700 !important;
    line-height:1.15 !important;
    color:#111827 !important;
}

body.oai-modern-sidebar .side-nav .oai-risk-parent-link .menu-arrow{
    margin-left:auto !important;
    color:#2563eb !important;
    flex:0 0 auto !important;
}

body.oai-modern-sidebar .side-nav-third-level > li.side-nav-item > div.collapse > ul.side-nav-forth-level,
body.oai-modern-sidebar .side-nav-forth-level > li.side-nav-item > div.collapse > ul.side-nav-forth-level{
    margin:2px 0 8px 18px !important;
    padding-left:13px !important;
    border-left:1px solid #d8e3f2 !important;
}

body.oai-modern-sidebar .side-nav-forth-level .oai-pill-link{
    padding-left:0 !important;
}

body.oai-modern-sidebar .side-nav .oai-pill-link.oai-active-menu::after{
    display:none !important;
}

body.oai-modern-sidebar .side-nav .oai-pill-link.oai-active-menu .badge,
body.oai-modern-sidebar .side-nav .oai-risk-parent-link.oai-open-parent .badge,
body.oai-modern-sidebar .side-nav .oai-risk-parent-link[aria-expanded="true"] .badge{
    outline:2px solid rgba(37,99,235,.16) !important;
    box-shadow:0 7px 16px rgba(15,23,42,.14) !important;
}

/* warna pill dibuat sama dan lebih lembut seperti contoh */
body.oai-modern-sidebar .side-nav .badge-success-lighten{background:#aef2c1 !important;color:#111827 !important;}
body.oai-modern-sidebar .side-nav .badge-primary-lighten{background:#bfcaff !important;color:#111827 !important;}
body.oai-modern-sidebar .side-nav .badge-warning-lighten{background:#ffe070 !important;color:#111827 !important;}
body.oai-modern-sidebar .side-nav .badge-danger-lighten{background:#ffb7b7 !important;color:#111827 !important;}
body.oai-modern-sidebar .side-nav .badge-info-lighten{background:#abe0ff !important;color:#111827 !important;}
body.oai-modern-sidebar .side-nav .badge-light-lighten{background:#e5e9ef !important;color:#111827 !important;}


/* =========================================================
   IMPLEMENTASI FONT SEPERTI SCRIPT KEDUA
   - Ukuran font dibuat pas seperti contoh screenshot
   - Tulisan abu-abu dipaksa hitam biasa
   - Tidak mengubah routing/sidebar/menu lain
========================================================= */
.text-muted,
.text-secondary,
.text-body-secondary,
.page-title-right,
.breadcrumb,
.breadcrumb-item,
.breadcrumb-item a,
.card p,
.card span,
.card label,
.table td,
.table th,
.side-nav-title,
.side-nav-title a,
.side-nav-link span,
.side-nav-second-level a,
.side-nav-third-level a,
.side-nav-forth-level a,
.account-user-name,
.account-position{
    color:#000000 !important;
}

body{
    zoom:0.72 !important;
    font-family:'Poppins', Arial, Helvetica, sans-serif !important;
    font-size:14px !important;
    color:#000000 !important;
}

.content-page,
.page-wrapper,
.page-content,
.container-fluid,
.card,
.card-body,
.table,
.form-control,
.form-select,
.btn,
.dropdown-menu,
.modal-content{
    font-size:14px !important;
}

.page-title,
.page-title-box h4,
.card-header h4,
.header-title{
    font-size:18px !important;
    font-weight:700 !important;
    color:#000000 !important;
}

.breadcrumb,
.breadcrumb-item,
.page-title-right{
    font-size:13px !important;
    color:#000000 !important;
}

.navbar-custom{
    min-height:68px !important;
}

.navbar-custom .button-menu-mobile{
    font-size:21px !important;
}

.account-user-name{
    font-size:13px !important;
    font-weight:700 !important;
    color:#000000 !important;
}

.account-position{
    font-size:12px !important;
    color:#000000 !important;
}

.btn{
    font-size:13px !important;
    font-weight:600 !important;
    padding:8px 14px !important;
    border-radius:8px !important;
}

.form-control,
.form-select,
textarea,
input,
select{
    font-size:13px !important;
    min-height:40px;
    color:#000000 !important;
}

.table th,
.table td,
table th,
table td{
    font-size:13px !important;
    vertical-align:middle !important;
    color:#000000 !important;
}

.dataTables_wrapper,
.dataTables_wrapper label,
.dataTables_wrapper input,
.dataTables_wrapper select,
.dataTables_info,
.dataTables_paginate{
    font-size:13px !important;
    color:#000000 !important;
}

.side-nav-link span{
    font-size:14px !important;
    font-weight:600 !important;
}

.side-nav-link i{
    font-size:17px !important;
}

.side-nav-title,
.side-nav-title a{
    font-size:13px !important;
    font-weight:800 !important;
    letter-spacing:.4px;
    color:#000000 !important;
}

.side-nav-second-level a,
.side-nav-third-level a,
.side-nav-forth-level a{
    font-size:13px !important;
    line-height:1.45 !important;
    color:#000000 !important;
}

.side-nav a p,
.side-nav p.font-15{
    font-size:13px !important;
    line-height:1.45 !important;
    margin:0 !important;
    color:#000000 !important;
}

.side-nav .badge{
    font-size:13px !important;
    padding:6px 12px !important;
    border-radius:999px !important;
}

.side-nav .badge p,
.side-nav .badge h5{
    font-size:13px !important;
    color:#000000 !important;
}

.modal-title{
    font-size:18px !important;
    font-weight:700 !important;
}

.modal-body{
    font-size:13px !important;
}

.card h4,
.card h5,
.card p,
.card span,
.card label{
    font-size:14px;
    color:#000000;
}

.content-page{
    padding-left:4px !important;
}

/* Print jangan kena zoom */
@media print{
    body{
        zoom:1 !important;
        font-size:12px !important;
    }
    .btn,
    .navbar-custom,
    .leftside-menu{
        display:none !important;
    }
}
</style>

<script id="oaiSidebarPillFixScript">
document.addEventListener('DOMContentLoaded', function(){
    var sideNav = document.querySelector('.side-nav');
    if(!sideNav) return;

    sideNav.querySelectorAll('a').forEach(function(a){
        if(a.querySelector('.badge')){
            a.classList.add('oai-pill-link');
            if(a.getAttribute('data-bs-toggle') === 'collapse'){
                a.classList.add('oai-risk-parent-link');
            }
        }
    });
});
</script>

</body>

</html>