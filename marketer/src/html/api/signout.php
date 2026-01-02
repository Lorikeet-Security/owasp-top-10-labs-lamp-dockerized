<?php

// unset the session loggedin=true
session_start();

if (isset($_SESSION['loggedin'])) {
    unset($_SESSION['loggedin']);
}

// set the session loggedin=false
if(!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}


header('Location: /login.php');