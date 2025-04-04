<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? '';
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
}

header("Location: homepage.php#report");
exit;
