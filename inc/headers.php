<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credential: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS,DELETE");
header("Access-Control-Allow-Headers: Content-type");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"]=== "OPTIONS") {
    return 0;
}