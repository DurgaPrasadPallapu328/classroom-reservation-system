<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'session.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");

    // Bind the parameter
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    // Execute the statement
    if ($stmt->execute()) {
        // Fetch the user record
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, set the session and redirect to the user home page
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../user/home.php');
            exit;
        } else {
            // Invalid username or password
            $error = "Invalid username or password";
            echo $error;
        }
    } else {
        // Error executing the statement
        $error = "Error executing the query: " . $stmt->errorInfo()[2];
        echo "SQL Error: " . $error;
        exit;
    }
}
