<?php

require '../api/db.php';
require '../api/authentication.php';

$sql = "SELECT * FROM users WHERE sessionID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', session_id());

$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$user_id = $user['id'];

?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Marketer</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo.png" alt="">
        <h1 class="sitename">Marketer</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/api/signout.php">Signout</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted flex-md-shrink-0" href="settings.php">Settings</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section class="mt-5">
      <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h2> Welcome to the Marketer Mailer Dashboard </h2>
                <p> Here you can send emails to your subscribers. </p>
            </div>
        </div>
        <style> 
            .custom-bg{
                background-color: #3f52ee; !important;
            }

            h4{
                color: white;
            }
        </style>
        <div class="card">
            <div class="card-body custom-bg">
                <div class="row mt-4 text-white">
                    <div class="col-sm-5">
                        <h4> Upload your email list </h4>
                        <form action="/api/upload.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload your email list</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                            <button type="submit" class="btn btn-dark">Upload</button>
                        </form>

                        <h4 class="mt-4">Your email lists</h4>
                        <ul>
                            <?php

                                $sql = "SELECT * FROM email_lists WHERE users = ?";
                                $stmt = $conn->prepare($sql);

                                $stmt->bind_param('s', $user_id);
                                $stmt->execute();

                                $result = $stmt->get_result();

                                while($row = $result->fetch_assoc()){
                                    echo "<li>".$row['list_name']."</li>";
                                }

                            ?>
                        </ul>
                    </div>
                    <div class="col-sm-5">
                        <h4> Send an email </h4>
                        <form action="/api/send.php" method="post">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject">
                            </div>
                            <div class="mb-3">
                                <label for="emaillist" class="form-label">Email List</label>
                                <select class="form-select" id="emaillist" name="emaillist">
                                    <option selected>Select an email list</option>
                                    <?php

                                        $sql = "SELECT * FROM email_lists WHERE users = ?";
                                        $stmt = $conn->prepare($sql);

                                        $stmt->bind_param('s', $user_id);
                                        $stmt->execute();

                                        $result = $stmt->get_result();

                                        while($row = $result->fetch_assoc()){
                                            echo "<option value='".$row['list_name']."'>".$row['list_name']."</option>";
                                        }

                                        if($result->num_rows == 0){
                                            echo "<option value=''>No email lists found</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>

    </section><!-- /Hero Section -->
</main>
</body>
</html>