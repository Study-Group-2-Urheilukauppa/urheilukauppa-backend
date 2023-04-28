<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$data = json_decode(file_get_contents("php://input"));
$userId = $data->userid;
$cart = $data->cart;

try {
    $dbcon = openDB();

    // Start transaction
    $dbcon->beginTransaction();

    // Insert client data
    $sql = "INSERT INTO Orders (clientid) VALUES (?)";
    $statement = $dbcon->prepare($sql);
    $statement->execute([$userId]);
    $clientid = $dbcon->lastInsertId();

    // Insert product data
    $sql = "INSERT INTO Orderrow (ordernum, rownum, productid, pcs) VALUES (?, ?, ?, ?)";
    $statement = $dbcon->prepare($sql);

    $rownum = 1; // Initialize rownum to 1

    foreach ($cart as $productid => $item) {
        $amount = $item->amount;

        $statement->execute([$clientid, $rownum, $productid, $amount]);

        $rownum++; // Increment rownum by 1
    }

    // Commit transaction
    $dbcon->commit();

    $response = array(
        "orderid" => $clientid,
        "success" => "Order placed successfully"
    );

    echo json_encode($response);

} catch(PDOException $pdoex) {
    // Rollback transaction
    $dbcon->rollback();

    returnError($pdoex);
}

