<!DOCTYPE html>
<html>

<head>
    <title>Movie Showtimes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-top: 20px;
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #FFA07A;
            color: #fff;
        }

        td {
            background-color: #f0f0f0;
        }

        .profile-dropdown {
            float: right;
            position: relative;
        }

        .profile-button {
            background-color: #FFA07A;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0;
            top: 40px;
        }

        .profile-dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .profile-dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-dropdown">
            <button class="profile-button">Profile</button>
            <div class="profile-dropdown-content">
                <a href="theatre.php">Home</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <?php
        include 'db.php';
        session_start();
        if (!isset($_SESSION['theatre'])) {
            header("location:login.php");
        }
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
</body>
</html>