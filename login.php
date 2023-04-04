<?php
require_once './inc/functions.php';
require_once './inc/headers.php'; 

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the username and password from the request body
    $data = json_decode(file_get_contents("php://input"));
    $username = htmlspecialchars($data->username);
    $password = htmlspecialchars($data->password);

    // TODO: Validate the username and password here

    // For demonstration purposes, assume the login is successful if the username is "admin" and the password is "password"
    if ($username == 'asd' && $password == '123') {

        // Return a JSON response indicating success
        $response = array(
            'success' => true,
            'message' => 'Login successful'
        );
        echo json_encode($response);

    } else {

        // Return a JSON response indicating failure
        $response = array(
            'success' => false,
            'message' => 'Invalid username or password'
        );
        echo json_encode($response);

    }

} else {

    // Return a JSON response indicating failure
    $response = array(
        'success' => false,
        'message' => 'Invalid request method'
    );
    echo json_encode($response);

}
