<?php
$host = "localhost";
$user = "root@localhost"; 
$pass = "";
$dbname = "exercise";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
