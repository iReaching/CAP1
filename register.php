<?php
session_start();
require 'db_connect.php'; // Ensure this matches your actual database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1: Collect and sanitize input
    $user_id  = trim($_POST["user_id"]);
    $email    = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Step 2: Basic validation
    if (empty($user_id) || empty($email) || empty($password)) {
        $_SESSION["register_error"] = "All fields are required.";
        header("Location: register_homeowner.php");
        exit();
    }

    // Step 3: Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION["register_error"] = "This email is already registered.";
        header("Location: register_homeowner.php");
        exit();
    }

    $check_stmt->close();

    // Step 4: Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Step 5: Insert into DB
    $insert_stmt = $conn->prepare("INSERT INTO users (user_id, email, password) VALUES (?, ?, ?)");
    $insert_stmt->bind_param("sss", $user_id, $email, $hashed_password);

    if ($insert_stmt->execute()) {
        $_SESSION["register_success"] = "Registration successful!";
    } else {
        $_SESSION["register_error"] = "Registration failed. Please try again.";
    }

    header("Location: register_homeowner.php");
    exit();
}
?>
