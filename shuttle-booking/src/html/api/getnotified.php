<?php

require 'dbconnect.php'; 

// Retrieve the email from POST
$email = $_POST['email'];
$message = "You have successfully subscribed with: " . $email;

// Prepare the SQL statement to avoid SQL injection
$sql = "INSERT INTO messages (message) VALUES (?)";

// Initialize statement
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param('s', $message);

// Execute the statement
if ($stmt->execute()) {
    // Output a JavaScript block to store the message in localStorage and perform the redirect
    echo "<script>
        localStorage.setItem('subscriptionMessage', '$message');
    </script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

header("Location: /booking/");

?>

