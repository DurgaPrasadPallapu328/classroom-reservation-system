<?php
require_once '../includes/session.php';

if (!isAdminLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT rr.*, u.username, e.title, r.name 
                     FROM rejectedroomrequests rr
                     JOIN users u ON rr.user_id = u.id
                     JOIN events e ON rr.event_id = e.id
                     JOIN rooms r ON rr.room_id = r.id");
$rejectedReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... -->
</head>

<body>
    <!-- ... -->
    <main>
        <section>
            <h2>Rejected Room Reservations</h2>
            <?php if (count($rejectedReservations) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Event</th>
                            <th>Room</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rejectedReservations as $reservation) : ?>
                            <tr>
                                <td><?php echo $reservation['username']; ?></td>
                                <td><?php echo $reservation['title']; ?></td>
                                <td><?php echo $reservation['name']; ?></td>
                                <td><?php echo $reservation['start_time']; ?></td>
                                <td><?php echo $reservation['end_time']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No rejected reservations found.</p>
            <?php endif; ?>
        </section>
    </main>
    <!-- ... -->
</body>

</html>