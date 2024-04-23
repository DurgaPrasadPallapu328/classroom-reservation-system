<?php
require_once '../includes/session.php';

if (!isAdminLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];

    $stmt = $pdo->prepare("INSERT INTO rooms (name, capacity) VALUES (:name, :capacity)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':capacity', $capacity, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: view-rooms.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room - Classroom Reservation System</title>
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
            <h2>Add Room</h2>
            <form action="add-room.php" method="post">
                <label for="name">Room Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="capacity">Capacity:</label>
                <input type="number" id="capacity" name="capacity" required>

                <button type="submit">Add Room</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>