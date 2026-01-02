<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // Ensure you have a database connection in db.php
require 'authentication.php'; // Ensure you have authentication in authentication.php

$sql = "SELECT * FROM users WHERE sessionID = ?";
$stmt = $conn->prepare($sql);
$session_id = session_id();
$stmt->bind_param('s', $session_id);

$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$user_id = $user['id'];

// Check if a file has been uploaded
if(isset($_FILES['file'])) {
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('csv', 'txt', 'json');

    if(in_array($fileActualExt, $allowed)) {
        if($fileError === 0) {
            if($fileSize < 100000000) { // Check file size
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = '/var/www/html/dashboard/uploads/' . $fileNameNew;
                if(move_uploaded_file($fileTmpName, $fileDestination)) {
                    // File successfully uploaded

                    // Process the uploaded file
                    if ($fileActualExt == 'csv') {
                        processCSV($fileDestination);
                    } elseif ($fileActualExt == 'txt') {
                        processTXT($fileDestination);
                    } elseif ($fileActualExt == 'json') {
                        processJSON($fileDestination);
                    }

                    header("Location: index.php?uploadsuccess");
                } else {
                    echo "There was an error moving your file!";
                }
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
} else {
    echo "No file uploaded!";
}

/**
 * Process CSV file and insert email addresses into the database
 */
function processCSV($file) {
    global $conn;

    if (($handle = fopen($file, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $email = $data[0];
            insertEmail($email);
        }
        fclose($handle);
    }
}

/**
 * Process TXT file and insert email addresses into the database
 */
function processTXT($file) {
    global $conn;

    $contents = file_get_contents($file);
    $lines = explode(PHP_EOL, $contents);
    foreach ($lines as $line) {
        $email = trim($line);
        insertEmail($email);
    }
}

/**
 * Process JSON file and insert email addresses into the database
 */
function processJSON($file) {
    global $conn;

    $contents = file_get_contents($file);
    $data = json_decode($contents, true);
    foreach ($data as $item) {
        $email = $item; // Assuming the JSON file contains an array of emails
        insertEmail($email);
    }
}

/**
 * Insert email into the database
 */
function insertEmail($email) {
    global $conn;

    $sql = "INSERT INTO email_lists (email, $user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('ss', $email, $user_id);

    if ($stmt->execute() === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

header("Location: /dashboard/msg=Upload successful");

?>
