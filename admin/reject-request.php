<?php
require_once '../includes/session.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = $_POST['request_id'];

    $stmt = $pdo->prepare("SELECT pr.*, u.email 
                           FROM pendingrequests pr
                           JOIN users u ON pr.user_id = u.id
                           WHERE pr.id = :id");
    $stmt->bindParam(':id', $requestId, PDO::PARAM_INT);
    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($request) {
        $userId = $request['user_id'];
        $eventId = $request['event_id'];
        $roomId = $request['room_id'];
        $startTime = $request['start_time'];
        $endTime = $request['end_time'];

        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $userEmail = $stmt->fetchColumn();

        $stmt = $pdo->prepare("INSERT INTO rejectedroomrequests (user_id, event_id, room_id, start_time, end_time) VALUES (:user_id, :event_id, :room_id, :start_time, :end_time)");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $stmt->bindParam(':start_time', $startTime, PDO::PARAM_STR);
        $stmt->bindParam(':end_time', $endTime, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM pendingrequests WHERE id = :id");
        $stmt->bindParam(':id', $requestId, PDO::PARAM_INT);
        $stmt->execute();

        // Send email to the user
        $subject = "Room Reservation Rejected";
        $message = "Dear user,<br><br>Your room reservation request has been rejected by the admin.<br><br>Reservation Details:<br>Event ID: $eventId<br>Room ID: $roomId<br>Start Time: $startTime<br>End Time: $endTime<br><br>Thank you.";
        sendEmail($userEmail, $subject, $message);

        if ($emailSent) {
            echo "Email sent successfully to $userEmail";
        } else {
            echo "Failed to send email to $userEmail";
        }
    }

    header('Location: pending-requests.php');
    exit;
}
