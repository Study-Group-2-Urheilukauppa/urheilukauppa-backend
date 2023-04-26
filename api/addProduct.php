<?php

require_once "inc/functions.php";
require_once "inc/headers.php";

$input = json_decode(file_get_contents("php://input"));
$productname = filter_var($input->productname, FILTER_SANITIZE_STRING);
$categoryid = filter_var($input->categoryid, FILTER_SANITIZE_STRING);
$price = filter_var($input->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$sale = isset($input->sale) ? filter_var($input->sale, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;
$imgURL = filter_var($input->imgURL, FILTER_SANITIZE_STRING);
$descript = filter_var($input->descript, FILTER_SANITIZE_STRING);
$fulldescript = filter_var($input->fulldescript, FILTER_SANITIZE_STRING);

try {
    $db = openDb();
    $query = $db->prepare("INSERT INTO Product(productname, categoryid, price, sale, imgURL, descript, fulldescript) VALUES
         (:productname, :categoryid, :price, :sale, :imgURL, :descript, :fulldescript)");
    $query->bindValue(":productname", $productname, PDO::PARAM_STR);
    $query->bindValue(":categoryid", $categoryid, PDO::PARAM_STR);
    $query->bindValue(":price", $price, PDO::PARAM_STR);
    $query->bindValue(":sale", $sale, PDO::PARAM_STR);
    $query->bindValue(":imgURL", $imgURL, PDO::PARAM_STR);
    $query->bindValue(":descript", $descript, PDO::PARAM_STR);
    $query->bindValue(":fulldescript", $fulldescript, PDO::PARAM_STR);
    $query->execute();

    header("HTTP/1.1 200 OK");
    $data = array("productid" => $db->lastInsertId(), "productname" => $productname, "categoryid" => $categoryid,
             "price" => $price, "sale" => $sale, "imgURL" => $imgURL, "descript" => $descript, "fulldescript" => $fulldescript);
    print json_encode($data);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}

