<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Reservation System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <h1>Classroom Reservation System</h1>
        <nav>
            <ul>
                <li><a href="#" id="admin-login-link">Admin Login</a></li>
                <li><a href="#" id="user-login-link">User Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Welcome to the Classroom Reservation System</h2>
            <p>This system allows users to reserve classrooms for their events. Admins can manage events, rooms, and user reservations.</p>
        </section>

        <div id="admin-login-form" style="display: none;">
            <h2>Admin Login</h2>
            <form action="includes/admin-login.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
            <p><a href="admin/admin-registration.php">Register as New Admin</a></p>
        </div>

        <div id="user-login-form" style="display: none;">
            <h2>User Login</h2>
            <form action="includes/user-login.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="user-password">Password:</label>
                <input type="password" id="user-password" name="password" required>

                <button type="submit">Login</button>
            </form>
            <p><a href="user/user-registration.php">Register as New User</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Classroom Reservation System</p>
    </footer>

    <script src="assets/js/script.js"></script>
    <script>
        document.getElementById('admin-login-link').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('admin-login-form').style.display = 'block';
            document.getElementById('user-login-form').style.display = 'none';
        });

        document.getElementById('user-login-link').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('admin-login-form').style.display = 'none';
            document.getElementById('user-login-form').style.display = 'block';
        });
    </script>
</body>

</html>