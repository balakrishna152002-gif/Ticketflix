<?php include('db.php');
session_start();

if (isset($_SESSION['username'])) {
    header("location:home.php");
    die();
}
if (isset($_SESSION['plususername'])) {
    header("location:plushome.php");
    die();
}
?>

<html>

<head>
    <title>Login</title>
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
        .col-lg-4 {
            background-color: #660000;
            color: white;
            height: 90%;
            padding-top: 14%;
            padding-bottom: 12.7%;
        }

        #a {
            color: #2e2eb8;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class=col-lg-8>

                <?php
                if (isset($_POST['login'])) {
                    include 'db.php';
                    $email = $_POST['email'];
                    $pwd = $_POST['password'];
                    $pass = md5($pwd);
                    $sql = "select * from users where email='$email' and password='$pass'";
                    $result = $conn->query($sql);
                    if (mysqli_num_rows($result) == 1) {
                        $row = $result->fetch_assoc();

                        if ($row['type'] == 1) {

                            $_SESSION['admin'] = $email;
                            header("location: admin.php");
                        }
                        if ($row['type'] == 3) {

                            $_SESSION['username'] = $email;
                            header("location: home.php");
                        }

                        if ($row['type'] == 3 and $row['plus'] == 1) {

                            $_SESSION['plususername'] = $email;
                            header("location: plushome.php");
                        }

                        if ($row['type'] == 2) {

                            $_SESSION['theatre'] = $email;
                            header("location: theatre.php");
                        }
                    } else {
                        echo "Wrong username./password combination";
                    }
                }


                ?>

            </div>
            <div class="col-lg-4">
                <form method="post">


                    <div class="heading">
                        <h2 style="font-family:Serif;">Login Ticketflix</h2>
                    </div><br>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" required aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text">We'll never share your email or password with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="Password">
                    </div>
                    <div class="form-check">
                        <br>
                    </div>
                    <button type="submit" name="login" style="background-color:#99d6ff;color:black;" class="btn btn-primary">Login</button><br><br>
                    Not Having Account ? <a id="a" href="signup.php">Signup</a>

                </form>

            </div>
        </div>
    </div>
</body>

</html>