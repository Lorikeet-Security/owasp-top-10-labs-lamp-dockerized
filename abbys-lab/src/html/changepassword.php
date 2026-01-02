<?php

ini_set('display_errors', 1);//NOT FOR PRODUCTION
ini_set('display_startup_errors', 1);//NOT FOR PRODUCTION
ini_set('max_execution_time', 100); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)
error_reporting(E_ALL);//NOT FOR PRODUCTION

$servername = "localhost";
$username = "php";
$password = "zYPw7wVH7c2S74vXpLviOjavdCnkuH";
$dbname = "ncis";

session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['password'])){

    $sql = "UPDATE `users` SET `password` = '".$_POST['password']."' WHERE `uid` = ".$_GET['uid']."";
    $result = $conn->query($sql);

    echo "Password changed!";
    die();
}

?>