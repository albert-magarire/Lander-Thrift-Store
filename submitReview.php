<?php
include 'database.php'; // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the seller's username from the URL
    $username = $_GET['username'] ?? null;

    // Validate if username is provided
    if (!$username) {
        die("Seller username is required.");
    }

    // Get the form data
    $review = $_POST['review'];
    $stars = $_POST['stars'] ?? null;

    // Validate that all fields are filled
    if (empty($review) || empty($stars)) {
        die("All fields are required. Please fill out the review and rating.");
    }

    // Prepare an SQL query to insert the review into the database
    $stmt = $conn->prepare("INSERT INTO reviews (seller, stars, review) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $username, $stars, $review);

    // Execute the query
    if ($stmt->execute()) {
        echo "Thank you! Your review has been submitted successfully.";
    } else {
        echo "Error: Unable to submit your review. Please try again.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request. Please submit the review form.";
}
?>
