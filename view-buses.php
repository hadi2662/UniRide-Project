<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Handle delete request
if (isset($_GET['delete'])) {
    $busId = $_GET['delete'];
    $deleteSql = "DELETE FROM buses WHERE BusId = '$busId'";
    
    if ($conn->query($deleteSql)) {
        $_SESSION['message'] = "Bus deleted successfully!";
        header("Location: view-buses.php"); // Redirect to the same page after deleting
        exit;
    } else {
        $_SESSION['message'] = "Error deleting bus: " . $conn->error;
    }
}

// Fetch all buses from the database
$sql = "SELECT BusId, BusNumber, Capacity, DriverName, ContactNumber, Route, Status, BusSchedule FROM buses ORDER BY BusNumber";
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
                    <h1>All Buses</h1>
                    
                    <?php if (isset($_SESSION['message'])): ?>
                        <p class="message"><?= $_SESSION['message']; ?></p>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>
                    
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
                                    <th>Bus Schedule</th> <!-- Added Bus Schedule column -->
                                    <th>Actions</th>
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
                                        <td>
                                            <!-- Edit Link -->
                                            <a href="edit-bus.php?busId=<?= urlencode($bus['BusId']); ?>">Edit</a> | 
                                            <!-- Delete Link -->
                                            <a href="view-buses.php?delete=<?= urlencode($bus['BusId']); ?>" 
                                            onclick="return confirm('Are you sure you want to delete this bus?');">Delete</a>
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
