<?php
include 'db_config.php';

$sql = "SELECT id, uploader_name, original_filename, stored_filename FROM uploads ORDER BY upload_date DESC";
$result = $conn->query($sql);
?>

<h2>Uploaded Files</h2>
<table border="1">
    <tr><th>Uploader</th><th>File</th><th>Download</th><th>View</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['uploader_name']) ?></td>
        <td><?= htmlspecialchars($row['original_filename']) ?></td>
        <td><a href="uploads/<?= $row['stored_filename'] ?>" download>Download</a></td>
        <td><a href="view_file.php?id=<?= $row['id'] ?>">View</a></td>
    </tr>
    <?php endwhile; ?>
</table>
