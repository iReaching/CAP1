<?php
session_start();
require 'db_connect.php';

// 🔐 Protect the route properly
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login_homeowner.php"); // fallback login page
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing profile
$stmt = $conn->prepare("SELECT full_name, contact_number, profile_pic FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$existing = $result->fetch_assoc();

// Fallback to existing data
$full_name = !empty(trim($_POST['full_name'])) ? trim($_POST['full_name']) : $existing['full_name'];
$contact = !empty(trim($_POST['contact_number'])) ? trim($_POST['contact_number']) : $existing['contact_number'];
$profile_pic = $existing['profile_pic'];

// Handle profile picture upload
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $file_name = time() . '_' . basename($_FILES['profile_pic']['name']);
    $target_path = $upload_dir . $file_name;

    $check = getimagesize($_FILES['profile_pic']['tmp_name']);
    if ($check !== false && move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_path)) {
        $profile_pic = $target_path;
    }
}

// Update the user_profiles table
$stmt = $conn->prepare("UPDATE user_profiles SET full_name = ?, contact_number = ?, profile_pic = ? WHERE user_id = ?");
$stmt->bind_param("ssss", $full_name, $contact, $profile_pic, $user_id);

if ($stmt->execute()) {
    $_SESSION["update_success"] = "Profile updated!";
    $_SESSION["profile_pic"] = $profile_pic;
} else {
    $_SESSION["update_error"] = "Failed to update profile.";
}

// ✅ Redirect based on role
switch ($_SESSION['role']) {
    case 'admin':
        header("Location: homepage.php");
        break;
    case 'staff':
        header("Location: staff_homepage.php");
        break;
    default:
        header("Location: homeowner_homepage.php");
}
exit();
?>
