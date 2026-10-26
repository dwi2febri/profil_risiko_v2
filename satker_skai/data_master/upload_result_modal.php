<?php
$masterUploadResult = $_SESSION['master_upload_result'] ?? null;
$showMasterUploadResult = is_array($masterUploadResult)
    && ($masterUploadResult['type'] ?? '') === $masterUploadType
    && (int)($masterUploadResult['id'] ?? 0) === (int)$id;
if ($showMasterUploadResult) unset($_SESSION['master_upload_result']);
?>
<?php if ($showMasterUploadResult) { ?>
<style>
#masterUploadResultModal{z-index:20010!important;}
#masterUploadResultModal .modal-dialog{max-width:780px!important;}
#masterUploadResultModal .modal-content{border:0!important;border-radius:18px!important;box-shadow:0 28px 80px rgba(15,23,42,.35)!important;overflow:hidden;}
#masterUploadResultModal .upload-result-icon{width:64px;height:64px;margin:0 auto 14px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;}
#masterUploadResultModal .upload-result-icon.success{background:#dcfce7;color:#16a34a;}
#masterUploadResultModal .upload-result-icon.failed{background:#fee2e2;color:#dc2626;}
#masterUploadResultModal .upload-result-details{margin-top:16px;padding:12px 14px;border-radius:12px;background:#f8fafc;text-align:left;max-height:180px;overflow:auto;}
#masterUploadResultModal .upload-result-details div{padding:5px 0;border-bottom:1px solid #e5e7eb;}
#masterUploadResultModal .upload-result-details div:last-child{border-bottom:0;}
#masterUploadResultModal .upload-result-table-wrap{margin-top:18px;max-height:340px;overflow:auto;border:1px solid #dfe5ec;border-radius:12px;text-align:left;}
#masterUploadResultModal .upload-result-table{width:100%;margin:0;border-collapse:separate;border-spacing:0;font-size:13px;}
#masterUploadResultModal .upload-result-table th{position:sticky;top:0;z-index:2;background:#eef2f7;color:#344054;font-weight:700;padding:10px 12px;border-bottom:1px solid #d7dde5;}
#masterUploadResultModal .upload-result-table td{padding:8px 12px;border-bottom:1px solid #e7ebf0;color:#344054;}
#masterUploadResultModal .upload-result-table tbody tr:nth-child(even) td{background:#f8fafc;}
#masterUploadResultModal .upload-result-table tbody tr:last-child td{border-bottom:0;}
#masterUploadResultModal .upload-result-table th:last-child,
#masterUploadResultModal .upload-result-table td:last-child{text-align:right;width:34%;font-variant-numeric:tabular-nums;}
.modal-backdrop.master-upload-backdrop{z-index:20000!important;opacity:.62!important;}
</style>
<div class="modal fade" id="masterUploadResultModal" tabindex="-1" aria-labelledby="masterUploadResultTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title" id="masterUploadResultTitle">Hasil Upload <?= $masterUploadType === 'kredit' ? 'Master Kredit' : 'Master Likuiditas' ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-center px-4 py-4">
        <div class="upload-result-icon <?= !empty($masterUploadResult['success']) ? 'success' : 'failed' ?>">
          <i class="mdi <?= !empty($masterUploadResult['success']) ? 'mdi-check-bold' : 'mdi-alert-circle-outline' ?>"></i>
        </div>
        <h4><?= !empty($masterUploadResult['success']) ? 'Upload Berhasil' : 'Upload Gagal' ?></h4>
        <p class="mb-0"><?= htmlspecialchars((string)($masterUploadResult['message'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
        <?php if (!empty($masterUploadResult['data'])) { ?>
          <div class="upload-result-table-wrap">
            <table class="upload-result-table">
              <thead><tr><th>Field</th><th>Value</th></tr></thead>
              <tbody>
                <?php foreach ($masterUploadResult['data'] as $field => $value) {
                    $displayValue = (string)$value;
                    if (is_numeric($displayValue)) {
                        $decimal = (float)$displayValue != (int)$displayValue;
                        $displayValue = number_format((float)$displayValue, $decimal ? 2 : 0, ',', '.');
                    }
                ?>
                  <tr>
                    <td><?= htmlspecialchars((string)$field, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($displayValue, ENT_QUOTES, 'UTF-8') ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } ?>
        <?php if (!empty($masterUploadResult['details'])) { ?>
          <div class="upload-result-details">
            <?php foreach ($masterUploadResult['details'] as $detail) { ?>
              <div><i class="mdi mdi-check-circle text-success me-1"></i><?= htmlspecialchars((string)$detail, ENT_QUOTES, 'UTF-8') ?></div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">OK, Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var modalElement = document.getElementById('masterUploadResultModal');
    if (!modalElement || typeof bootstrap === 'undefined') return;
    document.body.appendChild(modalElement);
    modalElement.addEventListener('shown.bs.modal', function(){
        var backdrops = document.querySelectorAll('.modal-backdrop');
        if (backdrops.length) backdrops[backdrops.length - 1].classList.add('master-upload-backdrop');
    });
    bootstrap.Modal.getOrCreateInstance(modalElement, {backdrop:'static', keyboard:true}).show();
});
</script>
<?php } ?>
