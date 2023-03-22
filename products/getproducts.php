<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
print_r($url);
$path = parse_url($url, PHP_URL_PATH);
$parts = explode('/', $path);
$category_id = $parts[count($parts)-1];

try {
  $db = openDb();
  $sql = "select * from category where categoryid = $category_id";
  $query = $db->query($sql);
  $category = $query->fetch(PDO::FETCH_ASSOC);

  $sql = "select * from product where categoryid = $category_id";
  $query = $db->query($sql);
  $products = $query->fetchAll(PDO::FETCH_ASSOC);

  header('HTTP/1.1 200 OK');
  echo json_encode(array(
    "category" => $category['categoryname'],
    "products" => $products
  ));
}
catch (PDOException $pdoex) {
  returnError($pdoex);
}