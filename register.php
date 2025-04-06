<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = trim($_POST["user_id"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $role = trim($_POST["role"]); 

    $redirectPage = "register_{$role}.php"; // Dynamic redirect target

    // Step 1: Validation
    if (empty($user_id) || empty($email) || empty($password) || empty($role)) {
        $_SESSION["register_error"] = "All fields including role are required!";
        header("Location: $redirectPage");
        exit();
    }

    // Step 2: Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION["register_error"] = "Email already exists!";
        header("Location: $redirectPage");
        exit();
    }
    $stmt->close();

    // Step 3: Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Step 4: Insert into database with role
    $stmt = $conn->prepare("INSERT INTO users (user_id, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        $_SESSION["register_success"] = "Registration successful!";
    } else {
        $_SESSION["register_error"] = "Something went wrong. Try again.";
    }

    // After user registration is successful
    $defaultProfilePic = './images/profile.png';
    $stmt = $conn->prepare("INSERT INTO user_profiles (user_id, full_name, contact_number, profile_pic) VALUES (?, '', '', ?)");
    $stmt->bind_param("ss", $user_id, $defaultProfilePic);
    $stmt->execute();



    header("Location: $redirectPage");
    exit();
}
?>
