<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

// localhost:3000/products/getproduct.php/test1/test2/test3
$uri = parse_url(filter_input(INPUT_SERVER,'PATH_INFO'),PHP_URL_PATH);

$parameters = explode('/',$uri);
$product_id = $parameters[0];



try {
  $db = openDb();
  selectRowAsJson($db,"select * from product where productid = $product_id");
}
catch (PDOException $pdoex) {
  returnError($pdoex);
}