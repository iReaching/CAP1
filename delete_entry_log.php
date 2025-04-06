<?php
session_start();
require 'db_connect.php';

$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'guard') ? 'guard_homepage.php' : (($role === 'staff') ? 'staff_homepage.php' : 'homepage.php#entrylog');


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['log_id'])) {
    $log_id = $_POST['log_id'];

    $stmt = $conn->prepare("DELETE FROM entry_log WHERE id = ?");
    $stmt->bind_param("i", $log_id);

    if ($stmt->execute()) {
        $_SESSION['entry_log_deleted'] = "Entry log deleted successfully.";
    } else {
        $_SESSION['entry_log_deleted'] = "Failed to delete log.";
    }
}

header("Location: $redirectHome");
exit();
?>
