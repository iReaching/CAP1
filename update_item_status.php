<?php
session_start();
require 'db_connect.php';

$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'homeowner') ? 'homeowner_homepage.php' : (($role === 'staff') ? 'staff_homepage.php' : 'homepage.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $schedule_id = $_POST['schedule_id'] ?? null;
    $new_status = $_POST['status'] ?? null;

    if ($schedule_id && in_array($new_status, ['approved', 'rejected'])) {
        $stmt = $conn->prepare("UPDATE item_schedule SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $schedule_id);
        
        if ($stmt->execute()) {
            $_SESSION['update_success'] = "Status updated successfully.";
        } else {
            $_SESSION['update_error'] = "Failed to update status.";
        }
    } else {
        $_SESSION['update_error'] = "Invalid status or schedule ID.";
    }
} else {
    $_SESSION['update_error'] = "Invalid request method.";
}

header("Location: $redirectHome");

exit();
