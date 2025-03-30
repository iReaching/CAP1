<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if (in_array($action, ['approve', 'reject'])) {
        $stmt = $conn->prepare("UPDATE amenity_schedule SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $action, $id);
        $stmt->execute();
    }
}

header("Location: homepage.php");
exit();
?>
