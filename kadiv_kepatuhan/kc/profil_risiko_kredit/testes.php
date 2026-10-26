<?php
$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$id'"));
$pil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$id'"));
       
?>
       <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Kredit Inhern Divisi</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren Profil Risiko Kredit</h4>

                            <hr>
                            </hr>



                            </br>


                            <!-- kredit-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
                                                <h4>
                                                    <center><b>RISIKO KREDIT INHEREN</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr style="color: #050505;">
                                            <th width="2%">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center" width="20%">
                                                PARAMETER
                                            </th>

                                            <th class="text-center" width="10%">
                                                NOMINAL
                                            </th>
                                            <th class="text-center" width="13%">
                                                RASIO
                                            </th>
                                            <th class="text-center" width="10%">
                                                DIVISI PEMASARAN
                                            </th>
                                            <th class="text-center" width="5%">
                                                DIVISI PENYELESAIAN KREDIT
                                            </th>
                                            
                                            <th class="text-center" width="10%">
                                                KETERANGAN PEMASARAN
                                            </th>
                                            <th class="text-center" width="25%">
                                                KETERANGAN DPK
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                <center>Aset Produktif</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['total_aset']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['ap_per_ta'] ?></td>

                                            <td>
                                                <center><?= $hsl1 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1_1'] ?></textarea>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a.<center>Penempatan Bank Lain</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset Produktif</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['pbl_per_tap'] ?> </td>

                                            <td>
                                                <center><?= $hsl1a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1a, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b.<center>Aba Pada 1 Bank Tertinggi</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P3['aba_tertinggi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apbt_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1b, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c.<center>Aba Pada BPR</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P3['aba_bpr']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['abapb_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1c ?></center>
                                            </td>
                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1c, 2) ?></center>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d.<center>NOA Kredit fon s/d 150 juta</center>
                                                <hr>
                                                </hr>
                                                <center>NOA KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['noa_kredit_sd150']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['noa_kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2f ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nkp150_per_nkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2f ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2f, 2) ?></center>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e.<center>Kredit PEP</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_pep']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2m ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kpep_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2m ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2m, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                f.<center>Kredit fon > 350jt</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_lebih350']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2n ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kp350_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2n ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2n, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                g.<center>Saldo PPAP</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['saldo_ppap']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p1a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['sppap_per_tk'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par1a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot7, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par1a, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                h.<center>AYDA</center>
                                                <hr>
                                                </hr>
                                                <center>KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['ayda']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p1b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['ayda_per_kyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par1b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot8, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par1b, 2) ?></center>
                                            </td>

                                        </tr>
















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                                <center>Kredit Yang Diberikan</center>
                                                <hr>
                                                </hr>
                                                <center>Aset Produktif</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kyd_per_ap'] ?></td>

                                            <td>
                                                <center><?= $hsl2 ?></center>
                                            </td>

                                            <td>
                                                <center><?= round($koreksi2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_2" form="my_form" name="ket_pil1_2" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1_2'] ?></textarea>
                            
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a.<center>Kredit Skema Potong Gaji</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_spg']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kspg_per_tk'] ?> </td>

                                            <td>
                                                <center><?= $hsl2a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b.<center>Kredit Musiman (Grace Period)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_pbta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['km_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2b, 2) ?></center>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c.<center>Kredit Jangka Pendek</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_jpendek']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kjpen_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d.<center>Kredit Jangka Menengah</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_jmenengah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2d ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjm_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2d, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e.<center>Kredit Jangka Panjang</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_jpanjang']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2e ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjpan_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2e ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2e, 2) ?></center>
                                            </td>

                                        </tr>


                                    


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                f.<center>Kredit Dengan Agunan Tanah dan Bangunan</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_tb']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2g ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kdatdb_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2g ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2g, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                g.<center>Kredit Agunan Kendaraan Bermotor</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_kb']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2h ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kak_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2h ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_7, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2h, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                h.<center>Kredit Agunan Kendaraan Roda 2</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_kr2']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2i ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kakr2_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2i ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_8, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2i, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                i.<center>OSC Produk KUB</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_kub']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2j ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['opk_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2j ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_9, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2j, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                j.<center>Kredit Tanpa Agunan</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_ta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2k ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kta_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2k ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_10, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2k, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                k.<center>Kredit Korporasi (Non Perorangan)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_korporasi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2l ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kknp_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2l ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_11, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2l, 2) ?></center>
                                            </td>
                                        </tr>















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th>
                                                <center>25 Debitur Inti</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['debitur_inti25']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p3 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['di25_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl3 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par3" value="<?= $pil1['pilar1_3'] ?>" class="form-control" id="koreksippl1_par3" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="number" form="my_form" name="nilaippl1_par3" value="<?= $pil1['hasil_pil1_par3'] ?>" class="form-control" id="nilaippl1_par3" readonly></center>

                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_3" form="my_form" name="ket_pil1_3" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1_3'] ?></textarea>
                            
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                                <label for="example-select" class="form-label">Target pasar</label>
                                                <select class="form-select" form="my_form" name="target_pasar1" id="target_pasar1">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil1['pilar1_3'] == "2" ? "selected" : "" ?>>2 = tidak berubah selama jangka waktu yang sangat lama</option>
                                                    <option value="3" <?= $pil1['pilar1_3'] == "3" ? "selected" : "" ?>>3 = tidak berubah selama jangka waktu yang lama</option>
                                                    <option value="4" <?= $pil1['pilar1_3'] == "4" ? "selected" : "" ?>>4 = tidak berubah selama jangka waktu yang cukup lama</option>
                                                    <option value="5" <?= $pil1['pilar1_3'] == "5" ? "selected" : "" ?>>5 = tidak berubah selama jangka waktu yang singkat</option>
                                                </select>
                                            </th>
                                            
                                            <td>
                                            <center>Periode sebelumnya</br><?= $pembanding_pil1['pilar1_3'] ?></center>
                                            </td>
                                            <td colspan="6">
                                            </td>


                                        </tr>
















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th>
                                                <center>Kredit Per Sektor Ekonomi</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_3sektor_ekonomi_terbesar']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p4 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kpse_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl4 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par4" value="<?= $pil1['pilar1_4'] ?>" class="form-control" id="koreksippl1_par4" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="text" form="my_form" name="nilaippl1_par4" value="<?= $pil1['hasil_pil1_par4'] ?>" class="form-control" id="nilaippl1_par4" readonly></center>

                                            </td>

                                            <td>
                                            <textarea class="form-control" id="ket_pil1_4" form="my_form" name="ket_pil1_4" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1_4'] ?></textarea>
                            
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                                <label for="example-select" class="form-label">Kredit yang berasal dari 3 sektor terbesar</label>
                                                <select class="form-select" form="my_form" name="sektor_terbesar3" id="sektor_terbesar3">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil1['pilar1_4'] == "2" ? "selected" : "" ?>>2 = tidak berubah selama jangka waktu yang sangat lama</option>
                                                    <option value="3" <?= $pil1['pilar1_4'] == "3" ? "selected" : "" ?>>3 = tidak berubah selama jangka waktu yang lama</option>
                                                    <option value="4" <?= $pil1['pilar1_4'] == "4" ? "selected" : "" ?>>4 = tidak berubah selama jangka waktu yang cukup lama</option>
                                                    <option value="5" <?= $pil1['pilar1_4'] == "5" ? "selected" : "" ?>>5 = tidak berubah selama jangka waktu yang singkat</option>
                                                </select>
                                            </th>
                                            <td>
                                            <center>Periode sebelumnya</br><?= $pembanding_pil1['pilar1_4'] ?></center>
                                            </td>
                                            <td colspan="6">
                                            </td>

                                        </tr>





                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 1</center>
                                            </th>
                                            <th>
                                                <center>Tertinggi</center>
                                                <center><input type="number" form="my_form" name="tertinggi_pil1" value="<?= $hasil['pil1_tertinggi'] ?>" class="form-control" id="tertinggi_pil1" readonly></center>
                                            </th>
                                            <th>
                                                <center>Terendah</center>
                                                <center><input type="number" form="my_form" name="terendah_pil1" value="<?= $hasil['pil1_terendah'] ?>" class="form-control" id="terendah_pil1" readonly></center>
                                            </th>
                                            <th>
                                                <center>Rata-rata</center>
                                                <center><input type="number" form="my_form" name="rata_rata_pil1" value="<?= $hasil['pil1_rata_rata'] ?>" class="form-control" id="rata_rata_pil1" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <select class="form-select" id="set_pil1" disabled>
                                                    <option value="1" <?= $inheren['inheren_kre_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $inheren['inheren_kre_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $inheren['inheren_kre_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select>
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil1" value="<?= $hasil['pil1_tingkat_risiko'] ?>" class="form-control" id="risiko_pil1" readonly></center>
                                            </th>

                                            <th>
                                            <textarea class="form-control" id="ket_pil1" form="my_form" name="ket_pil1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil1'] ?></textarea>
                            
                                            </th>


                                        </tr>




































                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 2 : Kualitas Aset</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                <center>Aset Produktif Bermasalah</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset Produktif</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['aset_produktif_bermasalah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($pilar2_p1 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apb_per_tap'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par1 ?></center>
                                            </td>

                                            <td>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par1, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil2_1'] ?></textarea>
                            
                                            </td>

                                        </tr>







                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                                <center>Kredit Bermasalah Neto</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['kredit_bermasalah_neto']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kbn_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par2 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi_pil2_par2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil2_2'] ?></textarea>
                            
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a.<center>NPL Kredit plafond s/d 150 juta</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD plafond s/d 150 jt</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_kredit_sd150']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kyd_plafon_sd150']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkp150_per_tkp150'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b.<center>NPL Kredit plafond diatas 50 juta</center>
                                                    <hr>
                                                    </hr>
                                                    <center>Total KYD plafond diatas 50 juta</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_kredit_diatas50']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kyd_plafon_diatas50']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkpd50_per_tkpd50'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2b, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c.<center>NPL Kredit Dengan Perikatan APHT</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_apht']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nkdpapht_prt_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d.<center>NPL Kredit Dengan Perikatan SKMHT</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_skmht']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2d ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkdpskmht_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2d, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e.<center>NPL Nilai Agunan Lebih Rendah Dari Baki Debet</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_agunan_lrd_bakidebet']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kredit_agunan_lrd_bakidebet']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2e ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nalrdbd_per_tknalrdbd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2e ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2e, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                f.<center>Kredit Macet sudah jatuh tempo</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['macet_jatuh_tempo']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['noa_kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p2f ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kmsjt_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2f ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2f, 2) ?></center>
                                            </td>

                                        </tr>















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th>
                                                <center>Kredit Kualitas Rendah</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['kkr']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kkr_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par3 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi_pil2_par3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3, 2) ?></center>
                                            </td>

                                            <td>
                                            <textarea class="form-control" id="ket_pil2_3" form="my_form" name="ket_pil2_3" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil2_3'] ?></textarea>
                            
                                            </td>
                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a.<center>Kredit Par 4</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['kredit_par4']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kp4_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b.<center>Kredit DP (PAR 3 + PAR 4 )</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['kredit_dp']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kdp3p4_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3b, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c.<center>NOA FPD 6 Bulan Terakhir</center>
                                                <hr>
                                                </hr>
                                                <center>NOA Ekspansi 6 Bulan Terakhir</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['noa_fpd_6bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['noa_ekspansi_6bln']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nf6bt_per_ne6bt'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d.<center>Nominal FPD 6 Bulan Terakhir</center>
                                                <hr>
                                                </hr>
                                                <center>plafond Ekspansi 6 Bulan Terakhir</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['nominal_fpd_6bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['plafond_ekspansi_6bln']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar2_p3d ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nomf6bt_per_pe6bt'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3d, 2) ?></center>
                                            </td>

                                        </tr>

                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 2</center>
                                            </th>
                                            <th>
                                                <center>Tertinggi</center>
                                                <center><input type="text" form="my_form" name="pilar2_max" class="form-control" value="<?= number_format($pil2_tertinggi ,2)?>" id="pilar2_max" readonly></center>
                                            </th>
                                            <th>
                                                <center>Terendah</center>
                                                <center><input type="text" form="my_form" name="pilar2_min" class="form-control"  value="<?= number_format($pil2_terendah ,2)?>" id="pilar2_min" readonly></center>
                                            </th>
                                            <th>
                                                <center>Rata-rata</center>
                                                <center><input type="text" form="my_form" name="pilar2_avg" class="form-control"  value="<?= number_format($pil2_rata_rata ,2)?>" id="pilar2_avg" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <select class="form-select" id="set_pil2" disabled>
                                                    <option value="1" <?= $inheren['inheren_kre_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $inheren['inheren_kre_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $inheren['inheren_kre_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select>
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="text" form="my_form" name="pil2_tingkat_risiko" class="form-control"  value="<?= number_format($pil2_tingkat_risiko ,2) ?>" id="pil2_tingkat_risiko" readonly></center>
                                            </th>

                                            <th>
                                            <textarea class="form-control" id="ket_pil2" form="my_form" name="ket_pil2" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil2'] ?></textarea>
                            
                                            </th>


                                        </tr>














                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 3 : Strategi Penyediaan Dana</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                Strategi Penyediaan Dana
                                            </th>
                                            <th>
                                                <center>Kyd - Rata-rata BPR</center>
                                                <center><?= number_format($master_kredit_P3['pertumbuhan_kyd_bpr'] ,2) ?> -
                                                    <?= number_format($master_kredit_P3['rasio_pertumbuhan_rata2_bpr'] ,2) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $pilar3_p1 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apb_per_tap'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil3_par1 ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1" value="<?= $pil3['pilar3_1'] ?>" class="form-control" id="koreksippl3_par1" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1" value="<?= $pil3['hasil_pil3_par1'] ?>" class="form-control" id="nilaippl3_par1" readonly>

                                            </th>
                                            <td>
                                            <textarea class="form-control" id="ket_pil3_1" form="my_form" name="ket_pil3_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil3_1'] ?></textarea>
                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                                <a href="https://www.bi.go.id/SEKDA/33/33-ii07.zip" target="_blank">https://www.bi.go.id/SEKDA/33/33-ii07.zip</a></br>
                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit" id="penyaluran_kredit">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1'] == "2" ? "selected" : "" ?>>2 = seluruhnya disalurkan ke sektor ekonomi yang dikuasai</option>
                                                    <option value="3" <?= $pil3['pilar3_1'] == "3" ? "selected" : "" ?>>3 = sebagian besar disalurkan ke sektor ekonomi yang dikuasai</option>
                                                    <option value="4" <?= $pil3['pilar3_1'] == "4" ? "selected" : "" ?>>4 = sebagian kecil atau tidak sama sekali disalurkan ke sektor ekonomi yg dikuasai </option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1'] ?>
                                            </th>
                                            <th>
                                                <center>%<input type="number" form="my_form" name="aba" value="<?= $pilar3_p1 ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>SK limit <<input type="number" form="my_form" name="pil3_par1_limit_persen" value="<?= number_format($bobot5_1, 1) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <th colspan="2">
                                                <center><input type="number" form="my_form" name="pil3_par1_limit_sk" value="<?= $hsl_pil3_par1 ?>" class="form-control" id="pil3_par1_limit_sk" readonly>

                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a. Pertumbuhan sektor ekonomi yang tidak dikuasai
                                            </th>
                                            <th>
                                                <center>Periode Penilaian<input type="text" form="my_form" name="aba" value="<?= rupiah($pilar3_p1a_pp) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Penilaian Sebelumnya<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($pilar3_p1a_ps) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1a ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1a" value="<?= $pil3['pilar3_1a'] ?>" class="form-control" id="koreksippl3_par1a" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1a" value="<?= $pil3['hasil_pil3_par1a'] ?>" class="form-control" id="nilaippl3_par1a" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit2" id="penyaluran_kredit2">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1a'] == "2" ? "selected" : "" ?>>2 = Terjadi penurunan OSC pada sektor ekonomi yang tidak dikuasai dan NPL membaik</option>
                                                    <option value="3" <?= $pil3['pilar3_1a'] == "3" ? "selected" : "" ?>>3 = Terjadi penurunan OSC pada sektor ekonomi yang tidak dikuasai dan NPL stagnan</option>
                                                    <option value="4" <?= $pil3['pilar3_1a'] == "4" ? "selected" : "" ?>>4 = Terjadi kenaikan OSC pada sektor ekonomi yang tidak dikuasai dan NPL memburuk </option>

                                                </select>
                                            </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1a'] ?>
                                            </th>

                                            <th colspan="7">

                                            </th>


                                        </tr>


                                       



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b. Pertumbuhan sektor ekonomi yang dikuasai
                                            </th>
                                            <th>
                                                <center>Periode Penilaian<input type="text" form="my_form" name="aba" value="<?= rupiah($pilar3_p1b_pp) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Penilaian Sebelumnya<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($pilar3_p1b_ps) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1b ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1b" value="<?= $pil3['pilar3_1b'] ?>" class="form-control" id="koreksippl3_par1b" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1b" value="<?= $pil3['hasil_pil3_par1b'] ?>" class="form-control" id="nilaippl3_par1b" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit3" id="penyaluran_kredit3">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1b'] == "2" ? "selected" : "" ?>>2 = Terjadi kenaikan OSC pada sektor ekonomi yang dikuasai dan NPL membaik</option>
                                                    <option value="3" <?= $pil3['pilar3_1b'] == "3" ? "selected" : "" ?>>3 = Terjadi kenaikan OSC pada sektor ekonomi yang dikuasai dan NPL stagnan</option>
                                                    <option value="4" <?= $pil3['pilar3_1b'] == "4" ? "selected" : "" ?>>4 = Terjadi penurunan OSC pada sektor ekonomi yang dikuasai dan NPL memburuk</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1b'] ?>
                                            </th>

                                            <th colspan="8">

                                            </th>


                                        </tr>


                                       



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c. Pertumbuhan OSC dan NPL
                                            </th>
                                            <th>
                                                <center>Pertumbuhan Kredit<input type="text" form="my_form" name="aba" value="<?= $pilar3_p1c_pertumbuhan_kredit ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Pertumbuhan Noa<input type="text" form="my_form" name="pil3_par1c_limit_persen" value="<?= $pilar3_p1c_pertumbuhan_noa ?>" class="form-control" id="pil3_par1c_limit_persen" readonly>
                                                </center>
                                                <center>Pertumbuhan Rasio NPL<input type="text" form="my_form" name="aba" value="<?= $pilar3_p1c_pertumbuhan_rasio_npl ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Pertumbuhan NOA NPL<input type="text" form="my_form" name="pil3_par1c_limit_persen" value="<?= $pilar3_p1c_pertumbuhan_noa_npl ?>" class="form-control" id="pil3_par1c_limit_persen" readonly>
                                                </center>


                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1c_rumus ?></center>
                                            </td>


                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1c" value="<?= $pil3['pilar3_1c'] ?>" class="form-control" id="koreksippl3_par1c" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1c" value="<?= $pil3['hasil_pil3_par1c'] ?>" class="form-control" id="nilaippl3_par1c" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                               
                                                <select class="form-select" form="my_form" name="penyaluran_kredit3_5" id="penyaluran_kredit3_5">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil3['pilar3_1c'] == "1" ? "selected" : "" ?>>1 = Pertumbuhan kredit positif dan NPL mengalami perbaikan</option>
                                                    <option value="2" <?= $pil3['pilar3_1c'] == "2" ? "selected" : "" ?>>2 = Pertumbuhan kredit positif dan NPL stagnan</option>
                                                    <option value="3" <?= $pil3['pilar3_1c'] == "3" ? "selected" : "" ?>>3 = Pertumbuhan Kredit positif namun NPL mengalami kenaikan</option>
                                                    <option value="4" <?= $pil3['pilar3_1c'] == "4" ? "selected" : "" ?>>4 = Pertumbuhan kredit negatif dan NPL mengalami perbaikan</option>
                                                    <option value="5" <?= $pil3['pilar3_1c'] == "5" ? "selected" : "" ?>>5 = Pertumbuhan kredit negatif dan NPL mengalami kenaikan</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1c'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d. Penempatan dana antar bank
                                            </th>
                                            <th>
                                                <center>Aba Pada BPR<input type="text" form="my_form" name="aba" value="<?= rupiah($master_kredit_P3['aba_bpr']) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Total ABA<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($master_kredit_P1['aba']) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td>
                                                <center><input type="text" form="my_form" name="aba" value="<?= number_format($hsl_pil3_par1d ,2) ?>" class="form-control" id="rupiah" readonly></center>
                                            </td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1d_rumus ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1d" value="<?= $pil3['pilar3_1d'] ?>" class="form-control" id="koreksippl3_par1d" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1d" value="<?= $pil3['hasil_pil3_par1d'] ?>" class="form-control" id="nilaippl3_par1d" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                                <label for="example-select" class="form-label">Penyaluran dana dalam bentuk penempatan ABA</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit4" id="penyaluran_kredit4">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1d'] == "2" ? "selected" : "" ?>>2 = seluruhnya ditempatkan pada Bank Umum</option>
                                                    <option value="3" <?= $pil3['pilar3_1d'] == "3" ? "selected" : "" ?>>3 = Kurang dari 20% ditempatkan pada BPR</option>
                                                    <option value="4" <?= $pil3['pilar3_1d'] == "4" ? "selected" : "" ?>>4 = Lebih dari 20% ditempatkan di BPR</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1d'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>


                                        



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e. Konsentrasi Penempatan ABA
                                            </th>
                                            <th>
                                                <center>Aba Pada Bank Teringgi<input type="text" form="my_form" name="aba" value="<?= rupiah($master_kredit_P3['aba_tertinggi']) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Total ABA<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($master_kredit_P1['aba']) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td>
                                                <center><input type="text" form="my_form" name="aba" value="<?= round($hsl_pil3_par1e, 2) ?>" class="form-control" id="rupiah" readonly></center>
                                            </td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1e_rumus ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1e" value="<?= $pil3['pilar3_1e'] ?>" class="form-control" id="koreksippl3_par1e" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1e" value="<?= $pil3['hasil_pil3_par1e'] ?>" class="form-control" id="nilaippl3_par1e" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                                <label for="example-select" class="form-label">Konsentrasi penyaluran dana dalam bentuk </br>penempatan ABA</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit5" id="penyaluran_kredit5">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1e'] == "2" ? "selected" : "" ?>>2 = seluruhnya ditempatkan pada Bank Umum</option>
                                                    <option value="3" <?= $pil3['pilar3_1e'] == "3" ? "selected" : "" ?>>3 = Kurang dari 20% ditempatkan pada BPR</option>
                                                    <option value="4" <?= $pil3['pilar3_1e'] == "4" ? "selected" : "" ?>>4 = Lebih dari 20% ditempatkan di BPR</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1e'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>


                                        

                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 3</center>
                                            </th>
                                            <th>
                                                <center>Tertinggi</center>
                                                <center><input type="number" form="my_form" name="tertinggi_pil3" value="<?= $hasil['pil3_tertinggi'] ?>" class="form-control" id="tertinggi_pil3" readonly></center>
                                            </th>
                                            <th>
                                                <center>Terendah</center>
                                                <center><input type="number" form="my_form" name="terendah_pil3" value="<?= $hasil['pil3_terendah'] ?>" class="form-control" id="terendah_pil3" readonly></center>
                                            </th>
                                            <th>
                                                <center>Rata-rata</center>
                                                <center><input type="number" form="my_form" name="rata_rata_pil3" value="<?= $hasil['pil3_rata_rata'] ?>" class="form-control" id="rata_rata_pil3" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <select class="form-select" id="set_pil3" disabled>
                                                    <option value="1" <?= $inheren['inheren_kre_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $inheren['inheren_kre_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $inheren['inheren_kre_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select>
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil3" value="<?= $hasil['pil3_tingkat_risiko'] ?>" class="form-control" id="risiko_pil3" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" id="ket_pil3" form="my_form" name="ket_pil3" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil3'] ?></textarea>
                                    
                                            </th>

                                        </tr>









                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 4 : Faktor Eksternal</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                Faktor Eksternal
                                            </th>
                                            <th>
                                            </th>
                                            <td></td>
                                            <td>
                                            <td>
                                            </td>

                                            <th>
                                             
                                            </th>
                                            <th>
                                               
                                            </th>
                                            <td>
                                            <textarea class="form-control" id="ket_pil4_1" form="my_form" name="ket_pil4_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil4_1'] ?></textarea>
                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                        
                                            </th>
                                            <th>
                                            
                                            </th>
                                            <th colspan="2">
                                               
                                        
                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a. Layanan Digital Kompetitor
                                                <select class="form-select" form="my_form" name="pilar4_1a" id="pilar4_1a">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1a'] == "1" ? "selected" : "" ?>>1 = Tidak berdampak pada kinerja Bank</option>
                                                    <option value="2" <?= $pil4['pilar4_1a'] == "2" ? "selected" : "" ?>>2 = Berdampak namun loyalitas nasabah masih terjaga</option>
                                                    <option value="3" <?= $pil4['pilar4_1a'] == "3" ? "selected" : "" ?>>3 = Berdampak loyalitas nasabah mulai menurun</option>
                                                    <option value="4" <?= $pil4['pilar4_1a'] == "4" ? "selected" : "" ?>>4 = Terdapat Kejadian Luar Biasa Yang Berpengaruh sd 5% Terhadap Kinerja Kredit</option>
                                                    <option value="5" <?= $pil4['pilar4_1a'] == "5" ? "selected" : "" ?>>5 = Terdapat Kejadian Luar Biasa Yang Berpengaruh >5% Terhadap Kinerja Kredit</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1a'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                    

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1a" value="<?= number_format($bobot6_1 ,2) ?>" class="form-control" id="koreksippl4_par1a" readonly>
                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1a" value="<?= $pil4['hasil_pil4_par1a'] ?>" class="form-control" id="nilaippl4_par1a" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b. Kejadian luar biasa yang berpengaruh terhadap</br> kinerja Bank
                                                <select class="form-select" form="my_form" name="pilar4_1b" id="pilar4_1b">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1b'] == "1" ? "selected" : "" ?>>1 = Tidak terdapat Kejadian Luar Biasa, tidak berdampak pada usaha dan kemampuan debitur</option>
                                                    <option value="2" <?= $pil4['pilar4_1b'] == "2" ? "selected" : "" ?>>2 = Tidak terdapat Kejadian Luar Biasa</option>
                                                    <option value="3" <?= $pil4['pilar4_1b'] == "3" ? "selected" : "" ?>>3 = Terdapat Kejadian Luar Biasa Yang Berpengaruh 1% Terhadap Kinerja Kredit</option>
                                                    <option value="4" <?= $pil4['pilar4_1b'] == "4" ? "selected" : "" ?>>4 = Terdapat Kejadian Luar Biasa Yang Berpengaruh sd 5% Terhadap Kinerja Kredit</option>
                                                    <option value="5" <?= $pil4['pilar4_1b'] == "5" ? "selected" : "" ?>>5 = Terdapat Kejadian Luar Biasa Yang Berpengaruh >5% Terhadap Kinerja Kredit</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1b'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1b" value="<?= number_format($bobot6_2 ,2) ?>" class="form-control" id="koreksippl4_par1b" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1b" value="<?= $pil4['hasil_pil4_par1b'] ?>" class="form-control" id="nilaippl4_par1b" readonly>

                                            </th>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c. Persaingan Layanan antar BPR
                                                <select class="form-select" form="my_form" name="pilar4_1c" id="pilar4_1c">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1c'] == "1" ? "selected" : "" ?>>1 = tidak berdampak pada kinerja dan pelayanan Bank</option>
                                                    <option value="2" <?= $pil4['pilar4_1c'] == "2" ? "selected" : "" ?>>2 = tidak berdampak pada kinerja dan layanan namun menimbulkan keluhan nasabah</option>
                                                    <option value="3" <?= $pil4['pilar4_1c'] == "3" ? "selected" : "" ?>>3 = berdampak pada kenyamanan nasabah yang berakibat nasabah enggan datang ke kantor</option>
                                                    <option value="4" <?= $pil4['pilar4_1c'] == "4" ? "selected" : "" ?>>4 = berdampak pada kenyamanan nasabah yang berakibat putusnya hubungan kerjasama</option>
                                                    <option value="5" <?= $pil4['pilar4_1c'] == "5" ? "selected" : "" ?>> 5 = berdampak pada kinerja dan layanan Bank yang cukup signifikan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1c'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1c" value="<?= number_format($bobot6_3 ,2) ?>" class="form-control" id="koreksippl4_par1c" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1c" value="<?= $pil4['hasil_pil4_par1c'] ?>" class="form-control" id="nilaippl4_par1c" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d. Regulasi Pemerintah
                                                <select class="form-select" form="my_form" name="pilar4_1d" id="pilar4_1d">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1d'] == "1" ? "selected" : "" ?>>1 = tidak berdampak pada volume bisnis dan capaian target NOA</option>
                                                    <option value="2" <?= $pil4['pilar4_1d'] == "2" ? "selected" : "" ?>>2 = tidak berdampak pada volume bisnis Bank namun berdampak pada capaian target</option>
                                                    <option value="3" <?= $pil4['pilar4_1d'] == "3" ? "selected" : "" ?>>3 = berdampak pada volume bisnis bank dan tidak terjadi pelepasan NOA existing</option>
                                                    <option value="4" <?= $pil4['pilar4_1d'] == "4" ? "selected" : "" ?>>4 = berdampak pada volume bisnis bank dan terjadi pelepasan NOA existing</option>
                                                    <option value="5" <?= $pil4['pilar4_1d'] == "5" ? "selected" : "" ?>>5 = berdampak pada volume bisnis dan capaian target NOA</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1d'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1d" value="<?= number_format($bobot6_4 ,2) ?>" class="form-control" id="koreksippl4_par1d" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1d" value="<?= $pil4['hasil_pil4_par1d'] ?>" class="form-control" id="nilaippl4_par1d" readonly>

                                            </th>

                                        </tr>


                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 4</center>
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th colspan="2">
                                                
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" value="<?= $hasil['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control" id="risiko_pil4" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" id="ket_pil4" form="my_form" name="ket_pil4" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil4'] ?></textarea>
                                    
                                            </th>

                                        </tr>



    

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>LAINNYA</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                Faktor Lainnya
                                            </th>
                                            <th>
                                            </th>
                                            <td></td>
                                            <td>
                                            <td>
                                            </td>

                                            <th>
                                             
                                            </th>
                                            <th>
                                               
                                            </th>
                                            <td>
                                            <textarea class="form-control" id="ket_pil5_1" form="my_form" name="ket_pil5_1" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil5_1'] ?></textarea>
                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                        
                                            </th>
                                            <th>
                                            
                                            </th>
                                            <th colspan="2">
                                               
                                        
                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a. Kompetensi AO
                                                <select class="form-select" form="my_form" name="pilar5_1a" id="pilar5_1a">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1a'] == "1" ? "selected" : "" ?>>1 = AO memiliki kompetensi yang Sangat Baik</option>
                                                    <option value="2" <?= $pil5['pilar5_1a'] == "2" ? "selected" : "" ?>>2 = AO memiliki kompetensi yang Baik</option>
                                                    <option value="3" <?= $pil5['pilar5_1a'] == "3" ? "selected" : "" ?>>3 = AO memiliki kompetensi yang Cukup Baik</option>
                                                    <option value="4" <?= $pil5['pilar5_1a'] == "4" ? "selected" : "" ?>>4 = AO memiliki kompetensi yang Kurang Baik</option>
                                                    <option value="5" <?= $pil5['pilar5_1a'] == "5" ? "selected" : "" ?>>5 = AO memiliki kompetensi yang Sangat Buruk</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1a'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                         

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1a" value="<?= number_format($bobot7_1 ,2) ?>" class="form-control" id="koreksippl5_par1a" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1a" value="<?= $pil5['hasil_pil5_par1a'] ?>" class="form-control" id="nilaippl5_par1a" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b. Kompetensi Analis
                                                <select class="form-select" form="my_form" name="pilar5_1b" id="pilar5_1b">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1b'] == "1" ? "selected" : "" ?>>1 = Analis memiliki kompetensi yang Sangat Baik</option>
                                                    <option value="2" <?= $pil5['pilar5_1b'] == "2" ? "selected" : "" ?>>2 = Analis memiliki kompetensi yang Baik</option>
                                                    <option value="3" <?= $pil5['pilar5_1b'] == "3" ? "selected" : "" ?>>3 = Analis memiliki kompetensi yang Cukup Baik</option>
                                                    <option value="4" <?= $pil5['pilar5_1b'] == "4" ? "selected" : "" ?>>4 = Analis memiliki kompetensi yang Kurang Baik</option>
                                                    <option value="5" <?= $pil5['pilar5_1b'] == "5" ? "selected" : "" ?>>5 = Analis memiliki kompetensi yang Sangat Buruk</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1b'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1b" value="<?= number_format($bobot7_2 ,2) ?>" class="form-control" id="koreksippl5_par1b" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1b" value="<?= $pil5['hasil_pil5_par1b'] ?>" class="form-control" id="nilaippl5_par1b" readonly>

                                            </th>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c. Komite Kredit
                                                <select class="form-select" form="my_form" name="pilar5_1c" id="pilar5_1c">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1c'] == "1" ? "selected" : "" ?>>1. Pembahasan Semua Aspek Perkreditan Meliputi 7C</option>
                                                    <option value="2" <?= $pil5['pilar5_1c'] == "2" ? "selected" : "" ?>>2. Pembahasan Semua Aspek Perkreditan Meliputi 6C</option>
                                                    <option value="3" <?= $pil5['pilar5_1c'] == "3" ? "selected" : "" ?>>3. Pembahasan Semua Aspek Perkreditan Meliputi 5C</option>
                                                    <option value="4" <?= $pil5['pilar5_1c'] == "4" ? "selected" : "" ?>>4. Pembahasan Semua Aspek Perkreditan Meliputi 3C (Character, Capital, Capacity)</option>
                                                    <option value="5" <?= $pil5['pilar5_1c'] == "5" ? "selected" : "" ?>>5. Pembahasan Semua Aspek Perkreditan Tidak Meliputi 5C</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1c'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1c" value="<?= number_format($bobot7_3 ,2) ?>" class="form-control" id="koreksippl5_par1c" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1c" value="<?= $pil5['hasil_pil5_par1c'] ?>" class="form-control" id="nilaippl5_par1c" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d. Keputusan dan Realisasi Kredit
                                                <select class="form-select" form="my_form" name="pilar5_1d" id="pilar5_1d">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1d'] == "1" ? "selected" : "" ?>>1. Keputusan Kredit Ditandatangani pada Hari yang Sama Saat Komite, Realisasi Dilakukan Apabila Seluruh Persyaratan terpenuhi</option>
                                                    <option value="2" <?= $pil5['pilar5_1d'] == "2" ? "selected" : "" ?>>2. Keputusan Kredit Maksimal 1 (Satu) Hari Kerja Setelah Komite, Realisasi Dilakukan Apabila Seluruh Persyaratan terpenuhi</option>
                                                    <option value="3" <?= $pil5['pilar5_1d'] == "3" ? "selected" : "" ?>>3. Keputusan Kredit Maksimal 1 (Satu) Hari Kerja Setelah Komite, Realisasi Dilakukan Apabila Persyaratan Utama terpenuhi</option>
                                                    <option value="4" <?= $pil5['pilar5_1d'] == "4" ? "selected" : "" ?>>4. Keputusan Kredit Ditandatangani pada Hari yang Sama Saat Komite, Realisasi Dilakukan Apabila Persyaratan Terpenuhi Sebagian</option>
                                                    <option value="5" <?= $pil5['pilar5_1d'] == "5" ? "selected" : "" ?>>5. Keputusan Kredit Ditandatangani pada Hari yang Sama Saat Komite, Realisasi Dilakukan Apabila Seluruh Persyaratan Belum Terpenuhi</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1d'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                        

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1d" value="<?= number_format($bobot7_4 ,2) ?>" class="form-control" id="koreksippl5_par1d" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1d" value="<?= $pil5['hasil_pil5_par1d'] ?>" class="form-control" id="nilaippl5_par1d" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e. Monitoring Penggunaan Dana Kredit
                                                <select class="form-select" form="my_form" name="pilar5_1e" id="pilar5_1e">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1e'] == "1" ? "selected" : "" ?>>1 = Monitoring Penggunaan Dana 3 (Tiga) Hari Kerja Setelah Realisasi</option>
                                                    <option value="2" <?= $pil5['pilar5_1e'] == "2" ? "selected" : "" ?>>2 = Monitoring Penggunaan Dana 15 (Lima Belas) Hari Kerja Setelah Realisasi</option>
                                                    <option value="3" <?= $pil5['pilar5_1e'] == "3" ? "selected" : "" ?>>3 = Monitoring Penggunaan Dana 20 (Lima Belas) Hari Kerja Setelah Realisasi</option>
                                                    <option value="4" <?= $pil5['pilar5_1e'] == "4" ? "selected" : "" ?>>4 = Monitoring Penggunaan Dana 25 (Dua Puluh Lima) Hari Kerja Setelah Realisasi</option>
                                                    <option value="5" <?= $pil5['pilar5_1e'] == "5" ? "selected" : "" ?>>5 = Monitoring Penggunaan Dana > 25 (Dua Puluh Lima) Hari Kerja Setelah Realisasi</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1e'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1e" value="<?= number_format($bobot7_5 ,2) ?>" class="form-control" id="koreksippl5_par1e" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1e" value="<?= $pil5['hasil_pil5_par1e'] ?>" class="form-control" id="nilaippl5_par1e" readonly>

                                            </th>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                f. Pengawasan Kredit
                                                <select class="form-select" form="my_form" name="pilar5_1f" id="pilar5_1f">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1f'] == "1" ? "selected" : "" ?>>1 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) Minimal 1 (satu) Kali Sebulan</option>
                                                    <option value="2" <?= $pil5['pilar5_1f'] == "2" ? "selected" : "" ?>>2 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) Minimal 2 (Dua) Kali Sebulan</option>
                                                    <option value="3" <?= $pil5['pilar5_1f'] == "3" ? "selected" : "" ?>>3 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) Minimal 1 (Satu) Kali Sebulan, Kecuali Debitur Tanpa Tunggakan Maksimal 2 (Dua) Bulan 1 (Satu) Kali Kunjungan </option>
                                                    <option value="4" <?= $pil5['pilar5_1f'] == "4" ? "selected" : "" ?>>4 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) 1 (Satu) Kali Sebulan, Kecuali Debitur Tanpa Tunggakan Maksimal 3 (Tiga) Bulan 1 (Satu) Kali Kunjungan </option>
                                                    <option value="5" <?= $pil5['pilar5_1f'] == "5" ? "selected" : "" ?>>5 = Setiap Debitur Mendapatkan Kunjungan (Daring/Luring) kurang dari 1 (Satu) Kali Sebulan, Debitur Tanpa Tunggakan > 2 (Dua) Bulan untuk 1 (Satu) Kali Kunjungan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1f'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1f" value="<?= number_format($bobot7_6 ,2) ?>" class="form-control" id="koreksippl5_par1f" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1f" value="<?= $pil5['hasil_pil5_par1f'] ?>" class="form-control" id="nilaippl5_par1f" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                g. Kecukupan Jumlah SDM Perkreditan
                                                <select class="form-select" form="my_form" name="pilar5_1g" id="pilar5_1g">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1g'] == "1" ? "selected" : "" ?>>1 =Tidak Terdapat Kekosongan SOTK Bidang Perkreditan</option>
                                                    <option value="2" <?= $pil5['pilar5_1g'] == "2" ? "selected" : "" ?>>2 =Terdapat Kekosongan SOTK Pada 2 (Dua) Formasi Non Struktural Bidang Perkreditan</option>
                                                    <option value="3" <?= $pil5['pilar5_1g'] == "3" ? "selected" : "" ?>>3 =Terdapat Kekosongan SOTK Pada 3 (Tiga) Formasi Non Struktural Bidang Perkreditan</option>
                                                    <option value="4" <?= $pil5['pilar5_1g'] == "4" ? "selected" : "" ?>>4 =Terdapat Kekosongan SOTK Pada 5 (Lima) Formasi Non Struktural Bidang Perkreditan</option>
                                                    <option value="5" <?= $pil5['pilar5_1g'] == "5" ? "selected" : "" ?>>5 =Terdapat Kekosongan SOTK Pada > 5 (Lima) Formasi Non Struktural Bidang Perkreditan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1g'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1g" value="<?= number_format($bobot7_7 ,2) ?>" class="form-control" id="koreksippl5_par1g" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1g" value="<?= $pil5['hasil_pil5_par1g'] ?>" class="form-control" id="nilaippl5_par1g" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                h. Kompetensi SDM Perkreditan
                                                <select class="form-select" form="my_form" name="pilar5_1h" id="pilar5_1h">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1h'] == "1" ? "selected" : "" ?>>1. 100% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>
                                                    <option value="2" <?= $pil5['pilar5_1h'] == "2" ? "selected" : "" ?>>2. 80% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>
                                                    <option value="3" <?= $pil5['pilar5_1h'] == "3" ? "selected" : "" ?>>3. 75% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>
                                                    <option value="4" <?= $pil5['pilar5_1h'] == "4" ? "selected" : "" ?>>4. 50% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>
                                                    <option value="5" <?= $pil5['pilar5_1h'] == "5" ? "selected" : "" ?>>5. < 50% SDM Bidang Perkreditan Mengikuti Pelatihan Modul Perkreditan Selama Tahun Berjalan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1h'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                          

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1h" value="<?= number_format($bobot7_8 ,2) ?>" class="form-control" id="koreksippl5_par1h" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1h" value="<?= $pil5['hasil_pil5_par1h'] ?>" class="form-control" id="nilaippl5_par1h" readonly>

                                            </th>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                i. Kelengkapan Ketentuan & Pedoman Perkreditan 
                                                <select class="form-select" form="my_form" name="pilar5_1i" id="pilar5_1i">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1i'] == "1" ? "selected" : "" ?>>1 = Review Berkala Setiap 3 (Tiga) Bulan</option>
                                                    <option value="2" <?= $pil5['pilar5_1i'] == "2" ? "selected" : "" ?>>2 = Review Berkala 2 (Dua) Kali Setahun</option>
                                                    <option value="3" <?= $pil5['pilar5_1i'] == "3" ? "selected" : "" ?>>3 = Review Berkala 1 (Satu) Kali Setahun</option>
                                                    <option value="4" <?= $pil5['pilar5_1i'] == "4" ? "selected" : "" ?>>4 = Review Berkala 1 (Satu) Kali dalam 3 tahun</option>
                                                    <option value="5" <?= $pil5['pilar5_1i'] == "5" ? "selected" : "" ?>>5 = Review Berkala > 3 tahun</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1i'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                          

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1i" value="<?= number_format($bobot7_9 ,2) ?>" class="form-control" id="koreksippl5_par1i" readonly>
                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1i" value="<?= $pil5['hasil_pil5_par1i'] ?>" class="form-control" id="nilaippl5_par1i" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                j. Ketersediaan Sistem Informasi Manajemen
                                                <select class="form-select" form="my_form" name="pilar5_1j" id="pilar5_1j">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1j'] == "1" ? "selected" : "" ?>>1 = SIM Tersedia Dengan Sangat Baik dan Lengkap </option>
                                                    <option value="2" <?= $pil5['pilar5_1j'] == "2" ? "selected" : "" ?>>2 = SIM Tersedia Dengan Baik </option>
                                                    <option value="3" <?= $pil5['pilar5_1j'] == "3" ? "selected" : "" ?>>3 = SIM Tersedia Dengan Cukup Baik </option>
                                                    <option value="4" <?= $pil5['pilar5_1j'] == "4" ? "selected" : "" ?>>4 = SIM Tersedia Dengan Kurang Baik </option>
                                                    <option value="5" <?= $pil5['pilar5_1j'] == "5" ? "selected" : "" ?>>5 = SIM Tidak Tersedia  </option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1j'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                     
                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1j" value="<?= number_format($bobot7_10 ,2) ?>" class="form-control" id="koreksippl5_par1j" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1j" value="<?= $pil5['hasil_pil5_par1j'] ?>" class="form-control" id="nilaippl5_par1j" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                k. Pengawasan Internal (Risk Taking Unit dan </br> Satuan Kerja Pengendalian) di Bidang Perkreditan
                                                <select class="form-select" form="my_form" name="pilar5_1k" id="pilar5_1k">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1k'] == "1" ? "selected" : "" ?>>1 = Pengawasan Internal Berkala Setiap Hari</option>
                                                    <option value="2" <?= $pil5['pilar5_1k'] == "2" ? "selected" : "" ?>>2 = Pengawasan Internal Berkala Minimal Seminggu Sekali</option>
                                                    <option value="3" <?= $pil5['pilar5_1k'] == "3" ? "selected" : "" ?>>3 = Pengawasan Internal Berkala Minimal 2 (Dua) Minggu Sekali</option>
                                                    <option value="4" <?= $pil5['pilar5_1k'] == "4" ? "selected" : "" ?>>4 = Pengawasan Internal Berkala 1 (Satu) Sebulan</option>
                                                    <option value="5" <?= $pil5['pilar5_1k'] == "5" ? "selected" : "" ?>>5 = Pengawasan Internal Berkala Tidak Dilakukan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1k'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1k" value="<?= number_format($bobot7_11 ,2) ?>" class="form-control" id="koreksippl5_par1k" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1k" value="<?= $pil5['hasil_pil5_par1k'] ?>" class="form-control" id="nilaippl5_par1k" readonly>

                                            </th>

                                        </tr>

                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko lainnya</center>
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th colspan="2">
                                                
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil5" value="<?= $hasil['pil5_tingkat_risiko'] ?>" class="form-control" id="risiko_pil5" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" id="ket_pil5" form="my_form" name="ket_pil5" cols="40" rows="5"><?= $ket_inhern_kredit['ket_pil5'] ?></textarea>
                                    
                                            </th>

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