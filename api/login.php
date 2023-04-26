<?php

require_once './inc/functions.php';
require_once './inc/headers.php';

// Check if the request method is POST


    // Get the username and password from the request body
    $data = json_decode(file_get_contents("php://input"));
    $username = htmlspecialchars($data->username);
    $password = htmlspecialchars($data->password);

    // Validate the username and password against the database
    try {
        $dbcon = openDB();

        $statement = $dbcon->prepare("SELECT Username, Pw, Role FROM Login WHERE BINARY Username = :username");
        $statement->bindParam(':username', $username);
        $statement->execute();

        if ($statement->rowCount() == 1) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $hash = $row['Pw'];
            if (password_verify($password, $hash)) {
                // Return a JSON response indicating success
                $token = bin2hex(random_bytes(16));

            // Store the token in the database
            $statement = $dbcon->prepare("UPDATE Login SET Token = :token WHERE BINARY Username = :username");
            $statement->bindParam(':token', $token);
            $statement->bindParam(':username', $username);
            $statement->execute();

            // Return a JSON response with the token and user role
            $response = array(
                'success' => true,
                'message' => 'Login successful',
                'role' => $row['Role'],
                'token' => $token
            );
            echo json_encode($response);
            }
        } else {
            // Return a JSON response indicating failure
            $response = array(
                'success' => false,
                'message' => 'Invalid username or password'
            );
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        // Return a JSON response indicating failure
        $response = array(
            'success' => false,
            'message' => 'Database connection error: ' . $e->getMessage()
        );
        echo json_encode($response);
    }


