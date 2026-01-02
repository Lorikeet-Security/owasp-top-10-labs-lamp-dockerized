<?php
session_start();
$root_url = $_SERVER['HTTP_HOST'];
define("ROOT_URL", "http://" . $root_url . "/");
define('DB_HOST', 'db');
define('DB_USER', 'underemployed');
define('DB_PASS', 'admin1234');
define('DB_NAME', 'blog');
if (!isset($_SESSION['user-id'])) {
    header("location: " . ROOT_URL . "logout.php");
    //destroy all sessions and redirect user to login page
    session_destroy();
    die();
    header("location: " . ROOT_URL . "signin.php");
}
