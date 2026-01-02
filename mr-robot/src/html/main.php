<?php

session_start();

if($_SESSION['loggedIn'] == false)
{
    die("You're not logged in");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome Employee</title>
</head>
<body>
    <h1>Check Availability of ECORP Server</h1>
    <br>
    <form action="main.php" method="post">
        <input type="text" name="attack" placeholder="Enter IP">
        <input type="submit" value="Check">
    </form>
    <?php
        if(isset($_POST['attack']))
        {
            $attack = $_POST['attack'];
            $results = shell_exec("ping -c 1 $attack");
            echo "<br>";
            echo $results;
        }
    ?>
</body>
</html>

