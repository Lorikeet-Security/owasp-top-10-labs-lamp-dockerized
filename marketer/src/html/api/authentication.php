<?php

require 'db.php';

session_start();


if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
    header('Location: /login.php');
    exit();
}



$sessionID = session_id();
$sql = "SELECT * FROM users WHERE sessionID = '$sessionID'";
$result = $conn->query($sql);
if($result->num_rows == 0){
    header('Location: /login.php');
    exit();
}



?>

