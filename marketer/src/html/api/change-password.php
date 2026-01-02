<?php

// web debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php';

// Check if the POST variables are set
if (isset($_POST['newpassword']) && isset($_POST['confirmpassword'])) {
    $new_password = $_POST['newpassword'];
    $confirm_password = $_POST['confirmpassword'];

    // Filter input
    $new_password = filter_var($new_password, FILTER_SANITIZE_STRING);
    $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        header("Location: /dashboard/settings.php?msg=Passwords do not match");
        exit();
    }

    // Hash the new password
    $new_password = hash('sha512', $new_password);
    $session_id = session_id();


    // Update the password in the database
    $sql = "UPDATE users SET password = ? WHERE sessionID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $session_id = session_id(); // Store session_id() in a variable
        $stmt->bind_param('ss', $new_password, $session_id);
        $stmt->execute();
        $stmt->close();

        $cmd = "echo 'Password changed successfully' >> /var/log/change-password.log";
        $cmd = base64_encode($cmd);
    
        header("Location: /api/create-log.php?cmd=change-password&actions=$cmd");
    } else {
        header("Location: /dashboard/settings.php?msg=Error preparing statement");
    }

} else {
    header("Location: /dashboard/settings.php?msg=Invalid input");
}

?>
