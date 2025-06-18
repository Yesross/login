<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    if (file_exists($file)) {
        header("Content-Disposition: attachment; filename=" . basename($file));
        readfile($file);
        exit;
    } else {
        echo "File not found.";
    }
}
?>
