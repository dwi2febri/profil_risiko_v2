<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <title>Silahkan Login Ulang | Profil Risiko BKK Jateng</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="theme-color" content="#0f172a" />
  <link rel="shortcut icon" href="assets/images/11.png" />

  <!-- PRELOAD: CSS penting (lebih cepat) -->
  <link rel="preload" href="assets/css/icons.min.css" as="style" />
  <link rel="preload" href="assets/css/app.min.css" as="style" />
  <!-- Kalau kamu tidak pakai dark mode di halaman ini, jangan load app-dark agar lebih ringan -->

  <!-- PRELOAD: gambar penting (logo + background) -->
  <link rel="preload" href="assets/images/SIMPRO_2gd.png" as="image" />
  <!-- Ganti file background ini kalau beda -->
  <link rel="preload" href="assets/images/bg-pattern.png" as="image" />

  <!-- CSS: load non-blocking -->
  <link rel="stylesheet" href="assets/css/icons.min.css" />
  <link rel="stylesheet" href="assets/css/app.min.css" id="light-style" />

  <style>
    /* ====== Critical CSS (biar langsung tampil walau CSS tema belum kebaca) ====== */
    :root { color-scheme: light; }
    html, body { height: 100%; }
    body {
      margin: 0;
      background: #0f172a;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      /* zoom optional: kalau mau */
      /* zoom: .9; */
    }

    /* Background layer: tampil cepat (warna/gradien), lalu gambar nyusul */
    body.authentication-bg::before{
      content:"";
      position:fixed; inset:0;
      background:
        radial-gradient(1200px 700px at 20% 10%, rgba(59,130,246,.35), transparent 60%),
        radial-gradient(900px 600px at 80% 30%, rgba(99,102,241,.25), transparent 55%),
        linear-gradient(135deg, #0b1220, #0f172a);
      z-index:-2;
    }

    /* Background image layer (baru muncul setelah loaded) */
    body.authentication-bg::after{
      content:"";
      position:fixed; inset:0;
      background: url("assets/images/bg-pattern.png") center/cover no-repeat;
      opacity: 0;
      transform: scale(1.02);
      transition: opacity .25s ease, transform .25s ease;
      z-index:-1;
      will-change: opacity, transform;
    }
    body.bg-loaded.authentication-bg::after{
      opacity: .28;
      transform: scale(1);
    }

    /* Loader kecil (hilang saat siap) */
    .page-loader{
      position: fixed; inset: 0;
      display:flex; align-items:center; justify-content:center;
      background: rgba(15,23,42,.35);
      backdrop-filter: blur(2px);
      z-index: 9999;
      transition: opacity .15s ease, visibility .15s ease;
    }
    .page-loader.hide{ opacity:0; visibility:hidden; }

    .spinner{
      width: 36px; height: 36px;
      border-radius: 50%;
      border: 3px solid rgba(255,255,255,.25);
      border-top-color: rgba(255,255,255,.95);
      animation: spin .8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Fallback styling (kalau class tema belum sempat ke-load) */
    .text-error{ font-size: 84px; font-weight: 800; line-height: 1; }
    .card{ border-radius: 14px; overflow:hidden; }
  </style>
</head>

<body class="loading authentication-bg"
      data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false,"leftSidebarCondensed":false,"leftSidebarScrollable":false,"darkMode":false,"showRightSidebarOnStart":true}'>

  <!-- Loader -->
  <div class="page-loader" id="pageLoader" aria-hidden="true">
    <div class="spinner" aria-label="Loading"></div>
  </div>

  <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
          <div class="card">
            <!-- Logo -->
            <div class="card-header pt-4 pb-4 text-center bg-secondary">
              <a href="./">
                <span>
                  <img src="assets/images/SIMPRO_2gd.png"
                       alt="SIMPRO"
                       height="100"
                       decoding="async"
                       fetchpriority="high">
                </span>
              </a>
            </div>

            <div class="card-body p-4">
              <div class="text-center">
                <h1 class="text-error">4<i class="mdi mdi-emoticon-sad"></i>4</h1>
                <h4 class="text-uppercase text-danger mt-3">Silahkan Login Ulang</h4>
                <p class="text-muted mt-3">Kamu tersesat ....</p>

                <a class="btn btn-info mt-3" href="./">
                  <i class="mdi mdi-reply"></i> Home
                </a>
              </div>
            </div>
          </div>
          <!-- end card -->
        </div>
      </div>
    </div>
  </div>

  <script>
    (function () {
      // 1) Prioritaskan loading background image, lalu munculkan (opacity)
      var bg = new Image();
      bg.src = "assets/images/bg-pattern.png"; // pastikan file ini ada
      bg.onload = function () {
        document.body.classList.add("bg-loaded");
      };

      // 2) Hilangkan loader secepat mungkin setelah DOM siap
      function hideLoader(){
        var el = document.getElementById("pageLoader");
        if (el) el.classList.add("hide");
        document.body.classList.remove("loading");
      }

      if (document.readyState === "complete" || document.readyState === "interactive") {
        // sedikit delay biar render halus
        setTimeout(hideLoader, 50);
      } else {
        document.addEventListener("DOMContentLoaded", function(){ setTimeout(hideLoader, 50); });
      }

      // 3) Safety: kalau image gagal load, tetap hilangkan loader
      setTimeout(hideLoader, 1200);
    })();
  </script>

</body>
</html>
