<?php
    require_once './inc/functions.php';
    require_once './inc/headers.php'; 
    

    // Get user data from frontend
    $data = json_decode(file_get_contents("php://input"));
    $username = htmlspecialchars($data->username);
    $password = htmlspecialchars(password_hash($data->password, PASSWORD_DEFAULT));

    try{
    $dbcon = openDB();
    $sql = "INSERT INTO Login (Username, Pw) VALUES (?, ?)";

    // Insert user data into database
    $statement = $dbcon->prepare($sql);
    $statement->execute([$username, $password]);
    }catch(PDOException $pdoex){
      returnError($pdoex);
    }