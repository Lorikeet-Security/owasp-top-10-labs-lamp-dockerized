<?php
session_start();
$root_url = $_SERVER['HTTP_HOST'];
define("ROOT_URL", "http://" . $root_url . "/");
define('DB_HOST', 'splinter-db');
define('DB_USER', 'php');
define('DB_PASS', 'zYPw7wVH7c2S74vXpLviOjavdCnkuH');
define('DB_NAME', 'lab_db');
if (!isset($_SESSION['user-id'])) {
    header("location: " . ROOT_URL . "logout.php");
    //destroy all sessions and redirect user to login page
    session_destroy();
    die();
    header("location: " . ROOT_URL . "signin.php");
}
