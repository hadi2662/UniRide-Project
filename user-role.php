<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch users from the database
$sql = "SELECT id, username, role FROM users";
$result = $conn->query($sql);

// Update user roles if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if there are roles to update
    if (isset($_POST['role']) && is_array($_POST['role'])) {
        foreach ($_POST['role'] as $user_id => $new_role) {
            // Make sure the role is valid (security check)
            $new_role = in_array($new_role, ['student', 'admin', 'faculty']) ? $new_role : 'student';

            // Update the user's role in the database
            $sql = "UPDATE users SET role = '$new_role' WHERE id = '$user_id'";
            if ($conn->query($sql)) {
                $_SESSION['message'] = "User role updated successfully!";
            } else {
                $_SESSION['message'] = "Error: " . $conn->error;
            }
        }
    }
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
        <section class="user-role">
            <div class="home-container">
                <div class="main-container">
                    <h1>Manage User Roles</h1>

                    <div class="user-role-table">
                        <!-- Form for updating user roles -->
                        <form method="POST" action="">
                            <table>
                                <tr>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Change Role</th>
                                </tr>

                                <?php while ($user = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['username']); ?></td>
                                    <td><?= htmlspecialchars($user['role']); ?></td>
                                    <td>
                                        <select name="role[<?= $user['id']; ?>]" class="user-select">
                                            <option value="student" <?= $user['role'] === 'student' ? 'selected' : ''; ?>>Student</option>
                                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            <option value="faculty" <?= $user['role'] === 'faculty' ? 'selected' : ''; ?>>Faculty</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </table>

                            <!-- Update role button outside the table -->
                            <button type="submit">Update Role</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- JavaScript to show alert based on session message -->
    <script>
        <?php if (isset($_SESSION['message'])): ?>
            alert("<?php echo $_SESSION['message']; ?>");
            <?php unset($_SESSION['message']); ?> // Clear the session message after showing the alert
        <?php endif; ?>
    </script>
</body>
</html>
