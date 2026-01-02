<?php

$server = "localhost";
$user = "webadmin";
$pass = "emailserver123$";
$db = "marketer";

$conn = new mysqli($server, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>