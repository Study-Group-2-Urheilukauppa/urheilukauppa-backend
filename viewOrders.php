<?php

require_once './inc/functions.php';
require_once './inc/headers.php';

try {
  $db = openDb();
  selectAsJson($db,'select * from Orders,Orderrow where Orders.ordernum = Orderrow.ordernum');
}
catch (PDOException $pdoex) {
  returnError($pdoex);
}