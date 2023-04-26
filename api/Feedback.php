<?php

require_once "inc/functions.php";
require_once "inc/headers.php";
// Get the form data from the request body
$data = json_decode(file_get_contents('php://input'));

// Validate the form data
if (!isset($data->name) || !isset($data->email) || !isset($data->feedback)) {
  header('HTTP/1.1 400 Bad Request');
  $error = array('error' => 'Missing required form data.');
  echo json_encode($error);
  exit;
}

$name = filter_var($data->name, FILTER_SANITIZE_STRING);
$email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
$text = filter_var($data->feedback, FILTER_SANITIZE_STRING);

try {
  $db = openDB();

  // Prepare the SQL query to insert the feedback data into the database
  $sql = "INSERT INTO Feedback (name, email, text) VALUES ('$name', '$email', '$text')";
  $id = executeInsert($db, $sql);

  header('Content-Type: application/json');
  echo json_encode(['success' => true, 'id' => $id]);

} catch (PDOException $pdoex) {
  returnError($pdoex);
}