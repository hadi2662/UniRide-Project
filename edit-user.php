<?php
session_start();
include 'db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Check if the UniId parameter is set in the URL
if (!isset($_GET['uniId'])) {
    header('Location: view-user.php');
    exit;
}

$uniId = $_GET['uniId'];

// Fetch the user details from the database
$sql = "SELECT * FROM users WHERE UniId = '$uniId'";
$result = $conn->query($sql);

// Check if the user exists
if ($result->num_rows !== 1) {
    die("User not found.");
}

$user = $result->fetch_assoc();

// Update user details if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    // Update query
    $updateSql = "UPDATE users SET username = '$username', email = '$email', contact_number = '$contact_number', Address = '$address', role = '$role' WHERE UniId = '$uniId'";

    if ($conn->query($updateSql)) {
        $_SESSION['message'] = "User details updated successfully!";
        header("Location: view-user.php");
        exit;
    } else {
        $_SESSION['message'] = "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
        <section class="edit-user">
            <div class="home-container">
                <div class="main-container">
                    <h1>Edit User</h1>

                    <?php if (isset($_SESSION['message'])): ?>
                        <p class="message"><?= $_SESSION['message']; ?></p>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <form method="POST" class="edit-user-form">
                        <label for="username">Username:</label>
                        <input class="edit-user-input" type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>

                        <label for="email">Email:</label>
                        <input class="edit-user-input" type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

                        <label for="contact_number">Contact Number:</label>
                        <input class="edit-user-input" type="number" name="contact_number" value="<?= htmlspecialchars($user['contact_number']); ?>" required>

                        <label for="address">Address:</label>
                        <!-- <textarea class="edit-user-input edit-user-input-text" name="address" required><?= htmlspecialchars($user['Address']); ?></textarea> -->
                        <input class="edit-user-input" type="text" name="address" value="<?= htmlspecialchars($user['Address']); ?>" required>

                        <label for="role">Role:</label>
                        <select class="edit-user-input-select edit-user-input" name="role" required>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="student" <?= $user['role'] === 'student' ? 'selected' : ''; ?>>Student</option>
                            <option value="faculty" <?= $user['role'] === 'faculty' ? 'selected' : ''; ?>>Faculty</option>
                        </select>

                        <button type="submit">Update User</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
