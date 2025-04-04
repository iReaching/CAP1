<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_id'])) {
    $report_id = $_POST['report_id'];

    $stmt = $conn->prepare("UPDATE maintenance_reports SET status = 'resolved' WHERE id = ?");
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Report marked as resolved.";
    } else {
        $_SESSION['message'] = "Failed to update report.";
    }

    $stmt->close();
}

header("Location: homepage.php#report");
exit;
