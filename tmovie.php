<?php
session_start();


if (!isset($_SESSION['theatre'])) {
  header("location:Login.php");
  die();
}
?>

<html>

<head>
  <title>Manage Movies</title>

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
    #btn{
      background-color: white;
      color:black;
      transition-duration:0.2s;
    }
    #btn:hover{
      background-color: black;
      color: white;
    }
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
  <!---Remove Movie----->
  <div class="container-fluid">
    <div class="col-lg-6">
      Remove Movies
      <hr>
      <form method="POST">
        <p class="red">CHECK DETAILS CAREFULLY AND ENTER...CHANGES CAN'T BE UNDONE</p>
        <div class="mb-3 mt-3">
          <label>Enter Movie id</label>
          <input type="text" class="form-control" id="Movie name1" placeholder="Enter Movie id" name="id" required>
        </div>
        <div class="mb-3 mt-3">
          <label>Enter Screen Number</label>
          <input type="text" class="form-control" id="Movie name1" placeholder="Enter Screen Number" name="screen" required>
        </div>
        <button name="delete" class="btn btn-primary">Delete</button>
        <a href="admin.php">
          <a>
      </form>
      
<a href="theatre.php">
<button id="btn">Home page</button></a>
<br><br>
      <?php
        echo"Current Movies";
      include 'db.php';
      $mail = $_SESSION['theatre'];
      $sql = "SELECT tid from theatre where email='$mail'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $tid = $row['tid'];

      $sql = "SELECT * from current where tid='$tid'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      /*while ($row = $result->fetch_assoc()) {
                                                                $mid=$row['mid'];
                                                                if ($result->num_rows > 0) {
                                                                  $sql = "select name,release_date from movies where m_id='$mid'";
                                                                  $result = $conn->query($sql);
                                                                  $row = $result->fetch_assoc();
                                                                  $mname = $row['name'];
                                                                  
                                                                  echo"$mname"

                                                              ?><br>
  <?php


                                                                }
                                                              }*/
      foreach ($result as $user) {
        $mid = $user['mid'];
        $screen = $user['screen'];
        $sql = "select *from movies where m_id='$mid'";
        $result = $conn->query($sql);
        $row1 = $result->fetch_assoc();
        $mname = $row1['name'];

        echo "Name : " . $mname . " .. ";
        echo "Id : " . $mid . " .. ";
        echo "Screen : " . $screen . " ";
      ?>
        <br>
        <br><?php
          }
        

if(isset($_POST['delete'])){

  $did=$_POST['id'];
  $dscreen=$_POST['screen'];
  echo$sql="delete from current where mid='$did'and screen='$dscreen'and tid='$tid'";
  $result = $conn->query($sql);
  if($result){
    ?><script>alert("Success")</script><?php
  }
  else{
    ?><script>alert("Fail")</script><?php
  }
}

            ?>
    </div>
  </div>
</body>