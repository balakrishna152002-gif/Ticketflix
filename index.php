<?php
session_start();

if (isset($_SESSION['username'])) {
  header("location: home.php");
  die();
}
?>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Movie Booking</title>

  <style>
    * {
      margin: 0;
      padding: 0;
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

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    form {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    .movies {
      display: flex;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    .movie-item {
      flex-basis: 33%;
      padding: 10px;
    }

    .movie-table {
      width: 100%;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .movie-table img {
      width: 100%;
      height: auto;
      border-radius: 5px 5px 0 0;
    }

    .movie-table td {
      padding: 10px;
    }

    .movie-table td.title {
      font-weight: bold;
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
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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



    body {
      background-color: #f1f1f1;
    }

    h1 {
      color: #333;
    }

    label {
      color: #555;
    }

    select {
      background-color: #fff;
      color: #333;
    }

    .movies {
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }

    .movie-item {
      background-color: #f9f9f9;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .movie-table {
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .buttons button {
      background-color: #009688;
      color: #fff;
    }

    .buttons button:hover {
      background-color: #00796b;
    }

    .profile-dropdown .profile-button {
      background-color: #009688;
      color: #fff;
    }

    .profile-dropdown .profile-button:hover {
      background-color: #00796b;
    }

    .profile-dropdown-content {
      background-color: #fff;
      color: #333;
      border-radius: 5px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    }

    .profile-dropdown-content a {
      color: #333;
    }

    .profile-dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .dot {
      height: 10px;
      width: 10px;
      background-color: #28a4a9;
      border-radius: 50%;
      display: inline-block;
    }
  </style>
</head>

<body>
  <div class="container">


    <h1>Welcome to Ticketflix</h1>

    <div class="profile-dropdown">
      <button class="profile-button">Login</button>
      <div class="profile-dropdown-content">
      
        <a href="login.php">Login</a>
      </div>
    </div>

    <div class="tab-content active" id="homeTab">
      <form>
        <label>Choose Your Location:</label>
        <select name="location" id="locationSelect">
          <option>Select City</option>
          <?php
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "ticketflix";
          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
            echo "Error connecting to server";
          }

          $sql = "SELECT tcity FROM theatre";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $loc = $row['tcity'];
            echo "<option>$loc</option>";
          }
          ?>
        </select>
      </form>

      <div class="movies" id="moviesContainer">
        <marquee>
          <?php
          echo "Coming Soon.... ";
          $sql = "SELECT name, coming_soon FROM movies WHERE coming_soon = '1'";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $namecs = $row['name'];
            echo $namecs . ' ';
            echo ' <div class="dot"></div> '; // Place the dot separately from the movie name
          }
          ?>
        </marquee>
        <!-- Movies will be loaded dynamically here -->
      </div>
    </div>

    <div class="tab-content" id="profileTab">
      <!-- User profile content here -->
    </div>

    <div class="buttons">
      <button onclick="openTab('homeTab')">Home</button>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#locationSelect').change(function() {
        var loc = $(this).val();

        if (loc) {
          $.ajax({
            type: 'post',
            url: 'fetch.php',
            data: {
              location: loc,
            },
            success: function(response) {
              $('#moviesContainer').html(response);
            },
            error: function(xhr, status, error) {
              console.log(error);
            }
          });
        } else {
          $('#moviesContainer').html("");
        }
      });
    });

    function openTab(tabId) {
      $('.tab-content').removeClass('active');
      $('#' + tabId).addClass('active');
    }
  </script>
</body>

</html>