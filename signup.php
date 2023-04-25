<?php
require_once './inc/functions.php';
require_once './inc/headers.php'; 

// Get user data from frontend
$data = json_decode(file_get_contents("php://input"));
$firstname = $data->firstname;
$lastname = $data->lastname;
$postal = $data->postal;
$address = $data->address;
$phone = $data->phone;
$username = htmlspecialchars($data->username);
$password = htmlspecialchars(password_hash($data->password, PASSWORD_DEFAULT));

try {
  $dbcon = openDB();

  // Insert client data
  $sql = "INSERT INTO Client (Firstname, Lastname, Postalcode, Clientaddress, Phonenumber) VALUES (?, ?, ?, ?, ?)";
  $statement = $dbcon->prepare($sql);
  $statement->execute([$firstname, $lastname, $postal, $address, $phone]);
  $clientid = $dbcon->lastInsertId();

  // Insert login data
  $sql = "INSERT INTO Login (clientid, Username, Pw) VALUES (?, ?, ?)";
  $statement = $dbcon->prepare($sql);
  $statement->execute([$clientid, $username, $password]);

} catch(PDOException $pdoex) {
  returnError($pdoex);
}
