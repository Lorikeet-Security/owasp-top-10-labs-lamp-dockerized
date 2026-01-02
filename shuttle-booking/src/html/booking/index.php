<?php

require '../api/dbconnect.php';

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="http://shuttlebooking.pctfs/core/framework/libs/pj/css/pj.bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="http://shuttlebooking.pctfs/index.php?controller=pjFrontEnd&action=pjActionLoadCss" type="text/css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="h1 text-center mt-5">
                    Shuttle Booking
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div id="message"></div>

                <!-- 
                    // dev note by by admin@shuttlebooking.pctfs 
                    // enable debugging by appending ?debug=true to your url
                -->

                <?php

                    if(isset($_GET['debug']) && $_GET['debug'] == 'true'){ 
                        $sql = "SELECT * FROM messages"; 
                        $result = $conn->query($sql); 

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $messages = $row['message']; 

                                echo "prevous messages" . $messages; 
                            }
                        } 
                    }else{
                        echo " <script>
                            // Retrieve the message from localStorage and inject it into the page
                            const message = localStorage.getItem('subscriptionMessage');
                            if (message) {
                                document.getElementById('message').innerHTML = message;
                            }
                        </script>";
                    }
                ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col d-flex justify-content-center">
                <form action="/api/getnotified.php" method="post">
                    <label for="sub">Enter your email to get notified when a new shuttle is available</label>
                    <input type="text" class="form-control" name="email" id="sub" placeholder="Enter Email" required style="width:700px;">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mt-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-10">
                <script type="text/javascript" src="http://shuttlebooking.pctfs/index.php?controller=pjFrontEnd&action=pjActionLoad"></script>
            </div>
        </div>
    </div>
</body>
</html>