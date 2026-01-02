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


// check if the credentials are correct 
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows == 0) {
    header("Location: /login.php?msg=User does not exist");
    exit();
}

$user = $result->fetch_assoc();


// check if the password is correct in sha256
$pass = hash('sha512', $pass);

if($user['password'] != $pass){
    header("Location: /login.php?msg=Incorrect password");
    exit();
}

// set the session loggedin=true
session_start();
$_SESSION['loggedin'] = true;

// update the sessionID in the database
$sql = "UPDATE users SET sessionID = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', session_id(), $email);
$stmt->execute();


header("Location: /dashboard/");


?>