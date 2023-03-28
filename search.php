<?php
require_once "inc/functions.php";
require_once "inc/headers.php";

$searchTerm = $_GET['q']; // Assuming the search term is passed as a query parameter

try{
// Connect to your database
$dbcon = openDB();

// Prepare the SQL query
$sql = "SELECT * FROM product WHERE productname LIKE :searchTerm";

// Bind the search term to the query
$statement = $dbcon->prepare($sql);
$statement->bindValue(':searchTerm', '%'.$searchTerm.'%');

// Execute the query
$statement->execute();

// Fetch the results
$results = $statement->fetchAll(PDO::FETCH_ASSOC);
header('HTTP/1.1 200 OK');
echo json_encode($results);

} catch (PDOException $pdoex) {
    returnError($pdoex);
}