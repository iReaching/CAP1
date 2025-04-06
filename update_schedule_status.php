<?php
session_start();
require 'db_connect.php';

$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'homeowner') ? 'homeowner_homepage.php' : (($role === 'staff') ? 'staff_homepage.php' : 'homepage.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['action'])) {
        $id = $_POST['id'];
        $action = $_POST['action'];

        // Check if the action is either 'approve' or 'reject'
        if ($action == 'approve') {
            $status = 'approved'; // Change to 'approved'
        } elseif ($action == 'reject') {
            $status = 'rejected'; // Change to 'rejected'
        } else {
            $status = 'pending'; // Default to 'pending'
        }

        // Prepare SQL statement
        $stmt = $conn->prepare("UPDATE amenity_schedule SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['message'] = "Status updated successfully.";
        } else {
            $_SESSION['message'] = "Failed to update status.";
        }
    }
}

header("Location: $redirectReport");

exit();
?>
