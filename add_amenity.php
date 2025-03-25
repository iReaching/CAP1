<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image = $_FILES['image'];

    // Validate input
    if (empty($name) || empty($description) || $image['error'] !== 0) {
        $_SESSION['update_error'] = "Please fill out all fields and upload a valid image.";
        header("Location: homepage.php#amenities");
        exit();
    }

    // Validate image
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_extensions)) {
        $_SESSION['update_error'] = "Invalid image format. Please upload JPG, PNG, or GIF.";
        header("Location: homepage.php#amenities");
        exit();
    }

    // Save image to /uploads/amenities/
    $filename = uniqid("amenity_") . "." . $ext;
    $destination = "uploads/amenities/" . $filename;

    if (!move_uploaded_file($image['tmp_name'], $destination)) {
        $_SESSION['update_error'] = "Failed to upload image.";
        header("Location: homepage.php#amenities");
        exit();
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO amenities (name, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $description, $destination);

    if ($stmt->execute()) {
        $_SESSION['update_success'] = "Amenity added successfully!";
    } else {
        $_SESSION['update_error'] = "Something went wrong while adding the amenity.";
    }

    header("Location: homepage.php#amenities");
    exit();
}
?>
