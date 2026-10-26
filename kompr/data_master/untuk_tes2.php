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
$id = $_GET['id'];

$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
if (isset($_POST['submit'])) {
    include "../conn/conn.php";

    //pilar1
    $kas = $_POST['kas'];
    $giro_aba = $_POST['giro_aba'];
    $tabungan_aba = $_POST['tabungan_aba'];
    $total_aset = $_POST['total_aset'];
    $kewajiban_segera = $_POST['kewajiban_segera'];
    $tabungan = $_POST['tabungan'];
    $deposito = $_POST['deposito'];
    $deposito_1bln = $_POST['deposito_1bln'];
    $deposito_3bln = $_POST['deposito_3bln'];
    $deposito_6bln = $_POST['deposito_6bln'];
    $deposito_12bln = $_POST['deposito_12bln'];

    $dpk_lbh_2m = $_POST['dpk_lbh_2m'];
    $deposito_diatas_cr = $_POST['deposito_diatas_cr'];
    $deposito_diatas_lps = $_POST['deposito_diatas_lps'];
    $korporasi = $_POST['korporasi'];
    $dpk_des_thn_sebelum = $_POST['dpk_des_thn_sebelum'];
    
    $penempatan_pd_bank_lain = $_POST['penempatan_pd_bank_lain'];
    $modal_disetor = $_POST['modal_disetor'];
    $kredit_des_thn_sebelum = $_POST['kredit_des_thn_sebelum'];
    $pinjaman = $_POST['pinjaman'];
    $kredit_kolek_lancar = $_POST['kredit_kolek_lancar'];
    $pertumbuhan_kredit = $_POST['pertumbuhan_kredit'];
    
    $simpanan_tdk_dijamin_lps = $_POST['simpanan_tdk_dijamin_lps'];
    

    $besar_deposan25 = $_POST['besar_deposan25'];
    $besar_penabung25 = $_POST['besar_penabung25'];
    $deposito_rs = $_POST['deposito_rs'];
    $kas_besar_debet = $_POST['kas_besar_debet'];
    $kas_besar_kredit = $_POST['kas_besar_kredit'];
    $deposito_inti = $_POST['deposito_inti'];
    $sisa_jangka_waktu_deposito = $_POST['sisa_jangka_waktu_deposito'];
    $kredit_l_dp = $_POST['kredit_l_dp'];

    $aset_likuid = $kas + $giro_aba + $tabungan_aba;
    $kewajiban_lancar = $kewajiban_segera + $tabungan + $deposito;
    $pendanaan_jangka_pendek = $tabungan + $deposito_1bln + $deposito_3bln;
    $kewajiban_jangka_pendek = $kewajiban_segera + $tabungan + $deposito_1bln + $deposito_3bln;
    $pendanaan_non_inti = $simpanan_tdk_dijamin_lps + $deposito_diatas_cr + $deposito_diatas_lps + $korporasi;
    $alat_likuid = $kas + $penempatan_pd_bank_lain;
    $total_dpk = $tabungan + $deposito;
    $dpk_dijamin_lps = ($tabungan + $deposito)-$simpanan_tdk_dijamin_lps;
    $dpk_tdk_dijamin_lps = $total_dpk - $dpk_dijamin_lps;
    
    $deposan_tabungan_terbesar25 = $besar_deposan25 + $besar_penabung25;
    $arus_kas_netto = $kas - $kas_besar_debet;




    mysqli_query($conn, "UPDATE master_likuiditas_pilar1 SET 
    aset_likuid = '$aset_likuid',
    kas = '$kas',
    giro_aba = '$giro_aba',
    tabungan_aba = '$tabungan_aba',
    total_aset = '$total_aset',
    kewajiban_lancar = '$kewajiban_lancar',
    kewajiban_segera = '$kewajiban_segera',
    tabungan = '$tabungan',
    deposito = '$deposito',
    pendanaan_jangka_pendek = '$pendanaan_jangka_pendek',
    kewajiban_jangka_pendek = '$kewajiban_jangka_pendek',
    deposito_1bln = '$deposito_1bln',
    deposito_3bln = '$deposito_3bln',
    deposito_6bln = '$deposito_6bln',
    deposito_12bln = '$deposito_12bln',
    pendanaan_non_inti = '$pendanaan_non_inti',
    dpk_lbh_2m = '$dpk_lbh_2m',
    deposito_diatas_cr = '$deposito_diatas_cr',
    deposito_diatas_lps = '$deposito_diatas_lps',
    korporasi = '$korporasi',
    dpk_des_thn_sebelum = '$dpk_des_thn_sebelum',
    alat_likuid = '$alat_likuid',
    penempatan_pd_bank_lain = '$penempatan_pd_bank_lain',
    modal_disetor = '$modal_disetor',
    kredit_des_thn_sebelum = '$kredit_des_thn_sebelum',
    pinjaman = '$pinjaman',
    kredit_kolek_lancar = '$kredit_kolek_lancar',
    pertumbuhan_kredit = '$pertumbuhan_kredit',
    dpk_dijamin_lps = '$dpk_dijamin_lps',
    simpanan_tdk_dijamin_lps = '$simpanan_tdk_dijamin_lps',
    total_dpk = '$total_dpk',
    dpk_tdk_dijamin_lps = '$dpk_tdk_dijamin_lps',
    deposan_tabungan_terbesar25 = '$deposan_tabungan_terbesar25',
    besar_deposan25 = '$besar_deposan25',
    besar_penabung25 = '$besar_penabung25',
    deposito_rs = '$deposito_rs',
    arus_kas_netto = '$arus_kas_netto',
    kas_besar_debet = '$kas_besar_debet',
    kas_besar_kredit = '$kas_besar_kredit',
    deposito_inti = '$deposito_inti',
    sisa_jangka_waktu_deposito = '$sisa_jangka_waktu_deposito',
    kredit_l_dp = '$kredit_l_dp' WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=maslik&id=$id");
    exit();
}
?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Master Likuiditas</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Master Data Likuiditas Untuk Profil Risiko Kredit</h4>
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


                            <p class="text-muted font-13">
                                *semua parameter harus terisi jika (tidak ada) isi saja angka 0
                            </p>

                            <!-- PILAR 1-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>

                                            <th colspan="4">
                                                <h3><b>PILAR 1 :KOMPOSISI DAN KONSENTRASI ASET DAN KEWAJIBAN</b></h3>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th colspan="2">
                                                NOMINAL
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Aset Likuid</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="aset_likuid" value="<?= $pil1['aset_likuid'] ?>" class="form-control" id="aset_likuid" readonly></td>
                                            <td>KAS Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kas" value="<?= $pil1['kas'] ?>" class="form-control" id="kas">
                                                Giro ABA Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="giro_aba" value="<?= $pil1['giro_aba'] ?>" class="form-control" id="giro_aba">
                                                Tabungan ABA Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="tabungan_aba" value="<?= $pil1['tabungan_aba'] ?>" class="form-control" id="tabungan_aba">
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Total Aset</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="total_aset" value="<?= $pil1['total_aset'] ?>" class="form-control" id="total_aset"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kewajiban Lancar</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kewajiban_lancar" value="<?= $pil1['kewajiban_lancar'] ?>" class="form-control" id="kewajiban_lancar" readonly></td>
                                            <td>
                                                Kewajiban-kewajiban yang segera Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kewajiban_segera" value="<?= $pil1['kewajiban_segera'] ?>" class="form-control" id="kewajiban_segera">
                                                Tabungan Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="tabungan" value="<?= $pil1['tabungan'] ?>" class="form-control" id="tabungan">
                                                Deposito Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito" value="<?= $pil1['deposito'] ?>" class="form-control" id="deposito">
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pendanaan Jangka Pendek</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="pendanaan_jangka_pendek" value="<?= $pil1['pendanaan_jangka_pendek'] ?>" class="form-control" id="pendanaan_jangka_pendek" readonly></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kewajiban Jangka Pendek</th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kewajiban_jangka_pendek" value="<?= $pil1['kewajiban_jangka_pendek'] ?>" class="form-control" id="kewajiban_jangka_pendek" readonly></td>
                                            <td>
                                                Kewajiban-kewajiban yang segera Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kewajiban_segera" value="<?= $pil1['kewajiban_segera'] ?>" class="form-control" id="kewajiban_segera" disabled>
                                                Tabungan Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="tabungan" value="<?= $pil1['tabungan'] ?>" class="form-control" id="tabungan" disabled>
                                                Deposito 1 Bln Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_1bln" value="<?= $pil1['deposito_1bln'] ?>" class="form-control" id="deposito_1bln">
                                                Deposito 3 Bln Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_3bln" value="<?= $pil1['deposito_3bln'] ?>" class="form-control" id="deposito_3bln">
                                                Deposito 6 Bln Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_6bln" value="<?= $pil1['deposito_6bln'] ?>" class="form-control" id="deposito_6bln">
                                                Deposito 12 Bln Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_12bln" value="<?= $pil1['deposito_12bln'] ?>" class="form-control" id="deposito_12bln">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pendanaan Non Inti
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="pendanaan_non_inti" value="<?= $pil1['pendanaan_non_inti'] ?>" class="form-control" id="pendanaan_non_inti" readonly></td>
                                            <td>
                                                Simpanan tidak dijamin LPS Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="simpanan_tdk_dijamin_lps" value="<?= $pil1['simpanan_tdk_dijamin_lps'] ?>" class="form-control" id="simpanan_tdk_dijamin_lps">
                                                Deposito rate diatas counter rate Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_diatas_cr" value="<?= $pil1['deposito_diatas_cr'] ?>" class="form-control" id="deposito_diatas_cr">
                                                Deposito rate diatas LPS Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_diatas_lps" value="<?= $pil1['deposito_diatas_lps'] ?>" class="form-control" id="deposito_diatas_lps">
                                                Korporasi Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="korporasi" value="<?= $pil1['korporasi'] ?>" class="form-control" id="korporasi">
                                                DPK periode sebelumnya Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="dpk_des_thn_sebelum" value="<?= $pil1['dpk_des_thn_sebelum'] ?>" class="form-control" id="dpk_des_thn_sebelum">

                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>6</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Alat Likuid
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="alat_likuid" value="<?= $pil1['alat_likuid'] ?>" class="form-control" id="alat_likuid" readonly></td>
                                            <td>
                                                Kas Rp.<input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kas" value="<?= $pil1['kas'] ?>" class="form-control" id="kas" disabled>
                                                Penempatan pada bank lain Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="penempatan_pd_bank_lain" value="<?= $pil1['penempatan_pd_bank_lain'] ?>" class="form-control" id="penempatan_pd_bank_lain">
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>7</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Modal Disetor
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="modal_disetor" value="<?= $pil1['modal_disetor'] ?>" class="form-control" id="modal_disetor"></td>
                                            <td>
                                                Kredit periode sebelumnya Rp.<input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kredit_des_thn_sebelum" value="<?= $pil1['kredit_des_thn_sebelum'] ?>" class="form-control" id="kredit_des_thn_sebelum">
                                                Pinjaman Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="pinjaman" value="<?= $pil1['pinjaman'] ?>" class="form-control" id="pinjaman">
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit Kolek Lancar
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kredit_kolek_lancar" value="<?= $pil1['kredit_kolek_lancar'] ?>" class="form-control" id="kredit_kolek_lancar"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Pertumbuhan Kredit
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="pertumbuhan_kredit" value="<?= $pil1['pertumbuhan_kredit'] ?>" class="form-control" id="pertumbuhan_kredit"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>8</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">DPK Yang Dijamin LPS
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="dpk_dijamin_lps" value="<?= $pil1['dpk_dijamin_lps'] ?>" class="form-control" id="dpk_dijamin_lps" disabled></td>
                                            <td>
                                                Deposito Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito" value="<?= $pil1['deposito'] ?>" class="form-control" id="deposito" disabled>
                                                Tabungan Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="tabungan" value="<?= $pil1['tabungan'] ?>" class="form-control" id="tabungan" disabled>
                                                Simpanan tidak dijamin LPS Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="simpanan_tdk_dijamin_lps" value="<?= $pil1['simpanan_tdk_dijamin_lps'] ?>" class="form-control" id="simpanan_tdk_dijamin_lps" disabled>
                                                Total DPK Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="total_dpk" value="<?= $pil1['total_dpk'] ?>" class="form-control" id="total_dpk" disabled>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>9</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">DPK Yang TIDAK Dijamin LPS
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="dpk_tdk_dijamin_lps" value="<?= $pil1['dpk_tdk_dijamin_lps'] ?>" class="form-control" id="dpk_tdk_dijamin_lps" disabled></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>10</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">25 Deposan + Tabungan Terbesar
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposan_tabungan_terbesar25" value="<?= $pil1['deposan_tabungan_terbesar25'] ?>" class="form-control" id="deposan_tabungan_terbesar25" disabled></td>
                                            <td>
                                                25 Besar Deposan Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="besar_deposan25" value="<?= $pil1['besar_deposan25'] ?>" class="form-control" id="besar_deposan25">
                                                25 Besar Penabung Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="besar_penabung25" value="<?= $pil1['besar_penabung25'] ?>" class="form-control" id="besar_penabung25">
                                            </td>


                                        </tr>
                                        <tr>
                                            <th>
                                                <center>11</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Deposito Rate Spesial
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_rs" value="<?= $pil1['deposito_diatas_cr'] ?>" class="form-control" id="deposito_rs" disabled></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>12</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Arus Kas Netto
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="arus_kas_netto" value="<?= $pil1['arus_kas_netto'] ?>" class="form-control" id="arus_kas_netto" disabled></td>
                                            <td>
                                            Saldo Kas Akhir Periode Sebelumnya Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kas_besar_debet" value="<?= $pil1['kas_besar_debet'] ?>" class="form-control" id="kas_besar_debet">
                                            Saldo Kas Akhir Periode Penilaian Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kas_besar_kredit" value="<?= $pil1['kas'] ?>" class="form-control" id="kas_besar_kredit" disabled>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>13</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Deposito Inti
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="deposito_inti" value="<?= $pil1['deposito_inti'] ?>" class="form-control" id="deposito_inti"></td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <th>
                                                <center>14</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Sisa Jangka Waktu Deposito
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="sisa_jangka_waktu_deposito" value="<?= $pil1['sisa_jangka_waktu_deposito'] ?>" class="form-control" id="sisa_jangka_waktu_deposito"></td>
                                            <td></td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center>15</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">Kredit L dan DP JT
                                            </th>
                                            <td>Rp. <input type="text" onchange="handleChange(this.value)" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(?!^)-/g, '').replace(/--/g, '-')" form="my_form" name="kredit_l_dp" value="<?= $pil1['kredit_l_dp'] ?>" class="form-control" id="kredit_l_dp"></td>
                                            <td></td>

                                        </tr>


                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->































                            <hr>
                            </hr>

                            <br></br>









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