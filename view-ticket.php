<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch all tickets with user and bus details, including the receipt_path
$sql = "SELECT t.TicketId, t.TicketNumber, t.Price, u.Username, b.BusNumber, b.Route, t.BusID, t.receipt_path
        FROM tickets t
        JOIN users u ON t.username = u.username  -- Updated to join using 'username'
        JOIN buses b ON t.BusID = b.BusID
        ORDER BY t.TicketId DESC";
$result = $conn->query($sql);

// Check if the query succeeded
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Handle ticket deletion
if (isset($_GET['delete'])) {
    $TicketId = $_GET['delete'];
    
    // Prepare the SQL query to delete the ticket using the TicketId
    $deleteSql = "DELETE FROM tickets WHERE TicketId = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $TicketId);  // Bind the TicketId as an integer
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Ticket deleted successfully!";
        header("Location: view-ticket.php"); // Redirect to the same page after deleting
        exit;
    } else {
        $_SESSION['message'] = "Error deleting ticket: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tickets</title>
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
        <section class="view-tickets">
            <div class="home-container">
                <div class="main-container">
                    <h1>All Tickets</h1>

                    <?php if (isset($_SESSION['message'])): ?>
                        <p class="message"><?= $_SESSION['message']; ?></p>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <?php if ($result->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Ticket Number</th>
                                    <th>User</th>
                                    <th>Bus Number</th>
                                    <th>Route</th>
                                    <th>Price</th>
                                    <th>Receipt</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($ticket = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ticket['TicketNumber']); ?></td>
                                        <td><?= htmlspecialchars($ticket['Username']); ?></td>
                                        <td><?= htmlspecialchars($ticket['BusNumber']); ?></td>
                                        <td><?= htmlspecialchars($ticket['Route']); ?></td>
                                        <td><?= htmlspecialchars($ticket['Price']); ?></td>
                                        <td>
                                            <?php if ($ticket['receipt_path']): ?>
                                                <a href="<?= htmlspecialchars($ticket['receipt_path']); ?>" target="_blank">View Receipt</a>
                                            <?php else: ?>
                                                No Receipt
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="view-ticket.php?delete=<?= urlencode($ticket['TicketId']); ?>" onclick="return confirm('Are you sure you want to delete this ticket?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No tickets found.</p>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    </main>

</body>
</html>
