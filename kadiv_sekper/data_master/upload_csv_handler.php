<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user_id']) || ($_SESSION['tipe'] ?? '') !== 'kepala divisi sekper') {
    header('Location: ../../login.php');
    exit;
}
require_once __DIR__ . '/../../conn/conn.php';

function master_upload_redirect($page, $id) {
    header('Location: ../index.php?page=' . rawurlencode($page) . '&id=' . (int)$id);
    exit;
}
function master_upload_flash($type, $id, $success, $message, $details = [], $data = []) {
    $_SESSION['master_upload_result'] = [
        'type'=>$type,
        'id'=>(int)$id,
        'success'=>(bool)$success,
        'message'=>$message,
        'details'=>array_slice($details, 0, 100),
        'data'=>array_slice($data, 0, 250, true)
    ];
}
function master_upload_normalize($field, $value) {
    $value = preg_replace('/^\xEF\xBB\xBF/', '', trim((string)$value));
    $value = preg_replace('/\s+/', '', str_ireplace(['Rp', 'IDR'], '', $value));
    if ($value === '') return '0';
    if (preg_match('/^-?\d{1,3}(\.\d{3})+(,\d+)?$/', $value)) return str_replace(',', '.', str_replace('.', '', $value));
    if (substr_count($value, ',') === 1 && substr_count($value, '.') === 0) return str_replace(',', '.', $value);
    return $value;
}

if (isset($_GET['template'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="template_master_' . $uploadType . '.csv"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF");
    fputcsv($out, ['field', 'value'], ';', '"', "\\");
    foreach ($templateFields as $field) fputcsv($out, [$field, '0'], ';', '"', "\\");
    fclose($out);
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['upload'])) {
    master_upload_flash($uploadType, $id, false, 'Permintaan upload tidak valid.');
    master_upload_redirect($redirectPage, $id);
}
if ($id <= 0) {
    master_upload_flash($uploadType, 0, false, 'ID laporan profil risiko tidak ditemukan.');
    master_upload_redirect($redirectPage, 0);
}
$frameCheck = mysqli_query($conn, "SELECT 1 FROM frame_laporan_profil_risiko WHERE id_profil_risiko='$id' LIMIT 1");
if (!$frameCheck || mysqli_num_rows($frameCheck) === 0) {
    master_upload_flash($uploadType, $id, false, 'Laporan profil risiko tidak ditemukan.');
    master_upload_redirect($redirectPage, $id);
}
if (!isset($_FILES['file_csv']) || $_FILES['file_csv']['error'] !== UPLOAD_ERR_OK) {
    master_upload_flash($uploadType, $id, false, 'File CSV gagal diunggah. Silakan pilih file kembali.');
    master_upload_redirect($redirectPage, $id);
}
$handle = fopen($_FILES['file_csv']['tmp_name'], 'r');
if (!$handle) {
    master_upload_flash($uploadType, $id, false, 'File CSV tidak dapat dibaca.');
    master_upload_redirect($redirectPage, $id);
}
$firstLine = fgets($handle);
rewind($handle);
$delimiter = substr_count((string)$firstLine, ';') >= substr_count((string)$firstLine, ',') ? ';' : ',';
$dataUpdate = [];
$rowNumber = 0;
while (($row = fgetcsv($handle, 0, $delimiter, '"', "\\")) !== false) {
    $rowNumber++;
    if (count($row) < 2) continue;
    $field = trim(preg_replace('/^\xEF\xBB\xBF/', '', (string)$row[0]));
    if ($rowNumber === 1 && strtolower($field) === 'field') continue;
    if (!in_array($field, $templateFields, true)) continue;
    $dataUpdate[$field] = master_upload_normalize($field, $row[1]);
}
fclose($handle);
if (!$dataUpdate) {
    master_upload_flash($uploadType, $id, false, 'Tidak ada field yang cocok. Gunakan template CSV yang tersedia.');
    master_upload_redirect($redirectPage, $id);
}

$details = [];
$savedFields = [];
mysqli_begin_transaction($conn);
try {
    foreach ($targetTables as $table) {
        $safeTable = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $columns = [];
        $qColumns = mysqli_query($conn, "SHOW COLUMNS FROM `$safeTable`");
        if (!$qColumns) throw new Exception("Struktur tabel $safeTable tidak dapat dibaca.");
        while ($column = mysqli_fetch_assoc($qColumns)) $columns[] = $column['Field'];
        $updates = [];
        foreach ($dataUpdate as $field => $value) {
            if (!in_array($field, $columns, true)) continue;
            $updates[] = "`$field`='" . mysqli_real_escape_string($conn, $value) . "'";
            $savedFields[$field] = $value;
        }
        if (!$updates) continue;
        $exists = mysqli_query($conn, "SELECT 1 FROM `$safeTable` WHERE id_profil_risiko='$id' LIMIT 1");
        if (!$exists) throw new Exception(mysqli_error($conn));
        if (mysqli_num_rows($exists) === 0 && !mysqli_query($conn, "INSERT INTO `$safeTable` (id_profil_risiko) VALUES ('$id')")) {
            throw new Exception("Gagal membuat data pada $safeTable: " . mysqli_error($conn));
        }
        if (!mysqli_query($conn, "UPDATE `$safeTable` SET " . implode(',', $updates) . " WHERE id_profil_risiko='$id'")) {
            throw new Exception("Gagal menyimpan $safeTable: " . mysqli_error($conn));
        }
        $details[] = count($updates) . " field tersimpan pada $safeTable";
    }
    if (!$savedFields) throw new Exception('Tidak ada kolom CSV yang sesuai dengan tabel database.');
    if ($uploadType === 'kredit') {
        // Halaman Master Kredit membaca tabel autosave sebagai nilai terakhir,
        // sehingga hasil upload harus disinkronkan agar tidak ditimpa data lama.
        $autosaveExists = mysqli_query($conn, "SHOW TABLES LIKE 'master_kredit_autosave'");
        if ($autosaveExists && mysqli_num_rows($autosaveExists) > 0) {
            foreach ($savedFields as $field => $value) {
                $safeField = mysqli_real_escape_string($conn, $field);
                $safeValue = mysqli_real_escape_string($conn, $value);
                if (!mysqli_query($conn, "INSERT INTO master_kredit_autosave (id_profil_risiko, field_name, field_value, updated_at)
                    VALUES ('$id','$safeField','$safeValue',NOW())
                    ON DUPLICATE KEY UPDATE field_value=VALUES(field_value), updated_at=NOW()")) {
                    throw new Exception('Gagal menyinkronkan autosave Kredit: ' . mysqli_error($conn));
                }
            }
        }
        $frameUpdates = [];
        foreach (['total_aset','modal_inti'] as $field) if (isset($dataUpdate[$field])) $frameUpdates[] = "`$field`='" . mysqli_real_escape_string($conn, $dataUpdate[$field]) . "'";
        if ($frameUpdates && !mysqli_query($conn, "UPDATE frame_laporan_profil_risiko SET " . implode(',', $frameUpdates) . " WHERE id_profil_risiko='$id'")) throw new Exception(mysqli_error($conn));
    }
    mysqli_commit($conn);
    master_upload_flash($uploadType, $id, true, count($savedFields) . ' field berhasil disimpan.', $details, $savedFields);
} catch (Throwable $e) {
    mysqli_rollback($conn);
    master_upload_flash($uploadType, $id, false, $e->getMessage());
}
master_upload_redirect($redirectPage, $id);
