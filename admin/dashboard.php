<?php
require_once '../includes/session.php';

// Check if the admin is logged in
if (!isAdminLoggedIn()) {
    header('Location: ../index.php');
    exit;
}

// Get the admin data
$adminData = getAdminData($_SESSION['admin_id']);

// Get the count of pending requests
$stmt = $pdo->query("SELECT COUNT(*) FROM pendingrequests");
$pendingRequestsCount = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Classroom Reservation System</title>
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
            <h2>Admin Dashboard</h2>
            <p>Welcome, <?php echo $adminData['username']; ?>!</p>

            <h3>Events</h3>
            <ul>
                <li><a href="view-events.php">View Events</a></li>
                <li><a href="add-event.php">Add Event</a></li>
            </ul>

            <h3>Rooms</h3>
            <ul>
                <li><a href="view-rooms.php">View Rooms</a></li>
                <li><a href="add-room.php">Add Room</a></li>
            </ul>

            <h3>Requests</h3>
            <ul>
                <li><a href="pending-requests.php">Pending Requests (<?php echo $pendingRequestsCount; ?>)</a></li>
                <li><a href="approved-requests.php">Approved Requests</a></li>
                <li><a href="rejected-requests.php">Rejected Requests</a></li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>