<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $homeowner_id = $_SESSION['user_id'] ?? '';
    $item_id = $_POST['item_id'] ?? '';
    $message = $_POST['message'] ?? '';
    $request_date = $_POST['request_date'] ?? '';
    $time_start = $_POST['time_start'] ?? '';
    $time_end = $_POST['time_end'] ?? '';

    if (!$homeowner_id || !$item_id || !$request_date || !$time_start || !$time_end) {
        $_SESSION['message'] = "Missing required fields.";
        header("Location: homeowner_homepage.php#schedule-section");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO item_schedule (homeowner_id, item_id, message, request_date, time_start, time_end) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $homeowner_id, $item_id, $message, $request_date, $time_start, $time_end);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Item scheduled successfully!";
    } else {
        $_SESSION['message'] = "Failed to schedule item. Please try again.";
    }

    header("Location: homeowner_homepage.php#schedule-section");
    exit();
}
?>
