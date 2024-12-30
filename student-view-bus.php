<?php
session_start();
include 'db.php'; // Include database connection

// Fetch all buses from the database
$sql = "SELECT BusId, BusNumber, Capacity, DriverName, ContactNumber, Route, Status, BusSchedule FROM buses WHERE Status = 'active' ORDER BY BusNumber;";
$result = $conn->query($sql);

// Check if the query succeeded
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Buses</title>
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
        <section class="view-buses">
            <div class="home-container">
                <div class="main-container">
                    <h1>Available Buses</h1>
                    
                    <?php if ($result->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Bus Number</th>
                                    <th>Capacity</th>
                                    <th>Driver Name</th>
                                    <th>Contact Number</th>
                                    <th>Route</th>
                                    <th>Status</th>
                                    <th>Bus Schedule</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($bus = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($bus['BusNumber']); ?></td>
                                        <td><?= htmlspecialchars($bus['Capacity']); ?></td>
                                        <td><?= htmlspecialchars($bus['DriverName']); ?></td>
                                        <td><?= htmlspecialchars($bus['ContactNumber']); ?></td>
                                        <td><?= htmlspecialchars($bus['Route']); ?></td>
                                        <td><?= htmlspecialchars($bus['Status']); ?></td>
                                        <td>
                                            <?php 
                                            // Handle the Bus Schedule display
                                            $busSchedule = $bus['BusSchedule'];

                                            if ($busSchedule) {
                                                // If BusSchedule is a DATETIME, format it
                                                echo date("F j, Y, g:i a", strtotime($busSchedule)); // Format: December 1, 2024, 3:30 pm
                                            } else {
                                                echo "No schedule set"; // If no schedule is set
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No buses found.</p>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    </main>
</body>
</html>
