<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
                    <ul>
                        <li><a href="student.php">Dashboard</a></li>
                        <li><a href="student-view-info.php">My Information</a></li>
                        <li><a href="student-view-bus.php">Busses</a></li>
                        <li><a href="student-book-ticket.php">Book Tickets</a></li>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                    </nav>
                </div>
                <div class="call-container">
                    <div class="call">
                        <div class="call-icon">
                            <img src="images/call-icon.svg" alt="Call Icon">
                        </div>
                        <div class="call-content">
                            <h2>CALL CENTER</h2>
                            <p><a href="tel:(+654) 8654 6543">(+654) 8654 6543</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <main>
        <section class="add-bus">
            <div class="home-container">
                <div class="main-container">
                    <h1>Welcome, Student <span style="text-transform: capitalize;"><?= $_SESSION['username'] ?></span></h1>
                    <p>View your bus routes and schedules here.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
