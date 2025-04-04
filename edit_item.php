<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $new_available = isset($_POST['available']) ? (int)$_POST['available'] : null;

    // Fetch existing item data
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if ($item) {
        // Keep existing values for name, image, and description
        $name = $item['name'];
        $description = $item['description'];
        $image = $item['image'];
        $borrowed = $item['borrowed'];

        // Update available with new one
        $stmt = $conn->prepare("UPDATE items SET name=?, description=?, image=?, available=?, borrowed=? WHERE id=?");
        $stmt->bind_param("sssiii", $name, $description, $image, $new_available, $borrowed, $item_id);

        if ($stmt->execute()) {
            $_SESSION['update_success'] = "Item updated successfully!";
        } else {
            $_SESSION['update_error'] = "Failed to update item.";
        }
    } else {
        $_SESSION['update_error'] = "Item not found.";
    }
} else {
    $_SESSION['update_error'] = "Invalid request.";
}

header("Location: homepage.php#items-section");
exit();

?>
