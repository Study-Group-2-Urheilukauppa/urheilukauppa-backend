<?php
require_once "inc/functions.php";
require_once "inc/headers.php";


    $token = $_COOKIE['token'];
    $token = filter_input(INPUT_COOKIE, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    

try {
    $db = openDb();
    $statement = $db->prepare("SELECT role FROM Login WHERE token = :token");
    $statement->bindParam(':token', $token);
    $statement->execute();

    $response = $statement->fetch(PDO::FETCH_ASSOC);
    echo json_encode($response);
    
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
