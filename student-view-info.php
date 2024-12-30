<?php
session_start();
include 'db.php'; // Include database connection

// Check if the student is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

// Retrieve student information from the database
$username = $_SESSION['username']; // Assuming username is unique for each student
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
} else {
    die("Student information not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
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
        <!-- Student Information Section -->
        <section class="student-info">
            <div class="home-container">
                <div class="main-container">
                    <h1>Your Information</h1>
                    <div class="student-info-container">
                        <div class="info-left">
                            <p><strong>University ID:</strong> <?= htmlspecialchars($student['UniId']); ?></p>
                            <p><strong>Username:</strong> <?= htmlspecialchars($student['username']); ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($student['email']); ?></p>
                        </div>
                        <div class="info-right">
                            <p><strong>Contact Number:</strong> <?= htmlspecialchars($student['contact_number']); ?></p>
                            <p><strong>User Role:</strong> <?= htmlspecialchars($student['role']); ?></p>
                            <p><strong>Address:</strong> <?= htmlspecialchars($student['Address']); ?></p>
                        </div>
                    </div>

                    <div class="edit-info-container">
                        <a href="edit-student-info.php" class="std-edit-info-btn">Edit Info</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

