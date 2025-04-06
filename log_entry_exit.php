<?php
session_start();
require 'db_connect.php';

$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'guard') ? 'guard_homepage.php' : (($role === 'staff') ? 'staff_homepage.php' : 'homepage.php#entrylog');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $entry_type = $_POST['entry_type'];
    $vehicle_plate = $_POST['vehicle_plate'] ?? '';
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO entry_log (name, entry_type, vehicle_plate, reason, timestamp) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $name, $entry_type, $vehicle_plate, $reason);
    
    if ($stmt->execute()) {
        header("Location: $redirectHome");
        exit();
    } else {
        echo "Error logging entry.";
    }
}
?>
