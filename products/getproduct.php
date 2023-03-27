<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

// localhost:3000/products/getproduct.php/1001
$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$path = parse_url($url, PHP_URL_PATH);
$parts = explode('/', $path);
$product_id = $parts[count($parts)-1];

try {
    $db = openDb();
    $sql = "select * from Product where productid = $product_id";
    $query = $db->query($sql);
    $results = $query->fetchALL(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    print json_encode($results);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
