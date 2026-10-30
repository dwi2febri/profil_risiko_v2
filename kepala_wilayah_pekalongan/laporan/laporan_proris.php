<?php
include "../fungsi/fungsi.php";

?>


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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100 oai-laporan-table">
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
                                            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                                            $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user = '3' AND kantor_cabang IN(22,23,24,25,26,27,28) order by id_profil_risiko desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action aksi-laporan">
                                                        <div class="aksi-wrap">
                                                            <a href="index.php?page=laporan_masuk&id=<?= $data['id_profil_risiko'] ?>" class="aksi-link aksi-check oai-force-blue-link">
                                                                <input type="checkbox" form="my_form" name="selected_id" <?= ($data['id_profil_risiko'] == $id ? 'checked' : '') ?> disabled>
                                                                <span>aktifkan</span>
                                                            </a>
                                                            <span class="aksi-separator">|</span>
                                                            <a href="../kepala_wilayah_pekalongan/laporan/cetak_laporan_profil_risiko.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank" class="aksi-link oai-force-blue-link">cetak</a>
                                                            <span class="aksi-separator">|</span>
                                                            <a href="index.php?page=konfirm&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin laporan cabang sudah benar?');" class="aksi-link aksi-check oai-force-blue-link">
                                                                <input type="checkbox" form="my_form" name="selected_id" <?= ($data['status_korwil'] == 1 ? 'checked' : '') ?> disabled>
                                                                <span>konfirmasi</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td class="table-action aksi-laporan">
                                                        <div class="aksi-wrap aksi-wrap-small">
                                                            <a href="javascript:void(0)" onclick="openCetakTindakLanjutModal(<?= (int)$data['id_profil_risiko'] ?>)" class="aksi-link oai-force-blue-link">cetak</a>
                                                        </div>
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
                                </div> <!-- end preview-->


                            </div> <!-- end tab-content-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container -->

    </div>
    <!-- content -->
</div>

<style id="oaiLaporanMasukPekalonganGreyCheckboxFix">
.oai-laporan-table thead th{vertical-align:middle!important;text-align:center!important}
.oai-laporan-table tbody td{vertical-align:middle!important}
.aksi-laporan{white-space:nowrap!important}
.aksi-wrap{display:inline-flex!important;align-items:center!important;justify-content:center!important;gap:7px!important;min-width:260px!important}
.aksi-wrap-small{min-width:70px!important}

/* FIX WARNA: aktifkan, cetak, konfirmasi, dan tindak lanjut cetak dipaksa biru */
.oai-laporan-table td.aksi-laporan a,
.oai-laporan-table td.aksi-laporan a:link,
.oai-laporan-table td.aksi-laporan a:visited,
.oai-laporan-table td.aksi-laporan a:active,
.oai-laporan-table td.aksi-laporan a span,
.oai-laporan-table td.aksi-laporan .aksi-link,
.oai-laporan-table td.aksi-laporan .aksi-link span,
.table-action.aksi-laporan a,
.table-action.aksi-laporan a span,
.table-action.aksi-laporan .oai-force-blue-link,
.table-action.aksi-laporan .oai-force-blue-link span{
    color:#5f6df4!important;
    -webkit-text-fill-color:#5f6df4!important;
    text-decoration:none!important;
    font-weight:500!important;
}
.oai-laporan-table td.aksi-laporan a:hover,
.oai-laporan-table td.aksi-laporan a:hover span,
.table-action.aksi-laporan a:hover,
.table-action.aksi-laporan a:hover span{
    color:#3544d8!important;
    -webkit-text-fill-color:#3544d8!important;
    text-decoration:none!important;
}

.aksi-link{display:inline-flex!important;align-items:center!important;justify-content:center!important;gap:5px!important;line-height:1!important;white-space:nowrap!important;text-decoration:none!important;color:#5f6df4!important;font-weight:500!important}
.aksi-check,.aksi-check span{color:#5f6df4!important;-webkit-text-fill-color:#5f6df4!important}
.aksi-link:hover{color:#3544d8!important;text-decoration:none!important}
.aksi-check:hover,.aksi-check:hover span{color:#3544d8!important;-webkit-text-fill-color:#3544d8!important}
.aksi-separator{color:#adb5bd!important}

/* FIX CHECKBOX: kecil abu-abu seperti contoh Banyumas */
.aksi-check input[type="checkbox"]{
    appearance:none!important;
    -webkit-appearance:none!important;
    display:inline-block!important;
    width:14px!important;
    min-width:14px!important;
    max-width:14px!important;
    height:14px!important;
    min-height:14px!important;
    max-height:14px!important;
    margin:0!important;
    padding:0!important;
    border:1.5px solid #cfd4dc!important;
    border-radius:3px!important;
    background:#ffffff!important;
    position:relative!important;
    top:0!important;
    flex:0 0 14px!important;
    vertical-align:middle!important;
    cursor:default!important;
    opacity:1!important;
    box-sizing:border-box!important;
    line-height:14px!important;
}
.aksi-check input[type="checkbox"]:checked{
    background:#cfd4dc!important;
    border-color:#cfd4dc!important;
}
.aksi-check input[type="checkbox"]:checked::after{
    content:"✓";
    position:absolute;
    left:2px;
    top:-2px;
    color:#ffffff!important;
    -webkit-text-fill-color:#ffffff!important;
    font-size:11px;
    font-weight:900;
    line-height:14px;
    width:10px;
    height:10px;
}
.aksi-check input[type="checkbox"]:disabled{
    opacity:1!important;
    filter:none!important;
}
</style>


<style id="oaiCheckboxKecilFinalOverride">
/* FINAL FIX: checkbox aktifkan/konfirmasi kecil abu-abu meskipun index.php memberi min-height input 40px */
.oai-laporan-table td.aksi-laporan .aksi-check input[type="checkbox"],
.table-action.aksi-laporan .aksi-check input[type="checkbox"]{
    appearance:none!important;
    -webkit-appearance:none!important;
    display:inline-block!important;
    width:14px!important;
    min-width:14px!important;
    max-width:14px!important;
    height:14px!important;
    min-height:14px!important;
    max-height:14px!important;
    flex:0 0 14px!important;
    margin:0!important;
    padding:0!important;
    border:1.5px solid #cfd4dc!important;
    border-radius:3px!important;
    background:#fff!important;
    box-sizing:border-box!important;
    line-height:14px!important;
    vertical-align:middle!important;
    position:relative!important;
    cursor:default!important;
    opacity:1!important;
}
.oai-laporan-table td.aksi-laporan .aksi-check input[type="checkbox"]:checked,
.table-action.aksi-laporan .aksi-check input[type="checkbox"]:checked{
    background:#cfd4dc!important;
    border-color:#cfd4dc!important;
}
.oai-laporan-table td.aksi-laporan .aksi-check input[type="checkbox"]:checked::after,
.table-action.aksi-laporan .aksi-check input[type="checkbox"]:checked::after{
    content:"✓"!important;
    position:absolute!important;
    left:2px!important;
    top:-2px!important;
    color:#fff!important;
    -webkit-text-fill-color:#fff!important;
    font-size:11px!important;
    font-weight:900!important;
    line-height:14px!important;
}
</style>


<style id="oaiCheckboxAbuFinalPaksa">
/* Paksa checkbox kecil warna abu-abu; teks aksi tetap biru. */
.oai-laporan-table td.aksi-laporan .aksi-check input[type="checkbox"],
.table-action.aksi-laporan .aksi-check input[type="checkbox"]{
    appearance:none!important;
    -webkit-appearance:none!important;
    display:inline-block!important;
    width:14px!important;
    min-width:14px!important;
    max-width:14px!important;
    height:14px!important;
    min-height:14px!important;
    max-height:14px!important;
    flex:0 0 14px!important;
    margin:0!important;
    padding:0!important;
    border:1.5px solid #cfd4dc!important;
    border-radius:3px!important;
    background:#ffffff!important;
    box-sizing:border-box!important;
    line-height:14px!important;
    vertical-align:middle!important;
    position:relative!important;
    cursor:default!important;
    opacity:1!important;
    filter:none!important;
    box-shadow:none!important;
}
.oai-laporan-table td.aksi-laporan .aksi-check input[type="checkbox"]:checked,
.table-action.aksi-laporan .aksi-check input[type="checkbox"]:checked{
    background:#cfd4dc!important;
    border-color:#cfd4dc!important;
}
.oai-laporan-table td.aksi-laporan .aksi-check input[type="checkbox"]:checked::after,
.table-action.aksi-laporan .aksi-check input[type="checkbox"]:checked::after{
    content:"✓"!important;
    position:absolute!important;
    left:2px!important;
    top:-2px!important;
    color:#ffffff!important;
    -webkit-text-fill-color:#ffffff!important;
    font-size:11px!important;
    font-weight:900!important;
    line-height:14px!important;
}
</style>

<div class="modal fade" id="modalCetakTindakLanjut" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog cetak-tl-modal-dialog">
        <div class="modal-content cetak-tl-modal-content">
            <div class="modal-header cetak-tl-modal-header">
                <div class="ms-auto d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-primary btn-lg btn-cetak-tl-print" onclick="printCetakTindakLanjutModal()"><i class="mdi mdi-printer"></i> Cetak PDF</button>
                    <button type="button" class="btn btn-light btn-lg btn-cetak-tl-close" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
            <div class="modal-body p-0 cetak-tl-modal-body">
                <div id="loadingCetakTindakLanjut" class="cetak-tl-loading">
                    <div class="cetak-tl-spinner" aria-hidden="true"></div>
                    <div class="cetak-tl-title">Loading...</div>
                    <div id="loadingCetakTindakLanjutText" class="cetak-tl-subtitle">Menyiapkan preview tindak lanjut...</div>
                </div>
                <iframe id="iframeCetakTindakLanjut" src="about:blank" style="width:100%;height:100%;border:0;background:#fff;display:block;"></iframe>
            </div>
        </div>
    </div>
</div>

<style>
#modalCetakTindakLanjut{background:transparent!important}
.modal-backdrop.show{opacity:.45!important;background:#000!important;backdrop-filter:blur(3px);-webkit-backdrop-filter:blur(3px)}
body.modal-open{overflow:hidden!important;padding-right:0!important}
#modalCetakTindakLanjut .modal-content,#modalCetakTindakLanjut .modal-body,#modalCetakTindakLanjut iframe{background:#fff!important}
#modalCetakTindakLanjut .modal-header{position:sticky;top:0;z-index:10}
#modalCetakTindakLanjut .modal-dialog,#modalCetakTindakLanjut .cetak-tl-modal-dialog{position:fixed!important;top:50%!important;left:50%!important;transform:translate(-50%,-50%)!important;max-width:none!important;width:calc(125vw - 18px)!important;height:calc(125vh - 18px)!important;margin:0!important;padding:0!important}
#modalCetakTindakLanjut.fade .modal-dialog,#modalCetakTindakLanjut.show .modal-dialog{transform:translate(-50%,-50%)!important}
#modalCetakTindakLanjut .cetak-tl-modal-content{border-radius:8px!important;overflow:hidden!important;width:100%!important;max-width:none!important;height:100%!important;box-shadow:0 10px 35px rgba(0,0,0,.28)!important}
#modalCetakTindakLanjut .cetak-tl-modal-header{background:#fff!important;border-bottom:1px solid #dee2e6!important;min-height:60px!important;height:60px!important;padding:9px 14px!important}
#modalCetakTindakLanjut .btn-cetak-tl-print,#modalCetakTindakLanjut .btn-cetak-tl-close{font-size:15px!important;font-weight:800!important;padding:10px 20px!important;border-radius:6px!important;min-height:40px!important;min-width:122px!important}
#modalCetakTindakLanjut .btn-cetak-tl-print{min-width:135px!important}
#modalCetakTindakLanjut .cetak-tl-modal-body{height:calc(125vh - 60px)!important;overflow:hidden!important;position:relative!important}
#modalCetakTindakLanjut #iframeCetakTindakLanjut{width:100%!important;height:100%!important;min-height:calc(125vh - 60px)!important}
#modalCetakTindakLanjut .cetak-tl-loading{position:absolute;inset:0;z-index:50;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(255,255,255,.94);color:#777}
#modalCetakTindakLanjut .cetak-tl-loading.is-hidden{display:none!important}
#modalCetakTindakLanjut .cetak-tl-spinner{width:74px;height:74px;border-radius:50%;border:7px solid #e1e1e1;border-top-color:#777;animation:cetakTlSpin .85s linear infinite}
#modalCetakTindakLanjut .cetak-tl-title{margin-top:12px;font-size:18px;font-weight:600}
#modalCetakTindakLanjut .cetak-tl-subtitle{margin-top:4px;font-size:13px}
@keyframes cetakTlSpin{to{transform:rotate(360deg)}}
</style>
<script>
var currentCetakTindakLanjutId = 0;
function setCetakTindakLanjutLoading(show, text){
    var loading = document.getElementById('loadingCetakTindakLanjut');
    var loadingText = document.getElementById('loadingCetakTindakLanjutText');
    if (loading) loading.classList.toggle('is-hidden', !show);
    if (loadingText && text) loadingText.textContent = text;
}
function openCetakTindakLanjutModal(idProfil){
    currentCetakTindakLanjutId = idProfil;
    var iframe = document.getElementById('iframeCetakTindakLanjut');
    var el = document.getElementById('modalCetakTindakLanjut');
    if (!iframe || !el) return;
    setCetakTindakLanjutLoading(true, 'Menyiapkan preview tindak lanjut profil per risiko...');
    iframe.onload = function(){ setTimeout(function(){ setCetakTindakLanjutLoading(false); }, 350); };
    iframe.src = 'about:blank';
    if (window.bootstrap && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(el, {backdrop:true, keyboard:true, focus:true}).show();
    } else if (window.$ && $('#modalCetakTindakLanjut').modal) {
        $('#modalCetakTindakLanjut').modal({backdrop:true, keyboard:true}).modal('show');
    }
    setTimeout(function(){
        iframe.src = 'laporan/cetak_laporan_profil_risiko.php?id=' + encodeURIComponent(idProfil) + '&modal_view=1&embed_modal=1&print_scale=300&only_tindak_lanjut=1&only_profil_per_risiko=1';
    }, 80);
}
function printCetakTindakLanjutModal(){
    var iframe = document.getElementById('iframeCetakTindakLanjut');
    if (!iframe || !iframe.contentWindow) return;
    iframe.contentWindow.focus();
    iframe.contentWindow.print();
}
</script>
