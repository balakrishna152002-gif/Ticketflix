<!-- Add And Delete Movie -->
<html>

<head>
    <title>Manage Movies</title>
    <link href="css/bootstrap-grid.css" rel="stylesheet">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <style>
        .container-fluid {
            width: auto;
            padding-top: 3%;
            padding-left: 2%;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                Add Movies
                <hr>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label>Enter Movie Name</label>
                        <input type="text" class="form-control" id="Movie_name" placeholder="Enter Movie Name" name="movie_name" required>
                    </div>
                    <div class="mb-3">
                        <label>Language</label>
                        <input type="text" class="form-control" id="language" placeholder="Enter Movie Language" name="language" required>
                    </div>
                    <div class="mb-3">
                        <label>Duration Hour</label>
                        <input type="text" class="form-control" id="duration_h" placeholder="Enter Duration of film" name="duration_h" required>
                    </div>
                    <div class="mb-3">
                        <label>Duration Min</label>
                        <input type="text" class="form-control" id="duration_m" placeholder="Enter Duration of film" name="duration_m" required>
                    </div>
                    <div class="mb-3">
                        <label>Censor rating</label>
                        <input type="text" class="form-control" id="censor_rating" placeholder="Enter Censor rating" name="censor_rating" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label>Enter Title Photo</label>
                        <input type="file" name="file" class="form-control" id="Movie_photo" accept="image/png, image/gif, image/jpeg" required>
                    </div>
                    <button name="insert" class="btn btn-primary">Submit</button>
                </form>
                <a href="admin.php">
                    <button name="admin" value="Admin Dashboard" class="btn btn-primary">Admin Dashboard</button>
                </a>
            </div>

            <div class="col-lg-6">
                Remove Movies
                <hr>
                <form method="POST">
                    <div class="mb-3 mt-3">
                        <label>Enter Movie Name</label>
                        <input type="text" class="form-control" id="Movie_name1" placeholder="Enter Movie Name" name="movie_name1" required>
                    </div>
                    <button name="delete" class="btn btn-primary">Submit</button>
                </form>
                <br>
                <?php
                include 'db.php';

                if (isset($_POST["delete"])) {
                    $mname = $_POST['movie_name1'];
                    $sql = "SELECT fname FROM movies WHERE name='$mname'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    ?><script>
                        alert("You Are Deleting a Movie")
                    </script>
                    <?php
                    $image = unlink('movies/' . $row['fname']);

                    $delete = $conn->query("DELETE FROM movies WHERE name='$mname'");

                    if ($image && $delete) {
                        echo "Deleted Successfully";
                    } else {
                        echo "Error Deleting";
                    }
                }

               
                if (isset($_POST["insert"]) && !empty($_FILES["file"]["name"])) {
                  $name = $_POST['movie_name'];
                  $duration = $_POST['duration_h'];
                  $duration_m = $_POST['duration_m'];
                  $rating = $_POST['censor_rating'];
                  $language = $_POST['language'];
                  $targetDir = "movies/";
                  $fileName = basename($_FILES["file"]["name"]);
                  $targetFilePath = $targetDir . $fileName;
                  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
  
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        $sql = "SELECT * FROM movies WHERE name='$name'";
                        $result = $conn->query($sql);
                        $rowcount = mysqli_num_rows($result);
                        if ($rowcount > 0) {
                            echo "Movie Already Exists";
                        } else {
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                                $insert = $conn->query("INSERT INTO movies (name, language, duration_h, duration_m, censor_rating, fname) VALUES ('$name', '$language', '$duration', '$duration_m', '$rating', '$fileName')");
                                if ($insert) {
                                    echo "Movie Added Successfully";
                                } else {
                                    echo "Error Adding Movie";
                                }
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    } else {
                        echo 'Sorry, only JPG, JPEG, PNG, and GIF files are allowed to upload.';
                    }
                }
                ?><br>
                <?php
                $sql = "SELECT * FROM movies ORDER BY name DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "Number Of Movies Added: " . $result->num_rows . "<br>";
                    while ($row = $result->fetch_assoc()) {
                        echo $row['name'] . "<br>";
                    }
                } else {
                    echo "<p>No Movies found...</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
