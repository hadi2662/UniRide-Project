<?php
session_start();
include 'db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Handle delete request
if (isset($_GET['delete'])) {
    $uniId = $_GET['delete'];
    $deleteSql = "DELETE FROM users WHERE UniId = '$uniId'";
    
    if ($conn->query($deleteSql)) {
        $_SESSION['message'] = "User deleted successfully!";
        header("Location: view-user.php"); // Redirect to the same page after deleting
        exit;
    } else {
        $_SESSION['message'] = "Error deleting user: " . $conn->error;
    }
}

// Fetch all users from the database
$sql = "SELECT UniId, username, email, contact_number, Address, role FROM users ORDER BY role, username";
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
    <title>View Users</title>
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
        <section class="view-user">
            <div class="home-container">
                <div class="main-container">
                    <h1>All Users</h1>
                    
                    <?php if (isset($_SESSION['message'])): ?>
                        <p class="message"><?= $_SESSION['message']; ?></p>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>
                    
                    <?php if ($result->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>University ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['UniId']); ?></td>
                                        <td><?= htmlspecialchars($user['username']); ?></td>
                                        <td><?= htmlspecialchars($user['email']); ?></td>
                                        <td><?= htmlspecialchars($user['contact_number']); ?></td>
                                        <td><?= htmlspecialchars($user['Address']); ?></td>
                                        <td><?= htmlspecialchars($user['role']); ?></td>
                                        <td>
                                            <!-- Edit Link -->
                                            <a href="edit-user.php?uniId=<?= urlencode($user['UniId']); ?>">Edit</a> | 
                                            <!-- Delete Link -->
                                            <a href="view-user.php?delete=<?= urlencode($user['UniId']); ?>" 
                                            onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No users found.</p>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    </main>
</body>
</html>
