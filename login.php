<?php

require_once "inc/functions.php";
require_once 'inc/headers.php';
// Get the login data from the POST request
$username = $_POST['username'];
$password = $_POST['password'];
$hashedPw = password_hash($password, PASSWORD_DEFAULT);


$db = openDB();
$command = 'SELECT * FROM adminlogin WHERE username = :? AND pw = :?';
$stmt = $db->prepare($command);
$stmt->execute(array($username, $hashedPw));

if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // The credentials are valid, set the response status to success
    $response = array('success' => true, $username => $row['username'], $hashedPw => $row['pw']);
    echo json_encode($response);
} else {
    // The credentials are invalid, set the response status to failure and provide an error message
    $response = array('success' => false, 'message' => 'Invalid username or password');
    echo json_encode($response);
}


