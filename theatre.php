<?php
session_start();


if (!isset($_SESSION['theatre'])) {
    header("location:Login.php");
    die();
}
?>
<html lang="en">
<span class="tid"><?php
                    include('db.php');
                    $email = $_SESSION['theatre'];
                    $sql = "SELECT * FROM theatre WHERE email = '$email'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $tid = $row['tid']; ?></span>
<span class="php"><?php
                    if (isset($_POST['insert'])) {
                        $check1 = isset($_POST['check1']) ? 1 : 0;
                        $check2 = isset($_POST['check2']) ? 1 : 0;
                        $check3 = isset($_POST['check3']) ? 1 : 0;
                        $check4 = isset($_POST['check4']) ? 1 : 0;
                        $mid = $_POST['movie_id'];
                        $screen = $_POST['screen'];

                        // Check if the movie is already added to the current list
                        $sql = "SELECT * FROM current WHERE tid = '$tid' AND screen = '$screen'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();

                        if ($row) {
                            if ($mid == $row['mid']) {
                                if ($screen == $row['screen']) {
                                    $morning = $row['morning'];
                                    $noon = $row['noon'];
                                    $first = $row['first'];
                                    $seccond = $row['seccond'];

                                    if ($check1 == 1) {
                                        if ($morning == 1) {
                                            echo "Morning Show Full At Screen " . $row['screen'] . "<br>";
                                        } else {
                                            $a = 1;
                                            $sql = "UPDATE current SET morning = '$a' WHERE tid = '$tid' AND screen = '$screen' AND mid = '$mid'";
                                            $conn->query($sql);
                                        }
                                    }

                                    if ($check2 == 1) {
                                        if ($noon == 1) {
                                            echo "Noon Show Full At Screen " . $row['screen'] . "<br>";
                                        } else {
                                            $a = 1;
                                            $sql = "UPDATE current SET noon = '$a' WHERE tid = '$tid' AND screen = '$screen' AND mid = '$mid'";
                                            $conn->query($sql);
                                        }
                                    }

                                    if ($check3 == 1) {
                                        if ($first == 1) {
                                            echo "First Show Full At Screen " . $row['screen'] . "<br>";
                                        } else {
                                            $a = 1;
                                            $sql = "UPDATE current SET first = '$a' WHERE tid = '$tid' AND screen = '$screen' AND mid = '$mid'";
                                            $conn->query($sql);
                                        }
                                    }

                                    if ($check4 == 1) {
                                        if ($seccond == 1) {
                                            echo "Second Show Full At Screen " . $row['screen'] . "<br>";
                                        } else {
                                            $a = 1;
                                            $sql = "UPDATE current SET seccond = '$a' WHERE tid = '$tid' AND screen = '$screen' AND mid = '$mid'";
                                            $conn->query($sql);
                                        }
                                    }
                                }
                            } else {
                                $sql = "INSERT INTO current (mid, tid, screen, morning, noon, first, seccond) VALUES ('$mid', '$tid', '$screen', '$check1', '$check2', '$check3', '$check4')";
                                $conn->query($sql);
                                header("location:theatre.php");
                            }
                        } else {
                            // Insert the movie into the current list
                            $sql = "INSERT INTO current (mid, tid, screen, morning, noon, first, seccond) VALUES ('$mid', '$tid', '$screen', '$check1', '$check2', '$check3', '$check4')";
                            $conn->query($sql);
                            header("location:theatre.php");
                        }
                    }
                    ?>
</span>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Theatre</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #FDF6F0;
            /* Peach background color */
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #b30059;
            /* Light Coral header background color */
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        /* Movie List styles */
        .movie-list {
            flex: 0 0 30%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .movie-list h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .movie {
            margin-bottom: 20px;
        }

        .movie img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .movie h3 {
            font-size: 1.2rem;
            margin: 0;
        }

        .movie p {
            margin: 0;
        }

        /* Add Movie Form styles */
        .add-movie-form {
            flex: 0 0 60%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .add-movie-form h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-check-label {
            font-weight: normal;
        }

        .colored-button {
            background-color: #602040;
            /* Light Coral button background color */
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .colored-button:hover {
            background-color: #FF6347;
            /* Tomato color on hover */
        }

        /* Current Movies styles */
        .current-movies {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .current-movies h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .current-movies p {
            margin-bottom: 10px;
        }

        /* Profile Dropdown styles */
        .profile-dropdown.active .profile-dropdown-content {
            display: block;
        }

        .profile-dropdown {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .profile-button {
            background-color: #FFA07A;
            /* Light Coral button background color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .profile-button:hover {
            background-color: #FF6347;
            /* Tomato color on hover */
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
            color: #000;
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
        .marquee{
            /* padding-top: 20px; */
            margin-top: 20px;
            background-color:#602040 ;
        }
    </style>
    </style>
    <script>
        // JavaScript code to toggle the dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdown = document.querySelector('.profile-dropdown');
            const dropdownContent = document.querySelector('.profile-dropdown-content');

            profileDropdown.addEventListener('click', function() {
                dropdownContent.classList.toggle('active');
            });
        });
    </script>
</head>

<body>
    <header>
        <h1>Welcome to Your Theatre Management</h1>
    </header>
    <div class="container">
        <div class="movie-list">
            <h2>Available Movies</h2>
            <?php
            include "db.php";
            $sql = "SELECT * FROM movies WHERE coming_soon = '0'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $mname = $row['name'];
                    $mid = $row['m_id'];
                    $imageURL = 'movies/' . $row['fname'];
            ?>
                    <div class="movie">
                        <img src="<?php echo $imageURL; ?>" alt="<?php echo $mname; ?>">
                        <h3><?php echo $mname; ?></h3>
                        <p>Language: <?php echo $row['language']; ?></p>
                        <p>ID: <?php echo $mid; ?></p>
                        <p>Duration: <?php echo $row['duration_h'] . "h " . $row['duration_m'] . "m"; ?></p>
                    </div>
            <?php
                }
            } else {
                echo "<p>No Movies found...</p>";
            }
            ?>
        </div>

        <div class="add-movie-form">
            <h2>Add Movies</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="movie-select">Select a Movie</label>
                    <select class="form-control" id="movie-select" name="movie_id">
                        <?php
                        include "db.php";
                        $sql = "SELECT * FROM movies WHERE coming_soon = '0'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $mname = $row['name'];
                                $mid = $row['m_id'];
                                echo '<option value="' . $mid . '">' . $mname . '</option>';
                            }
                        } else {
                            echo "<option value=''>No Movies found...</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="screen">Screen No:</label>
                    <input type="text" class="form-control" id="screen" name="screen" placeholder="Screen No">
                </div>
                <input type="hidden" name="tid" value="<?php echo $tid; ?>">
                <div class="form-group">
                    <label>Show Timings</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="morning" name="check1" value="option1">
                        <label class="form-check-label" for="morning">Morning (11:30 AM)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="noon" name="check2" value="option2">
                        <label class="form-check-label" for="noon">Noon (2:30 PM)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="first" name="check3" value="option3">
                        <label class="form-check-label" for="first">First (5:30 PM)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="second" name="check4" value="option4">
                        <label class="form-check-label" for="second">Second (8:30 PM)</label>
                    </div>
                </div>
                <button type="submit" name="insert" class="colored-button">Add Movie</button>
            </form>
            <br>
            <br>
            <div class="marquee">
      <marquee direction="up" scrollamount="3">
        <?php
        echo "<table style='border-collapse: collapse; color:white; width: 100%;height:25%'>
    <tr style='background-color: #f2f2f2;'>
      <th style='color:black;padding: 10px; border: 1px solid #ddd;'>Heading</th>
      <th style='color:black;padding: 10px; border: 1px solid #ddd;'>Content</th>
    </tr>";
        include "db.php";
        $sql = "SELECT * FROM notes where theatre=1";
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
            <div class="current-movies" style="margin-top:50px;">
                <h2>Current Movies</h2>
                <?php

                $email = $_SESSION['theatre'];
                $sql = "SELECT * FROM theatre WHERE email = '$email'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $tid = $row['tid'];

                $sql = "SELECT * FROM current WHERE tid = '$tid'";
                $result = $conn->query($sql);

                while ($ro = mysqli_fetch_assoc($result)) {
                    $screen = $ro['screen'];
                    $mid = $ro['mid'];
                    $sql = "SELECT * FROM movies WHERE m_id = '$mid'";
                    $movie_result = $conn->query($sql);
                    $re = mysqli_fetch_assoc($movie_result);
                    $movie = $re['name'];
                    $morning = $ro['morning'];
                    $noon = $ro['noon'];
                    $first = $ro['first'];
                    $second = $ro['seccond'];
                ?>
                    <h1>Movie Showtimes for <?php echo $movie; ?> (Screen <?php echo $screen; ?>)</h1>
                    <table border="1">
                        <tr>
                            <th>Morning</th>
                            <th>Noon</th>
                            <th>First</th>
                            <th>Second</th>
                        </tr>
                        <tr>
                            <td><?php echo $morning == 1 ? '✔' : '✘'; ?></td>
                            <td><?php echo $noon == 1 ? '✔' : '✘'; ?></td>
                            <td><?php echo $first == 1 ? '✔' : '✘'; ?></td>
                            <td><?php echo $second == 1 ? '✔' : '✘'; ?></td>
                        </tr>
                    </table>
                <?php
                }
                ?>
              
            </div>
        </div>
    </div>

    <div class="profile-dropdown">
        <button class="profile-button">MORE</button>
        <div class="profile-dropdown-content">
            <a href="tbookings.php">View Bookings</a>
            <a href="currentmovies.php">View Current Movies</a>
            <a href="tmovie.php">Delete Current Movies</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>

</html>