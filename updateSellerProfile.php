<?php
include 'database.php';

// Get the username of the seller from the GET request
$username = $_GET['username'];

// Initialize the status message
$statusMsg = "";

if (isset($_POST['update_seller']) && $_POST['update_seller'] == 'Update') {
    // Extract the form input fields
    $new_name = $_POST['username'] ?? '';
    $new_email = $_POST['email'] ?? '';

    // Validate that required fields are not empty
    if (!empty($new_name) && !empty($new_email)) {
        // Prepare the update query
        $updateQuery = $conn->prepare("UPDATE seller SET username = ?, email = ? WHERE username = ?");
        $updateQuery->bind_param("sss", $new_name, $new_email, $username);

        if ($updateQuery->execute()) {
            $statusMsg = "Seller profile has been successfully updated. Redirecting to your profile...";
            header('refresh: 1; url=sellerProfile.php?username=' . urlencode($new_name));
        } else {
            $statusMsg = "Failed to update seller profile. Please try again.";
        }

        // Close the prepared statement
        $updateQuery->close();
    } else {
        $statusMsg = "All fields are required. Please fill in all the fields.";
    }
} else {
    $statusMsg = "Invalid request. Please submit the update form.";
}

// Display the status message
echo $statusMsg;
?>
