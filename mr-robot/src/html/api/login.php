<?php

session_start();

ini_set('display_errors', 1);//NOT FOR PRODUCTION
ini_set('display_startup_errors', 1);//NOT FOR PRODUCTION
ini_set('max_execution_time', 100); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)
error_reporting(E_ALL);//NOT FOR PRODUCTION


$servername = "localhost";
$dbusername = "newuser";
$dbpassword = "hdgjsdhgjsdhgjsdhgjsdhgljsdhgljsd";
$dbname = "ourdatabase";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
  die("EVILCORP could not connect you to the database. Error: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username='" . $_POST["username"] . "' AND password='" . $_POST["password"] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $_SESSION['loggedIn'] = true;
    header("Location: /main.php");
  }
} else {
    $_SESSION['loggedIn'] = false;
    die("EVILCORP could not find your username or password. Please try again.");
}

?>

