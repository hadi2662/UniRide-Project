<?php
include 'db.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encrypt password

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Debugging: Print role and redirection information
        echo "User Role: " . $_SESSION['role']; // Remove after testing

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: admin.php');
        } elseif ($user['role'] === 'student') {
            header('Location: student.php');
        } elseif ($user['role'] === 'faculty') {
            header('Location: faculty.php');  // Redirect to faculty dashboard
        }
        exit;
    } else {
        $message = 'Invalid username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                            <li><a href="signup.php">SIGN UP</a></li>
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
        <section class="login-section">
            <div class="login-column home-container">
                <div class="login-content">
                    <h1>Welcome back!</h1>
                    <h3>We are glad to see you</h3>
                    <div class="login-container">
                        <h2>Login</h1>
                        <form method="POST">
                            <label for="username">Username</label>
                            <input class="login-input" type="text" name="username" placeholder="Username" required>
                            <label for="username">Password</label>
                            <input class="login-input" type="password" name="password" placeholder="Password" required>
                            <button type="submit" class="login-sub-button">Login</button>
                        </form>
                        <?php if ($message): ?>
                            <p class="error"><?= $message ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
</body>
</html>
