<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product data from the request body
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Extract the product ID and amount from the data
    $product_id = $data['productid'];
    $new_amount = $data['amount'];

    try {
        // Open the database connection
        $db = openDb();
        
        // Prepare the SQL query to update the product amount
        $stmt = $db->prepare("UPDATE Product SET amount = :amount WHERE productid = :productid");
        $stmt->bindValue(':amount', $new_amount, PDO::PARAM_INT);
        $stmt->bindValue(':productid', $product_id, PDO::PARAM_INT);
        
        // Execute the query
        $stmt->execute();
        
        // Return a success response
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        echo json_encode(array('message' => 'Product amount updated successfully'));

    } catch (PDOException $pdoex) {
        // Return an error response
        returnError($pdoex);
    }
} else {
    // If the request method is not POST, return the list of products
    try {
        $db = openDb();
        $sql = "SELECT Product.productid, Product.productname, Product.price, Product.sale, Product.categoryid, Product.amount, Category.categoryname FROM Product INNER JOIN Category ON Product.categoryid=Category.categoryid;";
        $query = $db->query($sql);
        $results = $query->fetchALL(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        print json_encode($results);
    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }
}