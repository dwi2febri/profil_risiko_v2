<?php
if (empty($id) || $id === null) {
  // Display modal notification on page load
  $displayModal = true;
} else {
  $displayModal = false;
}
?>
<script>
  $(document).ready(function() {
    <?php if ($displayModal) { ?>
      $('#myModal').modal('show');
    <?php } ?>
  });

  window.onclick = null;
  
</script>

<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Notifikasi</h5>
        <a href="javascript:history.back()"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
      <h5><center><b>Mohon untuk memilih laporan risiko di (menu dashboard -> laporan profil risiko -> klik (aktif)) terlebih dahulu.</b></center></h5>
      </div>
      <div class="modal-footer">
      <a href="javascript:history.back()"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></a>
      </div>
    </div>
  </div>
</div>


<?php
include "../fungsi/fungsi.php";



$id = $_GET['id'];



$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = '$id'"));

if (isset($_POST['submit'])) {
    include "../conn/conn.php";

    //pilar1
    $aba = $_POST['aba'];
    $aset_produktif = $_POST['aset_produktif'];
    $total_aset = $_POST['total_aset'];
    $kyd = $_POST['kyd'];
    $noa_kyd = $_POST['noa_kyd'];
    $debitur_inti25 = $_POST['debitur_inti25'];
    $kredit_3sektor_ekonomi_terbesar = $_POST['kredit_3sektor_ekonomi_terbesar'];
    $kredit_spg = $_POST['kredit_spg'];
    $kredit_pbta = $_POST['kredit_pbta'];
    $kredit_jpendek = $_POST['kredit_jpendek'];
    $kredit_jmenengah = $_POST['kredit_jmenengah'];
    $kredit_jpanjang = $_POST['kredit_jpanjang'];
    $kredit_agunan_tb = $_POST['kredit_agunan_tb'];
    $kredit_agunan_kb = $_POST['kredit_agunan_kb'];
    $kredit_agunan_kr2 = $_POST['kredit_agunan_kr2'];
    $kredit_ta = $_POST['kredit_ta'];
    $kredit_kub = $_POST['kredit_kub'];
    $kredit_korporasi = $_POST['kredit_korporasi'];
    $kredit_pep = $_POST['kredit_pep'];
    $kredit_lebih350 = $_POST['kredit_lebih350'];
    $kredit_joglo_mitra = $_POST['kredit_joglo_mitra'];


    //pilar 2
    $aset_produktif_bermasalah = $_POST['aset_produktif_bermasalah'];
    $total_aset_produktif = $_POST['aset_produktif'];
    $kredit_bermasalah = $_POST['kredit_bermasalah'];
    $noa_kredit_bermasalah = $_POST['noa_kredit_bermasalah'];
    $kredit_bermasalah_neto = $_POST['kredit_bermasalah_neto'];
    $saldo_ppap = $_POST['saldo_ppap'];
    $ayda = $_POST['ayda'];
    $modal_inti = $_POST['modal_inti'];
    $macet_jatuh_tempo = $_POST['macet_jatuh_tempo'];
    $kkr = $_POST['kkr'];
    $kredit_par4 = $_POST['kredit_par4'];
    $osc_bln_sebelumnya = $_POST['osc_bln_sebelumnya'];
    $osc_2bln_sebelumnya = $_POST['osc_2bln_sebelumnya'];
    $kredit_dp = $_POST['kredit_dp'];
    $noa_fpd_6bln = $_POST['noa_fpd_6bln'];
    $noa_ekspansi_6bln = $_POST['noa_ekspansi_6bln'];
    $nominal_fpd_6bln = $_POST['nominal_fpd_6bln'];
    $plafond_ekspansi_6bln = $_POST['plafond_ekspansi_6bln'];
    $npl_kredit_sd150 = $_POST['npl_kredit_sd150'];
    $kyd_plafon_sd150 = $_POST['kyd_plafon_sd150'];
    $noa_kredit_sd150 = $_POST['noa_kredit_sd150'];
    $npl_kredit_diatas50 = $_POST['npl_kredit_diatas50'];
    $kyd_plafon_diatas50 = $_POST['kyd_plafon_diatas50'];
    $npl_apht = $_POST['npl_apht'];
    $kyd_apht = $_POST['kyd_apht'];
    $npl_skmht = $_POST['npl_skmht'];
    $kyd_skmht = $_POST['kyd_skmht'];
    $npl_agunan_lrd_bakidebet = $_POST['npl_agunan_lrd_bakidebet'];
    $kredit_agunan_lrd_bakidebet = $_POST['kredit_agunan_lrd_bakidebet'];


    //pilar 3
    $osc_akhir_tahun_lalu = $_POST['osc_akhir_tahun_lalu'];
    $noa_osc_akhir_tahun_lalu = $_POST['noa_osc_akhir_tahun_lalu'];
    $npl_akhir_tahun_lalu = $_POST['npl_akhir_tahun_lalu'];
    $noa_npl_akhir_tahun_lalu = $_POST['noa_npl_akhir_tahun_lalu'];
    $osc_per_bln_penilaian = $_POST['kyd'];

    $pertumbuhan_rata2_bpr_thn_lalu = $_POST['pertumbuhan_rata2_bpr_thn_lalu'];
    $pertumbuhan_rata2_bpr = $_POST['pertumbuhan_rata2_bpr'];
    $td_pp_l = $_POST['td_pp_l'];
    $td_pp_dp = $_POST['td_pp_dp'];
    $td_pp_kl = $_POST['td_pp_kl'];
    $td_pp_d = $_POST['td_pp_d'];
    $td_pp_m = $_POST['td_pp_m'];
    $td_pp_l_noa = $_POST['td_pp_l_noa'];
    $td_pp_dp_noa = $_POST['td_pp_dp_noa'];
    $td_pp_kl_noa = $_POST['td_pp_kl_noa'];
    $td_pp_d_noa = $_POST['td_pp_d_noa'];
    $td_pp_m_noa = $_POST['td_pp_m_noa'];
    $td_ps_l = $_POST['td_ps_l'];
    $td_ps_dp = $_POST['td_ps_dp'];
    $td_ps_kl = $_POST['td_ps_kl'];
    $td_ps_d = $_POST['td_ps_d'];
    $td_ps_m = $_POST['td_ps_m'];
    $td_ps_l_noa = $_POST['td_ps_l_noa'];
    $td_ps_dp_noa = $_POST['td_ps_dp_noa'];
    $td_ps_kl_noa = $_POST['td_ps_kl_noa'];
    $td_ps_d_noa = $_POST['td_ps_d_noa'];
    $td_ps_m_noa = $_POST['td_ps_m_noa'];
    $d_pp_l = $_POST['d_pp_l'];
    $d_pp_dp = $_POST['d_pp_dp'];
    $d_pp_kl = $_POST['d_pp_kl'];
    $d_pp_d = $_POST['d_pp_d'];
    $d_pp_m = $_POST['d_pp_m'];
    $d_pp_l_noa = $_POST['d_pp_l_noa'];
    $d_pp_dp_noa = $_POST['d_pp_dp_noa'];
    $d_pp_kl_noa = $_POST['d_pp_kl_noa'];
    $d_pp_d_noa = $_POST['d_pp_d_noa'];
    $d_pp_m_noa = $_POST['d_pp_m_noa'];
    $d_ps_l = $_POST['d_ps_l'];
    $d_ps_dp = $_POST['d_ps_dp'];
    $d_ps_kl = $_POST['d_ps_kl'];
    $d_ps_d = $_POST['d_ps_d'];
    $d_ps_m = $_POST['d_ps_m'];
    $d_ps_l_noa = $_POST['d_ps_l_noa'];
    $d_ps_dp_noa = $_POST['d_ps_dp_noa'];
    $d_ps_kl_noa = $_POST['d_ps_kl_noa'];
    $d_ps_d_noa = $_POST['d_ps_d_noa'];
    $d_ps_m_noa = $_POST['d_ps_m_noa'];
    $osc_2bln_sebelumnya = $_POST['osc_2bln_sebelumnya'];
    $noa_2bln_sebelumnya = $_POST['noa_2bln_sebelumnya'];
    $npl_2bln_sebelumnya = $_POST['npl_2bln_sebelumnya'];
    $rasio_2bln_sebelumnya = $_POST['rasio_2bln_sebelumnya'];
    $osc_1bln_sebelumnya = $_POST['osc_1bln_sebelumnya'];
    $noa_1bln_sebelumnya = $_POST['noa_1bln_sebelumnya'];
    $npl_1bln_sebelumnya = $_POST['npl_1bln_sebelumnya'];
    $noa_npl_2bln_sebelumnya = $_POST['noa_npl_2bln_sebelumnya'];
    $rasio_npl_2bln_sebelumnya = $_POST['rasio_npl_2bln_sebelumnya'];
    $rasio_1bln_sebelumnya = $_POST['rasio_1bln_sebelumnya'];
    $osc_bln_penilaian = $_POST['kyd'];
    $noa_bln_penilaian = $_POST['noa_kyd'];
    $npl_bln_penilaian = $_POST['aset_produktif_bermasalah'];
    $rasio_bln_penilaian = $_POST['rasio_bln_penilaian'];

    $aba_tertinggi = $_POST['aba_tertinggi'];
    $aba_bank_umum = $_POST['aba_bank_umum'];
    $aba_bpr = $_POST['aba_bpr'];
    $noa_npl_1bln_sebelumnya = $_POST['noa_npl_1bln_sebelumnya'];
    $rasio_npl_1bln_sebelumnya = $_POST['rasio_npl_1bln_sebelumnya'];
    $noa_npl_bln_penilaian = $_POST['noa_kredit_bermasalah'];
    $rasio_npl_bln_penilaian = $_POST['rasio_npl_bln_penilaian'];



    $pertumbuhan_kyd_bpr = (($osc_per_bln_penilaian - $osc_akhir_tahun_lalu) / $osc_akhir_tahun_lalu) * 100;
    $rasio_pertumbuhan_rata2_bpr = (($pertumbuhan_rata2_bpr - $pertumbuhan_rata2_bpr_thn_lalu) / $pertumbuhan_rata2_bpr_thn_lalu) * 100;



    mysqli_query($conn, "UPDATE master_kredit_pilar1 SET 
    aba = '$aba',
    aset_produktif = '$aset_produktif',
    kyd = '$kyd',
    noa_kyd = '$noa_kyd',
    debitur_inti25 = '$debitur_inti25',
    kredit_3sektor_ekonomi_terbesar = '$kredit_3sektor_ekonomi_terbesar',
    kredit_spg = '$kredit_spg',
    kredit_pbta = '$kredit_pbta',
    kredit_jpendek = '$kredit_jpendek',
    kredit_jmenengah = '$kredit_jmenengah',
    kredit_jpanjang = '$kredit_jpanjang',
    kredit_agunan_tb = '$kredit_agunan_tb',
    kredit_agunan_kb = '$kredit_agunan_kb',
    kredit_agunan_kr2 = '$kredit_agunan_kr2',
    kredit_ta = '$kredit_ta',
    kredit_kub = '$kredit_kub',
    kredit_korporasi = '$kredit_korporasi',
    kredit_pep = '$kredit_pep',
    kredit_lebih350 = '$kredit_lebih350',
    kredit_joglo_mitra = '$kredit_joglo_mitra'
    WHERE id_profil_risiko = '$id'");



    mysqli_query($conn, "UPDATE master_kredit_pilar2 SET 
    aset_produktif_bermasalah = '$aset_produktif_bermasalah',
    total_aset_produktif = '$total_aset_produktif',
    kredit_bermasalah = '$kredit_bermasalah',
    noa_kredit_bermasalah = '$noa_kredit_bermasalah',
    kredit_bermasalah_neto = '$kredit_bermasalah_neto',
    saldo_ppap = '$saldo_ppap',
    ayda = '$ayda',
    kyd = '$kyd',
    macet_jatuh_tempo = '$macet_jatuh_tempo',
    kkr = '$kkr',
    kredit_par4 = '$kredit_par4',
    osc_bln_sebelumnya = '$osc_bln_sebelumnya',
    osc_2bln_sebelumnya = '$osc_2bln_sebelumnya',
    kredit_dp = '$kredit_dp',
    noa_fpd_6bln = '$noa_fpd_6bln',
    noa_ekspansi_6bln = '$noa_ekspansi_6bln',
    nominal_fpd_6bln = '$nominal_fpd_6bln',
    plafond_ekspansi_6bln = '$plafond_ekspansi_6bln',
    npl_kredit_sd150 = '$npl_kredit_sd150',
    kyd_plafon_sd150 = '$kyd_plafon_sd150',
    noa_kredit_sd150 = '$noa_kredit_sd150',
    npl_kredit_diatas50 = '$npl_kredit_diatas50',
    kyd_plafon_diatas50 = '$kyd_plafon_diatas50',
    npl_apht = '$npl_apht',
    kyd_apht = '$kyd_apht',
    npl_skmht = '$npl_skmht',
    kyd_skmht = '$kyd_skmht',
    npl_agunan_lrd_bakidebet = '$npl_agunan_lrd_bakidebet',
    kredit_agunan_lrd_bakidebet = '$kredit_agunan_lrd_bakidebet' WHERE id_profil_risiko = '$id'");


    mysqli_query($conn, "UPDATE master_kredit_pilar3 SET 
    osc_akhir_tahun_lalu = '$osc_akhir_tahun_lalu',
    noa_osc_akhir_tahun_lalu = '$noa_osc_akhir_tahun_lalu',
    npl_akhir_tahun_lalu = '$npl_akhir_tahun_lalu',
    noa_npl_akhir_tahun_lalu = '$noa_npl_akhir_tahun_lalu',
    osc_per_bln_penilaian = '$osc_per_bln_penilaian',
    pertumbuhan_rata2_bpr_thn_lalu = '$pertumbuhan_rata2_bpr_thn_lalu',
    pertumbuhan_rata2_bpr = '$pertumbuhan_rata2_bpr',
    pertumbuhan_kyd_bpr = '$pertumbuhan_kyd_bpr',
    rasio_pertumbuhan_rata2_bpr = '$rasio_pertumbuhan_rata2_bpr',
    td_pp_l = '$td_pp_l',
    td_pp_dp = '$td_pp_dp',
    td_pp_kl = '$td_pp_kl',
    td_pp_d = '$td_pp_d',
    td_pp_m = '$td_pp_m',
    td_pp_l_noa = '$td_pp_l_noa',
    td_pp_dp_noa = '$td_pp_dp_noa',
    td_pp_kl_noa = '$td_pp_kl_noa',
    td_pp_d_noa = '$td_pp_d_noa',
    td_pp_m_noa = '$td_pp_m_noa',
    td_ps_l = '$td_ps_l',
    td_ps_dp = '$td_ps_dp',
    td_ps_kl = '$td_ps_kl',
    td_ps_d = '$td_ps_d',
    td_ps_m = '$td_ps_m',
    td_ps_l_noa = '$td_ps_l_noa',
    td_ps_dp_noa = '$td_ps_dp_noa',
    td_ps_kl_noa = '$td_ps_kl_noa',
    td_ps_d_noa = '$td_ps_d_noa',
    td_ps_m_noa = '$td_ps_m_noa',
    d_pp_l = '$d_pp_l',
    d_pp_dp = '$d_pp_dp',
    d_pp_kl = '$d_pp_kl',
    d_pp_d = '$d_pp_d',
    d_pp_m = '$d_pp_m',
    d_pp_l_noa = '$d_pp_l_noa',
    d_pp_dp_noa = '$d_pp_dp_noa',
    d_pp_kl_noa = '$d_pp_kl_noa',
    d_pp_d_noa = '$d_pp_d_noa',
    d_pp_m_noa = '$d_pp_m_noa',
    d_ps_l = '$d_ps_l',
    d_ps_dp = '$d_ps_dp',
    d_ps_kl = '$d_ps_kl',
    d_ps_d = '$d_ps_d',
    d_ps_m = '$d_ps_m',
    d_ps_l_noa = '$d_ps_l_noa',
    d_ps_dp_noa = '$d_ps_dp_noa',
    d_ps_kl_noa = '$d_ps_kl_noa',
    d_ps_d_noa = '$d_ps_d_noa',
    d_ps_m_noa = '$d_ps_m_noa',
    osc_2bln_sebelumnya = '$osc_2bln_sebelumnya',
    noa_2bln_sebelumnya = '$noa_2bln_sebelumnya',
    npl_2bln_sebelumnya = '$npl_2bln_sebelumnya',
    rasio_2bln_sebelumnya = '$rasio_2bln_sebelumnya',
    osc_1bln_sebelumnya = '$osc_1bln_sebelumnya',
    noa_1bln_sebelumnya = '$noa_1bln_sebelumnya',
    npl_1bln_sebelumnya = '$npl_1bln_sebelumnya',
    noa_npl_2bln_sebelumnya = '$noa_npl_2bln_sebelumnya',
    rasio_npl_2bln_sebelumnya = '$rasio_npl_2bln_sebelumnya',
    rasio_1bln_sebelumnya = '$rasio_1bln_sebelumnya',
    osc_bln_penilaian = '$osc_bln_penilaian',
    noa_bln_penilaian = '$noa_bln_penilaian',
    npl_bln_penilaian = '$npl_bln_penilaian',
    rasio_bln_penilaian = '$rasio_bln_penilaian',
    aba = '$aba',
    aba_tertinggi = '$aba_tertinggi',
    aba_bank_umum = '$aba_bank_umum',
    aba_bpr = '$aba_bpr',
    noa_npl_1bln_sebelumnya = '$noa_npl_1bln_sebelumnya',
    rasio_npl_1bln_sebelumnya = '$rasio_npl_1bln_sebelumnya',
    noa_npl_bln_penilaian = '$noa_npl_bln_penilaian',
    rasio_npl_bln_penilaian = '$rasio_npl_bln_penilaian' WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=maskre&id=$id");
    exit();
}
?>

<script>
    function handleChange(value) {
        console.log(value)
    }
</script>













<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Master Kredit</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Master Data Kredit Untuk Profil Risiko Kredit</h4>
                            <p class="text-muted font-13">
                                Isilah Data keuangan dibawah ini
                            </p>
                            <hr>
                            </hr>


                            <div class="row">
                                <div class="col-12">
                                    <div class="col-lg-1 ">
                                        <button class="btn btn-primary" form="my_form" type="submit" name="submit">Submit</button>
                                    </div>

                                </div>
                            </div>

                            <br></br>



                            <div class="row">
                                <div class="col-12">
                                    <div class="col-sm-6">
                                    <label class="form-label">Upload File CSV</label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" id="inputGroupFile04">
                                            <button class="btn btn-dark" type="button">upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted font-40">
                                <b>*semua parameter harus terisi jika (tidak ada) isi saja angka 0 </br>
                                    * Dalam Mengisi Rasio bilangan decimal gunakan (.) contoh : penulisan 10,25 ditulis 10.25 (mohon untuk menginput angka saja bukan huruf)</b>
                            </p>
                            <!-- PILAR 1-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>PILAR 1 :KOMPOSISI PORTOFOLIO DAN TINGKAT KONSENTRASI KREDIT</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class="text-center">
                                                NOMINAL
                                            </th>
                                            <th class="text-center">
                                                NOA
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">ABA</th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="aba" value="<?= $pil1['aba'] ?>" class="form-control" id="rupiah"></td>
                                            <td></td>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Produktif</th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="aset_produktif" value="<?= $pil1['aset_produktif'] ?>" class="form-control" id="aset_produktif"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Aset</th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="total_aset" value="<?= $pil1['total_aset'] ?>" class="form-control" id="total_aset" disabled></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Yang Diberikan (KYD)</th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kyd" value="<?= $pil1['kyd'] ?>" class="form-control" id="kyd"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_kyd" value="<?= $pil1['noa_kyd'] ?>" class="form-control" id="noa_kyd"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">25 Debitur Inti
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="debitur_inti25" value="<?= $pil1['debitur_inti25'] ?>" class="form-control" id="debitur_inti25"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>6</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit 3 Sektor Ekonomi terbesar
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_3sektor_ekonomi_terbesar" value="<?= $pil1['kredit_3sektor_ekonomi_terbesar'] ?>" class="form-control" id="kredit_3sektor_ekonomi_terbesar"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>7</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Dengan Skema Potong Gaji (diluar KKPP)
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_spg" value="<?= $pil1['kredit_spg'] ?>" class="form-control" id="kredit_spg"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>8</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Dengan Pola Bayar Tanpa Angsuran
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_pbta" value="<?= $pil1['kredit_pbta'] ?>" class="form-control" id="kredit_pbta"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>9</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Jangka Pendek ( ≤ 36 bulan)
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_jpendek" value="<?= $pil1['kredit_jpendek'] ?>" class="form-control" id="kredit_jpendek"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>10</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Jangka Menengah (> 36 bulan sd ≤ 60 bulan)
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_jmenengah" value="<?= $pil1['kredit_jmenengah'] ?>" class="form-control" id="kredit_jmenengah"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>11</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Jangka Panjang > 60 bulan
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_jpanjang" value="<?= $pil1['kredit_jpanjang'] ?>" class="form-control" id="kredit_jpanjang"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>12</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Dengan Agunan Tanah dan Bangunan
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_agunan_tb" value="<?= $pil1['kredit_agunan_tb'] ?>" class="form-control" id="kredit_agunan_tb"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>13</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Agunan Kendaraan Bermotor
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_agunan_kb" value="<?= $pil1['kredit_agunan_kb'] ?>" class="form-control" id="kredit_agunan_kb"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>14</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Agunan Kendaraan Roda 2
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_agunan_kr2" value="<?= $pil1['kredit_agunan_kr2'] ?>" class="form-control" id="kredit_agunan_kr2"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>15</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Tanpa Agunan
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_ta" value="<?= $pil1['kredit_ta'] ?>" class="form-control" id="kredit_ta"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>16</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Produk KUB
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_kub" value="<?= $pil1['kredit_kub'] ?>" class="form-control" id="kredit_kub"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>17</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Korporasi
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_korporasi" value="<?= $pil1['kredit_korporasi'] ?>" class="form-control" id="kredit_korporasi"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>18</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit PEP
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_pep" value="<?= $pil1['kredit_pep'] ?>" class="form-control" id="kredit_pep"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>19</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit plafon > 350 jt
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_lebih350" value="<?= $pil1['kredit_lebih350'] ?>" class="form-control" id="kredit_lebih350"></td>
                                            <td></td>


                                        </tr>
                                        <tr>
                                            <th>
                                                <center>20</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Joglo Mitra
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_joglo_mitra" value="<?= $pil1['kredit_joglo_mitra'] ?>" class="form-control" id="kredit_joglo_mitra"></td>
                                            <td></td>


                                        </tr>


                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->































                            <hr>
                            </hr>

                            <br></br>




                            <!-- PILAR 2-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>PILAR 2 :KUALITAS ASET</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class="text-center">
                                                NOMINAL
                                            </th>
                                            <th class="text-center">
                                                NOA
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Produktif Bermasalah
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="aset_produktif_bermasalah" value="<?= $pil2['aset_produktif_bermasalah'] ?>" class="form-control" id="aset_produktif_bermasalah"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Aset Produktif (otomatis terinput)
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="#" value="<?= $pil2['total_aset_produktif'] ?>" class="form-control" id="#" disabled></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Bermasalah (NPL Gross)
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_bermasalah" value="<?= $pil2['kredit_bermasalah'] ?>" class="form-control" id="kredit_bermasalah"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NOA Kredit Bermasalah (NPL Gross)
                                            </th>
                                            <td></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_kredit_bermasalah" value="<?= $pil2['noa_kredit_bermasalah'] ?>" class="form-control" id="noa_kredit_bermasalah"></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Bermasalah Neto (NPL Net)
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_bermasalah_neto" value="<?= $pil2['kredit_bermasalah_neto'] ?>" class="form-control" id="kredit_bermasalah_neto"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>6</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Saldo PPAP
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="saldo_ppap" value="<?= $pil2['saldo_ppap'] ?>" class="form-control" id="saldo_ppap"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>7</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">AYDA
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="ayda" value="<?= $pil2['ayda'] ?>" class="form-control" id="ayda"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>8</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Modal Inti
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" name="modal_inti" class="form-control" value="<?= $pil2['modal_inti'] ?>" id="modal_inti" disabled></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>9</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Macet melewati Jatuh Tempo Kredit
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="macet_jatuh_tempo" value="<?= $pil2['macet_jatuh_tempo'] ?>" class="form-control" id="macet_jatuh_tempo"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>10</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Yang Diberikan (KYD) (otomatis terinput)

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="-" class="form-control" value="<?= $pil2['kyd'] ?>" id="-" disabled></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>11</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Kualitas Rendah

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kkr" value="<?= $pil2['kkr'] ?>" class="form-control" id="kkr"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>12</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit PAR 4

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_par4" value="<?= $pil2['kredit_par4'] ?>" class="form-control" id="kredit_par4"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>13</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">OSC Bulan Sebelumnya

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="osc_bln_sebelumnya" value="<?= $pil2['osc_bln_sebelumnya'] ?>" class="form-control" id="osc_bln_sebelumnya"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>14</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">OSC 2 Bulan Sebelumnya

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="osc_2bln_sebelumnya" value="<?= $pil2['osc_2bln_sebelumnya'] ?>" class="form-control" id="osc_2bln_sebelumnya"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>15</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit DP (PAR 3 + PAR 4 )

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_dp" value="<?= $pil2['kredit_dp'] ?>" class="form-control" id="kredit_dp"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>16</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NOA FPD 6 Bulan Terakhir

                                            </th>
                                            <td></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_fpd_6bln" value="<?= $pil2['noa_fpd_6bln'] ?>" class="form-control" id="noa_fpd_6bln"></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>17</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NOA Ekspansi 6 Bulan Terakhir

                                            </th>
                                            <td></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_ekspansi_6bln" value="<?= $pil2['noa_ekspansi_6bln'] ?>" class="form-control" id="noa_ekspansi_6bln"></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>18</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Nominal FPD 6 Bulan Terakhir

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="nominal_fpd_6bln" value="<?= $pil2['nominal_fpd_6bln'] ?>" class="form-control" id="nominal_fpd_6bln"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>19</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Plafond Ekspansi 6 Bulan Terakhir

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="plafond_ekspansi_6bln" value="<?= $pil2['plafond_ekspansi_6bln'] ?>" class="form-control" id="plafond_ekspansi_6bln"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>20</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL Kredit plafon s/d 150 juta

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_kredit_sd150" value="<?= $pil2['npl_kredit_sd150'] ?>" class="form-control" id="npl_kredit_sd150"></td>
                                            <td></td>


                                        </tr>


                                        <tr>
                                            <th>
                                                <center>21</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total KYD Plafond s/d 150 jt

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kyd_plafon_sd150" value="<?= $pil2['kyd_plafon_sd150'] ?>" class="form-control" id="kyd_plafon_sd150"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>22</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NOA Kredit Plafond s/d 150jt

                                            </th>
                                            <td></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_kredit_sd150" value="<?= $pil2['noa_kredit_sd150'] ?>" class="form-control" id="noa_kredit_sd150"></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>23</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL Kredit plafon diatas 50 juta

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_kredit_diatas50" value="<?= $pil2['npl_kredit_diatas50'] ?>" class="form-control" id="npl_kredit_diatas50"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>24</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total KYD Plafond diatas 50 jt

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kyd_plafon_diatas50" value="<?= $pil2['kyd_plafon_diatas50'] ?>" class="form-control" id="kyd_plafon_diatas50"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>25</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL Kredit Dengan Perikatan APHT

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_apht" value="<?= $pil2['npl_apht'] ?>" class="form-control" id="npl_apht"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>26</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">KYD Kredit Dengan Perikatan APHT

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kyd_apht" value="<?= $pil2['kyd_apht'] ?>" class="form-control" id="kyd_apht"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>27</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL Kredit Dengan Perikatan SKMHT

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_skmht" value="<?= $pil2['npl_skmht'] ?>" class="form-control" id="npl_skmht"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center>28</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">KYD Kredit Dengan Perikatan SKMHT

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kyd_skmht" value="<?= $pil2['kyd_skmht'] ?>" class="form-control" id="kyd_skmht"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>29</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit NPL Nilai Agunan Lebih Rendah dari Baki Debet

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_agunan_lrd_bakidebet" value="<?= $pil2['npl_agunan_lrd_bakidebet'] ?>" class="form-control" id="npl_agunan_lrd_bakidebet"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>30</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet

                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="kredit_agunan_lrd_bakidebet" value="<?= $pil2['kredit_agunan_lrd_bakidebet'] ?>" class="form-control" id=""></td>
                                            <td></td>


                                        </tr>


                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->




                            <hr>
                            </hr>

                            <br></br>



                            <!-- PILAR 3-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>PILAR 3 :STRATEGI PENYEDIAAN DANA</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class="text-center">
                                                NOMINAL
                                            </th>
                                            <th class="text-center">
                                                NOA & RASIO
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">OSC akhir tahun lalu</th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="osc_akhir_tahun_lalu" value="<?= $pil3['osc_akhir_tahun_lalu'] ?>" class="form-control" id="osc_akhir_tahun_lalu"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_osc_akhir_tahun_lalu" value="<?= $pil3['noa_osc_akhir_tahun_lalu'] ?>" class="form-control" id="noa_osc_akhir_tahun_lalu"></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">NPL akhir tahun lalu</th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_akhir_tahun_lalu" value="<?= $pil3['npl_akhir_tahun_lalu'] ?>" class="form-control" id="npl_akhir_tahun_lalu"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_npl_akhir_tahun_lalu" value="<?= $pil3['noa_npl_akhir_tahun_lalu'] ?>" class="form-control" id="noa_npl_akhir_tahun_lalu"></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">OSC per bulan penilaian (otomatis terisi)</th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="osc_per_bln_penilaian" value="<?= $pil3['osc_per_bln_penilaian'] ?>" class="form-control" id="osc_per_bln_penilaian" disabled></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pertumbuhan Kyd<br></br>Rata rata Pertumbuhan kredit industri BPR tingkat kabupaten/Kota </br><a href="https://www.bi.go.id/id/statistik/ekonomi-keuangan/sekda/StatistikRegionalDetail.aspx?idprov=33" target="_blank"> https://www.bi.go.id/id/statistik/ekonomi-keuangan/sekda/StatistikRegionalDetail.aspx?idprov=33</a></th>
                                            <td>

                                            Pertumbuhan Bpr des tahun sebelumnya <input type="number" form="my_form" name="pertumbuhan_rata2_bpr_thn_lalu" value="<?= $pil3['pertumbuhan_rata2_bpr_thn_lalu'] ?>" class="form-control" id="pertumbuhan_rata2_bpr_thn_lalu">
                                            Pertumbuhan rata-rata Bpr <input type="number" form="my_form" name="pertumbuhan_rata2_bpr" value="<?= $pil3['pertumbuhan_rata2_bpr'] ?>" class="form-control" id="pertumbuhan_rata2_bpr">
                                            </td>
                                            <td>Rasio pertumbuhan kyd <input type="text" form="my_form" name="pertumbuhan_kyd_bpr" value="<?= $pil3['pertumbuhan_kyd_bpr'] ?>" class="form-control" id="pertumbuhan_kyd_bpr" disabled>
                                                Rasio pertumbuhan rata-rata Bpr <input type="text" form="my_form" name="rasio_pertumbuhan_rata2_bpr" value="<?= $pil3['rasio_pertumbuhan_rata2_bpr'] ?>" class="form-control" id="rasio_pertumbuhan_rata2_bpr" disabled></td>

                                        </tr>

                                        <tr>
                                            <td>
                                                <center>5</center>
                                            </td>
                                            <td class="text-nowrap" scope="row">Pertumbuhan Sektor Ekonomi yang tidak dikuasai
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>

                                            </td>
                                            <td class="text-nowrap" scope="row"><b>5.1 Periode Penilaian</b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">L
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_l" value="<?= $pil3['td_pp_l'] ?>" class="form-control" id="td_pp_l"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_l_noa" value="<?= $pil3['td_pp_l_noa'] ?>" class="form-control" id="td_pp_l_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">DP
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_dp" value="<?= $pil3['td_pp_dp'] ?>" class="form-control" id="td_pp_dp"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_dp_noa" value="<?= $pil3['td_pp_dp_noa'] ?>" class="form-control" id="td_pp_dp_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">KL
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_kl" value="<?= $pil3['td_pp_kl'] ?>" class="form-control" id="td_pp_kl"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_kl_noa" value="<?= $pil3['td_pp_kl_noa'] ?>" class="form-control" id="td_pp_kl_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">D
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_d" value="<?= $pil3['td_pp_d'] ?>" class="form-control" id="td_pp_d"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_d_noa" value="<?= $pil3['td_pp_d_noa'] ?>" class="form-control" id="td_pp_d_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">M
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_m" value="<?= $pil3['td_pp_m'] ?>" class="form-control" id="td_pp_m"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_pp_m_noa" value="<?= $pil3['td_pp_m_noa'] ?>" class="form-control" id="td_pp_m_noa"></td>

                                        </tr>


                                        <tr>
                                            <td>

                                            </td>
                                            <td class="text-nowrap" scope="row"><b>5.2 Periode Sebelumnya</b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">L
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_l" value="<?= $pil3['td_ps_l'] ?>" class="form-control" id="td_ps_l"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_l_noa" value="<?= $pil3['td_ps_l_noa'] ?>" class="form-control" id="td_ps_l_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">DP
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_dp" value="<?= $pil3['td_ps_dp'] ?>" class="form-control" id="td_ps_dp"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_dp_noa" value="<?= $pil3['td_ps_dp_noa'] ?>" class="form-control" id="td_ps_dp_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">KL
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_kl" value="<?= $pil3['td_ps_kl'] ?>" class="form-control" id="td_ps_kl"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_kl_noa" value="<?= $pil3['td_ps_kl_noa'] ?>" class="form-control" id="td_ps_kl_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">D
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_d" value="<?= $pil3['td_ps_d'] ?>" class="form-control" id="td_ps_d"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_d_noa" value="<?= $pil3['td_ps_d_noa'] ?>" class="form-control" id="td_ps_d_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">M
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_m" value="<?= $pil3['td_ps_m'] ?>" class="form-control" id="td_ps_m"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="td_ps_m_noa" value="<?= $pil3['td_ps_m_noa'] ?>" class="form-control" id="td_ps_m_noa"></td>

                                        </tr>




                                        <tr>
                                            <td>
                                                <center>6</center>
                                            </td>
                                            <td class="text-nowrap" scope="row">Pertumbuhan Sektor Ekonomi yang dikuasai
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr>
                                            <td>

                                            </td>
                                            <td class="text-nowrap" scope="row"><b>6.1 Periode Penilaian</b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">L
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_l" value="<?= $pil3['d_pp_l'] ?>" class="form-control" id="d_pp_l"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_l_noa" value="<?= $pil3['d_pp_l_noa'] ?>" class="form-control" id="d_pp_l_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">DP
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_dp" value="<?= $pil3['d_pp_dp'] ?>" class="form-control" id="d_pp_dp"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_dp_noa" value="<?= $pil3['d_pp_dp_noa'] ?>" class="form-control" id="d_pp_dp_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">KL
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_kl" value="<?= $pil3['d_pp_kl'] ?>" class="form-control" id="d_pp_kl"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_kl_noa" value="<?= $pil3['d_pp_kl_noa'] ?>" class="form-control" id="d_pp_kl_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">D
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_d" value="<?= $pil3['d_pp_d'] ?>" class="form-control" id="d_pp_d"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_d_noa" value="<?= $pil3['d_pp_d_noa'] ?>" class="form-control" id="d_pp_d_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">M
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_m" value="<?= $pil3['d_pp_m'] ?>" class="form-control" id="d_pp_m"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_pp_m_noa" value="<?= $pil3['d_pp_m_noa'] ?>" class="form-control" id="d_pp_m_noa"></td>

                                        </tr>


                                        <tr>
                                            <td>

                                            </td>
                                            <td class="text-nowrap" scope="row"><b>6.2 Periode Sebelumnya</b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">L
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_l" value="<?= $pil3['d_ps_l'] ?>" class="form-control" id="d_ps_l"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_l_noa" value="<?= $pil3['d_ps_l_noa'] ?>" class="form-control" id="d_ps_l_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">DP
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_dp" value="<?= $pil3['d_ps_dp'] ?>" class="form-control" id="d_ps_dp"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_dp_noa" value="<?= $pil3['d_ps_dp_noa'] ?>" class="form-control" id="d_ps_dp_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">KL
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_kl" value="<?= $pil3['d_ps_kl'] ?>" class="form-control" id="d_ps_kl"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_kl_noa" value="<?= $pil3['d_ps_kl_noa'] ?>" class="form-control" id="d_ps_kl_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">D
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_d" value="<?= $pil3['d_ps_d'] ?>" class="form-control" id="d_ps_d"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_d_noa" value="<?= $pil3['d_ps_d_noa'] ?>" class="form-control" id="d_ps_d_noa"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">M
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_m" value="<?= $pil3['d_ps_m'] ?>" class="form-control" id="d_ps_m"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="d_ps_m_noa" value="<?= $pil3['d_ps_m_noa'] ?>" class="form-control" id="d_ps_m_noa"></td>

                                        </tr>




                                        <tr>
                                            <td>
                                                <center>7</center>
                                            </td>
                                            <td class="text-nowrap" scope="row">Pertumbuhan OSC dan NPL
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">OSC 2 bulan sebelumnya
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="osc_2bln_sebelumnya" value="<?= $pil3['osc_2bln_sebelumnya'] ?>" class="form-control" id="osc_2bln_sebelumnya"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_2bln_sebelumnya" value="<?= $pil3['noa_2bln_sebelumnya'] ?>" class="form-control" id="noa_2bln_sebelumnya">
                                                Rasio <input type="text" form="my_form" name="rasio_2bln_sebelumnya" value="<?= $pil3['rasio_2bln_sebelumnya'] ?>" class="form-control" id="rasio_2bln_sebelumnya"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">OSC 1 bulan sebelumnya
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="osc_1bln_sebelumnya" value="<?= $pil3['osc_1bln_sebelumnya'] ?>" class="form-control" id="osc_1bln_sebelumnya"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_1bln_sebelumnya" value="<?= $pil3['noa_1bln_sebelumnya'] ?>" class="form-control" id="noa_1bln_sebelumnya">
                                                Rasio <input type="text" form="my_form" name="rasio_1bln_sebelumnya" value="<?= $pil3['rasio_1bln_sebelumnya'] ?>" class="form-control" id="rasio_1bln_sebelumnya"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">OSC periode penilaian (nominatif & noa otomatis terisi)
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="osc_bln_penilaian" value="<?= $pil3['osc_bln_penilaian'] ?>" class="form-control" id="osc_bln_penilaian" disabled></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_bln_penilaian" value="<?= $pil3['noa_bln_penilaian'] ?>" class="form-control" id="noa_bln_penilaian" disabled>
                                                Rasio <input type="text" form="my_form" name="rasio_bln_penilaian" value="<?= $pil3['rasio_bln_penilaian'] ?>" class="form-control" id="rasio_bln_penilaian"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">NPL 2 bulan sebelumnya
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_2bln_sebelumnya" value="<?= $pil3['npl_2bln_sebelumnya'] ?>" class="form-control" id="npl_2bln_sebelumnya"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_npl_2bln_sebelumnya" value="<?= $pil3['noa_npl_2bln_sebelumnya'] ?>" class="form-control" id="noa_npl_2bln_sebelumnya">
                                                Rasio <input type="text" form="my_form" name="rasio_npl_2bln_sebelumnya" value="<?= $pil3['rasio_npl_2bln_sebelumnya'] ?>" class="form-control" id="rasio_npl_2bln_sebelumnya"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">NPL 1 bulan sebelumnya
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_1bln_sebelumnya" value="<?= $pil3['npl_1bln_sebelumnya'] ?>" class="form-control" id="npl_1bln_sebelumnya"></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_npl_1bln_sebelumnya" value="<?= $pil3['noa_npl_1bln_sebelumnya'] ?>" class="form-control" id="noa_npl_1bln_sebelumnya">
                                                Rasio <input type="text" form="my_form" name="rasio_npl_1bln_sebelumnya" value="<?= $pil3['rasio_npl_1bln_sebelumnya'] ?>" class="form-control" id="rasio_npl_1bln_sebelumnya"></td>

                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">NPL Periode Penilaian (nominatif & noa otomatis terisi)
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="npl_bln_penilaian" value="<?= $pil3['npl_bln_penilaian'] ?>" class="form-control" id="npl_bln_penilaian" disabled></td>
                                            <td>Noa <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="noa_npl_bln_penilaian" value="<?= $pil3['noa_npl_bln_penilaian'] ?>" class="form-control" id="noa_npl_bln_penilaian" disabled>
                                                Rasio <input type="text" form="my_form" name="rasio_npl_bln_penilaian" value="<?= $pil3['rasio_npl_bln_penilaian'] ?>" class="form-control" id="rasio_npl_bln_penilaian"></td>

                                        </tr>










                                        <tr>
                                            <td>
                                                <center>8</center>
                                            </td>
                                            <td class="text-nowrap" scope="row">Penempatan ABA
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">Total ABA
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" name="aba" value="<?= $pil3['aba'] ?>" class="form-control" id="aba" disabled></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">ABA Pada satu bank tertinggi
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="aba_tertinggi" value="<?= $pil3['aba_tertinggi'] ?>" class="form-control" id="aba_tertinggi"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">ABA pada bank umum
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="aba_bank_umum" value="<?= $pil3['aba_bank_umum'] ?>" class="form-control" id="aba_bank_umum"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>

                                            <th class="text-nowrap" scope="row">ABA pada BPR
                                            </th>
                                            <td>Rp. <input type="number" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9]/, '')" form="my_form" name="aba_bpr" value="<?= $pil3['aba_bpr'] ?>" class="form-control" id="aba_bpr"></td>
                                            <td></td>
                                        </tr>








                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->




                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>


            <!-- end row -->


            <!-- end row -->



            <!-- end row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->



</div>