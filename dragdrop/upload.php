<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['file'])) {
        
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $originalFileName = basename($_FILES['file']['name']);
        $fileType = mime_content_type($_FILES['file']['tmp_name']);
        $allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Only PDF and DOCX files are allowed.']);
            exit;
        }

        if ($_FILES['file']['size'] > $maxSize) {
            echo json_encode(['status' => 'error', 'message' => 'File must be less than 5MB.']);
            exit;
        }

        $fileExt = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $uploaderName = preg_replace("/[^a-zA-Z0-9]/", "_", $_POST['uploader_name'] ?? 'unknown');
        $newFileName = time() . "_$uploaderName.$fileExt";
        $targetFile = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO uploads (uploader_name, original_filename, stored_filename, file_type, file_size) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $uploaderName, $originalFileName, $newFileName, $fileType, $_FILES['file']['size']);
            $stmt->execute();
            $stmt->close();
            
            echo json_encode(['status' => 'success', 'file' => $newFileName]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded.']);
    }
}
$conn->close();
?>
