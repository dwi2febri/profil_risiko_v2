
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

$pdf->Cell(8, 5, '(RISIKO KREDIT)');
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR KREDIT');
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
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melaksanakan audit secara berkala terhadap penerapan Manajemen Risiko kredit,menyampaikan laporan hasil audit intern, dan memastikan tindak lanjut atas temuan pemeriksaan?',  $kpmr_kredit4['pil4_total1'],  $ru4['respon_pil4_1a'].$ru4['respon_pil4_1b'].$ru4['respon_pil4_1c'].$ru4['respon_pil4_1d'].$ru4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko kredit di berapa cabang atau unit kerja di bidang manajemen risiko kreditApakah dalam aktvitas perkreditan seluruh SDM telah berpedoman pada penerapan manajemen risiko kredit',  $kpmr_kredit4['pilar4_1a'], '



 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko kredit telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_kredit4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko kredit telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk kepatuhan kebijakan manajemen risiko kredit',  $kpmr_kredit4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko kredit',  $kpmr_kredit4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko kredit',  $kpmr_kredit4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko kredit telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_kredit4['pil4_total2'],  $ru4['respon_pil4_2a'].$ru4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perkreditan',  $kpmr_kredit4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja perkreditan telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_kredit4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr1['pil4_tingkat_risiko'],  $ket_kpmr_kredit['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR KREDIT', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr1['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr1['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr1['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR KREDIT', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_kredit['ket_kpmr']));





$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI KREDIT');
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


$pdf->Row(array($ket1['inheren_kredit'], $ket1['kpmr_kredit'], $ket1['tingkat_risiko'], $ket1['tingkat_kualitas_mr'],  $pembanding_ket1['inheren_kredit'], $pembanding_ket1['kpmr_kredit'], $pembanding_ket1['tingkat_risiko'], $pembanding_ket1['tingkat_kualitas_mr']));
$pdf->Row(array($inheren1['hasil_peringkat'], $kpmr1['hasil_peringkat'], $ket1['peringkat_tingkat_risiko'], $ket1['tingkat_kualitas_mr'],  $pembanding_inheren1['hasil_peringkat'], $pembanding_kpmr1['hasil_peringkat'], $pembanding_ket1['peringkat_tingkat_risiko'], $pembanding_ket1['tingkat_kualitas_mr']));
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


$pdf->Row(array('Tingkat Risiko',$ket1['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket1['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket1['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa


















//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO OPERASIONAL)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN OPERASIONAL');
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
$pdf->Row(array('PILAR 3 : Penyelenggaraan Teknologi Informasi (TI)'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Penyelenggaraan Teknologi Informasi (TI)',  $pil_op3['hasil_pil3_par1'],  $ket_pil_op3['ket_in_op_pil3_1'].$ket_pil_op3['ket_in_op_pil3_1a'].$ket_pil_op3['ket_in_op_pil3_1b'].$ket_pil_op3['ket_in_op_pil3_1c'].$ket_pil_op3['ket_in_op_pil3_1d'].$ket_pil_op3['ket_in_op_pil3_1e'].$ket_pil_op3['ket_in_op_pil3_1f'].$ket_pil_op3['ket_in_op_pil3_1g'].$ket_pil_op3['ket_in_op_pil3_1h']));
$pdf->Row2(array('','Pelaksanaan Audit Atas TI',  $pil_op3['pilar3_1i'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('LAINNYA'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Faktor Lainnya',  $pil_op6['hasil_pil6_par1'], $ket_pil_op6['ket_in_op_pil6_1a'].$ket_pil_op6['ket_in_op_pil6_1b'].$ket_pil_op6['ket_in_op_pil6_1c'].$ket_pil_op6['ket_in_op_pil6_1d'].$ket_pil_op6['ket_in_op_pil6_1e'].$ket_pil_op6['ket_in_op_pil6_1f']));
$pdf->Row2(array('','Pengawasan Internal',  $pil_op6['pilar6_1e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN OPERASIONAL', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);


$pdf->Row(array('Hasil Penilaian Lainnya',$hasil2['pil6_tingkat_risiko']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil2['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil2['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN OPERASIONAL', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_operasional['ket_inheren']));








$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR OPERASIONAL');
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
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PE Audit Internal telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko operasional, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_operasional4['pil4_total1'],  $ru_op4['respon_pil4_1a'].$ru_op4['respon_pil4_1b'].$ru_op4['respon_pil4_1c'].$ru_op4['respon_pil4_1d'].$ru_op4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko operasional di berapa cabang atau unit kerja di bidang manajemen risiko operasional',  $kpmr_operasional4['pilar4_1a'], '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko operasional telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_operasional4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko operasional telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk kepatuhan kebijakan manajemen risiko operasional',  $kpmr_operasional4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko operasional',  $kpmr_operasional4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko operasional',  $kpmr_operasional4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko operasional telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_operasional4['pil4_total2'],  $ru_op4['respon_pil4_2a'].$ru_op4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional peroperasionalan',  $kpmr_operasional4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja operasional telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_operasional4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr2['pil4_tingkat_risiko'],  $ket_kpmr_operasional['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR OPERASIONAL', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr2['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr2['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr2['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR OPERASIONAL', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_operasional['ket_kpmr']));




//Membuat Koneksi ke database akademik






$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI OPERASIONAL');
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


$pdf->Row(array($ket2['inheren_operasional'], $ket2['kpmr_operasional'], $ket2['tingkat_risiko'], $ket2['tingkat_kualitas_mr'],  $pembanding_ket2['inheren_operasional'], $pembanding_ket2['kpmr_operasional'], $pembanding_ket2['tingkat_risiko'], $pembanding_ket2['tingkat_kualitas_mr']));
$pdf->Row(array($inheren2['hasil_peringkat'], $kpmr2['hasil_peringkat'], $ket2['peringkat_tingkat_risiko'], $ket2['tingkat_kualitas_mr'],  $pembanding_inheren2['hasil_peringkat'], $pembanding_kpmr2['hasil_peringkat'], $pembanding_ket2['peringkat_tingkat_risiko'], $pembanding_ket2['tingkat_kualitas_mr']));
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


$pdf->Row(array('Tingkat Risiko',$ket2['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket2['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket2['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa












//Membuat Koneksi ke database akademik
$pdf->AddPage();


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
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('2','Signifikasi Tindak Lanjut Atas Temuan Pelanggaran',  $pil_kep1['hasil_pil1_par2'],  $ket_pil_kep1['ket_in_kep_pil1_2'].$ket_pil_kep1['ket_in_kep_pil1_2a'].$ket_pil_kep1['ket_in_kep_pil1_2b'].$ket_pil_kep1['ket_in_kep_pil1_2c'].$ket_pil_kep1['ket_in_kep_pil1_2d'].$ket_pil_kep1['ket_in_kep_pil1_2e'].$ket_pil_kep1['ket_in_kep_pil1_2f'].$ket_pil_kep1['ket_in_kep_pil1_2g'].$ket_pil_kep1['ket_in_kep_pil1_2h']));

$pdf->Row2(array('','Signifikasi Tindak Lanjut Atas Temuan Pelanggaran',  $pil_kep1['pilar1_2'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



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
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko kepatuhan, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_kepatuhan4['pil4_total1'],  $ru_kep4['respon_pil4_1a'].$ru_kep4['respon_pil4_1b'].$ru_kep4['respon_pil4_1c'].$ru_kep4['respon_pil4_1d'].$ru_kep4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko kepatuhan di berapa cabang atau unit kerja di bidang manajemen risiko kepatuhan',  $kpmr_kepatuhan4['pilar4_1a'], '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko kepatuhan telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_kepatuhan4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko kepatuhan telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk kepatuhan kebijakan manajemen risiko kepatuhan',  $kpmr_kepatuhan4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko kepatuhan',  $kpmr_kepatuhan4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko kepatuhan',  $kpmr_kepatuhan4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko kepatuhan telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_kepatuhan4['pil4_total2'],  $ru_kep4['respon_pil4_2a'].$ru_kep4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perkepatuhanan',  $kpmr_kepatuhan4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja kepatuhan telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_kepatuhan4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr3['pil4_tingkat_risiko'],  $ket_kpmr_kepatuhan['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR KEPATUHAN', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr3['pil4_tingkat_risiko']));

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

$pdf->Cell(8, 5, '(RISIKO LIKUIDITAS)');
$pdf->Ln();
$pdf->Ln();


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR LIKUIDITAS');
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
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko likuiditas, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_likuiditas4['pil4_total1'],  $ru_lik4['respon_pil4_1a'].$ru_lik4['respon_pil4_1b'].$ru_lik4['respon_pil4_1c'].$ru_lik4['respon_pil4_1d'].$ru_lik4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko likuiditas di berapa cabang atau unit kerja di bidang manajemen risiko likuiditas',  $kpmr_likuiditas4['pilar4_1a'], '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko likuiditas telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_likuiditas4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko likuiditas telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk likuiditas kebijakan manajemen risiko likuiditas',  $kpmr_likuiditas4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko likuiditas',  $kpmr_likuiditas4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko likuiditas',  $kpmr_likuiditas4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko likuiditas telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_likuiditas4['pil4_total2'],  $ru_lik4['respon_pil4_2a'].$ru_lik4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perlikuiditasan',  $kpmr_likuiditas4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja likuiditas telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_likuiditas4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr4['pil4_tingkat_risiko'],  $ket_kpmr_likuiditas['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR LIKUIDITAS', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr4['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr4['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr4['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR LIKUIDITAS', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_likuiditas['ket_kpmr']));




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI LIKUIDITAS');
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


$pdf->Row(array($ket4['inheren_likuiditas'], $ket4['kpmr_likuiditas'], $ket4['tingkat_risiko'], $ket4['tingkat_kualitas_mr'],  $pembanding_ket4['inheren_likuiditas'], $pembanding_ket4['kpmr_likuiditas'], $pembanding_ket4['tingkat_risiko'], $pembanding_ket4['tingkat_kualitas_mr']));
$pdf->Row(array($inheren4['hasil_peringkat'], $kpmr4['hasil_peringkat'], $ket4['peringkat_tingkat_risiko'], $ket4['tingkat_kualitas_mr'],  $pembanding_inheren4['hasil_peringkat'], $pembanding_kpmr4['hasil_peringkat'], $pembanding_ket4['peringkat_tingkat_risiko'], $pembanding_ket4['tingkat_kualitas_mr']));
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


$pdf->Row(array('Tingkat Risiko',$ket4['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket4['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket4['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa






//Membuat Koneksi ke database akademik
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
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : LAINNYA'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_rep4['hasil_pil4_par1'], $ket_pil_rep4['ket_in_rep_pil4_1a'].$ket_pil_rep4['ket_in_rep_pil4_1b'].$ket_pil_rep4['ket_in_rep_pil4_1c']));
$pdf->Row2(array('','Laporan Pemeriksaan SKAI',  $pil_rep4['pilar4_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);













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

$pdf->Row(array('Hasil Penilaian Lainnya',$hasil5['pil4_tingkat_risiko']));
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
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko reputasi, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_reputasi4['pil4_total1'],  $ru_rep4['respon_pil4_1a'].$ru_rep4['respon_pil4_1b'].$ru_rep4['respon_pil4_1c'].$ru_rep4['respon_pil4_1d'].$ru_rep4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko reputasi di berapa cabang atau unit kerja di bidang manajemen risiko reputasi',  $kpmr_reputasi4['pilar4_1a'], '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko reputasi telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_reputasi4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko reputasi telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk reputasi kebijakan manajemen risiko reputasi',  $kpmr_reputasi4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko reputasi',  $kpmr_reputasi4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko reputasi',  $kpmr_reputasi4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko reputasi telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_reputasi4['pil4_total2'],  $ru_rep4['respon_pil4_2a'].$ru_rep4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perreputasian',  $kpmr_reputasi4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja reputasi telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_reputasi4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr5['pil4_tingkat_risiko'],  $ket_kpmr_reputasi['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR REPUTASI', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr5['pil4_tingkat_risiko']));

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




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR STRATEJIK');
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
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko stratejik, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_stratejik4['pil4_total1'],  $ru_stra4['respon_pil4_1a'].$ru_stra4['respon_pil4_1b'].$ru_stra4['respon_pil4_1c'].$ru_stra4['respon_pil4_1d'].$ru_stra4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko stratejik di berapa cabang atau unit kerja di bidang manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko stratejik telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_stratejik4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko stratejik telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk stratejik kebijakan manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko stratejik telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_stratejik4['pil4_total2'],  $ru_stra4['respon_pil4_2a'].$ru_stra4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perstratejikan',  $kpmr_stratejik4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja stratejik telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_stratejik4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR STRATEJIK', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr6['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr6['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr6['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR STRATEJIK', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_stratejik['ket_kpmr']));




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI STRATEJIK');
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


$pdf->Row(array($ket6['inheren_stratejik'], $ket6['kpmr_stratejik'], $ket6['tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_ket6['inheren_stratejik'], $pembanding_ket6['kpmr_stratejik'], $pembanding_ket6['tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
$pdf->Row(array($inheren6['hasil_peringkat'], $kpmr6['hasil_peringkat'], $ket6['peringkat_tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_inheren6['hasil_peringkat'], $pembanding_kpmr6['hasil_peringkat'], $pembanding_ket6['peringkat_tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
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


$pdf->Row(array('Tingkat Risiko',$ket6['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket6['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket6['ket_profil_kpmr']));
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
$pdf->Cell(188, 5, 'Risiko Kredit', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->Row(array($ket1['inheren_kredit'], $ket1['kpmr_kredit'], $ket1['tingkat_risiko'], $ket1['tingkat_kualitas_mr'],  $pembanding_ket1['inheren_kredit'], $pembanding_ket1['kpmr_kredit'], $pembanding_ket1['tingkat_risiko'], $pembanding_ket1['tingkat_kualitas_mr']));
$pdf->Row(array($inheren1['hasil_peringkat'], $kpmr1['hasil_peringkat'], $ket1['peringkat_tingkat_risiko'], $ket1['tingkat_kualitas_mr'],  $pembanding_inheren1['hasil_peringkat'], $pembanding_kpmr1['hasil_peringkat'], $pembanding_ket1['peringkat_tingkat_risiko'], $pembanding_ket1['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Operasional', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->Row(array($ket2['inheren_operasional'], $ket2['kpmr_operasional'], $ket2['tingkat_risiko'], $ket2['tingkat_kualitas_mr'],  $pembanding_ket2['inheren_operasional'], $pembanding_ket2['kpmr_operasional'], $pembanding_ket2['tingkat_risiko'], $pembanding_ket2['tingkat_kualitas_mr']));
$pdf->Row(array($inheren2['hasil_peringkat'], $kpmr2['hasil_peringkat'], $ket2['peringkat_tingkat_risiko'], $ket2['tingkat_kualitas_mr'],  $pembanding_inheren2['hasil_peringkat'], $pembanding_kpmr2['hasil_peringkat'], $pembanding_ket2['peringkat_tingkat_risiko'], $pembanding_ket2['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Kepatuhan', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->Row(array($ket3['inheren_kepatuhan'], $ket3['kpmr_kepatuhan'], $ket3['tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_ket3['inheren_kepatuhan'], $pembanding_ket3['kpmr_kepatuhan'], $pembanding_ket3['tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
$pdf->Row(array($inheren3['hasil_peringkat'], $kpmr3['hasil_peringkat'], $ket3['peringkat_tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_inheren3['hasil_peringkat'], $pembanding_kpmr3['hasil_peringkat'], $pembanding_ket3['peringkat_tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Likuiditas', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->Row(array($ket4['inheren_likuiditas'], $ket4['kpmr_likuiditas'], $ket4['tingkat_risiko'], $ket4['tingkat_kualitas_mr'],  $pembanding_ket4['inheren_likuiditas'], $pembanding_ket4['kpmr_likuiditas'], $pembanding_ket4['tingkat_risiko'], $pembanding_ket4['tingkat_kualitas_mr']));
$pdf->Row(array($inheren4['hasil_peringkat'], $kpmr4['hasil_peringkat'], $ket4['peringkat_tingkat_risiko'], $ket4['tingkat_kualitas_mr'],  $pembanding_inheren4['hasil_peringkat'], $pembanding_kpmr4['hasil_peringkat'], $pembanding_ket4['peringkat_tingkat_risiko'], $pembanding_ket4['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Reputasi', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->Row(array($ket5['inheren_reputasi'], $ket5['kpmr_reputasi'], $ket5['tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_ket5['inheren_reputasi'], $pembanding_ket5['kpmr_reputasi'], $pembanding_ket5['tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
$pdf->Row(array($inheren5['hasil_peringkat'], $kpmr5['hasil_peringkat'], $ket5['peringkat_tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_inheren5['hasil_peringkat'], $pembanding_kpmr5['hasil_peringkat'], $pembanding_ket5['peringkat_tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Stratejik', 1, 0, 'C', 1);
$pdf->Ln();

$pdf->Row(array($ket6['inheren_stratejik'], $ket6['kpmr_stratejik'], $ket6['tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_ket6['inheren_stratejik'], $pembanding_ket6['kpmr_stratejik'], $pembanding_ket6['tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
$pdf->Row(array($inheren6['hasil_peringkat'], $kpmr6['hasil_peringkat'], $ket6['peringkat_tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_inheren6['hasil_peringkat'], $pembanding_kpmr6['hasil_peringkat'], $pembanding_ket6['peringkat_tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
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
