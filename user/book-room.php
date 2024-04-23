<?php
require_once '../includes/session.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $eventId = $_POST['event_id'];
    $roomId = $_POST['room_id'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    $stmt = $pdo->prepare("INSERT INTO pendingrequests (user_id, event_id, room_id, start_time, end_time) VALUES (:user_id, :event_id, :room_id, :start_time, :end_time)");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
    $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
    $stmt->bindParam(':start_time', $startTime, PDO::PARAM_STR);
    $stmt->bindParam(':end_time', $endTime, PDO::PARAM_STR);
    $stmt->execute();

    header('Location: home.php');
    exit;
}
