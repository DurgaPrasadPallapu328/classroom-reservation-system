<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'session.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");

    // Bind the parameter
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    // Execute the statement
    if ($stmt->execute()) {
        // Fetch the admin record
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($admin && password_verify($password, $admin['password'])) {
            // Password is correct, set the session and redirect to the dashboard
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: ../admin/dashboard.php');
            exit;
        } else {
            // Invalid username or password
            $error = "Invalid admin username or password";
            echo $error;
        }
    } else {
        // Error executing the statement
        $error = "Error executing the query: " . $stmt->errorInfo()[2];
        echo "SQL Error: " . $error;
        exit;
    }
}
