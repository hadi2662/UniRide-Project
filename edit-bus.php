<?php
session_start();
include 'db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Check if the BusId parameter is set in the URL
if (!isset($_GET['busId'])) {
    header('Location: view-buses.php');
    exit;
}

$busId = $_GET['busId'];

// Fetch the bus details from the database
$sql = "SELECT * FROM buses WHERE BusId = '$busId'";
$result = $conn->query($sql);

// Check if the bus exists
if ($result->num_rows !== 1) {
    die("Bus not found.");
}

$bus = $result->fetch_assoc();

// Update bus details if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $busNumber = $_POST['bus_number'];
    $capacity = $_POST['capacity'];
    $driverName = $_POST['driver_name'];
    $contactNumber = $_POST['contact_number'];
    $route = $_POST['route'];
    $status = $_POST['status'];
    $busSchedule = $_POST['bus_schedule'];  // New Bus Schedule field

    // Check if busSchedule is empty, if so, set it to NULL
    if (empty($busSchedule)) {
        $busSchedule = NULL;
    } else {
        // Convert the datetime to the correct format for MySQL
        $busSchedule = date('Y-m-d H:i:s', strtotime($busSchedule));
    }

    // Update query
    $updateSql = "UPDATE buses SET 
                    BusNumber = '$busNumber', 
                    Capacity = '$capacity', 
                    DriverName = '$driverName', 
                    ContactNumber = '$contactNumber', 
                    Route = '$route', 
                    Status = '$status',
                    BusSchedule = '$busSchedule' 
                  WHERE BusId = '$busId'";

    if ($conn->query($updateSql)) {
        $_SESSION['message'] = "Bus details updated successfully!";
        header("Location: view-buses.php");
        exit;
    } else {
        $_SESSION['message'] = "Error updating bus: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bus</title>
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
                    <h1>Edit Bus</h1>

                    <?php if (isset($_SESSION['message'])): ?>
                        <p class="message"><?= $_SESSION['message']; ?></p>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <form method="POST" class="edit-user-form">
                        <label for="bus_number">Bus Number:</label>
                        <input class="edit-user-input" type="text" name="bus_number" value="<?= htmlspecialchars($bus['BusNumber']); ?>" required>

                        <label for="capacity">Capacity:</label>
                        <input class="edit-user-input" type="number" name="capacity" value="<?= htmlspecialchars($bus['Capacity']); ?>" required>

                        <label for="driver_name">Driver Name:</label>
                        <input class="edit-user-input" type="text" name="driver_name" value="<?= htmlspecialchars($bus['DriverName']); ?>" required>

                        <label for="contact_number">Contact Number:</label>
                        <input class="edit-user-input" type="number" name="contact_number" value="<?= htmlspecialchars($bus['ContactNumber']); ?>" required>

                        <label for="route">Route:</label>
                        <input class="edit-user-input" type="text" name="route" value="<?= htmlspecialchars($bus['Route']); ?>" required>

                        <!-- New Bus Schedule field -->
                        <label for="bus_schedule">Bus Schedule:</label>
                        <input class="edit-user-input" type="datetime-local" name="bus_schedule" value="<?= date('Y-m-d\TH:i', strtotime($bus['BusSchedule'])); ?>" required>

                        <label for="status">Status:</label>
                        <select class="edit-user-input-select" name="status" required>
                            <option value="active" <?= $bus['Status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?= $bus['Status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>

                        <button type="submit">Update Bus</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
