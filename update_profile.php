<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_homeowner.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = trim($_POST['full_name']);
$contact = trim($_POST['contact_number']);
$profile_pic = null;

// Check if a file was uploaded
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $file_name = time() . '_' . basename($_FILES['profile_pic']['name']);
    $target_path = $upload_dir . $file_name;

    // Make sure it's an image
    $check = getimagesize($_FILES['profile_pic']['tmp_name']);
    if ($check !== false) {
        // Move the file
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_path)) {
            $profile_pic = $target_path;
        }
    }
}

// Build the SQL query
if ($profile_pic) {
    $stmt = $conn->prepare("UPDATE user_profiles SET full_name = ?, contact_number = ?, profile_pic = ? WHERE user_id = ?");
    $stmt->bind_param("ssss", $full_name, $contact, $profile_pic, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE user_profiles SET full_name = ?, contact_number = ? WHERE user_id = ?");
    $stmt->bind_param("sss", $full_name, $contact, $user_id);
}

if ($stmt->execute()) {
    $_SESSION["update_success"] = "Profile updated!";
    $_SESSION["profile_pic"] = $profile_pic; // Optional for immediate reload
} else {
    $_SESSION["update_error"] = "Failed to update profile.";
}

header("Location: homepage.php");
exit();
