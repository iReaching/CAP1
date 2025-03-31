<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $available = $_POST['available'];
    $image = $_FILES['image']['name'];

    // Handle image upload if provided
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    // Prepare SQL to update item
    $sql = "UPDATE items SET name = ?, description = ?, available = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $name, $description, $available, $image, $item_id);

    if ($stmt->execute()) {
        header("Location: homepage.php");  // Redirect to homepage after updating
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
