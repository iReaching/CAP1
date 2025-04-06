<?php
require 'db_connect.php';  // Include your database connection

$role = $_SESSION['role'] ?? 'admin';
$redirectHome = ($role === 'homeowner') ? 'homeowner_homepage.php#items-section' : (($role === 'staff') ? 'staff_homepage.php#items-section' : 'homepage.php#items-section');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $available = $_POST['available'];
    $image = $_FILES['image']['name'];

    // Specify the target directory for the uploaded image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert item into the database
        $sql = "INSERT INTO items (name, description, available, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $name, $description, $available, $image);

        if ($stmt->execute()) {
            header("Location: $redirectHome");  // Redirect back to homepage after success
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error uploading image.";
    }
}
?>
