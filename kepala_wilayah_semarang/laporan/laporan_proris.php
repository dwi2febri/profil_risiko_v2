<?php
include "../fungsi/fungsi.php";
?>

<div class="content-page">
    <div class="content">
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
                    <div class="card oai-card-head">
                        <div class="card-body">
                            <h4 class="header-title">Tabel Laporan Profil Risiko Yang Masuk</h4>
                            <p class="text-muted font-14 mb-0">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh User
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card oai-table-card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100 oai-laporan-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th><center>No</center></th>
                                                <th><center>Aksi</center></th>
                                                <th><center>Tindak Lanjut</center></th>
                                                <th><center>Kantor Cabang</center></th>
                                                <th><center>Tahun</center></th>
                                                <th><center>Jenis Profil Risiko</center></th>
                                                <th><center>Periode</center></th>
                                                <th><center>Total Aset</center></th>
                                                <th><center>Tanggal Dibuat</center></th>
                                                <th><center>Pembuat</center></th>
                                                <th><center>Keterangan</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../conn/conn.php";
                                            $no = 1;
                                            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                                            $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user = '3' AND kantor_cabang IN(1,2,3,4,5,6,7) order by id_profil_risiko desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td><center><?= $no++ ?></center></td>

                                                    <td class="table-action aksi-laporan">
                                                        <div class="aksi-wrap">
                                                            <a href="index.php?page=laporan_masuk&id=<?= $data['id_profil_risiko'] ?>" class="aksi-link aksi-check">
                                                                <input type="checkbox" form="my_form" name="selected_id" <?= ($data['id_profil_risiko'] == $id ? 'checked' : '') ?> disabled>
                                                                <span>aktifkan</span>
                                                            </a>

                                                            <span class="aksi-separator">|</span>

                                                            <a href="../kepala_wilayah_solo/laporan/cetak_laporan_profil_risiko.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank" class="aksi-link">
                                                                cetak
                                                            </a>

                                                            <span class="aksi-separator">|</span>

                                                            <a href="index.php?page=konfirm&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin laporan cabang sudah benar?');" class="aksi-link aksi-check">
                                                                <input type="checkbox" form="my_form" name="selected_id" <?= ($data['status_korwil'] == 1 ? 'checked' : '') ?> disabled>
                                                                <span>konfirmasi</span>
                                                            </a>
                                                        </div>
                                                    </td>

                                                    <td class="table-action aksi-laporan">
                                                        <div class="aksi-wrap aksi-wrap-small">
                                                            <a href="javascript:void(0)" onclick="openCetakTindakLanjutModal(<?= (int)$data['id_profil_risiko'] ?>)" class="aksi-link">
                                                                cetak
                                                            </a>
                                                        </div>
                                                    </td>

                                                    <td><center><?= $data['cabang'] ?></center></td>
                                                    <td><center><?= $data['tahun'] ?></center></td>
                                                    <td><center><?= $data['tipe_user'] ?></center></td>
                                                    <td><center><?= ucwords($data['periode_laporan']) ?></center></td>
                                                    <td>Rp. <?= rupiah($data['total_aset']) ?></td>
                                                    <td><center><?= ucwords($data['dibuat_at']) ?></center></td>
                                                    <td><center><?= ucwords($data['nama']) ?></center></td>
                                                    <td><?= ucwords($data['keterangan']) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style id="oaiLaporanMasukModernFix">
/* Tampilan dibuat lebih bersih, menu/query tetap sama */
.oai-card-head,
.oai-table-card{
    border:0 !important;
    border-radius:10px !important;
    box-shadow:0 8px 24px rgba(15,23,42,.04) !important;
}
.oai-card-head .card-body{
    padding:26px 28px !important;
}
.oai-card-head .header-title{
    text-transform:uppercase !important;
    font-weight:800 !important;
    letter-spacing:.2px !important;
    color:#000 !important;
    margin-bottom:8px !important;
}
.oai-card-head p,
.oai-card-head .text-muted{
    color:#000 !important;
    font-size:15px !important;
}
.oai-table-card .card-body{
    padding:24px 26px !important;
}
.oai-laporan-table thead th{
    background:#dfe2ff !important;
    color:#000 !important;
    font-weight:800 !important;
    border-color:#dfe2ff !important;
    vertical-align:middle !important;
    padding:14px 12px !important;
}
.oai-laporan-table tbody td{
    color:#000 !important;
    vertical-align:middle !important;
    padding:16px 12px !important;
    border-color:#edf0f5 !important;
}
.oai-laporan-table tbody tr:hover{
    background:#fafbff !important;
}

/* FIX UTAMA: checklist, aktifkan, cetak, konfirmasi sejajar */
.aksi-laporan{
    vertical-align:middle !important;
    white-space:nowrap !important;
}
.aksi-wrap{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:6px !important;
    flex-wrap:nowrap !important;
    white-space:nowrap !important;
    min-width:260px !important;
}
.aksi-wrap-small{
    min-width:70px !important;
}
.aksi-link{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:5px !important;
    line-height:1 !important;
    white-space:nowrap !important;
    text-decoration:none !important;
    color:#5f6df4 !important;
    font-weight:500 !important;
}
.aksi-link:hover{
    color:#3544d8 !important;
    text-decoration:none !important;
}
.aksi-check input[type="checkbox"]{
    width:14px !important;
    height:14px !important;
    margin:0 !important;
    padding:0 !important;
    position:relative !important;
    top:0 !important;
    flex:0 0 auto !important;
    vertical-align:middle !important;
    cursor:default !important;
}
.aksi-check span{
    display:inline-block !important;
    line-height:1 !important;
}
.aksi-separator{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    line-height:1 !important;
    color:#6b7280 !important;
}

/* Backup jika masih ada struktur center lama dari theme/DataTables */
.table-action center{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:6px !important;
    white-space:nowrap !important;
}
.table-action center a{
    display:inline-flex !important;
    align-items:center !important;
    gap:5px !important;
    white-space:nowrap !important;
}
.table-action center input[type="checkbox"]{
    margin:0 !important;
    vertical-align:middle !important;
}

/* DataTables supaya lebih rapi seperti screenshot */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate{
    color:#000 !important;
    font-size:14px !important;
}
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select{
    border:1px solid #d9dee8 !important;
    border-radius:6px !important;
    padding:8px 10px !important;
    color:#000 !important;
}


/* OAI FIX: aktifkan dan konfirmasi dibuat biru seperti link cetak */
.oai-laporan-table td.aksi-laporan .aksi-wrap a.aksi-link,
.oai-laporan-table td.aksi-laporan .aksi-wrap a.aksi-link span,
.oai-laporan-table td.aksi-laporan .aksi-wrap-small a.aksi-link{
    color:#5f6df4 !important;
    font-weight:500 !important;
}
.oai-laporan-table td.aksi-laporan .aksi-wrap a.aksi-link:hover,
.oai-laporan-table td.aksi-laporan .aksi-wrap a.aksi-link:hover span,
.oai-laporan-table td.aksi-laporan .aksi-wrap-small a.aksi-link:hover{
    color:#3544d8 !important;
    text-decoration:none !important;
}
.oai-laporan-table td.aksi-laporan .aksi-check input[type="checkbox"]{
    accent-color:#5f6df4 !important;
}
</style>


<!-- MODAL CETAK TINDAK LANJUT PROFIL RISIKO - SEPERTI SCRIPT KEDUA -->
<div class="modal fade" id="modalCetakTindakLanjut" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog cetak-tl-modal-dialog">
        <div class="modal-content cetak-tl-modal-content">
            <div class="modal-header cetak-tl-modal-header">
                <div class="ms-auto d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-primary btn-lg btn-cetak-tl-print" onclick="printCetakTindakLanjutModal()">
                        <i class="mdi mdi-printer"></i> Cetak PDF
                    </button>
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

<style id="oaiCetakTindakLanjutModalStyle">
#modalCetakTindakLanjut{background:transparent!important;}
.modal-backdrop.show{
    opacity:.45!important;
    background:#000!important;
    backdrop-filter:blur(3px);
    -webkit-backdrop-filter:blur(3px);
}
body.modal-open{overflow:hidden!important;padding-right:0!important;}
#modalCetakTindakLanjut .modal-content,
#modalCetakTindakLanjut .modal-body,
#modalCetakTindakLanjut iframe{background:#fff!important;}
#modalCetakTindakLanjut .modal-header{position:sticky;top:0;z-index:10;}
#modalCetakTindakLanjut .modal-dialog,
#modalCetakTindakLanjut .cetak-tl-modal-dialog{
    position:fixed!important;
    top:50%!important;
    left:50%!important;
    transform:translate(-50%,-50%)!important;
    -webkit-transform:translate(-50%,-50%)!important;
    max-width:none!important;
    width:calc(125vw - 18px)!important;
    height:calc(125vh - 18px)!important;
    margin:0!important;
    padding:0!important;
}
#modalCetakTindakLanjut.fade .modal-dialog,
#modalCetakTindakLanjut.show .modal-dialog{
    transform:translate(-50%,-50%)!important;
    -webkit-transform:translate(-50%,-50%)!important;
}
#modalCetakTindakLanjut .cetak-tl-modal-content{
    background:#fff!important;
    border-radius:8px!important;
    overflow:hidden!important;
    width:100%!important;
    max-width:none!important;
    height:100%!important;
    box-shadow:0 10px 35px rgba(0,0,0,.28)!important;
}
#modalCetakTindakLanjut .cetak-tl-modal-header{
    background:#fff!important;
    border-bottom:1px solid #dee2e6!important;
    min-height:60px!important;
    height:60px!important;
    padding:9px 14px!important;
}
#modalCetakTindakLanjut .btn-cetak-tl-print,
#modalCetakTindakLanjut .btn-cetak-tl-close{
    font-size:15px!important;
    font-weight:800!important;
    padding:10px 20px!important;
    border-radius:6px!important;
    min-height:40px!important;
    min-width:122px!important;
}
#modalCetakTindakLanjut .btn-cetak-tl-print{min-width:135px!important;}
#modalCetakTindakLanjut .cetak-tl-modal-body{
    background:#fff!important;
    height:calc(125vh - 60px)!important;
    overflow:hidden!important;
    position:relative!important;
}
#modalCetakTindakLanjut #iframeCetakTindakLanjut{
    width:100%!important;
    height:100%!important;
    min-height:calc(125vh - 60px)!important;
}
@media (max-width: 768px){
    #modalCetakTindakLanjut .modal-dialog,
    #modalCetakTindakLanjut .cetak-tl-modal-dialog{
        width:calc(125vw - 8px)!important;
        height:calc(125vh - 8px)!important;
    }
    #modalCetakTindakLanjut .cetak-tl-modal-body{height:calc(125vh - 52px)!important;}
}
#modalCetakTindakLanjut .cetak-tl-loading{
    position:absolute;
    inset:0;
    z-index:50;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.94);
    color:#6c757d;
    font-size:14px;
}
#modalCetakTindakLanjut .cetak-tl-loading.is-hidden{display:none!important;}
#modalCetakTindakLanjut .cetak-tl-spinner{
    width:74px;
    height:74px;
    border-radius:50%;
    border:7px solid #e1e1e1;
    border-top-color:#777;
    animation:cetakTlSpin .85s linear infinite;
}
#modalCetakTindakLanjut .cetak-tl-title{
    margin-top:12px;
    font-size:18px;
    font-weight:600;
    color:#777;
}
#modalCetakTindakLanjut .cetak-tl-subtitle{
    margin-top:4px;
    font-size:13px;
    color:#777;
}
@keyframes cetakTlSpin{to{transform:rotate(360deg);}}
</style>

<script id="oaiCetakTindakLanjutModalScript">
var currentCetakTindakLanjutId = 0;
var cetakTindakLanjutLoadingTimer = null;

function setCetakTindakLanjutLoading(show, text) {
    var loading = document.getElementById('loadingCetakTindakLanjut');
    var loadingText = document.getElementById('loadingCetakTindakLanjutText');
    if (loadingText && text) loadingText.textContent = text;
    if (!loading) return;
    if (show) loading.classList.remove('is-hidden');
    else loading.classList.add('is-hidden');
}

function startCetakTindakLanjutLoadingWatcher() {
    if (cetakTindakLanjutLoadingTimer) clearInterval(cetakTindakLanjutLoadingTimer);
    var iframe = document.getElementById('iframeCetakTindakLanjut');
    setCetakTindakLanjutLoading(true, 'Menyiapkan preview tindak lanjut...');

    cetakTindakLanjutLoadingTimer = setInterval(function(){
        try {
            if (!iframe || !iframe.contentWindow) return;
            var doc = iframe.contentDocument || iframe.contentWindow.document;
            if (!doc || !doc.body) return;

            var statusEl = doc.getElementById('loadStatus');
            var statusText = statusEl ? (statusEl.textContent || '').trim() : '';
            if (statusText) {
                setCetakTindakLanjutLoading(true, statusText);
                if (statusText.toLowerCase().indexOf('selesai') !== -1 || statusText.toLowerCase().indexOf('siap dicetak') !== -1) {
                    clearInterval(cetakTindakLanjutLoadingTimer);
                    cetakTindakLanjutLoadingTimer = null;
                    setTimeout(function(){ setCetakTindakLanjutLoading(false); }, 350);
                }
            } else if (doc.readyState === 'complete') {
                clearInterval(cetakTindakLanjutLoadingTimer);
                cetakTindakLanjutLoadingTimer = null;
                setTimeout(function(){ setCetakTindakLanjutLoading(false); }, 350);
            }
        } catch(e) {
            setCetakTindakLanjutLoading(true, 'Memuat preview tindak lanjut...');
        }
    }, 350);
}

function openCetakTindakLanjutModal(idProfil) {
    currentCetakTindakLanjutId = idProfil;
    var iframe = document.getElementById('iframeCetakTindakLanjut');
    if (!iframe) return;

    if (cetakTindakLanjutLoadingTimer) {
        clearInterval(cetakTindakLanjutLoadingTimer);
        cetakTindakLanjutLoadingTimer = null;
    }

    setCetakTindakLanjutLoading(true, 'Menyiapkan preview tindak lanjut profil per risiko...');
    iframe.onload = function(){ startCetakTindakLanjutLoadingWatcher(); };
    iframe.src = 'about:blank';

    var el = document.getElementById('modalCetakTindakLanjut');
    if (window.bootstrap && bootstrap.Modal) {
        var modal = bootstrap.Modal.getOrCreateInstance(el, {backdrop:true, keyboard:true, focus:true});
        modal.show();
    } else if (window.$ && $('#modalCetakTindakLanjut').modal) {
        $('#modalCetakTindakLanjut').modal({backdrop:true, keyboard:true}).modal('show');
    }

    setTimeout(function(){
        iframe.src = 'laporan/cetak_laporan_profil_risiko.php?id=' + encodeURIComponent(idProfil)
            + '&modal_view=1&embed_modal=1&print_scale=300'
            + '&only_tindak_lanjut=1&only_profil_per_risiko=1';
    }, 80);
}

function printCetakTindakLanjutModal() {
    var iframe = document.getElementById('iframeCetakTindakLanjut');
    if (!iframe || !iframe.contentWindow) return;
    try {
        if (iframe.contentWindow.setPrintOrientation) iframe.contentWindow.setPrintOrientation('portrait');
        if (iframe.contentWindow.setPrintScale) iframe.contentWindow.setPrintScale(160);
        if (iframe.contentWindow.prepareAndPrintF4) {
            iframe.contentWindow.prepareAndPrintF4();
            return;
        }
    } catch(e) {}
    setTimeout(function(){
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
    }, 250);
}

document.addEventListener('DOMContentLoaded', function() {
    var modalEl = document.getElementById('modalCetakTindakLanjut');
    var iframeEl = document.getElementById('iframeCetakTindakLanjut');
    var loadingEl = document.getElementById('loadingCetakTindakLanjut');
    if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function(){
            if (cetakTindakLanjutLoadingTimer) {
                clearInterval(cetakTindakLanjutLoadingTimer);
                cetakTindakLanjutLoadingTimer = null;
            }
            if (iframeEl) iframeEl.src = 'about:blank';
            if (loadingEl) loadingEl.classList.add('is-hidden');
        });
    }
});
</script>
