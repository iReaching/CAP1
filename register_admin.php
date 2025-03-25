<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = trim($_POST["user_id"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // ✅ Force values for admin
    $is_admin = 1;
    $role = "admin";

    if (empty($user_id) || empty($email) || empty($password)) {
        $_SESSION["register_error"] = "All fields are required!";
        header("Location: r_admin.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION["register_error"] = "Email already exists!";
        header("Location: r_admin.php");
        exit();
    }
    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Insert with hardcoded role
    $stmt = $conn->prepare("INSERT INTO users (user_id, email, password, is_admin, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $user_id, $email, $hashed_password, $is_admin, $role);

    if ($stmt->execute()) {
        $_SESSION["register_success"] = "Admin registration successful!";
    } else {
        $_SESSION["register_error"] = "Something went wrong. Try again.";
    }

    header("Location: r_admin.php");
    exit();
}
?>
