<?php
require_once '../includes/session.php';

if (!isAdminLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT pr.*, u.username, e.title, r.name 
                     FROM pendingrequests pr
                     JOIN users u ON pr.user_id = u.id
                     JOIN events e ON pr.event_id = e.id
                     JOIN rooms r ON pr.room_id = r.id");
$pendingRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <h2>Pending Room Reservation Requests</h2>
            <?php if (count($pendingRequests) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Event</th>
                            <th>Room</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingRequests as $request) : ?>
                            <tr>
                                <td><?php echo $request['username']; ?></td>
                                <td><?php echo $request['title']; ?></td>
                                <td><?php echo $request['name']; ?></td>
                                <td><?php echo $request['start_time']; ?></td>
                                <td><?php echo $request['end_time']; ?></td>
                                <td>
                                    <form action="approve-request.php" method="post" style="display: inline;">
                                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                        <button type="submit">Approve</button>
                                    </form>
                                    <form action="reject-request.php" method="post" style="display: inline;">
                                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                        <button type="submit">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No pending requests found.</p>
            <?php endif; ?>
        </section>
    </main>
    <!-- ... -->
</body>

</html>