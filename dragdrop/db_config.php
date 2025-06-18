<?php
$servername = "localhost";
$username = "root@localhost"; // Change if needed
$password = ""; // Change if needed
$dbname = "resume_analyzer";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
