<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Item deleted successfully.";
    } else {
        echo "Error deleting item: " . $conn->error; //retrun error if database connection error occurs
    }
    $stmt->close();
    $conn->close();
}else{
    echo "Nothing Happened";
}
?>
