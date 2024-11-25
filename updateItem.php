<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "UPDATE items SET size = ?, price = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $size, $price, $description, $id);

    if ($stmt->execute()) {
        echo "Item updated successfully.";
    } else {
        echo "Error updating item: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}
?>
