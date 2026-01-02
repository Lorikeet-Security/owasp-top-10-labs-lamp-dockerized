<?php

$servername = 'localhost'; 
$dbusername = 'dev';
$dbpassword = 'bob123$';
$dbname = "shuttle";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("We are experiencing issues with database connection right now. Please notify the administrators ASAP. Error: " . $conn->connect_error);
}