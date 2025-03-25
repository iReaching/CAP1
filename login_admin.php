<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = trim($_POST["user_id"]);
    $password = trim($_POST["password"]);

    if (empty($userID) || empty($password)) {
        $_SESSION["login_error"] = "Please fill in all fields.";
        header("Location: l_admin.php");
        exit();
    }

    // Only fetch users with both admin role and is_admin flag
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE user_id = ? AND is_admin = 1 AND role = 'admin'");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["login_success"] = "Welcome back, Admin!";
            header("Location: l_admin.php");
            exit();
        } else {
            $_SESSION["login_error"] = "Incorrect password.";
        }
    } else {
        $_SESSION["login_error"] = "Admin account not found.";
    }

    header("Location: l_admin.php");
    exit();
}
?>
