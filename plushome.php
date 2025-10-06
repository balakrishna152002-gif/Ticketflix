<?php
session_start();

if (!isset($_SESSION['plususername'])) {
    header("location: home.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Ticketflix Plus - Home</title>

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

        .ticketflix-plus-banner {
            background-color: #f00;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .ticketflix-plus-banner h2 {
            margin-bottom: 5px;
        }

        .ticketflix-plus-banner p {
            margin-bottom: 0;
        }

        .ticketflix-plus-banner a {
            color: #fff;
            text-decoration: underline;
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
            margin-left: 800px;
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

        .movies {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
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

        .dot {
            height: 10px;
            width: 10px;
            background-color: #28a4a9;
            border-radius: 50%;
            display: inline-block;
        }

        /* Additional styles for Ticketflix Plus members */
        .ticketflix-plus .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .ticketflix-plus h1 {
            color: #f00;
            text-align: center;
        }

        .ticketflix-plus .movies {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .ticketflix-plus .movie-item {
            background-color: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .ticketflix-plus .buttons button {
            background-color: #f00;
        }

        .ticketflix-plus .buttons button:hover {
            background-color: #c00;
        }

        .ticketflix-plus-banner {
            background-color: #ff531a;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .location-select-container {
            position: relative;
        }

        .location-select-container select {
            width: 100%;
            padding: 12px 40px 12px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            appearance: none;
            background-color: transparent;
        }

        .location-select-container select:focus {
            outline: none;
            border-color: #007bff;
        }

        /* Style the option dropdown items */
        .location-select-container select option {
            padding: 10px;
            background-color: #fff;
            color: #333;
        }

        .coming-soon-box {
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            width: 800px;
            height: 40px;
        }

        .coming-soon-box marquee {
            font-size: 15px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="ticketflix-plus-banner">
        <h2>Welcome to Ticketflix Plus</h2>
        <p>Enjoy exclusive benefits and premium content!</p>
    </div>

    <div class="container">
        <div class="profile-dropdown">
            <button class="profile-button">Profile</button>
            <div class="profile-dropdown-content">
                <a href="profile.php">View Profile</a>
                <a href="plus.php">De-Activate T-Plus</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="tab-content active" id="homeTab">
            <form>
                <br>
                <div class="location-select-container">
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

                        $sql = "SELECT tcity FROM theatre ORDER BY tcity ASC;";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            $loc = $row['tcity'];
                            echo "<option>$loc</option>";
                        }
                        ?>
                    </select>
            </form>

            <div class="movies" id="moviesContainer">
                <div class="coming-soon-box">
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
            <br>
            <div class="marquee">
                <marquee direction="up" scrollamount="2">
                    <?php
                    echo "<table style='border-collapse: collapse; width: 100%;height:25%'>
    <tr style='background-color: #f2f2f2;'>
      <th style='padding: 10px; border: 1px solid #ddd;'>Heading</th>
      <th style='padding: 10px; border: 1px solid #ddd;'>Content</th>
    </tr>";
                    include "db.php";
                    $sql = "SELECT * FROM notes where plus=1";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='border: 1px solid #ddd;'>
        <td style='padding: 10px;'>" . $row['heading'] . "</td>
        <td style='padding: 10px;'>" . $row['Note'] . "</td>
      </tr>";
                    }

                    echo "
  </table>";
                    ?>
                </marquee>
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
                                url: 'fetch_movies.php',
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