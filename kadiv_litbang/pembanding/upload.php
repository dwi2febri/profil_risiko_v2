<?php
require 'fetch.php';



if (isset($_FILES['pdfFile']) && isset($_POST['item_id'])) {
    $itemId = ($_POST['item_id']); // Konversi aman ke int
    $file = $_FILES['pdfFile'];
    $fileName = basename($file['name']);
    $uploadDir = "../../file/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetPath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

    if ($fileType !== 'pdf') {
        die("Hanya file PDF yang diperbolehkan.");
    }

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $stmt = $conn->prepare("INSERT INTO files (item_id, filename) VALUES (?, ?)");
        $stmt->bind_param("is", $itemId, $fileName);
        $stmt->execute();
        $stmt->close();

        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Gagal upload file.";
    }
}
?>