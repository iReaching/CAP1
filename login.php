<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = trim($_POST["user_id"]);
    $password = trim($_POST["password"]);
    $role = trim($_POST["role"]);

    if (empty($userID) || empty($password) || empty($role)) {
        $_SESSION["login_error"] = "All fields are required.";
        header("Location: login_{$role}.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE user_id = ? AND role = ?");
    $stmt->bind_param("ss", $userID, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["role"] = $role;
                $_SESSION["login_success"] = "Welcome back, $userID!";
            
                // Redirect by role
                switch ($role) {
                    case "admin":
                        header("Location: homepage.php");
                        break;
                    case "staff":
                        header("Location: staff_homepage.php");
                        break;
                    case "homeowner":
                        header("Location: homeowner_homepage.php");
                        break;
                    case "guard":
                        header("Location: guard_homepage.php");
                        break;
                    default:
                        $_SESSION["login_error"] = "Unknown role!";
                        header("Location: login_{$role}.php");
                        break;
                }                
                exit();
            }
            
        } else {
            $_SESSION["login_error"] = "Incorrect password.";
        }
    } else {
        $_SESSION["login_error"] = "User not found or role mismatch.";
    }

    header("Location: login_{$role}.php");
    exit();
?>
