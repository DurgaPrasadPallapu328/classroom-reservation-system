<?php
// Function to check if the user is logged in
function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    return false;
}

// Function to check if the admin is logged in
function isAdminLoggedIn()
{
    if (isset($_SESSION['admin_id'])) {
        return true;
    }
    return false;
}

// Function to get the user data
function getUserData($userId)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to get the admin data
function getAdminData($adminId)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE id = :id");
    $stmt->bindParam(':id', $adminId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}




//Function to send Email to the User
function sendEmail($to, $subject, $message)
{
    $headers = "From: Classroom Reservation System <noreply@example.com>" . "\r\n";
    $headers .= "Reply-To: noreply@example.com" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";

    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        error_log("Email could not be sent to: $to");
        return false;
    }
}
