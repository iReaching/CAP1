<?php
session_start();
require 'db_connect.php';

$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'homeowner') ? 'homeowner_homepage.php#amenities' : (($role === 'staff') ? 'staff_homepage.php#amenities' : 'homepage.php#amenities');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $homeowner_id = $_SESSION["user_id"];
    $house_id = trim($_POST["house_id"]);
    $date = trim($_POST["date"]);
    $message = trim($_POST["message"]);
    $amenity_id = trim($_POST["amenity_id"]);
    $start_time = trim($_POST["start_time"]);
    $end_time = trim($_POST["end_time"]);
    $status = 'pending';
    $user_id = $_SESSION["user_id"];

    // Basic validation
    if (empty($homeowner_id) || empty($house_id) || empty($date) || empty($message) || empty($amenity_id) || empty($start_time) || empty($end_time)) {
        $_SESSION["update_error"] = "All fields are required!";
        header("Location: $redirectHome");
        exit();
    }

    // Insert into amenity_schedule with amenity_id
    $stmt = $conn->prepare("INSERT INTO amenity_schedule (homeowner_id, house_id, request_date, message, amenity_id, time_start, time_end, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $homeowner_id, $house_id, $date, $message, $amenity_id, $start_time, $end_time, $status);


    if ($stmt->execute()) {
        $_SESSION["update_success"] = "Amenity request sent successfully!";
    } else {
        $_SESSION["update_error"] = "Something went wrong while submitting your request.";
    }

    header("Location: $redirectHome");
    exit();
} else {
    $_SESSION["update_error"] = "Invalid request.";
    header("Location: $redirectHome");
    exit();
}
