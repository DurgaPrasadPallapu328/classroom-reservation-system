<?php
require_once '../includes/session.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['booking_id'];

    $stmt = $pdo->prepare("DELETE FROM roomregistration WHERE id = :id");
    $stmt->bindParam(':id', $bookingId, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: view-bookings.php');
    exit;
}
