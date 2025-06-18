<?php
include 'config/db.php';

$result = $conn->query("SELECT * FROM uploads ORDER BY upload_date DESC");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $file_id = $row['id'];
        $file_name = $row['file_name'];
        $file_path = $row['file_path'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        echo "<div class='file-item'>
                <a href='download.php?file=" . urlencode($file_path) . "' target='_blank'>" . $file_name . "</a>
                <button class='delete-btn' data-id='" . $file_id . "'>Delete</button>
              </div>";

        // Display file content preview
        echo "<div class='file-content' data-filename='" . $file_name . "' style='display: none;'>";

        if (in_array($file_extension, ['txt', 'csv', 'log'])) {
            echo "<pre>" . htmlspecialchars(file_get_contents($file_path)) . "</pre>";
        } elseif ($file_extension === 'pdf') {
            echo "<iframe src='" . $file_path . "' width='100%' height='500px'></iframe>";
        }

        echo "</div>"; // Close div
    }
} else {
    echo "<p>No files uploaded yet.</p>";
}
?>
