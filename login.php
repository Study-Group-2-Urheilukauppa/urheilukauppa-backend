<?php
require_once './inc/functions.php';
require_once './inc/headers.php'; 
$data = json_decode(file_get_contents("php://input"));
    $username = htmlspecialchars($data->username);
    $password = htmlspecialchars(password_hash($data->password, PASSWORD_DEFAULT));
    
$dbcon = openDB();
try {
    $dbcon;
} catch (PDOException $pdoex) {
    returnError($pdoex);
}

// Prepare and execute the SQL statement to retrieve user credentials
$stmt = $dbcon->prepare("SELECT * FROM Login WHERE username=:username LIMIT 1");
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if a user was found with the provided username
if ($user !== false) {
    // Verify the password using the PHP password_verify function
    if (password_verify($password, $user['password'])) {
        // Return a success response
        $response = [
            'success' => true
        ];
    } else {
        // Return an error response
        $response = [
            'success' => false,
            'message' => 'Invalid password'
        ];
    }
} else {
    // Return an error response
    $response = [
        'success' => false,
        'message' => 'Invalid username'
    ];
}

// Close the database connection
$conn = null;

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
