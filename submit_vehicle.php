<?php
session_start();
require 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
  $_SESSION['update_error'] = "Unauthorized access.";
  header("Location: homepage.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'homeowner') ? 'homeowner_homepage.php#account' : (($role === 'staff') ? 'staff_homepage.php#account' : 'homepage.php#account');


// Sanitize inputs
$name = $_POST['name'] ?? '';
$color = $_POST['color'] ?? '';
$type_of_vehicle = $_POST['type_of_vehicle'] ?? '';
$plate_number = $_POST['plate_number'] ?? '';
$block = $_POST['block'] ?? '';
$lot = $_POST['lot'] ?? '';

// Handle file upload
function handleUpload($field, $upload_dir = 'uploads/') {
  if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
    $filename = uniqid() . '_' . basename($_FILES[$field]['name']);
    $target_path = $upload_dir . $filename;
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0777, true);
    }
    if (move_uploaded_file($_FILES[$field]['tmp_name'], $target_path)) {
      return $target_path;
    }
  }
  return null;
}

$vehicle_pic_path = handleUpload('vehicle_image');

// Insert into database
$stmt = $conn->prepare("
  INSERT INTO vehicle_registrations (
    user_id, name, color, type_of_vehicle, plate_number, vehicle_pic_path, block, lot
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
  "ssssssss",
  $user_id, $name, $color, $type_of_vehicle, $plate_number,
  $vehicle_pic_path, $block, $lot
);

if ($stmt->execute()) {
  $_SESSION['update_success'] = "Vehicle registered successfully!";
} else {
  $_SESSION['update_error'] = "Failed to register vehicle.";
}

$stmt->close();

// Redirect based on role
if ($role === 'homeowner') {
  header("Location: homeowner_homepage.php#account");
} else {
  header("Location: $redirectHome");

}
exit;
?>
