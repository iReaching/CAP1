<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $name = $_POST['name'];
    $reason = $_POST['reason'];
    $vehicle_plate = $_POST['vehicle_plate'] ?? '';
    $expected = isset($_POST['expected']) ? 1 : 0;
    $expected_time = $_POST['expected_time'] ?? null;
    $requested_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        INSERT INTO entry_log (name, entry_type, vehicle_plate, reason, expected, expected_time, requested_by, timestamp)
        VALUES (?, 'Entry', ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("sssiss", $name, $vehicle_plate, $reason, $expected, $expected_time, $requested_by);

    if ($stmt->execute()) {
        $_SESSION['update_success'] = "Entry log request submitted!";
    } else {
        $_SESSION['update_error'] = "Something went wrong while submitting.";
    }

    header("Location: homeowner_homepage.php#entry-request");
    exit();
}
?>
