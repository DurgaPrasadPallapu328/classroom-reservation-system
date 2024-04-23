<?php
require_once '../includes/session.php';

// Check if the user is logged in
if (!isLoggedIn()) {
    header('Location: ../index.php');
    exit;
}

// Get the user data
$userData = getUserData($_SESSION['user_id']);

// Get the list of rooms and events for the form
$stmt = $pdo->query("SELECT * FROM rooms");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the user's bookings
$stmt = $pdo->prepare("SELECT rr.*, e.title, r.name
                       FROM roomregistration rr
                       JOIN events e ON rr.event_id = e.id
                       JOIN rooms r ON rr.room_id = r.id
                       WHERE rr.user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the upcoming events
$stmt = $pdo->query("SELECT e.* 
                     FROM events e
                     JOIN upcomingevents ue ON e.id = ue.event_id");
$upcomingEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home - Classroom Reservation System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>Classroom Reservation System</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Welcome, <?php echo $userData['username']; ?>!</h2>

            <h3>Book a Room</h3>
            <form action="book-room.php" method="post">
                <label for="event">Event:</label>
                <select id="event" name="event_id" required>
                    <option value="">Select an event</option>
                    <?php foreach ($events as $event) : ?>
                        <option value="<?php echo $event['id']; ?>"><?php echo $event['title']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="room">Room:</label>
                <select id="room" name="room_id" required>
                    <option value="">Select a room</option>
                    <?php foreach ($rooms as $room) : ?>
                        <option value="<?php echo $room['id']; ?>"><?php echo $room['name']; ?> (Capacity: <?php echo $room['capacity']; ?>)</option>
                    <?php endforeach; ?>
                </select>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="start-time">Start Time:</label>
                <input type="time" id="start-time" name="start_time" required>

                <label for="end-time">End Time:</label>
                <input type="time" id="end-time" name="end_time" required>

                <button type="submit">Book Room</button>
            </form>

            <h3>Your Bookings</h3>
            <?php if (count($bookings) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking) : ?>
                            <tr>
                                <td><?php echo $booking['title']; ?></td>
                                <td><?php echo $booking['name']; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($booking['start_time'])); ?></td>
                                <td><?php echo date('h:i A', strtotime($booking['start_time'])); ?></td>
                                <td><?php echo date('h:i A', strtotime($booking['end_time'])); ?></td>
                                <td>
                                    <form action="cancel-booking.php" method="post">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                        <button type="submit">Cancel</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>You have no bookings.</p>
            <?php endif; ?>

            <h3>Upcoming Events</h3>
            <?php if (count($upcomingEvents) > 0) : ?>
                <ul>
                    <?php foreach ($upcomingEvents as $event) : ?>
                        <li>
                            <h4><?php echo $event['title']; ?></h4>
                            <p><?php echo $event['description']; ?></p>
                            <p>Start Date: <?php echo $event['start_date']; ?></p>
                            <p>End Date: <?php echo $event['end_date']; ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No upcoming events.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>