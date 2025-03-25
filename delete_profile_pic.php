<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_homeowner.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get current profile pic path
$stmt = $conn->prepare("SELECT profile_pic FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row && !empty($row['profile_pic']) && file_exists($row['profile_pic'])) {
    unlink($row['profile_pic']); // delete file from disk
}

// Remove from DB
$stmt = $conn->prepare("UPDATE user_profiles SET profile_pic = NULL WHERE user_id = ?");
$stmt->bind_param("s", $user_id);

if ($stmt->execute()) {
    $_SESSION["update_success"] = "Profile picture removed!";
    unset($_SESSION['profile_pic']);
} else {
    $_SESSION["update_error"] = "Failed to remove profile picture.";
}

header("Location: homepage.php");
exit();
