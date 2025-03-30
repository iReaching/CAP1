<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['update_error'] = "Unauthorized access.";
    header("Location: homepage.php");
    exit();
}

$userID = $_SESSION['user_id'];
$defaultPic = './images/profile.png';

// Only update the profile picture field
$stmt = $conn->prepare("UPDATE user_profiles SET profile_pic = ? WHERE user_id = ?");
$stmt->bind_param("ss", $defaultPic, $userID);

if ($stmt->execute()) {
    $_SESSION['update_success'] = "Profile picture removed successfully.";
} else {
    $_SESSION['update_error'] = "Failed to remove profile picture.";
}

header("Location: homepage.php");
exit();
?>
