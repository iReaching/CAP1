<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? '';
    $role = $_SESSION['role'] ?? 'admin';
    $redirectHome = ($role === 'homeowner') ? 'homeowner_homepage.php#report' : (($role === 'staff') ? 'staff_homepage.php#report' : 'homepage.php#report');    
    $message = trim($_POST['report_message'] ?? '');
    $block = $_POST['block'] ?? '';
    $lot = $_POST['lot'] ?? '';
    $date_submitted = date('Y-m-d');

    if ($user_id && $message && $block && $lot) {
        $stmt = $conn->prepare("INSERT INTO maintenance_reports (user_id, message, block, lot, date_submitted, status) VALUES (?, ?, ?, ?, ?, 'ongoing')");
        $stmt->bind_param("sssss", $user_id, $message, $block, $lot, $date_submitted);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Report submitted successfully!";
        } else {
            $_SESSION['message'] = "Failed to submit report.";
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Please fill out all required fields.";
    }

    // Redirect based on role
    if ($role === 'homeowner') {
        header("Location: homeowner_homepage.php#report");
    } else {
        header("Location: $redirectHome");

    }
    exit;
}
?>
