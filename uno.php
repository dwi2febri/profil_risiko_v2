<?php
declare(strict_types=1);

/*
 * SIMPRO Secret Game - js-dos + FastDoom + Freedoom Phase 2
 *
 * Cukup siapkan:
 *   games/FDOOM.EXE
 *   games/FREEDM2.WAD
 *
 * Halaman ini akan membuat games/doom2.jsdos secara otomatis
 * dengan path internal .jsdos/dosbox.conf yang benar.
 */

$gameDir = __DIR__ . DIRECTORY_SEPARATOR . 'games';
$exeFile = $gameDir . DIRECTORY_SEPARATOR . 'FDOOM.EXE';
$bundleFile = $gameDir . DIRECTORY_SEPARATOR . 'doom2.jsdos';

if (!is_dir($gameDir)) {
    @mkdir($gameDir, 0775, true);
}

/* Cari WAD dengan beberapa kemungkinan kapitalisasi/nama. */
$wadCandidates = [
    $gameDir . DIRECTORY_SEPARATOR . 'FREEDM2.WAD',
    $gameDir . DIRECTORY_SEPARATOR . 'FREEDM2.wad',
    $gameDir . DIRECTORY_SEPARATOR . 'freedm2.wad',
    $gameDir . DIRECTORY_SEPARATOR . 'freedoom2.wad',
];

$wadFile = null;
foreach ($wadCandidates as $candidate) {
    if (is_file($candidate)) {
        $wadFile = $candidate;
        break;
    }
}

$buildError = null;
$bundleReady = false;
$bundleEntries = [];

if (!is_file($exeFile)) {
    $buildError = 'File games/FDOOM.EXE belum ada.';
} elseif ($wadFile === null) {
    $buildError = 'File FREEDM2.WAD belum ada di folder games.';
} elseif (!class_exists('ZipArchive')) {
    $buildError = 'PHP extension ZipArchive belum aktif. Aktifkan extension=zip di php.ini lalu restart Apache.';
} else {
    $dosboxConf = <<<'CONF'
[sdl]
fullscreen=false
fulldouble=false
autolock=true
sensitivity=100

[dosbox]
machine=svga_s3
memsize=32

[render]
frameskip=0
aspect=false
scaler=none

[cpu]
core=auto
cputype=auto
cycles=max

[mixer]
nosound=false
rate=44100
blocksize=1024
prebuffer=20

[midi]
mpu401=none
mididevice=none

[sblaster]
sbtype=sb16
sbbase=220
irq=7
dma=1
hdma=5
mixer=true
oplmode=auto

[autoexec]
@echo off
mount c .
c:
FDOOM.EXE -iwad FREEDM2.WAD
CONF;

    $zip = new ZipArchive();
    $openResult = $zip->open($bundleFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    if ($openResult !== true) {
        $buildError = 'Gagal membuat games/doom2.jsdos. Kode ZipArchive: ' . (string)$openResult;
    } else {
        /*
         * Sangat penting:
         * nama entry harus PERSIS ".jsdos/dosbox.conf" memakai slash "/".
         */
        $okConf = $zip->addFromString('.jsdos/dosbox.conf', $dosboxConf);
        $okExe  = $zip->addFile($exeFile, 'FDOOM.EXE');
        $okWad  = $zip->addFile($wadFile, 'FREEDM2.WAD');

        $closeOk = $zip->close();

        if (!$okConf || !$okExe || !$okWad || !$closeOk) {
            $buildError = 'Gagal menambahkan file ke bundle js-dos.';
        } else {
            /* Verifikasi lagi isi ZIP setelah selesai ditulis. */
            $verify = new ZipArchive();
            if ($verify->open($bundleFile) === true) {
                for ($i = 0; $i < $verify->numFiles; $i++) {
                    $name = $verify->getNameIndex($i);
                    if ($name !== false) {
                        $bundleEntries[] = $name;
                    }
                }

                $hasConf = $verify->locateName('.jsdos/dosbox.conf', ZipArchive::FL_NOCASE) !== false;
                $hasExe  = $verify->locateName('FDOOM.EXE', ZipArchive::FL_NOCASE) !== false;
                $hasWad  = $verify->locateName('FREEDM2.WAD', ZipArchive::FL_NOCASE) !== false;
                $verify->close();

                if ($hasConf && $hasExe && $hasWad) {
                    $bundleReady = true;
                } else {
                    $buildError = 'Bundle terbentuk tetapi struktur internalnya tidak valid.';
                }
            } else {
                $buildError = 'Bundle selesai dibuat tetapi tidak dapat diverifikasi.';
            }
        }
    }
}

/*
 * Cache-buster: setiap bundle berubah, URL juga berubah.
 * Ini mencegah browser/js-dos membaca bundle lama.
 */
$bundleUrl = 'games/doom2.jsdos';
if ($bundleReady && is_file($bundleFile)) {
    $bundleUrl .= '?v=' . rawurlencode((string)filemtime($bundleFile));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPRO Secret Game</title>

    <!-- js-dos v8 official CDN -->
    <link rel="stylesheet" href="https://v8.js-dos.com/latest/js-dos.css">
    <script src="https://v8.js-dos.com/latest/js-dos.js"></script>

    <style>
        * { box-sizing: border-box; }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            background: #111827;
            overflow: hidden;
            font-family: Arial, Helvetica, sans-serif;
        }

        #dos {
            width: 100vw;
            height: 100vh;
        }

        #topControls {
            position: fixed;
            top: 14px;
            left: 14px;
            z-index: 999999;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        #backBtn {
            padding: 10px 16px;
            min-height: 44px;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 8px;
            background: rgba(0,0,0,.72);
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            backdrop-filter: blur(6px);
        }

        #backBtn:hover {
            background: rgba(150, 0, 0, .9);
        }

        #cursorHint {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 8px;
            background: rgba(0,0,0,.62);
            color: rgba(255,255,255,.92);
            font-size: 13px;
            font-weight: 600;
            backdrop-filter: blur(6px);
        }

        #cursorHint kbd {
            display: inline-block;
            padding: 3px 7px;
            border: 1px solid rgba(255,255,255,.35);
            border-bottom-width: 2px;
            border-radius: 5px;
            background: rgba(255,255,255,.12);
            color: #fff;
            font-family: inherit;
            font-size: 12px;
            font-weight: 800;
            line-height: 1.2;
        }

        .error-screen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #fff;
        }

        .error-card {
            width: min(760px, 100%);
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,.35);
        }

        .error-card h1 {
            margin-top: 0;
            color: #f87171;
            font-size: 24px;
        }

        .error-card code,
        .error-card pre {
            color: #fde68a;
        }

        .error-card pre {
            background: #111827;
            padding: 14px;
            border-radius: 10px;
            overflow: auto;
            white-space: pre-wrap;
        }
    </style>
</head>

<body>

<div id="topControls">
    <button id="backBtn" type="button" onclick="window.location.href='index.php'">
        ← Kembali ke SIMPRO
    </button>

    <div id="cursorHint" aria-label="Petunjuk kursor">
        <kbd>ESC</kbd>
        <span>untuk menampilkan kursor</span>
    </div>
</div>

<?php if (!$bundleReady): ?>
    <div class="error-screen">
        <div class="error-card">
            <h1>Game belum bisa dijalankan</h1>
            <p><?php echo htmlspecialchars((string)$buildError, ENT_QUOTES, 'UTF-8'); ?></p>

            <p>Pastikan struktur project seperti ini:</p>
            <pre>profil_risiko_v2/
├── uno.php
└── games/
    ├── FDOOM.EXE
    └── FREEDM2.WAD</pre>

            <?php if (!empty($bundleEntries)): ?>
                <p>Isi bundle yang terbaca:</p>
                <pre><?php echo htmlspecialchars(implode("\n", $bundleEntries), ENT_QUOTES, 'UTF-8'); ?></pre>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>

    <div id="dos"></div>

    <script>
        (function () {
            const bundleUrl = <?php echo json_encode($bundleUrl, JSON_UNESCAPED_SLASHES); ?>;

            if (typeof Dos !== "function") {
                document.body.innerHTML =
                    '<div class="error-screen"><div class="error-card">' +
                    '<h1>js-dos gagal dimuat</h1>' +
                    '<p>Periksa koneksi internet atau blokir CDN.</p>' +
                    '</div></div>';
                return;
            }

            console.log("Loading js-dos bundle:", bundleUrl);

            /*
             * Bentuk ini mengikuti API resmi js-dos v8:
             * Dos(element, { url: "bundle.jsdos" })
             */
            Dos(document.getElementById("dos"), {
                url: bundleUrl,

                // Langsung menjalankan game tanpa menekan tombol Play.
                autoStart: true,
                countDownStart: 0,

                // Setelah pengguna berinteraksi dengan layar game,
                // mouse dapat dicapture. Tekan ESC untuk menampilkan
                // kembali kursor dari pointer lock browser.
                mouseCapture: true,

                // Tampilan tetap memiliki kontrol js-dos, tetapi sidebar
                // dibuat lebih ringkas.
                thinSidebar: true
            });
        })();
    </script>

<?php endif; ?>

</body>
</html>
