<?php 
session_start();
?>
<!DOCTYPE html>
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

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .movie-item {
      margin-bottom: 20px;
    }

    .movie-table {
      width: 100%;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .movie-table td {
      padding: 10px;
    }

    .movie-table td.title {
      font-weight: bold;
    }

    .showtimes {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    .showtime-box {
      width: 20%;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 5px;
      text-align: center;
      cursor: pointer;
      opacity: 0.5;
      background-color: #f9f9f9;
      color: #333;
      text-decoration: none;
      transition: opacity 0.3s ease;
    }

    .showtime-box:hover {
      opacity: 1;
    }

    .date-selection {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .date-selection input[type="date"] {
      margin-right: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
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

<script>
    // Enable showtime selection after selecting a date
    function enableShowtimes() {
      var showtimeBoxes = document.querySelectorAll('.showtime-box');
      var selectedDate = document.getElementById('date').value;
      var currentDate = new Date();
      var currentDay = currentDate.getDay();

      // Calculate the maximum date allowed based on the current day
      var maxDate = new Date();
      if (currentDay === 4) { // Thursday
        maxDate.setDate(maxDate.getDate() + 7); // Add 7 days to get next Friday
      } else {
        maxDate.setDate(maxDate.getDate() + (5 - currentDay + 7) % 7); // Calculate the days until the next Friday
      }
      var formattedMaxDate = maxDate.toISOString().split('T')[0];

      document.getElementById('date').max = formattedMaxDate;

      showtimeBoxes.forEach(function (box) {
        var showtime = box.getAttribute('data-showtime');
        var movieId = box.getAttribute('data-movie-id');
        var theaterName = box.getAttribute('data-theater-name');
        var href = 'booking-form.php?movie_id=' + movieId + '&theater_name=' + theaterName + '&showtime=' + showtime + '&date=' + selectedDate;

        var showtimeDateTime = new Date(selectedDate + ' ' + showtime);

        if (showtimeDateTime > currentDate) {
          box.style.opacity = 1;
          box.removeAttribute('disabled');
          box.href = href;
        } else {
          box.style.opacity = 0.5;
          box.setAttribute('disabled', 'disabled');
          box.href = '';
        }
      });
    }
  </script>
</head>

<body>
  <div class="container">
    <?php
    // booking.php

    if (isset($_GET['movie_id'])) {
      $movieId = $_GET['movie_id'];

      // Implement your ticket booking logic here based on the movie ID

      // Connect to the database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "ticketflix";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Error connecting to the database: " . $conn->connect_error);
      }

      // Fetch the movie name
      $sql = "SELECT name FROM movies WHERE m_id = $movieId";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $movieName = $row['name'];
      $loc=$_SESSION['location']; 
      // Fetch the theaters where the movie is playing
      $sql = "SELECT theatre.tname, theatre.tcity,theatre.tlocation, current.screen, current.morning, current.noon, current.first, current.seccond
          FROM theatre
          INNER JOIN current ON theatre.tid = current.tid
          WHERE current.mid = $movieId and theatre.tcity='$loc'";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<h2>Theaters showing \"$movieName\":</h2>";
        while ($row = $result->fetch_assoc()) {
          $theaterName = $row['tname'];
          $theaterCity = $row['tcity'];
          $theaterlocation=$row['tlocation'];
          $screenNumber = $row['screen'];
          $morning = $row['morning'];
          $noon = $row['noon'];
          $first = $row['first'];
          $second = $row['seccond'];

          // Display theater information
          echo "<div class='movie-item'>";
          echo "<table class='table table-light movie-table'>";
          echo "<tr>";
          echo "<td class='title'>Theater Name: $theaterName</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td>City: $theaterCity</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td>Location: $theaterlocation</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td>Screen: $screenNumber</td>";
          echo "</tr>";
          echo "</table>";
          echo "</div>";

          // Display showtimes
          echo "<div class='showtimes'>";
          if ($morning == 1) {
            echo "<a href='#' class='showtime-box' data-movie-id='$movieId' data-theater-name='$theaterName' data-showtime='11:30' disabled>11:30</a>";
          }
          if ($noon == 1) {
            echo "<a href='#' class='showtime-box' data-movie-id='$movieId' data-theater-name='$theaterName' data-showtime='13:30' disabled>1:30</a>";
          }
          if ($first == 1) {
            echo "<a href='#' class='showtime-box' data-movie-id='$movieId' data-theater-name='$theaterName' data-showtime='17:30' disabled>5:30</a>";
          }
          if ($second == 1) {
            echo "<a href='#' class='showtime-box' data-movie-id='$movieId' data-theater-name='$theaterName' data-showtime='21:30' disabled>9:30</a>";
          }
          echo "</div>";
        }
      } else {
        echo "<p>No theaters found for this movie.</p>";
      }

      // Close the database connection
      $conn->close();
    }
    ?>
    
    <div class="date-selection">
      <input type="date" id="date" name="date" min="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d', strtotime('next friday')); ?>" required onchange="enableShowtimes()">
    </div>

  </div>
</body>

</html>
