<?php
session_start();
require 'db_connect.php';

$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'homeowner') ? 'homeowner_homepage.php#report' : (($role === 'staff') ? 'staff_homepage.php#report' : 'homepage.php#report');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_id'])) {
    $report_id = $_POST['report_id'];

    $stmt = $conn->prepare("UPDATE maintenance_reports SET status = 'resolved' WHERE id = ?");
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        $_SESSION['report_message'] = "Report marked as resolved.";
    } else {
        $_SESSION['report_message'] = "Failed to update report.";
    }

    $stmt->close();
}

header("Location: $redirectHome");

exit;
