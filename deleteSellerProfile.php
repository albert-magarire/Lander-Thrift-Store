<?php
include 'database.php';

// Get the username of the seller from the GET request
$username = $_GET['username'];

// Initialize the status message
$statusMsg = "";

if (isset($_POST['delete_seller']) && $_POST['delete_seller'] == 'Delete') {
    // Begin a transaction to ensure atomicity of operations
    $conn->begin_transaction();

    try {
        // Delete all items associated with the seller
        $deleteItems = $conn->query("DELETE FROM items WHERE seller = '$username'");
        
        if ($deleteItems) {
            // Delete the seller's profile from the seller table
            $deleteSeller = $conn->query("DELETE FROM seller WHERE username = '$username'");
            
            if ($deleteSeller) {
                // Commit the transaction
                $conn->commit();
                $statusMsg = "Seller profile and associated items have been successfully deleted. Redirecting to the home page...";
                header('refresh: 1; url=index.php');
            } else {
                throw new Exception("Failed to delete seller profile. Please try again.");
            }
        } else {
            throw new Exception("Failed to delete seller's items. Please try again.");
        }
    } catch (Exception $e) {
        // Roll back the transaction in case of any errors
        $conn->rollback();
        $statusMsg = $e->getMessage();
    }
} else {
    $statusMsg = "Invalid request. Please submit the delete form.";
}

// Display status message
echo $statusMsg;
?>
