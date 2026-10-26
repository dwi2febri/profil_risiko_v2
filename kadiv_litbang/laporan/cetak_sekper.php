
<?php
require('fpdf182/fpdf.php');

include 'fetch.php';
error_reporting(0);
ini_set('display_errors', 0);
$id_kepatuhan = $_GET['id'];


$id = $_GET['id'];
$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE id_profil_risiko = '$id'"));
$dp = $frame['data_pembanding'];
$tahun = $frame['tahun'];
$kc = $frame['cabang'];
$tgl = $frame['dibuat_at'];
$id = $_GET['id'];
$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE id_profil_risiko = '$id'"));
$dp = $frame['data_pembanding'];
$tahun = $frame['tahun'];
$kc = $frame['cabang'];
$tgl = $frame['dibuat_at'];
$per = $frame['periode'];
if ($per ==1) {
    $periode_lap = 'Triwulan 1';
} else if ($per ==2) {
    $periode_lap = 'Triwulan 2 / Semester 1';
} else if ($per ==3) {
    $periode_lap = 'Triwulan 3';
} elseif ($per ==4) {
    $periode_lap = 'Triwulan 4 / Semester 2';
} else {
    $periode_lap = '-';
}
$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$id'"));
$pil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$id'"));

$pil_op1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_op2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_op3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$pil_op4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar4 WHERE id_profil_risiko = '$id'"));
$pil_op5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar5 WHERE id_profil_risiko = '$id'"));
$pil_op6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_lainnya WHERE id_profil_risiko = '$id'"));

$ket_pil_op1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$ket_pil_op2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$ket_pil_op3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$ket_pil_op4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar4 WHERE id_profil_risiko = '$id'"));
$ket_pil_op5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar5 WHERE id_profil_risiko = '$id'"));
$ket_pil_op6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_lainnya WHERE id_profil_risiko = '$id'"));

$pil_kep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_kep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_kep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = '$id'"));

$pil_lik1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_lik2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_lik3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_likuiditas_lainnya WHERE id_profil_risiko = '$id'"));

$pil_rep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_rep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_rep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$pil_rep4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_lainnya WHERE id_profil_risiko = '$id'"));

$pil_stra1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_stra2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_stra3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$pil_stra4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_lainnya WHERE id_profil_risiko = '$id'"));


$ket_pil_kep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$ket_pil_kep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$ket_pil_kep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_kepatuhan_lainnya WHERE id_profil_risiko = '$id'"));


$ket_pil_rep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$ket_pil_rep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$ket_pil_rep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$ket_pil_rep4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya WHERE id_profil_risiko = '$id'"));

$ket_pil_stra1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$ket_pil_stra2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$ket_pil_stra3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$ket_pil_stra4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_lainnya WHERE id_profil_risiko = '$id'"));


$kpmr_kredit1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_kredit2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_kredit3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_kredit4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_operasional1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_operasional2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_operasional3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_operasional4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_kepatuhan1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_kepatuhan2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_kepatuhan3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kepatuhan_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_kepatuhan4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kepatuhan_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_likuiditas1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_likuiditas2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_likuiditas_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_likuiditas3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_likuiditas_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_likuiditas4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_likuiditas_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_reputasi1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_reputasi2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_reputasi3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_reputasi4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_reputasi_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_stratejik1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_stratejik2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_stratejik3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_stratejik4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_stratejik_pilar4 WHERE id_profil_risiko = '$id'"));


$ru1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kredit_pil1 WHERE id_profil_risiko = '$id'"));
$ru2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kredit_pil2 WHERE id_profil_risiko = '$id'"));
$ru3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kredit_pil3 WHERE id_profil_risiko = '$id'"));
$ru4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kredit_pil4 WHERE id_profil_risiko = '$id'"));

$ru_op1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil1 WHERE id_profil_risiko = '$id'"));
$ru_op2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil2 WHERE id_profil_risiko = '$id'"));
$ru_op3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil3 WHERE id_profil_risiko = '$id'"));
$ru_op4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil4 WHERE id_profil_risiko = '$id'"));

$ru_kep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kepatuhan_pil1 WHERE id_profil_risiko = '$id'"));
$ru_kep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kepatuhan_pil2 WHERE id_profil_risiko = '$id'"));
$ru_kep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kepatuhan_pil3 WHERE id_profil_risiko = '$id'"));
$ru_kep4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kepatuhan_pil4 WHERE id_profil_risiko = '$id'"));


$ru_lik1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_likuiditas_pil1 WHERE id_profil_risiko = '$id'"));
$ru_lik2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_likuiditas_pil2 WHERE id_profil_risiko = '$id'"));
$ru_lik3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_likuiditas_pil3 WHERE id_profil_risiko = '$id'"));
$ru_lik4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_likuiditas_pil4 WHERE id_profil_risiko = '$id'"));


$ru_rep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_reputasi_pil1 WHERE id_profil_risiko = '$id'"));
$ru_rep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_reputasi_pil2 WHERE id_profil_risiko = '$id'"));
$ru_rep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_reputasi_pil3 WHERE id_profil_risiko = '$id'"));
$ru_rep4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_reputasi_pil4 WHERE id_profil_risiko = '$id'"));


$ru_stra1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_stratejik_pil1 WHERE id_profil_risiko = '$id'"));
$ru_stra2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_stratejik_pil2 WHERE id_profil_risiko = '$id'"));
$ru_stra3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_stratejik_pil3 WHERE id_profil_risiko = '$id'"));
$ru_stra4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_stratejik_pil4 WHERE id_profil_risiko = '$id'"));



$ket_inhern_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren_kredit WHERE id_profil_risiko = '$id'"));
$ket_inhern_operasional = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_operasional WHERE id_profil_risiko = '$id'"));
$ket_inhern_kepatuhan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_kepatuhan WHERE id_profil_risiko = '$id'"));
$ket_inhern_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$ket_inhern_reputasi = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_reputasi WHERE id_profil_risiko = '$id'"));
$ket_inhern_stratejik = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_stratejik WHERE id_profil_risiko = '$id'"));


$ket_kpmr_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_kredit WHERE id_profil_risiko = '$id'"));
$ket_kpmr_operasional = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_operasional WHERE id_profil_risiko = '$id'"));
$ket_kpmr_kepatuhan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_kepatuhan WHERE id_profil_risiko = '$id'"));
$ket_kpmr_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_likuiditas WHERE id_profil_risiko = '$id'"));
$ket_kpmr_reputasi = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_reputasi WHERE id_profil_risiko = '$id'"));
$ket_kpmr_stratejik = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_stratejik WHERE id_profil_risiko = '$id'"));

$hasil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));
$hasil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$id'"));
$hasil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$id'"));
$hasil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$hasil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$id'"));
$hasil6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$id'"));


$ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = '$id'"));
$ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = '$id'"));
$ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$id'"));
$ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$id'"));
$ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = '$id'"));
$ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = '$id'"));

$pembanding_ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = '$dp'"));
$pembanding_ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = '$dp'"));
$pembanding_ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$dp'"));
$pembanding_ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$dp'"));
$pembanding_ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = '$dp'"));
$pembanding_ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = '$dp'"));

$inheren1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));
$inheren2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$id'"));
$inheren3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$id'"));
$inheren4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$inheren5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$id'"));
$inheren6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$id'"));

$kpmr1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = '$id'"));
$kpmr2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_operasional WHERE id_profil_risiko = '$id'"));
$kpmr3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko = '$id'"));
$kpmr4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_likuiditas WHERE id_profil_risiko = '$id'"));
$kpmr5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_reputasi WHERE id_profil_risiko = '$id'"));
$kpmr6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_stratejik WHERE id_profil_risiko = '$id'"));


$pembanding_inheren1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$dp'"));

$pembanding_kpmr1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_operasional WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_likuiditas WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_reputasi WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_stratejik WHERE id_profil_risiko = '$dp'"));

$nilpro = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = '$id'"));
$pembanding_nilpro = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = '$dp'"));




function GenerateWord()
{
    // Get a random word
    $nb = rand(3, 10);
    $w = '';
    for ($i = 1; $i <= $nb; $i++)
        $w .= chr(rand(ord('a'), ord('z')));
    return $w;
}

function GenerateSentence()
{
    // Get a random sentence
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++)
        $s .= GenerateWord() . ' ';
    return substr($s, 0, -1);
}


class PDF extends FPDF
{



    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data = null, $colors = null)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x, $y, $w, $h);
            // Print the text
            $this->MultiCell($w, 4, $data[$i], 0, $a);
            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        // Go to the next line
        $this->Ln($h);
    }
    function Row2($data = null, $colors = null) {
        // Calculate the height of the row
         // Calculate the height of the row
         $nb = 0;
         for ($i = 0; $i < count($data); $i++)
             $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
         $h = 5 * $nb;
         // Issue a page break first if needed
         $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
           
            // Set fill color for the column
            $this->SetFillColor($colors[$i][0], $colors[$i][1], $colors[$i][2]);
            // Draw the cell
            
            
            $this->MultiCell($w, 5, $data[$i], 0, $a, true);
            
            $this->Rect($x, $y, $w, $h);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }
    
    

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if (!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }






























    function Header()
    {
        $this->Image('logo.png', 10, 8, 17);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40);
        $this->Cell(45, 5, ' HASIL PELAPORAN PROFIL RISIKO KANTOR PUSAT');
        $this->Cell(200);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(45, 5, '', 0, 1, 'C');
        $this->Cell(75);
        $this->Cell(45, 5, 'PT.BPR BKK JATENG (PERSERODA)', 0, 1, 'C');
        $this->Cell(45);
        $this->Cell(45, 5, '', 0, 1, 'C');
        $this->Cell(90);
        $this->SetFont('Arial', '', 8);
        $this->Cell(15, 5, 'Jl. Tanjung No.11-A Sekayu, Semarang Tengah, Kota Semarang 50132 - info@bprbkkinfo.com - (024) 86405241 - 0815 1400 0400', 0, 1, 'C');

        $this->SetLineWidth(1);
        $this->Line(10, 31, 200, 31);
        $this->SetLineWidth(0);
        $this->Line(10, 32, 200, 32);
        $this->Ln(10);
    }
    function Footer()
    {
        $this->SetY(15);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 10, 'Halaman' . $this->PageNo() . ' / {nb}', 0, 0, 'R');
    }
    function ttd()
    {

        $this->Ln(10);
        $this->SetFont('Arial', '', 12);
        $this->Cell(130);
        $this->Cell(190, 5, 'Semarang, ' . tgl_indo(date('Y-m-d')), 0, 1, 'C');
        $this->Cell(130);
        $this->Cell(190, 5, 'Mengetahui', 0, 1, 'C');
        $this->Cell(130);
        $this->Cell(190, 5, 'Kepala Satuan Kerja Manajemen Risiko', 0, 1, 'C');
        $this->Ln(16);
        $this->Cell(130);
        $this->SetFont('Arial', 'U', 12);
        $this->Cell(190, 5, '', 0, 1, 'C');
        $this->Cell(130);
        $this->SetFont('Arial', '', 12);
    }

}



$pdf = new PDF('P', 'mm', array(210, 330));


$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60);
$pdf->Cell(10, 5, 'HASIL LAPORAN PROFIL RISIKO ');

$pdf->Ln(10);


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, ' ' );
$pdf->Ln(4);
$pdf->Cell(20, 5, 'Tahun Realisasi '. $tahun);
$pdf->Ln(6);
$pdf->Cell(20, 5, $periode_lap);
$pdf->Ln(6);
$pdf->Cell(20, 5,'Profil Risiko '. $kc);

$pdf->Ln(6);

$pdf->SetFont('Arial','', 10);
$pdf->Cell(1);
$pdf->Cell(1, 5, 'Sehubungan dengan telah dilaksanakan pengisian aplikasi simpro, pada tanggal : '.tgl_indo($tgl));

$pdf->Ln(6);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1);
$pdf->Cell(10, 5, 'Tingkat risiko yang telah ditetapkan mengacu pada cakupan penerapan secara umum sebagaimana diatur dalam kebijakan');



$pdf->Ln(4);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1);
$pdf->Cell(10, 5, 'dan pedoman penerapan manajemen risiko. Maka kami informasikan hasil pengukuran sebagai berikut:');



$pdf->Ln(8);
function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
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




$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO KEPATUHAN)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN KEPATUHAN');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);
$pdf->Ln();


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Faktor Kelemahan Aspek Hukum'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Kelemahan Dalam Perikatan',  $pil_kep2['hasil_pil2_par1'],  $ket_pil_kep2['ket_in_kep_pil2_1'].$ket_pil_kep2['ket_in_kep_pil2_1a']));
$pdf->Row2(array('','Kelemahan Dalam Perikatan',  $pil_kep2['pilar2_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Corporate Legal',  $pil_kep2['pilar2_1a'],  
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Litigasi Terkait Nominal Gugatan Atau Estimasi Kerugian Yang Dialami BPR Akibat Gugatan',  $pil_kep2['hasil_pil2_par2'],  $ket_pil_kep2['ket_in_kep_pil2_2'].$ket_pil_kep2['ket_in_kep_pil2_2a']));
$pdf->Row2(array('','Litigasi Terkait Nominal Gugatan Atau Estimasi Kerugian Yang Dialami BPR Akibat Gugatan',  $pil_kep2['pilar2_2'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pendampingan Hukum',  $pil_kep2['pilar2_2a'],  

 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Litigasi Terkait Kerugian Yang Dialami Karena Putusan Pengadilan Berkekuatan Hukum Tetap',  $pil_kep2['hasil_pil2_par3'],  $ket_pil_kep2['ket_in_kep_pil2_3'].$ket_pil_kep2['ket_in_kep_pil2_3a']));
$pdf->Row2(array('','Litigasi Terkait Kerugian Yang Dialami Karena Putusan Pengadilan Berkekuatan Hukum Tetap',  $pil_kep2['pilar2_3'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kerugian Akibat Putusan Pengadilan Berkekuatan Hukum Tetap',  $pil_kep2['pilar2_3a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN KEPATUHAN', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil3['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil3['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN KEPATUHAN', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_kepatuhan['ket_inheren']));








$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR KEPATUHAN');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko kepatuhan yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_kepatuhan1['pil1_total1'],  $ru_kep1['respon_pil1_1a'].$ru_kep1['respon_pil1_1b'].$ru_kep1['respon_pil1_1c'].$ru_kep1['respon_pil1_1d'].$ru_kep1['respon_pil1_1e']));


$pdf->Row2(array('','Apakah ketentuan dan kebijakan manajemen risiko kepatuhan yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP kepatuhan, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_kepatuhan1['pilar1_1a'], '
 
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko kepatuhan yang disetujui Dewan Komisaris telah dilakukan (Ketentuan kepatuhan yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_kepatuhan1['pilar1_1b'],  '
 
 
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko kepatuhan dalam menjalankan tugas dan fungsinya',  $kpmr_kepatuhan1['pilar1_1c'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko kepatuhan sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_kepatuhan1['pilar1_1d'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_kepatuhan1['pilar1_1e'],  '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko kepatuhan secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_kepatuhan1['pil1_total2'],  $ru_kep1['respon_pil1_2a'].$ru_kep1['respon_pil1_2b'].$ru_kep1['respon_pil1_2c'].$ru_kep1['respon_pil1_2d'].$ru_kep1['respon_pil1_2e']));
$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko kepatuhan secara tertulis dan dalam forum rapat (terdapat notulen)',  $kpmr_kepatuhan1['pilar1_2a'], '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko kepatuhan kepada Direksi secara tertulis dan forum rapat',  $kpmr_kepatuhan1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko kepatuhan',  $kpmr_kepatuhan1['pilar1_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko kepatuhan',  $kpmr_kepatuhan1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_kepatuhan1['pilar1_2e'],  '
 

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko kepatuhan, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_kepatuhan1['pil1_total3'],  $ru_kep1['respon_pil1_3a'].$ru_kep1['respon_pil1_3b'].$ru_kep1['respon_pil1_3c']));
$pdf->Row2(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko kepatuhan (Pelatihan tentang manajemen risiko kepatuhan yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko kepatuhan)',  $kpmr_kepatuhan1['pilar1_3a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketentuan dan kebijakan manajemen risiko kepatuhan yang disetujui Direksi apa saja yang telah ditetapkan (SK Direksi, SOP kepatuhan, SE Direksi)',  $kpmr_kepatuhan1['pilar1_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko kepatuhan yang disetujui Direksi dilakukan (Ketentuan kepatuhan yang diterbitkan selama periode penilaian)',  $kpmr_kepatuhan1['pilar1_3c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko kepatuhan, dan melakukan komunikasi kebijakan Manajemen Risiko kepatuhan terhadap seluru_keph jenjang organisasi BPR?',  $kpmr_kepatuhan1['pil1_total4'],  $ru_kep1['respon_pil1_4a'].$ru_kep1['respon_pil1_4b'].$ru_kep1['respon_pil1_4c'].$ru_kep1['respon_pil1_4d'].$ru_kep1['respon_pil1_4e']));
$pdf->Row2(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko kepatuhan',  $kpmr_kepatuhan1['pilar1_4a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluru_keph unit kerja',  $kpmr_kepatuhan1['pilar1_4b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko kepatuhan kepada seluru_keph unit kerja',  $kpmr_kepatuhan1['pilar1_4c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_kepatuhan1['pilar1_4d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_kepatuhan1['pilar1_4e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi kepatuhan dan fungsi Manajemen Risiko kepatuhan?',  $kpmr_kepatuhan1['pil1_total5'],  $ru_kep1['respon_pil1_5a'].$ru_kep1['respon_pil1_5b'].$ru_kep1['respon_pil1_5c'].$ru_kep1['respon_pil1_5d']));
$pdf->Row2(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja kepatuhan dan melaksanakan tugasnya secara independen',  $kpmr_kepatuhan1['pilar1_5a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di unit kerja kepatuhan telah didukung dengan kompetensi yang baik',  $kpmr_kepatuhan1['pilar1_5b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di satuan manajemen risiko kepatuhan telah didukung dengan kompetensi yang baik',  $kpmr_kepatuhan1['pilar1_5c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah proses kepatuhan dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_kepatuhan1['pilar1_5d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko kepatuhan?',  $kpmr_kepatuhan1['pil1_total6'],  $ru_kep1['respon_pil1_6a'].$ru_kep1['respon_pil1_6b'].$ru_kep1['respon_pil1_6c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko kepatuhan, tidak terdapat perangkapan jabatan, independen',  $kpmr_kepatuhan1['pilar1_6a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_kepatuhan1['pilar1_6b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang kepatuhan',  $kpmr_kepatuhan1['pilar1_6c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('7','Apakah Direksi telah menyusun kebijakan internal yang mendukung terselenggaranya fungsi kepatuhan, memberikan perhatian terhadap ketentuan peraturan perundang- undangan, serta terdapat kebijakan reward and punishment bagi internal BPR?',  $kpmr_kepatuhan1['pil1_total7'],  $ru_kep1['respon_pil1_7a'].$ru_kep1['respon_pil1_7b'].$ru_kep1['respon_pil1_7c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko kepatuhan, tidak terdapat perangkapan jabatan, independen',  $kpmr_kepatuhan1['pilar1_7a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_kepatuhan1['pilar1_7b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang kepatuhan',  $kpmr_kepatuhan1['pilar1_7c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr3['pil1_tingkat_risiko'],  $ket_kpmr_kepatuhan['ket_pil1']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko kepatuhan yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_kepatuhan2['pil2_total1'],  $ru_kep2['respon_pil2_1a'].$ru_kep2['respon_pil2_1b'].$ru_kep2['respon_pil2_1c'].$ru_kep2['respon_pil2_1d'].$ru_kep2['respon_pil2_1e']));


$pdf->Row2(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko kepatuhan',  $kpmr_kepatuhan2['pilar2_1a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko kepatuhan',  $kpmr_kepatuhan2['pilar2_1b'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan manajemen risiko kepatuhan dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_kepatuhan2['pilar2_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko kepatuhan memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko kepatuhan, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_kepatuhan2['pilar2_1d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_kepatuhan2['pilar2_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','"Apakah BPR:
1. memiliki prosedur Manajemen Risiko kepatuhan dan penetapan limit Risiko kepatuhan yang ditetapkan oleh Direksi ?
2. melaksanakan prosedur Manajemen Risiko kepatuhan dan penetapan limit Risiko kepatuhan secara konsisten untuk seluruh aktivitas ? Dan
3. melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko kepatuhan dan penetapan limit Risiko kepatuhan secara berkala?"',  $kpmr_kepatuhan2['pil2_total2'],  $ru_kep2['respon_pil2_2a'].$ru_kep2['respon_pil2_2b'].$ru_kep2['respon_pil2_2c'].$ru_kep2['respon_pil2_2d'].$ru_kep2['respon_pil2_2e'].$ru_kep2['respon_pil2_2f'].$ru_kep2['respon_pil2_2g'].$ru_kep2['respon_pil2_2h']));


$pdf->Row2(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko kepatuhan yang ditetapkan dalam SK Direksi',  $kpmr_kepatuhan2['pilar2_2a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko kepatuhan',  $kpmr_kepatuhan2['pilar2_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_kepatuhan2['pilar2_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko kepatuhan',  $kpmr_kepatuhan2['pilar2_2d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_kepatuhan2['pilar2_2e'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi kepatuhan',  $kpmr_kepatuhan2['pilar2_2f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_kepatuhan2['pilar2_2g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_kepatuhan2['pilar2_2h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko kepatuhan sesuai dengan ketentuan?',  $kpmr_kepatuhan2['pil2_total3'],  $ru_kep2['respon_pil2_3a'].$ru_kep2['respon_pil2_3b'].$ru_kep2['respon_pil2_3c']));


$pdf->Row2(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_kepatuhan2['pilar2_3a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_kepatuhan2['pilar2_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_kepatuhan2['pilar2_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr3['pil2_tingkat_risiko'],  $ket_kpmr_kepatuhan['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko kepatuhan yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko kepatuhan?',  $kpmr_kepatuhan3['pil3_total1'],  $ru_kep3['respon_pil3_1a'].$ru_kep3['respon_pil3_1b'].$ru_kep3['respon_pil3_1c'].$ru_kep3['respon_pil3_1d'].$ru_kep3['respon_pil3_1e'].$ru_kep3['respon_pil3_1f'].$ru_kep3['respon_pil3_1g'].$ru_kep3['respon_pil3_1h'].$ru_kep3['respon_pil3_1i'].$ru_kep3['respon_pil3_1j']));


$pdf->Row2(array('','Apakah dalam aktvitas kepatuhan seluruh SDM telah berpedoman pada penerapan manajemen risiko kepatuhan',  $kpmr_kepatuhan3['pilar3_1a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas kepatuhan',  $kpmr_kepatuhan3['pilar3_1b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses kepatuhan dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_kepatuhan3['pilar3_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses pengambilan keputusan bidang kepatuhan dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_kepatuhan3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajamen risiko kepatuhan telah didukung dengan data kepatuhan yang akurat dan informatif',  $kpmr_kepatuhan3['pilar3_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajemen risiko kepatuhan telah melakukan analisa karakteristik risiko kepatuhan yang melekat pada produk dan layanan',  $kpmr_kepatuhan3['pilar3_1f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko kepatuhan telah dilakukan evaluasi',  $kpmr_kepatuhan3['pilar3_1g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pengukuran risiko kepatuhan telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_kepatuhan3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pemantauan risiko kepatuhan telah dilakukan evaluasi terhadap eksposur risiko kepatuhan',  $kpmr_kepatuhan3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apabila terdapat perubahan yang material dalam faktor risiko kepatuhan apakah juga dilakukan penyesuaian pelaporan',  $kpmr_kepatuhan3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko kepatuhan serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_kepatuhan3['pil3_total2'],  $ru_kep3['respon_pil3_2a'].$ru_kep3['respon_pil3_2b'].$ru_kep3['respon_pil3_2c'].$ru_kep3['respon_pil3_2d'].$ru_kep3['respon_pil3_2e']));


$pdf->Row2(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_kepatuhan3['pilar3_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi risiko kepatuhan dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_kepatuhan3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko kepatuhan yang lengkap dan cepat',  $kpmr_kepatuhan3['pilar3_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan kepatuhan terhadap kebijakan manajemen risiko kepatuhan (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_kepatuhan3['pilar3_2d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_kepatuhan3['pilar3_2e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr3['pil3_tingkat_risiko'],  $ket_kpmr_kepatuhan['ket_pil3']));


$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR KEPATUHAN', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr3['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr3['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr3['pil3_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr3['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr3['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR KEPATUHAN', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_kepatuhan['ket_kpmr']));




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI KEPATUHAN');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();






$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 7);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket3['inheren_kepatuhan'], $ket3['kpmr_kepatuhan'], $ket3['tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_ket3['inheren_kepatuhan'], $pembanding_ket3['kpmr_kepatuhan'], $pembanding_ket3['tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
$pdf->Row(array($inheren3['hasil_peringkat'], $kpmr3['hasil_peringkat'], $ket3['peringkat_tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_inheren3['hasil_peringkat'], $pembanding_kpmr3['hasil_peringkat'], $pembanding_ket3['peringkat_tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Tingkat Risiko',$ket3['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket3['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket3['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa








$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO REPUTASI)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN REPUTASI');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);
$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR',  $pil_rep1['hasil_pil1_par1'],  $ket_pil_rep1['ket_in_rep_pil1_1'].$ket_pil_rep1['ket_in_rep_pil1_1a'].$ket_pil_rep1['ket_in_rep_pil1_1b'].$ket_pil_rep1['ket_in_rep_pil1_1c'].$ket_pil_rep1['ket_in_rep_pil1_1d']));
$pdf->Row2(array('','Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR',  $pil_rep1['pilar1_1'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemberitaan Negatif Terhadap Perusahaan Terkait',  $pil_rep1['pilar1_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kerjasama Dengan Mitra Bisnis',  $pil_rep1['pilar1_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penyediaan Media untuk Menjaring Kejadian Terkait Risiko Reputasi',  $pil_rep1['pilar1_1c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penunjukan PIC untuk Pemantauan Terhadap Informasi yang Meningkatkan Eksposure Risiko Reputasi',  $pil_rep1['pilar1_1d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->Row(array('2','Signifikansi Dan Materualitas Dampak Yang Ditimbulkan Akibat Kejadian Reputasi',  $pil_rep1['hasil_pil1_par2'],  $ket_pil_rep1['ket_in_rep_pil1_2'].$ket_pil_rep1['ket_in_rep_pil1_2a'].$ket_pil_rep1['ket_in_rep_pil1_2b'].$ket_pil_rep1['ket_in_rep_pil1_2c'].$ket_pil_rep1['ket_in_rep_pil1_2d']));

$pdf->Row2(array('','Signifikansi Dan Materualitas Dampak Yang Ditimbulkan Akibat Kejadian Reputasi',  $pil_rep1['pilar1_2'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jenis Dan Variasi Pemberitaan',  $pil_rep1['pilar1_2a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jangkauan Dan Kredibilitas Media Massa',  $pil_rep1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Kejadian Terkait dengan Risiko Reputasi pada Periode Penilaian',  $pil_rep1['pilar1_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Pemberitaan Negatif (Regional Jawa Tengah) pada Media Massa Cetak dan Elektronik',  $pil_rep1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Transparansi Informasi Keuangan'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Transparansi Informasi Keuangan',  $pil_rep3['hasil_pil3_par1'],  $ket_pil_rep3['ket_in_rep_pil3_1'].$ket_pil_rep3['ket_in_rep_pil3_1a'].$ket_pil_rep3['ket_in_rep_pil3_1b'].$ket_pil_rep3['ket_in_rep_pil3_1c']));
$pdf->Row2(array('','Transparansi Informasi Keuangan',  $pil_rep3['pilar3_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Transparansi Data Dokumen Dan Informasi Terhadap Laporan Keuangan Dan Non Keuangan',  $pil_rep3['pilar3_1a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Transparansi Rekrutmen Pegawai',  $pil_rep3['pilar3_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemutusan Hubungan Kerja',  $pil_rep3['pilar3_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Transparansi Produk Dan Layanan BPR',  $pil_rep3['hasil_pil3_par2'],  $ket_pil_rep3['ket_in_rep_pil3_2'].$ket_pil_rep3['ket_in_rep_pil3_2a'].$ket_pil_rep3['ket_in_rep_pil3_2b']));
$pdf->Row2(array('','Transparansi Produk Dan Layanan BPR',  $pil_rep3['pilar3_2'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kegiatan Pemasaran',  $pil_rep3['pilar3_2a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Transparansi Fasilitas Produk Dan Layanan',  $pil_rep3['pilar3_2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : LAINNYA'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_rep4['hasil_pil4_par1'], $ket_pil_rep4['ket_in_rep_pil4_1a'].$ket_pil_rep4['ket_in_rep_pil4_1b'].$ket_pil_rep4['ket_in_rep_pil4_1c']));
$pdf->Row2(array('','Laporan Pemeriksaan SKAI',  $pil_rep4['pilar4_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Laporan Hasil Monitoring Satuan Kerja Kepatuhan',  $pil_rep4['pilar4_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemberitaan Positif Tentang Kinerja dan Kegiatan Bank',  $pil_rep4['pilar4_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);














//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN REPUTASI', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);
$pdf->Row(array('Nilai Tertinggi',$hasil5['hasil_inheren_tertinggi']));
$pdf->Row(array('Nilai Terendah',$hasil5['hasil_inheren_terendah']));
$pdf->Row(array('Nilai rata-rata',$hasil5['hasil_inheren_rata_rata']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil5['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil5['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN REPUTASI', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_reputasi['ket_inheren']));






$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR REPUTASI');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko reputasi yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_reputasi1['pil1_total1'],  $ru_rep1['respon_pil1_1a'].$ru_rep1['respon_pil1_1b'].$ru_rep1['respon_pil1_1c'].$ru_rep1['respon_pil1_1d'].$ru_rep1['respon_pil1_1e']));


$pdf->Row2(array('','Apakah ketentuan dan kebijakan manajemen risiko reputasi yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP reputasi, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_reputasi1['pilar1_1a'], '
 

 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko reputasi yang disetujui Dewan Komisaris telah dilakukan (Ketentuan reputasi yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_reputasi1['pilar1_1b'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko reputasi dalam menjalankan tugas dan fungsinya',  $kpmr_reputasi1['pilar1_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko reputasi sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_reputasi1['pilar1_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_reputasi1['pilar1_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko reputasi secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_reputasi1['pil1_total2'],  $ru_rep1['respon_pil1_2a'].$ru_rep1['respon_pil1_2b'].$ru_rep1['respon_pil1_2c'].$ru_rep1['respon_pil1_2d'].$ru_rep1['respon_pil1_2e']));
$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko reputasi secara tertulis dan dalam forum rapat (terdapat notulen)',  $kpmr_reputasi1['pilar1_2a'], '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko reputasi kepada Direksi secara tertulis dan forum rapat',  $kpmr_reputasi1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko reputasi',  $kpmr_reputasi1['pilar1_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko reputasi',  $kpmr_reputasi1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_reputasi1['pilar1_2e'],  '
 

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko reputasi, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_reputasi1['pil1_total3'],  $ru_rep1['respon_pil1_3a'].$ru_rep1['respon_pil1_3b'].$ru_rep1['respon_pil1_3c']));
$pdf->Row2(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko reputasi (Pelatihan tentang manajemen risiko reputasi yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko reputasi)',  $kpmr_reputasi1['pilar1_3a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketentuan dan kebijakan manajemen risiko Reputasi yang disetujui Direksi apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP PerReputasian, SE Direksi, SK BWMK)',  $kpmr_reputasi1['pilar1_3b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko reputasi yang disetujui Direksi dilakukan (Ketentuan reputasi yang diterbitkan selama periode penilaian)',  $kpmr_reputasi1['pilar1_3c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko reputasi, dan melakukan komunikasi kebijakan Manajemen Risiko reputasi terhadap seluruh jenjang organisasi BPR?',  $kpmr_reputasi1['pil1_total4'],  $ru_rep1['respon_pil1_4a'].$ru_rep1['respon_pil1_4b'].$ru_rep1['respon_pil1_4c'].$ru_rep1['respon_pil1_4d'].$ru_rep1['respon_pil1_4e']));
$pdf->Row2(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko reputasi',  $kpmr_reputasi1['pilar1_4a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluru_reph unit kerja',  $kpmr_reputasi1['pilar1_4b'],  '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko reputasi kepada seluru_reph unit kerja',  $kpmr_reputasi1['pilar1_4c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_reputasi1['pilar1_4d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_reputasi1['pilar1_4e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi reputasi dan fungsi Manajemen Risiko reputasi?',  $kpmr_reputasi1['pil1_total5'],  $ru_rep1['respon_pil1_5a'].$ru_rep1['respon_pil1_5b'].$ru_rep1['respon_pil1_5c'].$ru_rep1['respon_pil1_5d']));
$pdf->Row2(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja perreputasi dan melaksanakan tugasnya secara independen',  $kpmr_reputasi1['pilar1_5a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di unit kerja reputasi telah didukung dengan kompetensi yang baik',  $kpmr_reputasi1['pilar1_5b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di satuan manajemen risiko reputasi telah didukung dengan kompetensi yang baik',  $kpmr_reputasi1['pilar1_5c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah proses perreputasi dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_reputasi1['pilar1_5d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko reputasi?',  $kpmr_reputasi1['pil1_total6'],  $ru_rep1['respon_pil1_6a'].$ru_rep1['respon_pil1_6b'].$ru_rep1['respon_pil1_6c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko reputasi, tidak terdapat perangkapan jabatan, independen',  $kpmr_reputasi1['pilar1_6a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_reputasi1['pilar1_6b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang reputasi',  $kpmr_reputasi1['pilar1_6c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr5['pil1_tingkat_risiko'],  $ket_kpmr_reputasi['ket_pil1']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko reputasi yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_reputasi2['pil2_total1'],  $ru_rep2['respon_pil2_1a'].$ru_rep2['respon_pil2_1b'].$ru_rep2['respon_pil2_1c'].$ru_rep2['respon_pil2_1d'].$ru_rep2['respon_pil2_1e']));


$pdf->Row2(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko reputasi',  $kpmr_reputasi2['pilar2_1a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko reputasi',  $kpmr_reputasi2['pilar2_1b'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan manajemen risiko reputasi dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_reputasi2['pilar2_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko reputasi memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko reputasi, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_reputasi2['pilar2_1d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_reputasi2['pilar2_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','"Apakah BPR:
1. memiliki prosedur Manajemen Risiko reputasi dan penetapan limit Risiko reputasi yang ditetapkan oleh Direksi ?
2. melaksanakan prosedur Manajemen Risiko reputasi dan penetapan limit Risiko reputasi secara konsisten untuk seluruh aktivitas ? Dan
3. melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko reputasi dan penetapan limit Risiko reputasi secara berkala?"',  $kpmr_reputasi2['pil2_total2'],  $ru_rep2['respon_pil2_2a'].$ru_rep2['respon_pil2_2b'].$ru_rep2['respon_pil2_2c'].$ru_rep2['respon_pil2_2d'].$ru_rep2['respon_pil2_2e'].$ru_rep2['respon_pil2_2f'].$ru_rep2['respon_pil2_2g'].$ru_rep2['respon_pil2_2h']));


$pdf->Row2(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko reputasi yang ditetapkan dalam SK Direksi',  $kpmr_reputasi2['pilar2_2a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko reputasi',  $kpmr_reputasi2['pilar2_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_reputasi2['pilar2_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko reputasi',  $kpmr_reputasi2['pilar2_2d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_reputasi2['pilar2_2e'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi reputasi',  $kpmr_reputasi2['pilar2_2f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_reputasi2['pilar2_2g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_reputasi2['pilar2_2h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko reputasi sesuai dengan ketentuan?',  $kpmr_reputasi2['pil2_total3'],  $ru_rep2['respon_pil2_3a'].$ru_rep2['respon_pil2_3b'].$ru_rep2['respon_pil2_3c']));


$pdf->Row2(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_reputasi2['pilar2_3a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_reputasi2['pilar2_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_reputasi2['pilar2_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr5['pil2_tingkat_risiko'],  $ket_kpmr_reputasi['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko reputasi yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko reputasi?',  $kpmr_reputasi3['pil3_total1'],  $ru_rep3['respon_pil3_1a'].$ru_rep3['respon_pil3_1b'].$ru_rep3['respon_pil3_1c'].$ru_rep3['respon_pil3_1d'].$ru_rep3['respon_pil3_1e'].$ru_rep3['respon_pil3_1f'].$ru_rep3['respon_pil3_1g'].$ru_rep3['respon_pil3_1h'].$ru_rep3['respon_pil3_1i'].$ru_rep3['respon_pil3_1j']));


$pdf->Row2(array('','Apakah dalam aktvitas reputasi seluruh SDM telah berpedoman pada penerapan manajemen risiko reputasi',  $kpmr_reputasi3['pilar3_1a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas reputasi',  $kpmr_reputasi3['pilar3_1b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses reputasi dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_reputasi3['pilar3_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses pengambilan keputusan bidang perreputasian dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_reputasi3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajamen risiko reputasi telah didukung dengan data reputasi yang akurat dan informatif',  $kpmr_reputasi3['pilar3_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajemen risiko reputasi telah melakukan analisa karakteristik risiko reputasi yang melekat pada produk dan layanan',  $kpmr_reputasi3['pilar3_1f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko reputasi telah dilakukan evaluasi',  $kpmr_reputasi3['pilar3_1g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pengukuran risiko reputasi telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_reputasi3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pemantauan risiko reputasi telah dilakukan evaluasi terhadap eksposur risiko reputasi',  $kpmr_reputasi3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apabila terdapat perubahan yang material dalam faktor risiko reputasi apakah juga dilakukan penyesuaian pelaporan',  $kpmr_reputasi3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko reputasi serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_reputasi3['pil3_total2'],  $ru_rep3['respon_pil3_2a'].$ru_rep3['respon_pil3_2b'].$ru_rep3['respon_pil3_2c'].$ru_rep3['respon_pil3_2d'].$ru_rep3['respon_pil3_2e']));


$pdf->Row2(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_reputasi3['pilar3_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi risiko reputasi dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_reputasi3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko reputasi yang lengkap dan cepat',  $kpmr_reputasi3['pilar3_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan reputasi terhadap kebijakan manajemen risiko reputasi (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_reputasi3['pilar3_2d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_reputasi3['pilar3_2e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr5['pil3_tingkat_risiko'],  $ket_kpmr_reputasi['ket_pil3']));


$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR REPUTASI', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Pengawasan Direksi dan Dewan Komisaris',$kpmr5['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr5['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr5['pil3_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr5['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr5['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR REPUTASI', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_reputasi['ket_kpmr']));




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI REPUTASI');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();






$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 7);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket5['inheren_reputasi'], $ket5['kpmr_reputasi'], $ket5['tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_ket5['inheren_reputasi'], $pembanding_ket5['kpmr_reputasi'], $pembanding_ket5['tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
$pdf->Row(array($inheren5['hasil_peringkat'], $kpmr5['hasil_peringkat'], $ket5['peringkat_tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_inheren5['hasil_peringkat'], $pembanding_kpmr5['hasil_peringkat'], $pembanding_ket5['peringkat_tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Tingkat Risiko',$ket5['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket5['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket5['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa











//Membuat Koneksi ke database akademik



$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(1);
$pdf->Cell(8, 5, '(PROFIL NILAI)');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();

$pdf->SetFillColor(51, 204, 255);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 1);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 1);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFillColor(204, 245, 255);
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Kepatuhan', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->Row(array($ket3['inheren_kepatuhan'], $ket3['inheren_kepatuhan'], $ket3['tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_ket3['inheren_kepatuhan'], $pembanding_ket3['kpmr_kepatuhan'], $pembanding_ket3['tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
$pdf->Row(array($inheren3['hasil_peringkat'], $kpmr3['hasil_peringkat'], $ket3['peringkat_tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_inheren3['hasil_peringkat'], $pembanding_kpmr3['hasil_peringkat'], $pembanding_ket3['peringkat_tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Reputasi', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->Row(array($ket5['inheren_reputasi'], $ket5['inheren_reputasi'], $ket5['tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_ket5['inheren_reputasi'], $pembanding_ket5['kpmr_reputasi'], $pembanding_ket5['tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
$pdf->Row(array($inheren5['hasil_peringkat'], $kpmr5['hasil_peringkat'], $ket5['peringkat_tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_inheren5['hasil_peringkat'], $pembanding_kpmr5['hasil_peringkat'], $pembanding_ket5['peringkat_tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->SetFillColor(51, 204, 255);
$pdf->Cell(47, 5,'Peringkat Risiko' , 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, $nilpro['total_nilai'], 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, $nilpro['ket_total_nilai'], 1, 0, 'C', 1);

$pdf->Cell(47, 5,'Dikutip dari laporan sebelumnya' , 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, $pembanding_nilpro['total_nilai'], 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, $pembanding_nilpro['ket_total_nilai'], 1, 0, 'C', 1);







$pdf->Ln();
$pdf->Ln();
$pdf->SetFillColor(51, 204, 255);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(188, 5, 'Uraian', 1, 0, 'C', 1);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->SetAligns(array());
$pdf->Ln();
$no =1;


$pdf->Row(array($nilpro['ket_nilai_risiko']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa






$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(10, 5, 'Dengan ini menyatakan bahwa seluruh informasi dalam pengisian profil risiko di BPR BKK Jateng adalah akurat dan sesuai');
$pdf->Ln();
$pdf->Cell(10, 5, 'dengan kondisi sebenarnya. Dengan Tindak lanjut atas profil risiko dan hasil perbaikan oleh Divisi Kantor Pusat dilakukan');
$pdf->Ln();
$pdf->Cell(10, 5, 'sebelum periode penilaian selanjutnya dan akan di evaluasi secara berkala');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(20);
$pdf->SetFillColor(224, 224, 23);
$pdf->Cell(190, 5, 'Semarang, ' . tgl_indo(date('Y-m-d')), 0, 1);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Kepala Divisi', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Kepala Bidang', 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(94, 40, '', 1, 0, 'C', 0);
$pdf->Cell(94, 40, '', 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(94, 5, '     Nama : ', 1, 0);
$pdf->Cell(94, 5, '     Nama : ', 1, 0);





$pdf->Output();
