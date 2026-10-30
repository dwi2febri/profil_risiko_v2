

<?php
include "../fungsi/fungsi.php";

?>


<script>


    
    $(document).ready(function() {
        var table = $('#scroll-horizontal-datatable1').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(4).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });

    $(document).ready(function() {
        var table = $('#basic-datatable1').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(4).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });

    $(document).ready(function() {
        var table = $('#row-callback-datatable1').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(4).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });

    $(document).ready(function() {
        var table = $('#selection-datatable1').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(4).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });

        function updateText2() {
            // Ambil elemen dropdown
            var dropdown = document.getElementById("yearFilter");
            // Ambil nilai yang dipilih
            var selectedValue2 = dropdown.options[dropdown.selectedIndex].text;
            // Update elemen teks
            document.getElementById("displayText2").innerText = selectedValue2;
            document.getElementById("displayText4").innerText = selectedValue2;
            document.getElementById("displayText6").innerText = selectedValue2;
            document.getElementById("displayText8").innerText = selectedValue2;
        }

        function updateText1() {
            // Ambil elemen dropdown
            var dropdown = document.getElementById("quarterFilter");
            // Ambil nilai yang dipilih
            var selectedValue1 = dropdown.options[dropdown.selectedIndex].text;
            // Update elemen teks
            document.getElementById("displayText1").innerText = selectedValue1;
            document.getElementById("displayText3").innerText = selectedValue1;
            document.getElementById("displayText5").innerText = selectedValue1;
            document.getElementById("displayText7").innerText = selectedValue1;
        }





</script>



<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Simpro</a></li>
                                            <li class="breadcrumb-item active">Laporan Masuk</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Menu Laporan Profil Risiko</h4>
                                </div>
                            </div>
                        </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Tabel Laporan Profil Risiko Yang Masuk</h4>
                            <p class="text-muted font-14">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh User
                            </p>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->




                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-4">Filter</h4>

                                        <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">  <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                               
                                                <div class="col-lg-6">
                                                        <label for="yearFilter" class="form-label">Tahun</label>
                                                        <select class="form-select mb-3" name="yearFilter" id="yearFilter" onchange="updateText2()" required="">
                                                            <option value=" " selected> </option>
                                                            <option value="2024" >2024</option>
                                                            <option value="2025" >2025</option>
                                                            <option value="2026" >2026</option>
                                                            <option value="2027" >2027</option>
                                                            <option value="2028" >2028</option>
                                                            <option value="2029" >2029</option>
                                                            <option value="2030" >2030</option>
                                                            <option value="2031" >2031</option>
                                                            <option value="2032" >2032</option>
                                                            <option value="2033" >2033</option>
                                                            <option value="2034" >2034</option>
                                                            <option value="2035" >2035</option>
                                                            <option value="2036" >2036</option>
                                                            <option value="2037" >2037</option>
                                                        </select>
                                                </div>
                                                <div class="col-lg-6">
                                                        <label for="quarterFilter" class="form-label">Periode</label>
                                                        <select class="form-select mb-3" name="quarterFilter" id="quarterFilter" onchange="updateText1()" required="">
                                                        <option value=" " selected> </option>
                                                            <option value="1" >Triwulan 1</option>
                                                            <option value="2" >Triwulan 2</option>
                                                            <option value="3" >Triwulan 3</option>
                                                            <option value="4" >Triwulan 4</option>
                                                        </select>
                                                </div>
                                                
                                            </div>
                                        </form>
                                        <!-- end row-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                                                       
                        </div>



                        
<script>
    $(document).ready(function() {
        $('.open-modal').on('click', function(e) {
            e.preventDefault();
            var itemId = $(this).data('id'); // Ambil ID dari data-id
            $('#item-id').text(itemId); // Set ID ke dalam modal
            $('#item-link').attr('href', '../satker_skai/laporan/cetak_laporan_kc.php?id=' + itemId); // Set URL dengan ID
            $('#item-link1').attr('href', '../satker_skai/laporan/cetak_kc_risiko_kredit.php?id=' + itemId); // Set URL dengan ID
            $('#item-link2').attr('href', '../satker_skai/laporan/cetak_kc_risiko_operasional.php?id=' + itemId); // Set URL dengan ID
            $('#item-link3').attr('href', '../satker_skai/laporan/cetak_kc_risiko_kepatuhan.php?id=' + itemId); // Set URL dengan ID
            $('#item-link4').attr('href', '../satker_skai/laporan/cetak_kc_risiko_likuiditas.php?id=' + itemId); // Set URL dengan ID
            $('#item-link5').attr('href', '../satker_skai/laporan/cetak_kc_risiko_reputasi.php?id=' + itemId); // Set URL dengan ID
            $('#item-link6').attr('href', '../satker_skai/laporan/cetak_kc_risiko_stratejik.php?id=' + itemId); // Set URL dengan ID
            $('#myModal').modal('show'); // Tampilkan modal
        });
    });
</script>
                                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">

                                                                        <div class="modal-body">

                                                                            <div class="text-center mt-2 mb-4">

                                                                                <h4><b>Cetak Laporan ID: <span id="item-id"></b></h4>

                                                                            </div>
                                                                            <form class="ps-3 pe-3" action="" method="POST" enctype="multipart/form-data">

                                                                                <div class="mb-3">
                                                                                    <label for="kc" class="form-label">Risiko Kredit :</label>
                                                                                    <a href="#" id="item-link1" target="_blank"> klik untuk cetak </a>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="tahun" class="form-label">Risiko Operasional :</label>
                                                                                    <a href="#" id="item-link2" target="_blank"> klik untuk cetak </a>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="user" class="form-label">Risiko Kepatuhan :</label>                     
                                                                                    <a href="#" id="item-link3" target="_blank"> klik untuk cetak </a>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="periode" class="form-label">Risiko Likuiditas :</label>
                                                                                    <a href="#" id="item-link4" target="_blank"> klik untuk cetak </a>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="modal_inti" class="form-label">Risiko Reputasi :</label>
                                                                                    <a href="#" id="item-link5" target="_blank"> klik untuk cetak </a>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="total_aset" class="form-label">Risiko Stratejik :</label>
                                                                                    <a href="#" id="item-link6" target="_blank"> klik untuk cetak </a>
                                                                                </div>


                                                                                <div class="mb-3">
                                                                                    <label for="keterangan" class="form-label">Cetak Keseluruhan :</label>
                                                                                    <a href="#" id="item-link" target="_blank"> klik untuk cetak </a>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->





            <div class="row">

                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#semarang" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Area Semarang</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#solo" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Area Solo</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#banyumas" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Area Banyumas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#pekalongan" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Area Pekalongan</span>
                                </a>
                            </li>
                        
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="semarang">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header" style="background-color: #FF8000; color: white; font-size: 2.5rem; padding: 15px;">
                                                <h3 class="header-title mb-3">Profil Risiko Area Semarang (<span id="displayText1"> </span> - <span id="displayText2"></span>)</h3>
                                            </div>
                                            <div class="card-body">
                                            <div class="tab-pane show active" id="basic-datatable-preview">
                                                <table id="scroll-horizontal-datatable1" class="table dt-responsive nowrap w-100">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>
                                                                <center>No</center>
                                                            </th>

                                                            <th>
                                                                <center>Aksi</center>
                                                            </th>
                                                            <th>
                                                                <center>Tindak Lanjut</center>
                                                            </th>
                                                            <th>
                                                                <center>Kantor Cabang</center>
                                                            </th>
                                                            <th>
                                                                <center>Tahun</center>
                                                            </th>
                                                            
                                                            <th>
                                                                <center>Periode</center>
                                                            </th>

                                                            <th>
                                                                <center>Total Aset</center>
                                                            </th>
                                                            
                                                            <th>
                                                                <center>Tanggal Dibuat</center>
                                                            </th>
                                                            <th>
                                                                <center>Pembuat</center>
                                                            </th>
                                                            <th>
                                                                <center>Cetak Per Risiko</center>
                                                            </th>
                                                           

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require dirname(__DIR__, 2).'/conn/conn.php';
                                                        $no = 1;
                                                        $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                                        INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                                        INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                                        INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                                        INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user = '3' AND status_korwil = 1 AND jenis_cabang.id_cabang IN (1,2,3,4,5,6,7) order by id_profil_risiko desc");
                                                        while ($data = mysqli_fetch_array($query)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <center><?= $no++ ?></center>
                                                                </td>
                                                                <td class="table-action">
                                                                    <center>
                                                                        
                                                                         <a href="../satker_skai/laporan/cetak_laporan_kc.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">cetak</a>
                                                                       
                                                                    </center>
                                                                </td>
                                                                <td class="table-action">
                                                                    <center>
                                                                        <a href="../satker_skai/laporan/cetak_tindak_lanjut.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank"> cetak </a>
                                                                    
                                                                    </center>
                                                                </td>


                                                                <td>
                                                                    <center><?= $data['cabang'] ?></center>
                                                                </td>
                                                                <td>
                                                                    <center><?= $data['tahun'] ?></center>
                                                                </td>
                                                                
                                                                <td>
                                                                    <center><?= ucwords($data['periode_laporan']) ?></center>
                                                                </td>

                                                                <td>
                                                                    Rp. <?= rupiah($data['total_aset']) ?>
                                                                </td>
                                                                
                                                                <td>
                                                                    <center><?= ucwords($data['dibuat_at']) ?></center>
                                                                </td>
                                                                <td>
                                                                    <center><?= ucwords($data['nama']) ?></center>
                                                                </td>
                                                                <td>
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_kredit.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">kredit</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_operasional.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">operasional</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_kepatuhan.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">kepatuhan</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_likuiditas.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">likuiditas</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_reputasi.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">reputasi</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_stratejik.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">stratejik</a>
                                                                </td>
                                                            





                                                            </tr>
                                                        <?php
                                                        };
                                                        ?>
                                                    </tbody>
                                                </table>
                                                </div> <!-- end table-responsive-->

                                            </div> <!-- end card body-->
                                        </div> <!-- end card -->
                                    </div><!-- end col-->
                                </div>
                            </div>
                            <div class="tab-pane" id="solo">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header" style="background-color: #024CAA; color: white; font-size: 2.5rem; padding: 15px;">
                                                <h3 class="header-title mb-3">Profil Risiko Area Solo (<span id="displayText3"> </span> - <span id="displayText4"></span>)</h3>
                                            </div>
                                            <div class="card-body">

                                            <div class="tab-pane" id="basic-datatable-preview">
                                                <table id="basic-datatable1" class="table dt-responsive nowrap w-100">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>
                                                                <center>No</center>
                                                            </th>

                                                            <th>
                                                                <center>Aksi</center>
                                                            </th>
                                                            <th>
                                                                <center>Tindak Lanjut</center>
                                                            </th>
                                                            <th>
                                                                <center>Kantor Cabang</center>
                                                            </th>
                                                            <th>
                                                                <center>Tahun</center>
                                                            </th>
                                                           
                                                            <th>
                                                                <center>Periode</center>
                                                            </th>

                                                            <th>
                                                                <center>Total Aset</center>
                                                            </th>
                                                            
                                                            <th>
                                                                <center>Tanggal Dibuat</center>
                                                            </th>
                                                            <th>
                                                                <center>Pembuat</center>
                                                            </th>
                                                            <th>
                                                                <center>Cetak Per Risiko</center>
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require dirname(__DIR__, 2).'/conn/conn.php';
                                                        $no = 1;
                                                        $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                                        INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                                        INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                                        INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                                        INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user = '3' AND status_korwil = 1 AND jenis_cabang.id_cabang IN (8,9,10,11,12,13,14) order by id_profil_risiko desc");
                                                        while ($data = mysqli_fetch_array($query)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <center><?= $no++ ?></center>
                                                                </td>
                                                                <td class="table-action">
                                                                    <center>
                                                                       
                                                                         <a href="../satker_skai/laporan/cetak_laporan_kc.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">cetak</a>
                                                                       
                                                                    </center>
                                                                </td>
                                                                <td class="table-action">
                                                                    <center>
                                                                        <a href="../satker_skai/laporan/cetak_tindak_lanjut.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank"> cetak </a>
                                                                    
                                                                    </center>
                                                                </td>

                                                                <td>
                                                                    <center><?= $data['cabang'] ?></center>
                                                                </td>
                                                                <td>
                                                                    <center><?= $data['tahun'] ?></center>
                                                                </td>
                                                               
                                                                <td>
                                                                    <center><?= ucwords($data['periode_laporan']) ?></center>
                                                                </td>

                                                                <td>
                                                                    Rp. <?= rupiah($data['total_aset']) ?>
                                                                </td>
                                                                
                                                                <td>
                                                                    <center><?= ucwords($data['dibuat_at']) ?></center>
                                                                </td>
                                                                <td>
                                                                    <center><?= ucwords($data['nama']) ?></center>
                                                                </td>
                                                                <td>
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_kredit.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">kredit</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_operasional.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">operasional</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_kepatuhan.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">kepatuhan</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_likuiditas.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">likuiditas</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_reputasi.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">reputasi</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_stratejik.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">stratejik</a>
                                                                </td>

                                                            





                                                            </tr>
                                                        <?php
                                                        };
                                                        ?>
                                                    </tbody>
                                                </table>
                                                </div> <!-- end table-responsive-->

                                            </div> <!-- end card body-->
                                        </div> <!-- end card -->
                                    </div><!-- end col-->
                                </div>
                            </div>
                            <div class="tab-pane" id="banyumas">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header" style="background-color: #219B9D; color: white; font-size: 2.5rem; padding: 15px;">
                                                <h3 class="header-title mb-3">Profil Risiko Area Banyumas (<span id="displayText5"> </span> - <span id="displayText6"></span>)</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-pane show active" id="row-callback-preview">
                                                <table id="row-callback-datatable1" class="table dt-responsive nowrap w-100">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>
                                                                <center>No</center>
                                                            </th>

                                                            <th>
                                                                <center>Aksi</center>
                                                            </th>
                                                            <th>
                                                                <center>Tindak Lanjut</center>
                                                            </th>
                                                            <th>
                                                                <center>Kantor Cabang</center>
                                                            </th>
                                                            <th>
                                                                <center>Tahun</center>
                                                            </th>
                                                           
                                                            <th>
                                                                <center>Periode</center>
                                                            </th>

                                                            <th>
                                                                <center>Total Aset</center>
                                                            </th>
                                                            
                                                            <th>
                                                                <center>Tanggal Dibuat</center>
                                                            </th>
                                                            <th>
                                                                <center>Pembuat</center>
                                                            </th>
                                                            <th>
                                                                <center>Cetak Per Risiko</center>
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require dirname(__DIR__, 2).'/conn/conn.php';
                                                        $no = 1;
                                                        $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                                        INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                                        INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                                        INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                                        INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user = '3' AND status_korwil = 1 AND jenis_cabang.id_cabang IN (15,16,17,18,19,20,21) order by id_profil_risiko desc");
                                                        while ($data = mysqli_fetch_array($query)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <center><?= $no++ ?></center>
                                                                </td>
                                                                <td class="table-action">
                                                                    <center>
                                                                        
                                                                         <a href="../satker_skai/laporan/cetak_laporan_kc.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">cetak</a>
                                                                       
                                                                    </center>
                                                                </td>
                                                                <td class="table-action">
                                                                    <center>
                                                                        <a href="../satker_skai/laporan/cetak_tindak_lanjut.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank"> cetak </a>
                                                                    
                                                                    </center>
                                                                </td>

                                                                <td>
                                                                    <center><?= $data['cabang'] ?></center>
                                                                </td>
                                                                <td>
                                                                    <center><?= $data['tahun'] ?></center>
                                                                </td>
                                                               
                                                                <td>
                                                                    <center><?= $data['periode_laporan'] ?></center>
                                                                </td>

                                                                <td>
                                                                    Rp. <?= rupiah($data['total_aset']) ?>
                                                                </td>
                                                                
                                                                <td>
                                                                    <center><?= ucwords($data['dibuat_at']) ?></center>
                                                                </td>
                                                                <td>
                                                                    <center><?= ucwords($data['nama']) ?></center>
                                                                </td>
                                                                <td>
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_kredit.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">kredit</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_operasional.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">operasional</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_kepatuhan.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">kepatuhan</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_likuiditas.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">likuiditas</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_reputasi.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">reputasi</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_stratejik.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">stratejik</a>
                                                                </td>

                                                            





                                                            </tr>
                                                        <?php
                                                        };
                                                        ?>
                                                    </tbody>
                                                </table>
                                                </div> <!-- end table-responsive-->

                                            </div> <!-- end card body-->
                                        </div> <!-- end card -->
                                    </div><!-- end col-->
                                </div>
                            </div>
                            <div class="tab-pane" id="pekalongan">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header" style="background-color: #091057; color: white; font-size: 2.5rem; padding: 15px;">
                                                <h3 class="header-title mb-3">Profil Risiko Area Pekalongan (<span id="displayText7"> </span> - <span id="displayText8"></span>)</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-pane show active" id="multi-item-preview">
                                                <table id="selection-datatable1" class="table dt-responsive nowrap w-100">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>
                                                                <center>No</center>
                                                            </th>

                                                            <th>
                                                                <center>Aksi</center>
                                                            </th>
                                                            <th>
                                                                <center>Tindak Lanjut</center>
                                                            </th>
                                                            <th>
                                                                <center>Kantor Cabang</center>
                                                            </th>
                                                            <th>
                                                                <center>Tahun</center>
                                                            </th>
                                                            
                                                            <th>
                                                                <center>Periode</center>
                                                            </th>

                                                            <th>
                                                                <center>Total Aset</center>
                                                            </th>
                                                            
                                                            <th>
                                                                <center>Tanggal Dibuat</center>
                                                            </th>
                                                            <th>
                                                                <center>Pembuat</center>
                                                            </th>
                                                            <th>
                                                                <center>Cetak Per Risiko</center>
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require dirname(__DIR__, 2).'/conn/conn.php';
                                                        $no = 1;
                                                        $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                                        INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                                        INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                                        INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                                        INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user = '3' AND status_korwil = 1 AND jenis_cabang.id_cabang IN (22,23,24,25,26,27,28) order by id_profil_risiko desc");
                                                        while ($data = mysqli_fetch_array($query)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <center><?= $no++ ?></center>
                                                                </td>
                                                                <td class="table-action">
                                                                    <center>
                                                                       
                                                                         <a href="../satker_skai/laporan/cetak_laporan_kc.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">cetak</a>
                                                                       
                                                                    </center>
                                                                </td>
                                                                <td class="table-action">
                                                                    <center>
                                                                        <a href="../satker_skai/laporan/cetak_tindak_lanjut.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank"> cetak </a>
                                                                    
                                                                    </center>
                                                                </td>
                                                                <td>
                                                                    <center><?= $data['cabang'] ?></center>
                                                                </td>
                                                                <td>
                                                                    <center><?= $data['tahun'] ?></center>
                                                                </td>
                                                                
                                                                <td>
                                                                    <center><?= $data['periode_laporan'] ?></center>
                                                                </td>

                                                                <td>
                                                                    Rp. <?= rupiah($data['total_aset']) ?>
                                                                </td>
                                                                
                                                                <td>
                                                                    <center><?= ucwords($data['dibuat_at']) ?></center>
                                                                </td>
                                                                <td>
                                                                    <center><?= ucwords($data['nama']) ?></center>
                                                                </td>
                                                                <td>
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_kredit.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">kredit</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_operasional.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">operasional</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_kepatuhan.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">kepatuhan</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_likuiditas.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">likuiditas</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_reputasi.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">reputasi</a> |
                                                                <a href="../satker_skai/laporan/cetak_kc_risiko_stratejik.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">stratejik</a>
                                                                </td>

                                                            





                                                            </tr>
                                                        <?php
                                                        };
                                                        ?>
                                                    </tbody>
                                                </table>
                                                </div> <!-- end table-responsive-->

                                            </div> <!-- end card body-->
                                        </div> <!-- end card -->
                                    </div><!-- end col-->
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>

<!--- table all ---
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>

                                                <th>
                                                    <center>Aksi</center>
                                                </th>
                                                <th>
                                                                <center>Tindak Lanjut</center>
                                                            </th>
                                                <th>
                                                    <center>Kantor Cabang</center>
                                                </th>
                                                <th>
                                                    <center>Tahun</center>
                                                </th>
                                                <th>
                                                    <center>Jenis Profil Risiko</center>
                                                </th>
                                                <th>
                                                    <center>Periode</center>
                                                </th>

                                                <th>
                                                    <center>Total Aset</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                                <th>
                                                    <center>Pembuat</center>
                                                </th>
                                                <th>
                                                    <center>Keterangan</center>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $no = 1;
                                            $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user = '3' AND status_korwil = 1 order by id_profil_risiko desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=laporan_masuk&id=<?= $data['id_profil_risiko'] ?>"><i><input type="checkbox" form="my_form" id="selected_id"  name="selected_id" <?php if ($data['id_profil_risiko'] == $id) echo 'checked'; ?> disabled></i> aktifkan</a>
                                                            |
                                                            <a href="index.php?page=konfirm&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin laporan cabang sudah benar?');"><i><input type="checkbox" form="my_form" id="selected_id"  name="selected_id" <?php if ($data['status_skmr'] == 1) echo 'checked'; ?> disabled></i> konfirmasi</a> |
                                                             <a href="../satker_skai/laporan/cetak_laporan_kc.php?id=<?= $data['id_profil_risiko'] ?>"target="_blank">cetak</a>|
                                                            <a href="index.php?page=delete_frame&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin menghapus data?');"><i class=" mdi mdi-delete"></i>hapus</a>
                                                        </center>
                                                    </td>


                                                    <td>
                                                        <center><?= $data['cabang'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tipe_user'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['periode_laporan']) ?></center>
                                                    </td>

                                                    <td>
                                                        Rp. <?= rupiah($data['total_aset']) ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <center><?= ucwords($data['dibuat_at']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['nama']) ?></center>
                                                    </td>
                                                    <td>
                                                        <?= ucwords($data['keterangan']) ?>
                                                    </td>

                                                   





                                                </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div> 


                            </div> 
                        </div>
                    </div>
                </div>
            </div>
--->

        </div>
        <!-- container -->

    </div>
    <!-- content -->
</div>