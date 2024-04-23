<?php
require_once '../includes/session.php';

if (!isAdminLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['event_id'];

    $stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: view-events.php');
    exit;
}

$eventId = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
$stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event - Classroom Reservation System</title>
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
            <h2>Delete Event</h2>
            <p>Are you sure you want to delete the event "<?php echo $event['title']; ?>"?</p>
            <form action="delete-event.php" method="post">
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                <button type="submit">Delete Event</button>
                <a href="view-events.php">Cancel</a>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>