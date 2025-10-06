<!-- Add And Delete Movie-->
<html>

<head>
    <title>Manage Theatre</title>

    <link href="css\bootstrap-grid.css  " rel="stylesheet">
    <link href="css\bootstrap-grid.min.css" rel="stylesheet">
    <link href="css\bootstrap.css" rel="stylesheet">
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js\bootstrap.bundle.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\bootstrap.min.js"></script>
    <script src="js\bootstrap.bundle.min.js"></script>

    <style>
        .container-fluid {
            width: auto;
            padding-top: 3%;
            padding-left: 2%;
        }

        .red {
            color: red;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                Add Theatre
                <hr>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label>Enter Email</label>
                        <input type="email" class="form-control" placeholder="Enter Email to update as Theatre" name="email" required>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3 mt-3">
                            <label>Enter Theatre Name</label>
                            <input type="text" class="form-control" id="Movie name" placeholder="Enter Theatre Name" name="theatre_name" required>
                        </div>
                        <div class="mb-3">
                            <label>city</label>
                            <input type="varchar" class="form-control" placeholder="Enter city" name="city" required>
                        </div>

                        <div class="mb-3">
                            <label>location</label>
                            <input type="varchar" class="form-control" placeholder="Enter Location" name="location" required>
                        </div>


                        <div class="mb-3">
                            <label>No of Screens</label>
                            <input type="number" class="form-control" placeholder="Enter No of screens" name="screens" required>
                        </div>




                        <button name="insert" class="btn btn-primary">Insert Theatre</button>
                    </form>
                    <a href="admin.php">
                        <button name="admin" value="Admin Dashboard" class="btn btn-primary">Admin Dashboard</button><a>

            </div>
            <div class="col-lg-6">
                <h1>Delete A Theatre</h1>
                <hr>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <p class="red">CHECK DETAILS CAREFULLY AND ENTER</p>
                        <label>Enter Name of Theatre</label>
                        <input type="text" class="form-control" placeholder="Enter Name to Delete" name="tname" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label>Enter Email Of Theatre</label>
                        <input type="email" class="form-control" placeholder="Enter Email to update" name="demail" required>
                    </div>

                    <button name="delete" class="btn btn-primary">Delete Theatre</button>

                    <br>

                    <h1> Added Theatres</h1>
                    <table class="table table-light">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>City</th>
                        <th>No. of screens</th>
                        <tr>
                            <?php
                            include 'db.php';
                            $sql = "select*from theatre";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {

                            while($row = $result->fetch_assoc()){
                            
                                
                            ?>  
                                    <td><?php echo $row['tname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['tlocation']; ?></td>
                                    <td><?php echo $row['tcity']; ?></td>
                                    <td><?php echo $row['screens'];?></td><br>
                        </tr><?php }}?>
                    </table> 
                   
                    
           
                </div>
        </div>
    </div>
</body>

</html>
<?php
error_reporting(0);
include 'db.php';
$email = $_POST['email'];
$tname = $_POST['theatre_name'];
$city = $_POST['city'];
$location = $_POST['location'];
$screens = $_POST['screens'];
$name = $_POST['tname'];
$email1 = $_POST['demail'];
$a = 2;
$b = 3;
$i = 0;
if (isset($_POST['delete'])) {
    $sql = "delete from theatre where tname='$name' and email='$email1'";
    $result = $conn->query($sql);
    $sql = "update users set type='$b' where email='$email1'";
    $result = $conn->query($sql);
}
if (isset($_POST['insert'])) {
    $sql = "select*from theatre where tname='$tname'";
    $result = $conn->query($sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "Theatre Already Regestered";
        } else {

            $sql = "insert into theatre(email,tname,tcity,tlocation,screens)values('$email','$tname','$city','$location','$screens')";
            $result = $conn->query($sql);
            
        }

        if ($result) {

            $sql = "update users set type=$a WHERE email='$email'";
            $result = $conn->query($sql);
?>
            <script>
                alert("Record Added");
            </script>
<?php
            header("#");
        }
    }
} else {
    echo "Failed to update";
}


?>