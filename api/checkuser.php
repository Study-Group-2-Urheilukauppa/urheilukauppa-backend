<?php
require_once "inc/functions.php";
require_once "inc/headers.php";


    $token = $_COOKIE['token'];
    $token = filter_input(INPUT_COOKIE, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    

try {
    $db = openDb();

    $statement = $db->prepare("SELECT id FROM Login WHERE token = :token");
    $statement->bindParam(':token', $token);
    $statement->execute();
    $id = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $db->prepare("SELECT role FROM Login WHERE token = :token");
    $statement->bindParam(':token', $token);
    $statement->execute();
    $role = $statement->fetch(PDO::FETCH_ASSOC);

    $response = array(
        "userid" => $id['id'],
        "role" => $role['role']
    );

    echo json_encode($response);
    
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
