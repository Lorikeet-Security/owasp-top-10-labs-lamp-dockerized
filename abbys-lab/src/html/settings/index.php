<?php

session_start();

$servername = "localhost";
$username = "php";
$password = "zYPw7wVH7c2S74vXpLviOjavdCnkuH";
$dbname = "ncis";

session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['search'])){
    $results = "<h1>No case files found matching your query!</h1>";
}

$sql = "SELECT uid FROM `users` WHERE `username` = '".$_SESSION['username']."'";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $uid = $row['uid'];
    }
}

if(isset($_POST['search'])){
    $results = "<p><br><br>No case files found matching your query!</p>";
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="../dashboard/css/spur.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    <script src="js/chart-js-config.js"></script>
    <title>Dashboard</title>
    <style>

        .box{
            width: 600px;
            margin: 0 auto;
            text-align: center;
            border : 1px solid black;
            border-radius: 5px;
            float: center;
            padding: 40px;
            height: 400px;
            margin-top: -40%;
        }

    </style>
</head>

<body>
    <div class="dash">
        <div class="dash-app">
            <header style='background-color: #e9edf4' class="dash-toolbar"><center><h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1></center>
                <div class="tools">
                    <div class="dropdown tools-item">
                            <a href = "/settings"><i class="fas fa-user"></i></a>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                            <a class="dropdown-item" href="#!">Profile</a>
                            <a class="dropdown-item" href="login.html">Logout</a>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    <center>
    <div class = "box">
<h1>Change Password</h1>
<form action = "/changepassword.php?uid=<?php echo $uid; ?>" method="post">
    <input type = "password" name = "password" placeholder = "Change Password" requried>
    <input type = "submit" name="submit" value = "Submit">
</form>
</div>
    </center>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/spur.js"></script>
</body>

</html>