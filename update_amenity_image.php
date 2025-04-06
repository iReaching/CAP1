<?php
session_start();
require 'db_connect.php';

$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'homeowner') ? 'homeowner_homepage.php#amenities' : (($role === 'staff') ? 'staff_homepage.php#amenities' : 'homepage.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["new_image"])) {
    $amenity_id = $_POST["amenity_id"];
    $image = $_FILES["new_image"];

    if ($image["error"] === 0 && $image["size"] < 5 * 1024 * 1024) {
        $ext = pathinfo($image["name"], PATHINFO_EXTENSION);
        $filename = uniqid("amenity_") . "." . $ext;
        $path = "uploads/amenities/" . $filename;

        if (move_uploaded_file($image["tmp_name"], $path)) {
            $stmt = $conn->prepare("UPDATE amenities SET image = ? WHERE id = ?");
            $stmt->bind_param("si", $path, $amenity_id);
            $stmt->execute();
            $_SESSION["update_success"] = "Amenity image updated successfully!";
        } else {
            $_SESSION["update_error"] = "Failed to move uploaded file.";
        }
    } else {
        $_SESSION["update_error"] = "Invalid image or file too large.";
    }

    header("Location: $redirectHome");
    exit();
}
?>
