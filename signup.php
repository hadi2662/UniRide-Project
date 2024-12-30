<?php
include 'db.php'; // Include the database connection
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uniId = $_POST['uniId']; // Get the University ID
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number']; // Get the contact number
    $address = $_POST['address']; // Get the address

    // Validate the form inputs
    if ($password !== $confirm_password) {
        $message = 'Passwords do not match!';
    } else {
        // Hash the password
        $hashed_password = md5($password); // For production, use password_hash()

        // Set role to 'student' by default
        $role = 'student'; // Only admin should be able to set this

        // Insert into the database
        $sql = "INSERT INTO users (UniId, username, password, role, email, contact_number, Address) 
                VALUES ('$uniId', '$username', '$hashed_password', '$role', '$email', '$contact_number', '$address')";

        if ($conn->query($sql)) {
            $message = 'Signup successful! You can now log in.';
            // Redirect to login page after successful signup
            header('Location: login.php'); 
            exit;
        } else {
            $message = 'Error: ' . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
                            <li><a href="index.php">HOME</a></li>
                            <li><a href="login.php">LOGIN</a></li>
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
        <section class="signup-section login-section">
            <div class="signup-column home-container login-column">
                <div class="login-content signup-content">
                    <h1>New Here?</h1>

                    <div class="login-container signup-container">
                        <h2>Sign Up</h1>
                        <form id="signupForm" action="signup.php" method="POST">
                            <label for="uniId">University ID:</label>
                            <input class="login-input" type="text" name="uniId" id="uniId" placeholder="University ID" required value="<?= isset($_POST['uniId']) ? htmlspecialchars($_POST['uniId']) : ''; ?>">

                            <label for="username">Username:</label>
                            <input class="login-input" type="text" name="username" id="username" placeholder="Username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">

                            <label for="email">Email:</label>
                            <input class="login-input" type="email" name="email" id="email" placeholder="Email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

                            <label for="password">Password:</label>
                            <input class="login-input" type="password" name="password" id="password" placeholder="Password" required>

                            <label for="confirm_password">Confirm Password:</label>
                            <input class="login-input" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>

                            <label for="contact_number">Contact Number:</label>
                            <input class="login-input" type="text" name="contact_number" id="contact_number" placeholder="Enter Contact Number" required value="<?= isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number']) : ''; ?>">

                            <label for="address">Address:</label>
                            <textarea class="login-input" name="address" id="address" placeholder="Enter Address" required><?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>

                            <button type="submit">Sign Up</button>
                        </form>

                        <!-- Display messages (success or error) -->
                        <?php if ($message): ?>
                            <p><?= htmlspecialchars($message); ?></p>
                        <?php endif; ?>

                        <!-- Link to login page -->
                        <div class="link">
                            <p>Already have an account? <a href="login.php">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    
    <script>
        // Get the form and password fields
        const form = document.getElementById('signupForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');

        // Add event listener to validate password match before submitting
        form.addEventListener('submit', function(event) {
            if (password.value !== confirmPassword.value) {
                alert('Passwords do not match!');
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>
</html>
