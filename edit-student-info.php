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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Update query for email, contact, and address
    $update_sql = "UPDATE users SET 
                    email = '$email', 
                    contact_number = '$contact_number', 
                    Address = '$address' 
                  WHERE username = '$username'";

    if (!empty($new_password)) {
        // Validate password match
        if ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            // Hash the new password
            $password = md5($_POST['new_password']);
            $update_sql = "UPDATE users SET 
                            email = '$email', 
                            contact_number = '$contact_number', 
                            Address = '$address', 
                            password = '$password' 
                          WHERE username = '$username'";
        }
    }

    if (!isset($error) && $conn->query($update_sql)) {
        $_SESSION['message'] = "Information updated successfully!";
        header('Location: student-view-info.php');
        exit;
    } else {
        $error = isset($error) ? $error : "Error updating information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information</title>
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
        <section class="edit-student-info">
            <div class="home-container">
                <div class="main-container">
                    <h1>Edit Your Information</h1>

                    <?php if (isset($error)): ?>
                        <p class="error"><?= htmlspecialchars($error); ?></p>
                    <?php endif; ?>

                    <form class="edit-student-form" method="POST">
                        <div class="email">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="<?= htmlspecialchars($student['email']); ?>" required>
                        </div> 

                        <div class="contact-number">
                            <label for="contact_number">Contact Number:</label>
                            <input type="text" name="contact_number" id="contact_number" 
                                value="<?= htmlspecialchars($student['contact_number']); ?>" required>
                        </div>

                        <div class="address">
                            <label for="address">Address:</label>
                            <textarea name="address" id="address" rows="4" required><?= htmlspecialchars($student['Address']); ?></textarea>
                        </div>

                        <div class="password">
                            <h2>Change Password (Optional)</h2>

                            <div class="pass-change">

                                <div class="new-pass">
                                    <label for="new_password">New Password:</label>
                                    <input class="edit-user-input" type="password" name="new_password" id="new_password" placeholder="New Password">
                                </div>

                                <div class="confirm-pass">
                                    <label for="confirm_password">Confirm New Password:</label>
                                    <input class="edit-user-input" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>

                        <button type="submit">Update Info</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
