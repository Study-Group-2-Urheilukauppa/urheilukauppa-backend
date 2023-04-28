<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$data = json_decode(file_get_contents("php://input"));
$userId = $data->userid;
$cart = $data->cart;

try {
    $dbcon = openDB();
  
    // Insert client data
    $sql = "INSERT INTO Orders (clientid) VALUES (?)";
    $statement = $dbcon->prepare($sql);
    $statement->execute([$userId]);
    $clientid = $dbcon->lastInsertId();
  
    // Insert product data
    $sql = "INSERT INTO Orderrow (ordernum, productid, pcs) VALUES (?, ?, ?)";
    $statement = $dbcon->prepare($sql);

    foreach ($cart as $productid => $item) {
        $amount = $item->amount;
        
        $statement->execute([$clientid, $productid, $amount]);
    }

    

    $response = array(
        "orderid" => $clientid,
        "message" => "Order placed successfully"
    );

    echo json_encode($response);
  
} catch(PDOException $pdoex) {
    returnError($pdoex);
}
