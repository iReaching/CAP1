<?php
session_start();
include "db_connect.php"; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use "user_id" in place of full name
    $user_id = trim($_POST["user_id"]);
    $email   = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Validate empty fields
    if (empty($user_id) || empty($email) || empty($password)) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: login_visitor.php");
        exit();
    }

    // Check if email is already registered
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION["error"] = "Email already registered!";
        header("Location: login_visitor.php");
        exit();
    }
    $check_stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $conn->prepare("INSERT INTO users (user_id, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user_id, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION["register_success"] = "Registration successful! You can now log in.";
        header("Location: login_visitor.php");
        exit();
    } else {
        $_SESSION["error"] = "Registration failed. Please try again.";
        header("Location: login_visitor.php");
        exit();
    }
}
?>
