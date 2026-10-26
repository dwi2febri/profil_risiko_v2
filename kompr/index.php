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
if ($cek != "admin") {
    header("Location: ../login.php");
    exit();
}

?>

<?php
include "../conn/conn.php";
$user_id = $_SESSION['user_id'];
$data_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'"));


$id = $_GET['id'];
$get_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko = '$id'"));

date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profil Risiko BKK Jateng</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/11.png">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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

                <!-- LOGO -->
                <a href="#" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="../assets/images/SIMPRO_2gd.png" alt="" height="60">
                    </span>
                    <span class="logo-sm">
                        <img src="../assets/images/SIMPRO_2.png" alt="" height="50">
                    </span>
                </a>

                <div class="h-100" id="leftside-menu-container" data-simplebar="">

                    <!--- Sidemenu -->
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
                                    <li>
                                        <a href="index.php?page=dashboard">Rekapitulasi Laporan</a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=rekap_cbg">Rekap per korwil</a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=hasil_lapkc">Hasil laporan KC</a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=menulapawal&id=<?= $get_data['id_profil_risiko'] ?>">Laporan Profil Risiko</a>
                                    </li>

                                </ul>
                            </div>
                        </li>






                       

                        <li class="side-nav-title side-nav-item"> <a href="#">Data Pembanding</a></li>

                        <li class="side-nav-item a">
                            <a href="index.php?page=pembanding&id=<?= $get_data['id_profil_risiko'] ?>" class="side-nav-link">
                                <i class=" uil-copy"></i>
                                <span>Pilih data pembanding</span>
                            </a>
                        </li>


                        <li class="side-nav-title side-nav-item"> <a href="#">Data Master</a></li>



                        <li class="side-nav-item">
                            <a href="index.php?page=maskre&id=<?= $get_data['id_profil_risiko'] ?>" class="side-nav-link">
                                <i class=" uil-server"></i>
                                <span> Data Master Kredit </span>
                            </a>
                        </li>

                        <li class="side-nav-item a">
                            <a href="index.php?page=maslik&id=<?= $get_data['id_profil_risiko'] ?>" class="side-nav-link">
                                <i class=" uil-server"></i>
                                <span> Data Master Likuiditas </span>
                            </a>
                        </li>



                        <li class="side-nav-title side-nav-item"> <a href="#">Profil Risiko</a></li>

                        <li class="side-nav-item a">
                            <a href="index.php?page=progress&id=<?= $get_data['id_profil_risiko'] ?>" class="side-nav-link">
                                <i class=" uil-analytics"></i>
                                <span>Progress Pengerjaan</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarkre" aria-expanded="false" aria-controls="sidebarkre" class="side-nav-link">
                                <i class="uil-box"></i>
                                <span class="badge badge-success-lighten">
                                    <h5> Risiko Kredit </h5>
                                </span>
                                <span class="menu-arrow"></span>
                            </a>







                            <div class="collapse" id="sidebarkre">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="index.php?page=kre_inhern&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-success-lighten">
                                                <h5>Risiko Inhern</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=kre_kpmr1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-success-lighten">
                                                <h5>KPMR 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=kre_kpmr2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-success-lighten">
                                                <h5>KPMR 2
                                            </span></h5></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=kre_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-success-lighten">
                                                <h5>Kredit Profil</h5>
                                            </span></a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarop" aria-expanded="false" aria-controls="sidebarop" class="side-nav-link">
                                <i class="uil-box"></i>
                                <span class="badge badge-primary-lighten">
                                    <h5>Risiko Operasional</h5>
                                </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarop">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="index.php?page=op_inhern1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-primary-lighten">
                                                <h5>Risiko Inhern 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=op_inhern2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-primary-lighten">
                                                <h5>Risiko Inhern 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=op_kpmr1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-primary-lighten">
                                                <h5>KPMR 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=op_kpmr2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-primary-lighten">
                                                <h5>KPMR 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=op_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-primary-lighten">
                                                <h5>Operasional Profil</h5>
                                            </span></a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarkep" aria-expanded="false" aria-controls="sidebarkep" class="side-nav-link">
                                <i class="uil-box"></i>
                                <span class="badge badge-warning-lighten">
                                    <h5>Risiko Kepatuhan</h5>
                                </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarkep">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="index.php?page=kep_inhern1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-warning-lighten">
                                                <h5>Risiko Inhern 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=kep_inhern2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-warning-lighten">
                                                <h5>Risiko Inhern 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=kep_kpmr1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-warning-lighten">
                                                <h5>KPMR 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=kep_kpmr2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-warning-lighten">
                                                <h5>KPMR 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=kep_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-warning-lighten">
                                                <h5>Kepatuhan Profil</h5>
                                            </span></a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarlik" aria-expanded="false" aria-controls="sidebarlik" class="side-nav-link">
                                <i class="uil-box"></i>
                                <span class="badge badge-danger-lighten">
                                    <h5>Risiko Likuiditas</h5>
                                </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarlik">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="index.php?page=lik_inhern&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-danger-lighten">
                                                <h5>Risiko Inhern</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=lik_kpmr1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-danger-lighten">
                                                <h5>KPMR 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=lik_kpmr2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-danger-lighten">
                                                <h5>KPMR 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=lik_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-danger-lighten">
                                        <h5>Likuiditas Profil</h5></span></a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarrep" aria-expanded="false" aria-controls="sidebarrep" class="side-nav-link">
                                <i class="uil-box"></i>
                                <span class="badge badge-info-lighten">
                                    <h5>Risiko Reputasi</h5>
                                </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarrep">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="index.php?page=rep_inhern1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-info-lighten">
                                                <h5>Risiko Inhern 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=rep_inhern2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-info-lighten">
                                                <h5>Risiko Inhern 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=rep_kpmr1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-info-lighten">
                                                <h5>KPMR 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=rep_kpmr2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-info-lighten">
                                                <h5>KPMR 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=rep_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-info-lighten">
                                                <h5>Reputasi Profil</h5>
                                            </span></a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarstra" aria-expanded="false" aria-controls="sidebarstra" class="side-nav-link">
                                <i class="uil-box"></i>
                                <span class="badge badge-light-lighten">
                                    <h5>Risiko Stratejik</h5>
                                </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarstra">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="index.php?page=stra_inhern1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-light-lighten">
                                                <h5>Risiko Inhern 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=stra_inhern2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-light-lighten">
                                                <h5>Risiko Inhern 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=stra_kpmr1&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-light-lighten">
                                                <h5>KPMR 1</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=stra_kpmr2&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-light-lighten">
                                                <h5>KPMR 2</h5>
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="index.php?page=stra_profil&id=<?= $get_data['id_profil_risiko'] ?>"><span class="badge badge-light-lighten">
                                                <h5>Stratejik Profil</h5>
                                            </span></a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-title side-nav-item"> <a href="#">Nilai Dan Peringkat</a></li>



                        <li class="side-nav-item">
                            <a href="index.php?page=nilpro&id=<?= $get_data['id_profil_risiko'] ?>" class="side-nav-link">
                                <i class="uil-presentation-plus"></i>
                                <span> Profil Nilai </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="index.php?page=perpro&id=<?= $get_data['id_profil_risiko'] ?>"" class="side-nav-link">
                                <i class="uil-presentation-edit"></i>
                                <span> Profil Peringkat </span>
                            </a>
                        </li>


                        <li class="side-nav-title side-nav-item"> <a href="#">Menu User</a></li>



                        <li class="side-nav-item">
                            <a href="index.php?page=profile" class="side-nav-link">
                                <i class="uil-user"></i>
                                <span> Info User </span>
                            </a>
                        </li>

                        
                        <!-- end Help Box -->
                        <!-- End Sidebar -->

                        <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

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

                                case 'konfirm':
                                    include "laporan/konfirmasi.php";
                                    break;

                            case 'menulapawal':
                                include "laporan/menu_laporan_awal.php";
                                break;

                            case 'hasil_lapkc':
                                include "laporan/hasil_laporan_cabang.php";
                                break;
    
                            case 'laporan_masuk':
                                include "laporan/laporan_proris.php";
                                break;
                            
                            case 'rekap_cbg':
                                include "laporan/rekap_cabang.php";
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
        <script src="../assets/js/vendor.min.js"></script>
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















        <!-- demo app -->
        <script src="../assets/js/pages/demo.datatable-init.js"></script>

        <!-- end demo js-->


    </body>

</html>