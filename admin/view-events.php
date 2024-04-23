<?php
require_once '../includes/session.php';

if (!isAdminLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events - Classroom Reservation System</title>
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
            <h2>View Events</h2>
            <?php if (count($events) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event) : ?>
                            <tr>
                                <td><?php echo $event['title']; ?></td>
                                <td><?php echo $event['description']; ?></td>
                                <td><?php echo $event['start_date']; ?></td>
                                <td><?php echo $event['end_date']; ?></td>
                                <td>
                                    <a href="update-event.php?id=<?php echo $event['id']; ?>">Edit</a>
                                    <a href="delete-event.php?id=<?php echo $event['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No events found.</p>
            <?php endif; ?>
            <a href="add-event.php">Add Event</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>