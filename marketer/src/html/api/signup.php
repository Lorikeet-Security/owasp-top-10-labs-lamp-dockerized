<?php

require 'db.php';

// grab the data from the form
$email = $_POST['email'];
$pass = $_POST['password'];


// filter email and pass
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$pass = filter_var($pass, FILTER_SANITIZE_STRING);

// check if email is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: /login.php?msg=Invalid email format");
    exit();
}

// check if email is valid
if (strlen($pass) < 8) {
    header("Location: /login.php?msg=Password must be at least 8 characters long");
    exit();
}

// create new user but check if that user exists first
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    header("Location: /login.php?msg=User already exists");
    exit();
}

// hash the password in sha256
$pass = hash('sha512', $pass);

// insert the user into the database
$sql = "INSERT INTO users (email, password, sessionID) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $email, $pass, session_id());
$stmt->execute();

header("Location: /login.php?msg=Signup successful");


?>