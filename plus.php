<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: Login.php");
  die();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticketflix";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the user is already a T-Plus member
$userId = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE email = '$userId'"; // Enclose $userId in single quotes
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $isTPlusMember = $row['plus'];
} else {
  // Handle the case where the user's email is not found in the database
  die("Error: User data not found.");
}
error_reporting(0);
// Handle the T-Plus membership upgrade or downgrade
if (isset($_POST['submit'])) {
  $cardHolderName = $_POST['card_holder_name'];
  $cardNumber = md5($_POST['card_number']);
  $cvv = md5($_POST['cvv']);
  $expiryMonth = $_POST['expiry_month'];
  $expiryYear = $_POST['expiry_year'];
  $becomeNormal = isset($_POST['become_normal']) ? $_POST['become_normal'] : '';

  if ($becomeNormal === "yes") {
    // Downgrade to a normal user
    $sql = "UPDATE users SET plus = 0 WHERE email = '$userId'";
    $conn->query($sql);
    unset($_SESSION['plususername']);
    // Redirect the user to the Home page after becoming a normal user
    header("Location: plushome.php");
    die();
  } else {
    // Validate the card details and check if the card has sufficient balance
    $sql = "SELECT * FROM cards WHERE card_number = '$cardNumber' AND cvv = '$cvv' AND expiry_month = '$expiryMonth' AND expiry_year = '$expiryYear' AND card_holder_name = '$cardHolderName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $cardRow = $result->fetch_assoc();
      $cardBalance = $cardRow['balance'];

      if ($cardBalance >= 200) {
        // Deduct 200 from the user's balance in the cards table
        $newCardBalance = $cardBalance - 200;
        echo $sql = "UPDATE cards SET balance = $newCardBalance WHERE card_number = '$cardNumber'";
        $conn->query($sql);

        // Update the user's plus status to 1 (T-Plus member) in the users table
        $sql = "UPDATE users SET plus = 1 WHERE email = '$userId'";
        $conn->query($sql);
        $_SESSION['plususername']=$_SESSION['username'];
        // Redirect the user to the Home page after successful upgrade
        header("Location: plushome.php");
        die();
      } else {
        // Insufficient balance on the card, display an error message
        $error_message = "Insufficient balance on the card. Please top up your card before upgrading.";
      }
    } else {
      // Card details not found or incorrect, display an error message
      $error_message = "Invalid card details. Please check your card information and try again.";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Upgrade to T-Plus</title>

  <style>
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: #f9f9f9;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .alert {
      margin-bottom: 20px;
    }

    .btn {
      margin-top: 10px;
    }

    #red {
      color: red;
    }

    #small {
      margin-top: 10px;
      font-size: small;
      color: #888;
    }
    .homebtn:hover{
      background-color: #cc0000;
      color:white;
    }
    .homebtn{
      border: none;
      border-radius: 6px;
      height:50px;
      width: 90px;
      background-color: wheat;
      color:black;
      margin-top: 30px;
      margin-left: 90%;
    }
  </style>
</head>

<body>
<a href="plushome.php" ><button class="homebtn" type="button">Home</button></a>
  <div class="container">
    <h1>Upgrade to T-Plus</h1>
    <p>Upgrade to our premium T-Plus membership to enjoy exclusive benefits!</p>

    <?php if ($isTPlusMember) { ?>
      <div class="alert alert-success" role="alert">
        You are already a T-Plus member!
      </div>
      <form method="post">
        <div class="mb-3">
          <label for="become_normal" class="form-label">Become a Normal User :</label>
          <input type="checkbox" id="become_normal" name="become_normal" value="yes">
          <label for="become_normal">I want to become a normal user again</label><br>
          <label id="red">No Refund Will Be Issued</label><br>
          <label id="red">Tick The CheckBox</label>
        </div>
        <button type="submit" name="submit" class="btn btn-danger">Downgrade to Normal User</button>
      </form>
    <?php } else { ?>
      <h3>Benefits of T-Plus Membership:</h3>
      <ul>
        <li>Priority access to movie bookings</li>
        <li>Free snacks and drinks during the movie</li>
        <li>Exclusive discounts on tickets and concessions</li>
        <!-- Add more benefits if needed -->
      </ul>
     
      <form method="post">
      <div class="mb-3">
        <label for="card_holder_name" class="form-label">Card Holder Name</label>
        <input type="text" class="form-control" id="card_holder_name" name="card_holder_name" required>
      </div>
      <div class="mb-3">
        <label for="card_number" class="form-label">Card Number</label>
        <input type="text" class="form-control" id="card_number" name="card_number" required>
      </div>
      <div class="mb-3">
        <label for="cvv" class="form-label">CVV</label>
        <input type="text" class="form-control" id="cvv" name="cvv" required>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="expiry_month" class="form-label">Expiry Month</label>
          <input type="text" class="form-control" id="expiry_month" name="expiry_month" required>
        </div>
        <div class="col">
          <label for="expiry_year" class="form-label">Expiry Year</label>
          <input type="text" class="form-control" id="expiry_year" name="expiry_year" required>
        </div>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Upgrade Now (Pay Rs.200)</button>
    </form>
    <div id="small">
    <label id="red">Note:No Refund Will Be Provided On Cancellation</label><br>
      <label id="red">Rs 200 Will Be Charged Every Month</label>
    </div>
    <?php } ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
