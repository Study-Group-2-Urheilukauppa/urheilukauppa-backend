<?php

// This is only example from another practice
require_once "inc/functions.php";
require_once "inc/headers.php";

$input = json_decode(file_get_contents("php://input"));
$categoryname = filter_var($input->categoryname,FILTER_SANITIZE_STRING);

try {
    $db = openDb();
    $query = $db->prepare("insert into category(categoryname) values (:categoryname)");
    $query->bindValue(":categoryname", $categoryname,PDO::PARAM_STR);
    $query->execute();

    header("HTTP/1.1 200 OK");
    $data = array("categoryid" => $db->lastInsertId(),"categoryname" => $categoryname);
    print json_encode($data);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}