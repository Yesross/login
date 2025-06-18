<?php
include 'config/db.php';

if (isset($_POST['id'])) {
    $fileId = intval($_POST['id']);

    $query = $conn->prepare("SELECT file_path FROM uploads WHERE id = ?");
    $query->bind_param("i", $fileId);
    $query->execute();
    $query->bind_result($filePath);
    $query->fetch();
    $query->close();

    if (file_exists($filePath)) {
        unlink($filePath); // Delete the file from the server
    }

    $delete = $conn->prepare("DELETE FROM uploads WHERE id = ?");
    $delete->bind_param("i", $fileId);
    $delete->execute();
    echo "File deleted successfully!";
}
?>
