<?php
/* =========================================================
   PROSES LOGIN DI ATAS HTML
   Supaya header redirect aman dan login tetap jalan
========================================================= */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "conn/conn.php";

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    $cek_user = $query ? mysqli_num_rows($query) : 0;

    if ($cek_user > 0) {
        $data = mysqli_fetch_array($query);

        $_SESSION['username'] = $data['username'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['lokasi_kerja'] = $data['lokasi_kerja'];
        $_SESSION['tipe'] = $data['tipe'];

        if ($data['tipe'] == "admin") {
            header("location:admin/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala cabang") {
            header("location:kepala_cabang/index.php");
            exit();
        } elseif ($data['tipe'] == "admin kc") {
            header("location:admin_kc/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala wilayah semarang") {
            header("location:kepala_wilayah_semarang/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala wilayah solo") {
            header("location:kepala_wilayah_solo/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala wilayah banyumas") {
            header("location:kepala_wilayah_banyumas/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala wilayah pekalongan") {
            header("location:kepala_wilayah_pekalongan/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala divisi pemasaran") {
            header("location:kadiv_pemasaran/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala divisi penyelesaian kredit") {
            header("location:kadiv_penyelesaian_kredit/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala divisi operasional") {
            header("location:kadiv_operasional/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala divisi sdm") {
            header("location:kadiv_sdm/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala divisi kepatuhan") {
            header("location:kadiv_kepatuhan/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala divisi sekper") {
            header("location:kadiv_sekper/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala divisi litbang") {
            header("location:kadiv_litbang/index.php");
            exit();
        } elseif ($data['tipe'] == "kepala divisi skai") {
            header("location:satker_skai/index.php");
            exit();
        } elseif ($data['tipe'] == "direksi") {
            header("location:direksi/index.php");
            exit();
        } elseif ($data['tipe'] == "pic semarang") {
            header("location:pic_area_semarang/index.php");
            exit();
        } elseif ($data['tipe'] == "pic solo") {
            header("location:pic_area_solo/index.php");
            exit();
        } elseif ($data['tipe'] == "pic pekalongan") {
            header("location:pic_area_pekalongan/index.php");
            exit();
        } elseif ($data['tipe'] == "pic banyumas") {
            header("location:pic_area_banyumas/index.php");
            exit();
        }
    } else {
        header("location:index.php?alert=gagal");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | Profil Risiko BKK Jateng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Sistem Informasi Profil Risiko PT BPR BKK Jateng" name="description" />
    <meta name="theme-color" content="#0b3b78" />
    <link rel="shortcut icon" href="assets/images/11.png">

    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<style>
    :root{
        --login-primary:#1559b7;
        --login-primary-2:#0a3572;
        --login-accent:#ffb229;
        --login-text:#14213d;
        --login-muted:#69758c;
        --login-border:#e5eaf2;
    }

    *{box-sizing:border-box;}

    body{
        font-family:'Poppins',sans-serif !important;
        min-height:100vh;
        background-image:
            linear-gradient(115deg, rgba(3,20,44,.88), rgba(12,61,124,.61), rgba(255,255,255,.12)),
            url('assets/images/Kantor_blur3.jpg') !important;
        background-size:cover !important;
        background-repeat:no-repeat !important;
        background-position:center !important;
        overflow-x:hidden;
    }

    body::before{
        content:"";
        position:fixed;
        inset:0;
        pointer-events:none;
        background:
            radial-gradient(circle at 15% 10%, rgba(255,255,255,.24), transparent 28%),
            radial-gradient(circle at 85% 85%, rgba(245,165,36,.22), transparent 30%);
        z-index:0;
    }

    .modern-login-page{
        position:relative;
        z-index:1;
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:32px 24px 58px;
    }

    .login-shell{
        width:100%;
        max-width:1190px;
        display:grid;
        grid-template-columns:1.05fr .95fr;
        align-items:stretch;
        border-radius:30px;
        overflow:hidden;
        background:rgba(255,255,255,.14);
        border:1px solid rgba(255,255,255,.28);
        box-shadow:0 34px 100px rgba(2,15,36,.42);
        backdrop-filter:blur(16px);
        -webkit-backdrop-filter:blur(16px);
    }

    .login-info-panel{
        position:relative;
        padding:52px 50px;
        color:#fff;
        background:linear-gradient(145deg, rgba(14,58,122,.94), rgba(21,82,164,.78));
        display:flex;
        flex-direction:column;
        justify-content:space-between;
        min-height:680px;
        overflow:hidden;
    }

    .login-info-panel::after{
        content:"";
        position:absolute;
        right:-80px;
        bottom:-80px;
        width:230px;
        height:230px;
        border-radius:50%;
        background:rgba(245,165,36,.25);
    }

    .login-info-panel::before{
        content:"";
        position:absolute;
        width:340px;
        height:340px;
        left:-190px;
        top:145px;
        border:1px solid rgba(255,255,255,.13);
        border-radius:50%;
        box-shadow:0 0 0 58px rgba(255,255,255,.035), 0 0 0 116px rgba(255,255,255,.025);
    }

    .brand-mini{
        display:flex;
        align-items:center;
        gap:12px;
        position:relative;
        z-index:1;
    }

    .brand-icon{
        width:52px;
        height:52px;
        border-radius:16px;
        background:rgba(255,255,255,.18);
        display:flex;
        align-items:center;
        justify-content:center;
        border:1px solid rgba(255,255,255,.24);
    }

    .brand-icon i{font-size:24px;color:#fff;}
    .brand-mini strong{display:block;font-size:18px;letter-spacing:.2px;}
    .brand-mini span{display:block;font-size:12px;color:rgba(255,255,255,.78);margin-top:1px;}

    .login-info-main{
        position:relative;
        z-index:1;
        margin:48px 0 38px;
    }

    .login-chip{
        display:inline-flex;
        align-items:center;
        gap:7px;
        padding:8px 12px;
        border-radius:999px;
        background:rgba(255,255,255,.15);
        border:1px solid rgba(255,255,255,.22);
        font-size:12px;
        font-weight:600;
        margin-bottom:18px;
    }

    .login-info-main h1{
        color:#fff;
        font-size:42px;
        line-height:1.18;
        font-weight:800;
        margin:0 0 16px;
        letter-spacing:-.6px;
    }

    .login-info-main p{
        color:rgba(255,255,255,.82);
        font-size:15px;
        line-height:1.75;
        margin:0;
        max-width:510px;
    }

    .login-feature-list{
        position:relative;
        z-index:1;
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:12px;
        margin-top:30px;
    }

    .login-feature{
        display:flex;
        align-items:center;
        gap:10px;
        padding:15px 16px;
        border-radius:16px;
        background:rgba(255,255,255,.12);
        border:1px solid rgba(255,255,255,.18);
        font-size:12px;
        color:rgba(255,255,255,.9);
    }

    .login-feature i{font-size:18px;color:#ffd166;}

    .login-card-panel{
        padding:48px 54px;
        background:linear-gradient(155deg, rgba(255,255,255,.99), rgba(246,249,254,.98));
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .modern-login-card{
        width:100%;
        max-width:450px;
        border:0 !important;
        box-shadow:none !important;
        background:transparent !important;
        margin:0 !important;
    }

    .modern-logo-box{
        text-align:center;
        background:#fff;
        border:1px solid var(--login-border);
        border-radius:20px;
        padding:10px 18px 8px;
        margin:0 auto 24px;
        max-width:330px;
        box-shadow:0 14px 35px rgba(15,45,90,.09);
    }

    .modern-logo-box img{
        max-width:100%;
        height:105px !important;
        object-fit:contain;
    }

    .modern-login-title{
        text-align:center;
        margin-bottom:23px;
    }

    .modern-login-title h4{
        color:var(--login-text) !important;
        font-size:29px;
        font-weight:800 !important;
        margin-bottom:6px;
    }

    .modern-login-title p{
        color:var(--login-muted) !important;
        font-size:13px;
        line-height:1.6;
        margin:0;
    }

    .modern-alert{
        border:0 !important;
        border-radius:16px !important;
        padding:12px 14px !important;
        font-size:13px;
        font-weight:600;
        box-shadow:0 10px 24px rgba(15,23,42,.08);
    }

    .form-label{
        color:#344054;
        font-weight:700;
        font-size:13px;
        margin-bottom:8px;
    }

    .modern-input-wrap{
        position:relative;
    }

    .modern-input-icon{
        position:absolute;
        left:15px;
        top:50%;
        transform:translateY(-50%);
        z-index:4;
        color:#98a2b3;
        font-size:18px;
        pointer-events:none;
    }

    .modern-login-card .form-control{
        height:54px;
        border-radius:14px !important;
        border:1px solid #d0d5dd !important;
        background:#fff !important;
        color:#111827 !important;
        font-size:14px;
        padding-left:44px;
        box-shadow:none !important;
        transition:.18s ease;
    }

    .modern-login-card .form-control:focus{
        border-color:var(--login-primary) !important;
        box-shadow:0 0 0 4px rgba(21,82,164,.12) !important;
    }

    .modern-login-card .input-group.input-group-merge{
        border:0 !important;
        box-shadow:none !important;
        display:flex;
        align-items:stretch;
    }

    .modern-login-card .input-group.input-group-merge .form-control{
        border-top-right-radius:0 !important;
        border-bottom-right-radius:0 !important;
        border-right:0 !important;
    }

    .modern-login-card .input-group-text{
        border-radius:0 14px 14px 0 !important;
        border:1px solid #d0d5dd !important;
        border-left:0 !important;
        background:#fff !important;
        cursor:pointer;
        min-width:54px;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#667085;
        transition:.18s ease;
    }

    .modern-login-card .input-group:focus-within .input-group-text{
        border-color:var(--login-primary) !important;
        box-shadow:0 0 0 4px rgba(21,82,164,.12) !important;
        box-shadow:none !important;
    }

    .btn-login-modern{
        width:100%;
        height:54px;
        border:0 !important;
        border-radius:14px !important;
        background:linear-gradient(135deg, var(--login-primary), var(--login-primary-2)) !important;
        color:#fff !important;
        font-size:15px;
        font-weight:800;
        letter-spacing:.2px;
        box-shadow:0 14px 28px rgba(21,82,164,.26);
        transition:.18s ease;
    }

    .btn-login-modern:hover{
        transform:translateY(-1px);
        box-shadow:0 18px 34px rgba(21,82,164,.34);
    }

    .btn-login-modern:focus{
        box-shadow:0 0 0 4px rgba(21,89,183,.18), 0 14px 28px rgba(21,82,164,.26) !important;
    }

    .forgot-box{
        margin-top:18px;
        padding:13px 14px;
        border-radius:16px;
        background:#f8fafc;
        border:1px solid #eef2f7;
        text-align:center;
        font-size:13px;
        color:#667085;
    }

    .forgot-box a{
        color:var(--login-primary) !important;
        text-decoration:none;
        font-weight:800;
    }

    .footer.footer-alt{
        position:absolute;
        left:0;
        right:0;
        bottom:8px;
        z-index:2;
        color:rgba(255,255,255,.78) !important;
        background:transparent !important;
        padding:0 12px;
        font-size:12px;
    }

    .footer.footer-alt a{
        color:rgba(255,255,255,.82) !important;
        text-shadow:0 1px 4px rgba(0,0,0,.35);
    }

    .login-security-note{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        color:#667085;
        font-size:12px;
        margin-top:16px;
    }

    .login-security-note i{color:#12b76a;font-size:16px;}

    @media (max-width: 991.98px){
        .modern-login-page{padding:22px 14px 64px;}
        .login-shell{grid-template-columns:1fr;max-width:520px;border-radius:24px;}
        .login-info-panel{min-height:auto;padding:28px 24px;}
        .login-info-main{margin:24px 0 12px;}
        .login-info-main h1{font-size:28px;}
        .login-feature-list{display:none;}
        .login-card-panel{padding:26px 22px 28px;}
        .modern-logo-box img{height:90px !important;}
    }

    @media (max-width: 575.98px){
        .modern-login-page{align-items:flex-start;padding:12px 10px 58px;}
        .login-shell{border-radius:22px;}
        .login-info-panel{padding:22px 20px 24px;}
        .brand-icon{width:44px;height:44px;border-radius:13px;}
        .login-info-main{margin:25px 0 0;}
        .login-info-main h1{font-size:27px;}
        .login-info-main p{font-size:13px;line-height:1.65;}
        .login-info-panel > .brand-mini:last-child{display:none;}
        .login-card-panel{padding:25px 20px 27px;}
        .modern-logo-box{max-width:270px;margin-bottom:20px;}
        .modern-logo-box img{height:82px !important;}
        .modern-login-title h4{font-size:25px;}
        .footer.footer-alt{font-size:10px;bottom:5px;}
    }

    @media (prefers-reduced-motion:no-preference){
        .login-shell{animation:loginReveal .55s cubic-bezier(.2,.8,.2,1) both;}
        .modern-login-card{animation:cardReveal .65s .08s cubic-bezier(.2,.8,.2,1) both;}
        @keyframes loginReveal{from{opacity:0;transform:translateY(18px) scale(.985)}to{opacity:1;transform:none}}
        @keyframes cardReveal{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
    }

    /* Ukuran ringkas agar seluruh form muat tanpa scroll pada layar laptop. */
    .modern-login-page{padding:16px 24px 36px;}
    .login-shell{max-width:1060px;}
    .login-info-panel{min-height:570px;padding:32px 38px;}
    .brand-icon{width:46px;height:46px;}
    .brand-mini strong{font-size:16px;}
    .login-info-main{margin:26px 0 20px;}
    .login-info-main h1{font-size:34px;}
    .login-info-main p{font-size:13px;line-height:1.65;}
    .login-feature-list{margin-top:20px;}
    .login-feature{padding:11px 13px;}
    .login-card-panel{padding:25px 40px;}
    .modern-login-card{max-width:400px;}
    .modern-logo-box{max-width:250px;padding:6px 15px 4px;margin-bottom:14px;}
    .modern-logo-box img{height:68px !important;}
    .modern-login-title{margin-bottom:14px;}
    .modern-login-title h4{font-size:25px;margin-bottom:3px;}
    .modern-alert{padding:9px 12px !important;margin-bottom:12px !important;}
    .modern-login-card .mb-3{margin-bottom:12px !important;}
    .modern-login-card .form-control,.btn-login-modern{height:46px;}
    .forgot-box{margin-top:11px;padding:9px 11px;}
    .login-security-note{margin-top:10px;}
    .modern-password-toggle i{font-size:19px;line-height:1;pointer-events:none;}

    @media (max-height:720px) and (min-width:992px){
        .modern-login-page{padding-top:8px;padding-bottom:25px;}
        .login-info-panel{min-height:535px;padding-top:26px;padding-bottom:26px;}
        .login-info-main{margin:18px 0 14px;}
        .login-feature-list{margin-top:14px;gap:8px;}
        .modern-logo-box{margin-bottom:9px;}
        .modern-logo-box img{height:58px !important;}
        .modern-login-title{margin-bottom:9px;}
        .modern-login-card .mb-3{margin-bottom:9px !important;}
    }

    @media (max-width:991.98px){
        .modern-login-page{padding:14px 12px 48px;}
        .login-info-panel{min-height:auto;padding:24px;}
        .login-card-panel{padding:23px 22px 25px;}
        .modern-logo-box img{height:66px !important;}
    }
</style>

<body class="loading authentication-bg" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="modern-login-page">
        <div class="login-shell">
            <div class="login-info-panel">
                <div class="brand-mini">
                    <div class="brand-icon"><i class="uil-shield-check"></i></div>
                    <div>
                        <strong>SIMPRO</strong>
                        <span>Profil Risiko BKK Jateng</span>
                    </div>
                </div>

                <div class="login-info-main">
                    <div class="login-chip"><i class="uil-lock-alt"></i> Akses Aman &amp; Terintegrasi</div>
                    <h1>Sistem Informasi Profil Risiko</h1>
                    <p>Masuk ke aplikasi untuk melakukan pengelolaan, pemantauan, dan pelaporan profil risiko PT BPR BKK Jateng (Perseroda).</p>

                    <div class="login-feature-list">
                        <div class="login-feature"><i class="uil-chart-growth"></i><span>Monitoring Risiko</span></div>
                        <div class="login-feature"><i class="uil-file-check-alt"></i><span>Laporan SKMR</span></div>
                        <div class="login-feature"><i class="uil-database"></i><span>Data Terpusat</span></div>
                        <div class="login-feature"><i class="uil-users-alt"></i><span>Akses Berjenjang</span></div>
                    </div>
                </div>

                <div class="brand-mini">
                    <div class="brand-icon"><i class="uil-building"></i></div>
                    <div>
                        <strong>PT BPR BKK Jateng</strong>
                        <span>Perseroda</span>
                    </div>
                </div>
            </div>

            <div class="login-card-panel">
                <div class="card modern-login-card">
                    <div class="modern-logo-box">
                        <a href="#">
                            <span><img src="assets/images/SIMPRO_3.png" alt="SIMPRO"></span>
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="modern-login-title">
                            <h4>Selamat Datang</h4>
                            <p>Silakan masuk menggunakan akun SIMPRO Anda.</p>
                        </div>

                        <?php
                        if (isset($_GET['alert'])) {
                            if ($_GET['alert'] == "gagal") {
                                echo "<div class='alert alert-danger modern-alert'>LOGIN GAGAL! USERNAME DAN PASSWORD SALAH!</div>";
                            } else if ($_GET['alert'] == "logout") {
                                echo "<div class='alert alert-success modern-alert'>ANDA TELAH BERHASIL LOGOUT</div>";
                            } else if ($_GET['alert'] == "belum_login") {
                                echo "<div class='alert alert-warning modern-alert'>ANDA HARUS LOGIN UNTUK MENGAKSES DASHBOARD</div>";
                            }
                        }
                        ?>

                        <form action="" method="POST" id="formLoginModern">
                            <input type="hidden" name="submit" value="1">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="modern-input-wrap">
                                    <i class="uil-user modern-input-icon"></i>
                                    <input class="form-control" type="text" name="username" id="username" required="" placeholder="Masukan username" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^A-Za-z0-9_@#$%^&*()+= ]/, '')" require>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge modern-input-wrap">
                                    <i class="uil-lock-alt modern-input-icon"></i>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^A-Za-z0-9_@#$%^&*()+= ]/, '')" require>
                                    <button class="input-group-text modern-password-toggle" type="button" id="togglePasswordModern" aria-label="Tampilkan password" aria-pressed="false">
                                        <i class="uil-eye" id="passwordEyeIcon" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3 mb-0 text-center">
                                <button class="btn btn-primary btn-login-modern" name="submit" type="submit">
                                    <i class="uil-sign-in-alt me-1"></i> Masuk ke SIMPRO
                                </button>
                            </div>
                        </form>

                        <div class="forgot-box">
                            Lupa password? Hubungi admin melalui
                            <a href="https://wa.link/g3j1s7" class="ms-1" target="_blank" rel="noopener"><b>WhatsApp</b></a>
                        </div>

                        <div class="login-security-note">
                            <i class="uil-check-circle"></i>
                            <span>Akses hanya untuk pengguna terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer footer-alt">
        <a  style="text-decoration: none;">
            Copyright &copy; PT BPR BKK Jateng (Perseroda) &middot; SIMPRO <?php echo date("Y"); ?>
        </a>
    </footer>

    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script>
        localStorage.removeItem('activeSidebarMenu');
        function handleChange(v){ return v; }

        document.addEventListener('DOMContentLoaded', function(){
            var toggle = document.getElementById('togglePasswordModern');
            var password = document.getElementById('password');
            var eyeIcon = document.getElementById('passwordEyeIcon');
            if (toggle && password) {
                toggle.addEventListener('click', function(){
                    var isPass = password.getAttribute('type') === 'password';
                    password.setAttribute('type', isPass ? 'text' : 'password');
                    toggle.setAttribute('aria-pressed', isPass ? 'true' : 'false');
                    toggle.setAttribute('aria-label', isPass ? 'Sembunyikan password' : 'Tampilkan password');
                    if (eyeIcon) {
                        eyeIcon.className = isPass ? 'uil-eye-slash' : 'uil-eye';
                    }
                });
            }

            var form = document.getElementById('formLoginModern');
            if (form) {
                form.addEventListener('submit', function(){
                    var btn = form.querySelector('button[name="submit"]');
                    if (btn) {
                        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
                        // tombol tidak di-disable agar field submit tetap terkirim di beberapa browser lama
                    }
                });
            }
        });
    </script>
</body>
</html>
