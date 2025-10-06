<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header("location:Login.php");
    die();
}


?>

<html>

<head>
    <title>Admin Pannel</title>
    <link href="css\bootstrap-grid.css  " rel="stylesheet">
    <link href="css\bootstrap-grid.min.css" rel="stylesheet">
    <link href="css\bootstrap.css" rel="stylesheet">
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <style>
        * {
            width: auto;
            padding-top: 0.5%;
            padding-left: 0.4%;
        }

        .col-lg-9 {
            width: auto;
            padding-left: 7%;
        }

        .col-lg-12 {
            width: auto;
            height: 100%;
            background-color: whitesmoke;
        }

        .dot {
            height: 10px;
            width: 10px;
            background-color: #28a4a9;
            border-radius: 50%;
            display: inline-block;
        }

        #cs {
            color: green;
            border: #28a4a9;
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
            margin-left: 90px;
        }

        .profile-dropdown .profile-button {
            background-color: #4f67ea;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
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
    </style>
    <script src="js\bootstrap.bundle.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\bootstrap.min.js"></script>
    <script src="js\bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <h1>Manage Movies</h1>
                <hr>
                <a href="managemovies.php">
                    <button type="button" class="btn btn-success">Add Or Delete Movie</button></a>
                <br><br>


                <?php
                include 'db.php';




                //movies left
                $sql = "SELECT * FROM movies where 	coming_soon='' ORDER BY name DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "Number Of Movies Added :" . $result->num_rows; ?><br><?php
                                                                                while ($row = $result->fetch_assoc()) {
                                                                                    $sql = "select name,release_date from movies";
                                                                                    $mname = $row['name'];
                                                                                    $imageURL = 'movies/' . $row['fname'];



                                                                                    $mname = $row['name'];
                                                                                    echo $mname;
                                                                                ?><br>
                        <img style="height: 270px;" src="<?php echo $imageURL; ?>" alt=""><br><br>





                    <?php


                                                                                }
                                                                            } else { ?>
                    <p>No Movies found...</p>
                <?php
                                                                            }

                ?>

                <!--theatre--->
            </div>

            <div class="col-lg-7">

                <h1>Manage Theatre</h1>
                <div class="col-lg-12" id="main-div">

                    <a href="managetheatre.php">
                        <button type="button" class="btn btn-info" style="padding-top:1%;">Add Or Delete theatre</button></a><br><br>
                    <hr>

                    <h1>Raise a Requests</h1>
                    <form method="post">
                        <input type="number" id="nore" name="nore" placeholder="Enter Request Number"><br><br>
                        <input type="text" id="ch" name="ch" placeholder="Enter Request Heading"><br><br>
                        <input type="text" id="re" name="re" placeholder="Enter Request"><br><br>
                        <label for="theatre">Theatre:</label>
                        <input type="checkbox" id="theatre" name="theatre" value="1"><br>
                        <label for="plus">Plus:</label>
                        <input type="checkbox" id="plus" name="plus" value="1"><br>
                        <label for="user">User:</label>
                        <input type="checkbox" id="user" name="user" value="1"><br><br>
                        <input type="submit" name="rebtn" value="POST" class="btn btn-info">
                    </form>

                    <?php
                    include "db.php";
                    if (isset($_POST['rebtn'])) {

                        $renum = $_POST['nore'];
                        $recontent = $_POST['ch'];
                        $request = $_POST['re'];

                        $theatre_checked = isset($_POST['theatre']) ? $_POST['theatre'] : 0;
                        $user_checked = isset($_POST['user']) ? $_POST['user'] : 0;
                        $plus_checked = isset($_POST['plus']) ? $_POST['plus'] : 0;

                        $sql = "SELECT * FROM notes WHERE heading='$recontent'";
                        $result = $conn->query($sql);

                        if (mysqli_num_rows($result) > 0) {
                            echo "Similar Request Already Inserted";
                        } else {
                            $sql = "INSERT INTO notes (id, heading, Note, theatre,plus, user) VALUES ('$renum', '$recontent', '$request', '$theatre_checked', '$plus_checked','$user_checked')";
                            $result = $conn->query($sql);
                            echo "Insertion Successful";
                        }
                    }
                    ?>
                    <br><br>
                    Delete A Request
                    <hr>
                    <form method="post">
                        <input type="text" id="cs" name="dreid" placeholder="Enter Request Number to Delete "><br><br>
                        <input type="submit" value="delete" name="redbtn" class="btn btn-danger">
                    </form><?php
                            $sql = "SELECT * FROM notes";
                            $result = $conn->query($sql);
                            ?>

                    <h1>Requests</h1>

                    <?php
                    if ($result->num_rows > 0) {
                        echo "<table>
                                   <tr>
                                    <th>Id</th>
                                     <th>Heading</th>
                                     <th>Content</th>
                                   </tr>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $row['id'] . "</td>
                                     <td>" . $row['heading'] . "</td>
                                     <td>" . $row['Note'] . "</td>
                                   </tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "<p>No Requests found.</p>";
                    }


                    if (isset($_POST['redbtn'])) {
                        $deleteid = $_POST['dreid'];
                        $sql = "delete from notes where id='$deleteid'";
                        $result = $conn->query($sql);
                        echo "Deletion Succesful";
                    }

                    ?> </table>

                </div>

            </div>
            <div class="col-lg-2">
                <div class="profile-dropdown">
                    <button class="profile-button">MORE</button>
                    <div class="profile-dropdown-content">
                        <a href="bookings.php">View Bookings</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12">
                    Add to Coming soon list
                    <hr>
                    <form method="post">
                        <input type="text" id="cs" name="cs" placeholder="Enter Name to Enter "><br><br>
                        <input type="submit" name="csbtn" class="btn btn-info">
                    </form>
                    <?php
                    include "db.php";
                    if (isset($_POST['csbtn'])) {
                        $csname = $_POST['cs'];
                        $sql = "select*from movies where name='$csname'";
                        $result = $conn->query($sql);
                        if (mysqli_num_rows($result) == 1) {
                            echo "Same Movie Already Inserted";
                        } else {
                            $sql = "insert into movies(name,coming_soon)values('$csname','1')";
                            $result = $conn->query($sql);
                            echo "Insertion Succesful";
                        }
                    }
                    ?>
                    Delete from list
                    <hr>
                    <form method="post">
                        <input type="text" id="cs" name="csd" placeholder="Enter Name to Delete "><br><br>
                        <input type="submit" value="delete" name="csdbtn" class="btn btn-danger">
                    </form>
                    <table>
                        <tr>
                            <th>Name</th>
                        </tr>
                        <tr>
                            <?php
                            include "db.php";
                            $sql = "select*from movies where coming_soon='1'";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                            ?><td><?php echo ' <div class="dot"></div> ' . $row['name']; ?>
                                <td>
                        </tr>
                        <tr></tr><?php
                                }
                                if (isset($_POST['csdbtn'])) {
                                    $csdname = $_POST['csd'];

                                    $sql = "delete from movies where name='$csdname'";
                                    $result = $conn->query($sql);
                                    echo "Deletion Succesful";
                                }

                                    ?>

                    </table>
                </div>
            </div>
        </div>
</body>

</html>