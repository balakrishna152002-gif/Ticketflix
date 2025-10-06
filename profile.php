<?php
    session_start();

    if (!isset($_SESSION['username'])) {
      header("location: Login.php");
      die();
    }
    ?>
    <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .profile {
      text-align: center;
      margin-bottom: 30px;
    }

    .profile img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
    }

    .profile h2 {
      margin-top: 20px;
    }

    .profile p {
      margin-top: 10px;
    }

    .buttons {
      text-align: center;
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
  </style>
</head>

<body>
  <div class="container">
    <?php
    // Retrieve user's first name and last name from the database (replace with your own database connection code)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ticketflix";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
$mail=$_SESSION['username'];
    // Fetch user data from the users table
    $sql = "SELECT fname, lname FROM users where email='$mail'";
    $result = $conn->query($sql);

    // Check if data exists
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $firstname = $row["fname"];
      $lastname = $row["lname"];
    } else {
      $firstname = "";
      $lastname = "";
    }

    $conn->close();
    ?>

    <div class="profile">
      <h2><?php echo"Welcome ". $firstname . " " . $lastname; ?></h2>
      <p>Email: "<?php echo $_SESSION['username']?>"</p>
    </div>

    <div class="buttons">
      <a href="ubookings.php"><button>View Booking</button></a>
      <a href="home.php"><button>Home</button></a>
      <a href="logout.php"><button>Logout</button></a>
    </div>
  </div>
</body>

</html>
