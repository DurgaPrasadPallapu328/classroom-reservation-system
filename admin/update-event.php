<?php
require_once '../includes/session.php';

if (!isAdminLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['event_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $stmt = $pdo->prepare("UPDATE events SET title = :title, description = :description, start_date = :start_date, end_date = :end_date WHERE id = :id");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
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
    <title>Update Event - Classroom Reservation System</title>
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
            <h2>Update Event</h2>
            <form action="update-event.php" method="post">
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo $event['title']; ?>" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description"><?php echo $event['description']; ?></textarea>

                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo $event['start_date']; ?>" required>

                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo $event['end_date']; ?>" required>

                <button type="submit">Update Event</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>