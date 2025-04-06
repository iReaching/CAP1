<?php
session_start();
require 'db_connect.php';

// Role-based redirect
$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'guard') ? 'guard_homepage.php' : (($role === 'staff') ? 'staff_homepage.php' : 'homepage.php#entrylog');

// Upload helper function
function uploadIDPhoto($fileKey) {
    $uploadDir = 'uploads/id_photos/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $filename = uniqid("id_") . '_' . basename($_FILES[$fileKey]['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $targetPath)) {
            return $targetPath;
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $entry_type = $_POST['entry_type'];
    $vehicle_plate = $_POST['vehicle_plate'] ?? '';
    $reason = $_POST['reason'];
    $id_photo_path = uploadIDPhoto('id_photo'); // Get photo from form

    $stmt = $conn->prepare("
        INSERT INTO entry_log (name, entry_type, vehicle_plate, reason, id_photo_path, timestamp)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("sssss", $name, $entry_type, $vehicle_plate, $reason, $id_photo_path);

    if ($stmt->execute()) {
        header("Location: $redirectHome");
        exit();
    } else {
        echo "Error logging entry: " . $conn->error;
    }
}

if (isset($_FILES['id_photo'])) {
    if ($_FILES['id_photo']['error'] !== UPLOAD_ERR_OK) {
        echo "Upload error code: " . $_FILES['id_photo']['error'];
    }
}

?>
