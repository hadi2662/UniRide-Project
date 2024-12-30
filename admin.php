<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navigation">
        <div class="hero-column">
            <div class="nav-container">
                <div class="site-logo">
                    <ul>
                        <li><a href="index.php"><img src="images/sitelogo.svg" alt="SMIU UniRide Logo"></a></li>
                    </ul>
                </div>
                <div class="navbar">
                    <nav>
                    <nav>
                    <ul>
                        <li><a href="admin.php">Dashboard</a></li>
                        <li><a href="user-role.php">User Role</a></li>
                        <li><a href="view-user.php">View & Edit User</a></li>
                        <li><a href="add-bus.php">Add Bus</a></li>
                        <li><a href="view-buses.php">View & Edit Bus</a></li>
                        <li><a href="view-ticket.php">View Ticket</a></li>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                    </nav>
                </div>
                
            </div>
        </div>
    </div>

    <main>
        <section class="add-bus">
            <div class="home-container">
                <div class="main-container">
                    <h1>Welcome, Admin <span style="text-transform: capitalize;"><?= $_SESSION['username'] ?></span></h1>
                    <p>Manage bus routes and schedules here.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
