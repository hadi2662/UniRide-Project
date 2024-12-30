<?php
session_start();
include 'db.php'; // Include database connection
require('fpdf/fpdf.php'); // Include FPDF library

// Check if the user is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

// Fetch all active buses to display in the form
$sql = "SELECT BusID, BusNumber, Route FROM buses WHERE status = 'active'";
$result = $conn->query($sql);

// Check if the query succeeded
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Handle the ticket booking process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $busId = $_POST['busId'];
    $price = $_POST['price'];  // You can calculate the price based on bus or user
    $ticketNumber = strtoupper(uniqid("TICKET-"));  // Generate a unique ticket number
    $username = $_SESSION['username'];  // Get the logged-in user's username

    // Insert the ticket into the database
    $ticketSql = "INSERT INTO tickets (TicketNumber, Price, username, BusID) 
                  VALUES ('$ticketNumber', '$price', '$username', '$busId')";

    if ($conn->query($ticketSql)) {
        $_SESSION['message'] = "Ticket booked successfully! Your ticket number is $ticketNumber.";

        // Fetch booking details for the receipt
        $ticketDetailsSql = "SELECT t.TicketNumber, t.Price, u.Username, b.BusNumber, b.Route
                             FROM tickets t
                             JOIN users u ON t.username = u.username
                             JOIN buses b ON t.BusID = b.BusID
                             WHERE t.TicketNumber = '$ticketNumber'";

        $ticketDetailsResult = $conn->query($ticketDetailsSql);
        $ticketDetails = $ticketDetailsResult->fetch_assoc();

        // Generate and save the PDF receipt, then display it
        $pdfPath = generateAndSavePDFReceipt($ticketDetails); // Save PDF and get path

        // Save PDF path to database
        $updateTicketSql = "UPDATE tickets SET receipt_path = '$pdfPath' WHERE TicketNumber = '$ticketNumber'";
        if ($conn->query($updateTicketSql)) {
            $_SESSION['pdfPath'] = $pdfPath;  // Store the PDF path in session for later use

            // Redirect to show the PDF link to download
            header('Location: student-book-ticket.php');
            exit;  // Make sure no further output is generated
        } else {
            $_SESSION['message'] = "Error saving receipt path: " . $conn->error;
        }
    } else {
        $_SESSION['message'] = "Error booking ticket: " . $conn->error;
    }
}

// Function to generate and save the PDF receipt on the server
function generateAndSavePDFReceipt($ticketDetails) {
    // Initialize PDF object
    $pdf = new FPDF();
    $pdf->AddPage();

    // Add Logo: Adjust the size and position as needed
    $pdf->Image('images/inoride-png-logo.png', 100, 10, 20); // (image path, x position, y position, width)
    
    // Add "SMIU UniRide" text below the logo (centered, adjust position)
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Ln(20);  // Add some space between logo and text
    $pdf->Cell(200, 10, 'SMIU UniRide', 0, 1, 'C');
    
    $pdf->Ln(10);  // Line break to provide spacing between the title and the rest of the content

    // Set title for the ticket details
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(200, 10, 'Ticket Booking Receipt', 0, 1, 'C');
    $pdf->Ln(10);  // Line break

    // Set font for the ticket details
    $pdf->SetFont('Arial', '', 12);

    // Add some spacing and title for the ticket information
    $pdf->Cell(200, 10, 'Ticket Details', 0, 1, 'L');
    $pdf->Ln(5);

    // Table structure: headers and data
    $pdf->SetFillColor(200, 220, 255); // Light blue fill for header
    $pdf->Cell(40, 10, 'Ticket Number:', 1, 0, 'L', true);
    $pdf->Cell(150, 10, $ticketDetails['TicketNumber'], 1, 1, 'L');

    $pdf->Cell(40, 10, 'Username:', 1, 0, 'L', true);
    $pdf->Cell(150, 10, $ticketDetails['Username'], 1, 1, 'L');

    $pdf->Cell(40, 10, 'Bus Number:', 1, 0, 'L', true);
    $pdf->Cell(150, 10, $ticketDetails['BusNumber'], 1, 1, 'L');

    $pdf->Cell(40, 10, 'Route:', 1, 0, 'L', true);
    $pdf->Cell(150, 10, $ticketDetails['Route'], 1, 1, 'L');

    $pdf->Cell(40, 10, 'Price:', 1, 0, 'L', true);
    $pdf->Cell(150, 10, '$' . $ticketDetails['Price'], 1, 1, 'L');

    // Add a footer section with extra info
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(200, 10, 'Thank you for booking with us!', 0, 1, 'C');
    $pdf->Cell(200, 10, 'For any inquiries, contact support@smiiuniride.com', 0, 1, 'C');

    // Define path to save the PDF
    $pdfDir = 'receipts/';  // Directory where the PDF will be saved
    if (!file_exists($pdfDir)) {
        mkdir($pdfDir, 0777, true);  // Create the directory if it doesn't exist
    }

    // Save the PDF to the server
    $pdfPath = $pdfDir . 'receipt_' . $ticketDetails['TicketNumber'] . '.pdf';
    $pdf->Output('F', $pdfPath);  // Save the PDF to the server ('F' means save to file)

    return $pdfPath;  // Return the path of the saved PDF
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ticket</title>
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
            </div>
        </div>
    </div>

    <main>
        <section class="book-ticket">
            <div class="home-container">
                <div class="main-container">
                    <h1>Book a Ticket</h1>

                    <?php if (isset($_SESSION['message'])): ?>
                        <p class="message"><?= $_SESSION['message']; ?></p>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['pdfPath'])): ?>
                        <p>Your receipt has been saved. <a href="<?= $_SESSION['pdfPath']; ?>" target="_blank">Click here to view or download the receipt.</a></p>
                        <?php unset($_SESSION['pdfPath']); ?>
                    <?php endif; ?>

                    <form method="POST" action="student-book-ticket.php">
                        <div class="ticket-form">
                            <label for="busId">Select Bus:</label>
                            <select name="busId" id="busId" required>
                                <option value="">Choose a Bus</option>
                                <?php while ($bus = $result->fetch_assoc()): ?>
                                    <option value="<?= $bus['BusID']; ?>"><?= $bus['BusNumber'] . " - " . $bus['Route']; ?></option>
                                <?php endwhile; ?>
                            </select>

                            <label for="price">Price:</label>
                            <input type="number" name="price" id="price" value="10.00" readonly>
                        </div>

                        <button type="submit">Book Ticket</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
