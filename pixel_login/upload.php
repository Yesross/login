<?php
include 'config/db.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_FILES['file']['error'] == 0) {
    $allowed_types = ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
    $max_size = 5 * 1024 * 1024;

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = mime_content_type($file_tmp);

    if (!in_array($file_type, $allowed_types)) {
        die("Invalid file type.");
    }

    if ($file_size > $max_size) {
        die("File size exceeds 5MB.");
    }

    $new_name = date("YmdHis") . "_" . $file_name;
    $upload_dir = "uploads/";
    $file_path = $upload_dir . $new_name;

    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT id FROM responsive WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $uploaded_by = $row['id']; // Get user ID

        if (move_uploaded_file($file_tmp, $file_path)) {
            $stmt = $conn->prepare("INSERT INTO uploads (file_name, file_path, uploaded_by) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $new_name, $file_path, $uploaded_by);
            $stmt->execute();
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }else {
        echo "User not found.";
    }
}
?>
