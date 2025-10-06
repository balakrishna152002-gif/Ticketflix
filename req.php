<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookings</title>
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

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
    }

    th {
      background-color: #007bff;
      color: #fff;
      text-align: left;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .profile-dropdown {
      position: relative;
      display: inline-block;
      margin-left: 900px;
    }

    .profile-dropdown .profile-button {
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .profile-dropdown .profile-button:hover {
      background-color: #0056b3;
    }

    .profile-dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      right: 0;
    }

    .profile-dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .profile-dropdown:hover .profile-dropdown-content {
      display: block;
    }

    .profile-dropdown-content a:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>

<body>
  <div class="container">
    
  <div class="profile-dropdown">
      <button class="profile-button">Profile</button>
      <div class="profile-dropdown-content">
        <a href="theatre.php">View Profile</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>

    <?php
    session_start();

    if (!isset($_SESSION['theatre'])) {
      header("location: Login.php");
      die();
    }

    // Database connection (replace with your own connection code)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ticketflix";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user's bookings from the database


    $sql = "SELECT * FROM notes where theatre=1";
    $result = $conn->query($sql);
    ?>

    <h1>Requests</h1>

    <?php
    if ($result->num_rows > 0) {
      echo "<table>
              <tr>
                <th>Heading</th>
                <th>Content</th>
              </tr>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['heading'] . "</td>
                <td>" . $row['Note'] . "</td>
              </tr>";
      }

      echo "</table>";
    } else {
      echo "<p>No Requests found.</p>";
    }

    $conn->close();
    ?>
  </div>
</body>

</html>
