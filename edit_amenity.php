<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amenity_id = $_POST["amenity_id"] ?? '';
    $new_name = trim($_POST["new_name"] ?? '');
    $new_description = trim($_POST["new_description"] ?? '');
    $new_image_path = null;

    if (empty($amenity_id)) {
        $_SESSION['update_error'] = "Amenity ID is required.";
        header("Location: homepage.php");
        exit();
    }

    // Fetch current details
    $stmt = $conn->prepare("SELECT name, description, image FROM amenities WHERE id = ?");
    $stmt->bind_param("i", $amenity_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current = $result->fetch_assoc();
    $stmt->close();

    if (!$current) {
        $_SESSION['update_error'] = "Amenity not found.";
        header("Location: homepage.php");
        exit();
    }

    // Fallbacks if no input is provided
    $final_name = $new_name !== '' ? $new_name : $current['name'];
    $final_description = $new_description !== '' ? $new_description : $current['description'];
    $final_image = $current['image'];

    // Handle image upload if provided
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = time() . '_' . basename($_FILES['new_image']['name']);
        $target_path = $upload_dir . $file_name;

        $check = getimagesize($_FILES['new_image']['tmp_name']);
        if ($check !== false && move_uploaded_file($_FILES['new_image']['tmp_name'], $target_path)) {
            $final_image = $target_path;
        } else {
            $_SESSION['update_error'] = "Invalid image upload.";
            header("Location: homepage.php");
            exit();
        }
    }

    // Perform the update
    $stmt = $conn->prepare("UPDATE amenities SET name = ?, description = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssi", $final_name, $final_description, $final_image, $amenity_id);

    if ($stmt->execute()) {
        $_SESSION['update_success'] = "Amenity updated successfully.";
    } else {
        $_SESSION['update_error'] = "Failed to update amenity.";
    }

    header("Location: homepage.php#amenities");
    exit();
}
?>
