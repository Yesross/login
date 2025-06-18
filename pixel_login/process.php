<?php
include 'config/db.php';
session_start();//for getting username from login to upload table

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);

    // Validation patterns
    $namePattern = "/^[A-Za-z\s]+$/";
    $emailPattern = "/^[\w.]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/";
    $phonePattern = "/^\d{10}$/";
    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/";

    // Validate inputs
    if (!preg_match($namePattern, $name)) {
        die("Invalid name.");
    }
    if (!preg_match($emailPattern, $email)) {
        die("Invalid email.");
    }
    if (!preg_match($phonePattern, $phone)) {
        die("Invalid phone number.");
    }
    if (!preg_match($passwordPattern, $password)) {
        die("Password does not meet criteria.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO responsive (name, email, phone, password, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $hashedPassword, $address);

    if ($stmt->execute()) {
        $_SESSION['username'] = $name;//for getting username from login table to upload table once registration is successfull
        // Clear the output buffer to prevent any output before the header
        ob_start(); 
        header("Location: upload_page.php");
        ob_end_flush(); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();

?>
