<?php
include('db.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    die();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "ticketflix";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the booking form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardHolderName = $_POST['card_holder_name'];
    $cardNumber = $_POST['card_number'];
    $expiryMonth = $_POST['expiry_month'];
    $expiryYear = $_POST['expiry_year'];
    $cvv = $_POST['cvv'];
    $selectedSeats = $_POST['selected_seats'];
    $email = $_SESSION['username'];

    // Validate the card details (e.g., check card number, expiry date, CVV)

    // Save the booking details to the database
    ?><script>alert()</script><?php
    $bookingQuery = "INSERT INTO bookings (movie_id, theater_name, showtime, date, card_holder_name, card_number, expiry_month, expiry_year, cvv, email, selected_seats) VALUES ('$movieId', '$theaterName', '$showtime', '$date', '$cardHolderName', '$cardNumber', '$expiryMonth', '$expiryYear', '$cvv', '$email', '$selectedSeats')";

    if ($conn->query($bookingQuery) === TRUE) {
        $bookingId = $conn->insert_id;

        // Return the booking ID as a response
        $response = [
            'success' => true,
            'booking_id' => $bookingId
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => "Error: " . $conn->error
        ];
        echo json_encode($response);
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
    /* ... existing styles ... */
  </style>
</head>
<body>
    <div class="container">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "ticketflix";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['booking_id'])) {
            $bookingId = $_GET['booking_id'];

            // Retrieve the booking details from the database
            $bookingQuery = "SELECT * FROM bookings WHERE id = '$bookingId'";
            $bookingResult = $conn->query($bookingQuery);

            if ($bookingResult->num_rows > 0) {
                $bookingData = $bookingResult->fetch_assoc();
                $cardHolderName = $bookingData['card_holder_name'];
                $cardNumber = $bookingData['card_number'];
                $expiryMonth = $bookingData['expiry_month'];
                $expiryYear = $bookingData['expiry_year'];
                $cvv = $bookingData['cvv'];
                $selectedSeats = $bookingData['selected_seats'];

                // Retrieve other relevant details from the database (e.g., movie, theater, showtime, etc.)

                // Display the ticket details
                echo "<h2>Ticket Details</h2>";
                echo "<p>Booking ID: $bookingId</p>";
                echo "<p>Card Holder Name: $cardHolderName</p>";
                echo "<p>Card Number: $cardNumber</p>";
                echo "<p>Expiry Date: $expiryMonth/$expiryYear</p>";
                echo "<p>CVV: $cvv</p>";
                echo "<p>Selected Seats: $selectedSeats</p>";
                // ... display other relevant details ...
            } else {
                echo "<p>Booking not found.</p>";
            }
        } else {
            echo "<p>Invalid booking details.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>
