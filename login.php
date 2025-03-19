<?php
session_start();
require 'db_connect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = trim($_POST["user_id"]);
    $password = trim($_POST["password"]);
    $role = isset($_POST["role"]) ? trim($_POST["role"]) : "";


    // Validate empty fields
    if (empty($userID) || empty($password)) {
        $_SESSION["login_error"] = "Please fill in all fields.";
        header("Location: login_homeowner.php");
        exit();
    }

    // Retrieve user record by user_id
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE user_id = ? AND role = ?");
    $stmt->bind_param("ss", $userID, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["login_success"] = "Welcome back, $userID!";
            // Redirect back to login_visitor.php to show modal
            header("Location: login_homeowner.php");
            exit();
        } else {
            $_SESSION["login_error"] = "Incorrect password.";
        }
    } else {
        $_SESSION["login_error"] = "User ID not found.";
    }
    
    header("Location: login_homeowner.php");
    exit();
}
?>
