<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $entry_type = $_POST['entry_type'];
    $vehicle_plate = $_POST['vehicle_plate'] ?? '';
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO entry_log (name, entry_type, vehicle_plate, reason, timestamp) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $name, $entry_type, $vehicle_plate, $reason);
    
    if ($stmt->execute()) {
        header("Location: homepage.php#entrylog");
        exit();
    } else {
        echo "Error logging entry.";
    }
}
?>
