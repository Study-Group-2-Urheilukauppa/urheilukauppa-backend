<?php

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
    $sql = "INSERT INTO Orderrow (orderid, productid, amount) VALUES (?, ?, ?)";
    $statement = $dbcon->prepare($sql);
    
    foreach ($cart as $item) {
        $productid = $item->productid;
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
