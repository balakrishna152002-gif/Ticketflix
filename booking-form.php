<?php
include "db.php";
// Retrieve the booking details from the database
$theaterName = "Your Theater Name"; // Replace with your actual theater name
$date = "2023-07-19"; // Replace with the desired date

// Query the database to retrieve the booked seats for the specified theater and date
$query = "SELECT selected_seats FROM bookings WHERE theater_name = '$theaterName' AND date = '$date'";
$result = $conn->query($query);

// Create an empty array to store the booked seats
$bookedSeats = [];

// Check if there are any booked seats
if ($result->num_rows > 0) {
  // Fetch the booked seats from the result and add them to the array
  while ($row = $result->fetch_assoc()) {
    $selectedSeats = explode(",", $row['selected_seats']);
    $bookedSeats = array_merge($bookedSeats, $selectedSeats);
  }
}

// Function to check if a seat is booked
function isSeatBooked($seatLabel, $bookedSeats)
{
  return in_array($seatLabel, $bookedSeats);
}

// Function to generate the CSS class for a seat based on its availability
function getSeatClass($seatLabel, $bookedSeats)
{
  if (isSeatBooked($seatLabel, $bookedSeats)) {
    return 'seat booked';
  } else {
    return 'seat';
  }
}

?>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Booking Form</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .seat-selection {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .seat-row {
      display: flex;
      align-items: center;
      margin-top: 22px;
    }

    .seat {
      width: 40px;
      height: 40px;
      margin: 5px;
      margin-top: 6px;
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #fff;
      position: relative;
    }

    .selected {
      background-color: #007bff;
    }

    .pathway {
      width: 40px;
      height: 40px;
      margin: 5px;
      background-color: transparent;
      border: none;
    }

    .space {
      width: 100%;
      height: 40px;
    }

    .theater-info {
      text-align: center;
      margin-bottom: 10px;
      margin-top: 40px;
    }

    .screen {
      text-align: center;
      width: 850px;
      margin-bottom: 20px;
      font-weight: bold;
      background-color: #007bff;
      color: #fff;
      padding: 10px;
      border-radius: 4px;
      margin-top: 50px;
      height: 30px;
    }

    /* Add new seat color styles */
    .gold {
      background-color: gold;
    }

    .silver {
      background-color: silver;
    }

    .bronze {
      background-color: #cd7f32;
    }

    /* Update existing seat styles */
    .seat {
      width: 40px;
      height: 40px;
      margin: 5px;
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #fff;
    }

    .selected {
      background-color: #007bff;
    }

    /* Add ticket price styles */
    .ticket-price {
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .ticket-price p {
      display: inline-block;
      margin: 0 10px;
    }

    .total-price {
      text-align: center;
      margin-top: 10px;
    }

    .buttons {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .buttons button {
      margin: 0 5px;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .buttons button:hover {
      background-color: #0056b3;
    }

    #payment-success {
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
      display: none;
    }

    .seat-price {
      position: absolute;
      top: -20px;
      left: 0;
      width: 100%;
      text-align: center;
      font-size: 12px;
      color: #000;
    }

    .total-price-label {
      font-weight: bold;
    }

    .ticket {
      display: none;
      background-color: #fff;
      padding: 20px;
      border-radius: 4px;
      margin-top: 50px;
      text-align: center;
    }

    .booked {
      background-color: red;
      cursor: not-allowed;
    }
    #payment-form {
    margin-top: 20px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
  }

  /* Style input fields */
  #payment-form input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  /* Style the submit button */
  #payment-form button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  #payment-form button[type="submit"]:hover {
    background-color: #0056b3;
  }

  /* Style the payment success message */
  #payment-success {
    text-align: center;
    margin-top: 20px;
    font-weight: bold;
    display: none;
    color: #4CAF50; /* Green color for success */
  }
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

    if (isset($_GET['movie_id']) && isset($_GET['theater_name']) && isset($_GET['showtime']) && isset($_GET['date'])) {
      $movieId = $_GET['movie_id'];
      $theaterName = $_GET['theater_name'];
      $showtime = $_GET['showtime'];
      $date = $_GET['date'];

      // Implement your booking form logic here
      echo "<div class='seat-selection'>";
      echo "<h2>Booking Form</h2>";
      echo "<div class='theater-info'>";
      echo "<p>Theater: $theaterName</p>";
      echo "<p>Date: $date</p>";
      echo "<p>Showtime: $showtime</p>";
      echo "</div>";

      echo "<div class='ticket-price'>";
      echo "<p>Ticket Prices:</p>";
      echo "<p class='gold'>Gold: Rs 200</p>";
      echo "<p class='silver'>Silver: Rs 180</p>";
      echo "<p class='bronze'>Bronze: Rs 140</p>";
      echo "<p></p>";
      echo "<p><span class='total-price-label'>Total Price:</span> <span id='total-price'>0</span></p>";
      echo "</div>";

      // Initialize $totalPrice variable
      $totalPrice = 0;

      echo "<h3>Select Seats:</h3>";
      $sql = "SELECT * FROM bookings WHERE theater_name='$theaterName'and showtime='$showtime' and date='$date'";
      $result = $conn->query($sql);
      $selectedSeats = array(); // Variable to store the selected seats

      while ($row = $result->fetch_assoc()) {
        $selectedSeats[] = $row['selected_seats'];
      }


      $rows = 10;
      $seatsPerRow = 17;

      $seatIndex = 1;
      $seatNumbers = "";

      for ($row = 1; $row <= $rows; $row++) {
        $rowLabel = chr(65 + $row - 1); // Convert row number to ASCII character

        if ($row == 1) {
          $ticketPrice = 200;
          $seatColor = 'gold';
        } elseif ($row <= 7) {
          $ticketPrice = 180;
          $seatColor = 'silver';
        } else {
          $ticketPrice = 140;
          $seatColor = 'bronze';
        }

        if ($row == 6) {
          echo "<div class='space'></div>";
        }

        echo "<div class='seat-row'>";
        for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
          $seatLabel = $rowLabel . $seat;

          if ($seat == 6 || $seat == 13) {
            echo "<div class='pathway'></div>";
          }

          $seatClass = 'seat ' . $seatColor;

          // Check if the seat is booked
          if (in_array($seatLabel, $selectedSeats)) {
            $seatClass .= ' booked'; // Add 'booked' class to make the seat red
          }

          echo "<div class='$seatClass' data-price='$ticketPrice' data-seat-label='$seatLabel'>";
          echo "<span class='seat-price'>Rs $ticketPrice</span>";
          echo "{$seatLabel}</div>";

          $seatIndex++;
        }
        echo "</div>";
      }
      echo "<div class='screen'>Screen</div>";
      echo "</div>";



      echo "<div class='buttons'>";
      echo "<button id='book-now-btn'>Book Now</button>";
      echo "</div>";

      // Payment handling logic
      if (isset($_POST['card_holder_name']) && isset($_POST['card_number']) && isset($_POST['expiry_month']) && isset($_POST['expiry_year']) && isset($_POST['cvv'])) {
        $cardHolderName = $_POST['card_holder_name'];
        $cardNumber = md5($_POST['card_number']);
        $expiryMonth = $_POST['expiry_month'];
        $expiryYear = $_POST['expiry_year'];
        $cvv = md5($_POST['cvv']);

        // Query the cards table to retrieve the card details and balance
        $cardQuery = "SELECT * FROM cards WHERE card_number = '$cardNumber' AND expiry_month = '$expiryMonth' AND expiry_year = '$expiryYear' AND cvv = '$cvv' AND card_holder_name = '$cardHolderName'";
        $cardResult = $conn->query($cardQuery);

        if ($cardResult->num_rows > 0) {
          // Card exists, retrieve the balance
          $cardData = $cardResult->fetch_assoc();
          $balance = $cardData['balance'];

          // Calculate the total price
          $selectedSeats = $_POST['selected_seats'];
          $seatCount = count(explode(",", $selectedSeats));
          $ticketPrice = 0;

          if ($seatCount > 0 && $seatCount <= 5) {
            $ticketPrice = 200;
          } elseif ($seatCount > 5 && $seatCount <= 11) {
            $ticketPrice = 180;
          } else {
            $ticketPrice = 140;
          }

          $totalPrice = $seatCount * $ticketPrice;

          // Compare the balance with the total price
          if ($balance >= $totalPrice) {
            // Sufficient balance, deduct the total price from the card's balance
            $newBalance = $balance - $totalPrice;

            $admincard = "SELECT * FROM cards WHERE id=2";
            $cardResult = $conn->query($admincard);
            $admincardData = $cardResult->fetch_assoc();
            $adba= $admincardData['balance'];
            $adb = $adba + $totalPrice;
            // Update the balance in the cards table
            $updateQuery = "UPDATE cards SET balance = '$newBalance' WHERE card_number = '$cardNumber'";
            $conn->query($updateQuery);
            $up = "update cards set balance='$adb' where card_holder_name='admin'";
            $conn->query($up);

            $timestamp = date('Y-m-d H:i:s');
            $email = $_SESSION['username'];
            // Insert the booking details into the database
            $insertQuery = "INSERT INTO bookings (movie_id, theater_name, showtime, date, card_holder_name, card_number, expiry_month, expiry_year, cvv, email, selected_seats, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssssssssssss", $movieId, $theaterName, $showtime, $date, $cardHolderName, $cardNumber, $expiryMonth, $expiryYear, $cvv, $email, $selectedSeats, $timestamp);

            if ($stmt->execute()) {
              // Successful booking, proceed with payment and confirmation
              // ...

              // Retrieve the booking ID
              $bookingId = $stmt->insert_id;

              // ...
            } else {
              // Error in inserting booking details
              echo "Error: " . $stmt->error;
            }

            $stmt->close();

            // Payment and booking confirmation
            echo "<h2>Payment Confirmation</h2>";
            echo "<p>Thank you, $cardHolderName, for your payment!</p>";
            echo "<p>Your booking for the movie '$movieId' at '$theaterName' on '$date' at '$showtime' has been confirmed.</p>";
            echo "<div id='payment-success'>Payment Successful ! Go To Profile For Ticket </div>";
            echo "<div class='ticket' id='ticket'>";
            echo "<h2>Ticket Details</h2>";
            echo "<p>Theater: $theaterName</p>";
            echo "<p>Date: $date</p>";
            echo "<p>Showtime: $showtime</p>";
            echo "<p>Movie: $movieId</p>";
            echo "<p>Total Price: Rs $totalPrice</p>";
            echo "View Ticket Under Profile";
            echo "</div>";
            echo "<script>document.getElementById('payment-form').style.display = 'none';</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'http://localhost/ticketflix/plushome.php'; }, 5000);</script>";
          } else {
            // Insufficient balance
            echo "Error: Insufficient funds in the card.";
          }
        } else {
          // Card not found
          echo "Error: Card details not found.";
        }
      }
    } else {
      echo "<p>Invalid booking details.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
  </div>

  <script>
    // JavaScript code for seat selection
    const seats = document.querySelectorAll('.seat');
    const bookNowButton = document.getElementById('book-now-btn');
    const totalPriceElement = document.getElementById('total-price');

    let totalPrice = 0;

    seats.forEach(seat => {
      seat.addEventListener('click', () => {
        if (!seat.classList.contains('booked')) { // Check if the seat is not already booked
          seat.classList.toggle('selected');

          const seatPrice = parseInt(seat.getAttribute('data-price'));

          if (seat.classList.contains('selected')) {
            totalPrice += seatPrice;
          } else {
            totalPrice -= seatPrice;
          }

          totalPriceElement.textContent = totalPrice;
        }
      });
    });

    bookNowButton.addEventListener('click', () => {
      const selectedSeats = document.querySelectorAll('.seat.selected');

      if (selectedSeats.length === 0) {
        alert("Please select at least one seat.");
        return;
      }

      const paymentForm = document.createElement('form');
      paymentForm.id = "payment-form";
      paymentForm.method = "post";
      paymentForm.action = "";

      const cardHolderNameInput = document.createElement('input');
      cardHolderNameInput.type = "text";
      cardHolderNameInput.name = "card_holder_name";
      cardHolderNameInput.placeholder = "Card Holder Name";
      paymentForm.appendChild(cardHolderNameInput);

      const cardNumberInput = document.createElement('input');
      cardNumberInput.type = "text";
      cardNumberInput.name = "card_number";
      cardNumberInput.placeholder = "Card Number";
      paymentForm.appendChild(cardNumberInput);

      const expiryMonthInput = document.createElement('input');
      expiryMonthInput.type = "text";
      expiryMonthInput.name = "expiry_month";
      expiryMonthInput.placeholder = "Expiry Month";
      paymentForm.appendChild(expiryMonthInput);

      const expiryYearInput = document.createElement('input');
      expiryYearInput.type = "text";
      expiryYearInput.name = "expiry_year";
      expiryYearInput.placeholder = "Expiry Year";
      paymentForm.appendChild(expiryYearInput);

      const cvvInput = document.createElement('input');
      cvvInput.type = "text";
      cvvInput.name = "cvv";
      cvvInput.placeholder = "CVV";
      paymentForm.appendChild(cvvInput);

      const selectedSeatsInput = document.createElement('input');
      selectedSeatsInput.type = "hidden";
      selectedSeatsInput.name = "selected_seats";
      selectedSeatsInput.value = Array.from(selectedSeats).map(seat => seat.getAttribute('data-seat-label')).join(",");
      paymentForm.appendChild(selectedSeatsInput);

      const submitButton = document.createElement('button');
      submitButton.type = "submit";
      submitButton.textContent = "Make Payment";
      paymentForm.appendChild(submitButton);

      document.querySelector('.container').appendChild(paymentForm);

      // Hide the seat selection and book now button
      document.querySelector('.seat-selection').style.display = 'none';
      document.querySelector('.buttons').style.display = 'none';

      // Show the payment success message
      document.getElementById('payment-success').style.display = 'block';
    });
  </script>
</body>

</html>