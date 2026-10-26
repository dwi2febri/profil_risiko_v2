<?php
require 'fetch.php';

if (isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);

    $stmt = $conn->prepare("SELECT filename FROM files WHERE item_id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->bind_result($filename);
    
    if ($stmt->fetch()) {
        echo json_encode(['success' => true, 'filename' => $filename]);
    } else {
        echo json_encode(['success' => false, 'message' => 'File tidak ditemukan.']);
    }
    $stmt->close();
}
?>
