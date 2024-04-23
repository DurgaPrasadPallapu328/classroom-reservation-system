<?php
require_once '../includes/session.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT r.*, e.title, rm.name
                       FROM roomregistration r
                       JOIN events e ON r.event_id = e.id
                       JOIN rooms rm ON r.room_id = rm.id
                       WHERE r.user_id = :user_id");
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings - Classroom Reservation System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>Classroom Reservation System</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Your Bookings</h2>
            <?php if (count($bookings) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Room</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking) : ?>
                            <tr>
                                <td><?php echo $booking['title']; ?></td>
                                <td><?php echo $booking['name']; ?></td>
                                <td><?php echo date('h:i A', strtotime($booking['start_time'])); ?></td>
                                <td><?php echo date('h:i A', strtotime($booking['end_time'])); ?></td>
                                <td><?php echo $booking['status']; ?></td>
                                <td>
                                    <?php if ($booking['status'] === 'pending') : ?>
                                        <form action="cancel-booking.php" method="post" style="display: inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                            <button type="submit">Cancel</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>You don't have any bookings yet.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>