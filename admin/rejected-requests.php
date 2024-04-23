<?php
require_once '../includes/session.php';

// Check if the admin is logged in
if (!isAdminLoggedIn()) {
    header('Location: ../index.php');
    exit;
}

// Get the rejected requests
$stmt = $pdo->query("SELECT rr.*, u.username, e.title, r.name 
                     FROM rejectedroomrequests rr
                     JOIN users u ON rr.user_id = u.id
                     JOIN events e ON rr.event_id = e.id
                     JOIN rooms r ON rr.room_id = r.id");
$rejectedRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected Requests - Classroom Reservation System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>Classroom Reservation System</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Rejected Requests</h2>
            <?php if (count($rejectedRequests) > 0) : ?>
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
                        <?php foreach ($rejectedRequests as $request) : ?>
                            <tr>
                                <td><?php echo $request['username']; ?></td>
                                <td><?php echo $request['title']; ?></td>
                                <td><?php echo $request['name']; ?></td>
                                <td><?php echo $request['start_time']; ?></td>
                                <td><?php echo $request['end_time']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No rejected requests found.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>