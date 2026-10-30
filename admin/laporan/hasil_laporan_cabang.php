<?php
include "../conn/conn.php";

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

$id = $_SESSION['user_id'] ?? null;
$get_data_user = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM user

WHERE user_id = '$id'"));

?>


<!--jamu-->
<?php
$tahun = (int)($_GET['tahun'] ?? 0);
$periode = (int)($_GET['periode'] ?? 0);
$status_laporan = $_GET['status_laporan'] ?? 'semua';
if (!in_array($status_laporan, ['semua', 'diterima'], true)) $status_laporan = 'semua';
if (isset($_POST['submit'])) {
    $tahun = (int)($_POST['tahun'] ?? $tahun);
    $periode = (int)($_POST['periode'] ?? $periode);
    $status_laporan = $_POST['status_laporan'] ?? $status_laporan;
    if (!in_array($status_laporan, ['semua', 'diterima'], true)) $status_laporan = 'semua';
    header('Location: index.php?' . http_build_query([
        'page' => 'hasil_lapkc', 'tahun' => $tahun, 'periode' => $periode, 'status_laporan' => $status_laporan,
    ]));
    exit();
}
require_once __DIR__ . '/../includes/hasil_laporan_cabang_filter.php';


require_once __DIR__ . '/../includes/hasil_laporan_cabang_data.php';
$hasilKCResults = hasil_kc_load_results($conn, $hasilKCFrames);
require __DIR__ . '/../includes/hasil_laporan_cabang_columns.php';

foreach (range(1, 28) as $hasilBranchNumber) {
    foreach (['kredit', 'operasional', 'kepatuhan', 'likuiditas', 'reputasi', 'stratejik'] as $hasilRiskKey) {
        ${$hasilRiskKey . $hasilBranchNumber} = $hasilKCResults[$hasilBranchNumber][$hasilRiskKey] ?? [];
    }
    ${'tingkat_ris' . $hasilBranchNumber} = $hasilKCResults[$hasilBranchNumber]['total'] ?? [];
}

$semarang_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(DISTINCT kantor_cabang) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =3 $hasilStatusSql AND kantor_cabang IN(1,2,3,4,5,6,7)"));
$solo_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(DISTINCT kantor_cabang) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =3 $hasilStatusSql AND kantor_cabang IN(8,9,10,11,12,13,14)"));
$banyumas_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(DISTINCT kantor_cabang) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =3 $hasilStatusSql AND kantor_cabang IN(15,16,17,18,19,20,21)"));
$pekalongan_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(DISTINCT kantor_cabang) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =3 $hasilStatusSql AND kantor_cabang IN(22,23,24,25,26,27,28)"));


?>
<!---->



<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<div class="content-page">
    <div class="content">


                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Simpro</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Hasil laporan KC</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Hasil Laporan Profil Risiko Kantor Cabang</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <!-- end row-->


                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-4">Filter</h4>

                                        <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                               
                                                <div class="mb-3">
                                                        <label for="tahun" class="form-label">Tahun</label>
                                                        <select class="form-select mb-3" name="tahun" id="tahun" required="">
                                                            <option value=" " selected> </option>
                                                            <option value="2024" <?= 2024 == $tahun ? ' selected' : '' ?>>2024</option>
                                                            <option value="2025" <?= 2025 == $tahun ? ' selected' : '' ?>>2025</option>
                                                            <option value="2026" <?= 2026 == $tahun ? ' selected' : '' ?>>2026</option>
                                                            <option value="2027" <?= 2027 == $tahun ? ' selected' : '' ?>>2027</option>
                                                            <option value="2028" <?= 2028 == $tahun ? ' selected' : '' ?>>2028</option>
                                                            <option value="2029" <?= 2029 == $tahun ? ' selected' : '' ?>>2029</option>
                                                            <option value="2030" <?= 2030 == $tahun ? ' selected' : '' ?>>2030</option>
                                                            <option value="2031" <?= 2031 == $tahun ? ' selected' : '' ?>>2031</option>
                                                            <option value="2032" <?= 2032 == $tahun ? ' selected' : '' ?>>2032</option>
                                                            <option value="2033" <?= 2033 == $tahun ? ' selected' : '' ?>>2033</option>
                                                            <option value="2034" <?= 2034 == $tahun ? ' selected' : '' ?>>2034</option>
                                                            <option value="2035" <?= 2035 == $tahun ? ' selected' : '' ?>>2035</option>
                                                            <option value="2036" <?= 2036 == $tahun ? ' selected' : '' ?>>2036</option>
                                                            <option value="2037" <?= 2037 == $tahun ? ' selected' : '' ?>>2037</option>
                                                        </select>
                                                </div>
                                                <div class="mb-3">
                                                        <label for="periode" class="form-label">Periode</label>
                                                        <select class="form-select mb-3" name="periode" id="periode" required="">
                                                        <option value=" " selected> </option>
                                                                    <?php
                                                                    include "../conn/conn.php";
                                                                    $query_periode = mysqli_query($conn, "SELECT * FROM periode_laporan_profil_risiko");
                                                                    while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                                        <option value="<?= $data['id_periode'] ?? '' ?>" <?= $data['id_periode'] == $periode ? ' selected' : '' ?>><?= ucwords($data['periode_laporan']) ?></option>
                                                                    <?php
                                                                    };
                                                                    ?>
                                                        </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status_laporan" class="form-label">Status Laporan</label>
                                                    <select class="form-select" name="status_laporan" id="status_laporan">
                                                        <option value="semua" <?= $status_laporan === 'semua' ? 'selected' : '' ?>>Semua laporan</option>
                                                        <option value="diterima" <?= $status_laporan === 'diterima' ? 'selected' : '' ?>>Sudah diterima Korwil dan SKMR</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 text-center">
                                                        <button class="btn btn-primary" type="submit" name="submit">Cari</button>
                                                </div>

                                            </div>
                                        </form>
                                        <!-- end row-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                    <h4 class="header-title mb-4"><?= $status_laporan === 'diterima' ? 'Laporan Diterima' : 'Laporan Tersedia' ?></h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $semarang_cnt['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">Laporan area semarang</p>
                                                    </div>
                                            </div>
                
                                            <div class="col-lg-4">
                                                <div class="card shadow-none m-0 border-start">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $solo_cnt['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">Laporan area solo</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $banyumas_cnt['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">laporan area banyumas</p>
                                                    </div>
                                            </div>
                
                                            <div class="col-lg-4">
                                                <div class="card shadow-none m-0 border-start">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $pekalongan_cnt['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">laporan area pekalongan</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

<?php require __DIR__ . '/../includes/hasil_laporan_cabang_table.php'; ?>

                        
                    </div> <!-- container -->



    </div>
    <!-- content -->



</div>










