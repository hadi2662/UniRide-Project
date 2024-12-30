<?php
session_start();
include 'db.php'; // Include the database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $busNumber = $_POST['busNumber'];
    $capacity = $_POST['capacity'];
    $driverName = $_POST['driverName'];
    $contactNumber = $_POST['contactNumber'];
    $route = $_POST['route'];
    $status = $_POST['status'];
    $busSchedule = $_POST['bus_schedule'];

    // Check if busSchedule is empty, if so, set it to NULL
    if (empty($busSchedule)) {
        $busSchedule = NULL;
    } else {
        // Convert the datetime to the correct format for MySQL
        $busSchedule = date('Y-m-d H:i:s', strtotime($busSchedule));
    }

    // Insert bus details into the database
    $sql = "INSERT INTO buses (BusNumber, Capacity, DriverName, ContactNumber, Route, Status, BusSchedule) 
            VALUES ('$busNumber', '$capacity', '$driverName', '$contactNumber', '$route', '$status', " . 
            ($busSchedule ? "'$busSchedule'" : "NULL") . ")";

    if ($conn->query($sql)) {
        $message = 'Bus details added successfully!';
    } else {
        $message = 'Error: ' . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bus</title>
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
                    <h1>Add Bus Details</h1>
                    
                    <?php if ($message): ?>
                        <p class="message"><?= htmlspecialchars($message); ?></p>
                    <?php endif; ?>

                    <form class="edit-user-form" action="add-bus.php" method="POST">
                        <label for="busNumber">Bus Number:</label>
                        <input class="edit-user-input" type="text" name="busNumber" id="busNumber" placeholder="Enter bus number" required>

                        <label for="capacity">Capacity:</label>
                        <input class="edit-user-input" type="number" name="capacity" id="capacity" placeholder="Enter capacity" required>

                        <label for="driverName">Driver Name:</label>
                        <input class="edit-user-input" type="text" name="driverName" id="driverName" placeholder="Enter driver's name" required>

                        <label for="contactNumber">Driver's Contact Number:</label>
                        <input class="edit-user-input" type="text" name="contactNumber" id="contactNumber" placeholder="Enter contact number">

                        <label for="route">Route:</label>
                        <input class="edit-user-input" type="text" name="route" id="route" placeholder="Enter route" required>

                        <label for="bus_schedule">Bus Schedule:</label>
                        <input class="edit-user-input" type="datetime-local" name="bus_schedule" id="bus_schedule" placeholder="Enter bus schedule">

                        <label for="status">Status:</label>
                        <select class="edit-user-input-select" name="status" id="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <button type="submit">Add Bus</button>
                    </form>

                </div>
            </div>
        </section>
    </main>
</body>
</html>
