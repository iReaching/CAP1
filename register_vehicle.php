<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $name = $_POST['name'];
  $color = $_POST['color'];
  $type_of_vehicle = $_POST['type_of_vehicle'];
  $plate_number = $_POST['plate_number'] ?? '';
  $message = $_POST['message'];
  $block = $_POST['block'];
  $lot = $_POST['lot'];
  $time = $_POST['time'];
  $date = $_POST['date'];

  // Handle uploads
  function uploadFile($fileKey) {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
      $target = 'uploads/vehicles/' . basename($_FILES[$fileKey]['name']);
      move_uploaded_file($_FILES[$fileKey]['tmp_name'], $target);
      return $target;
    }
    return '';
  }

  $valid_id = uploadFile('valid_id');
  $vehicle_pic = uploadFile('vehicle_pic');
  $documents = uploadFile('documents');

  $stmt = $conn->prepare("INSERT INTO vehicle_registrations 
    (user_id, name, color, type_of_vehicle, plate_number, valid_id_path, vehicle_pic_path, documents_path, message, block, lot, time, date)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
  $stmt->bind_param("sssssssssssss", $user_id, $name, $color, $type_of_vehicle, $plate_number, $valid_id, $vehicle_pic, $documents, $message, $block, $lot, $time, $date);

  if ($stmt->execute()) {
    $_SESSION['toast_success'] = "Vehicle registered successfully.";
  } else {
    $_SESSION['toast_error'] = "Something went wrong. Try again.";
  }

  header("Location: homepage.php#account");
  exit();
}
?>
