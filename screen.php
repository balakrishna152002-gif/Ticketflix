<?php
include 'db.php';
session_start();


if (!isset($_SESSION['theatre'])) {
    header("location:Login.php");
    die();
}
?>

<html>

<head>
    <title>Theatre login</title>
    <link href="css\bootstrap-grid.css  " rel="stylesheet">
    <link href="css\bootstrap-grid.min.css" rel="stylesheet">
    <link href="css\bootstrap.css" rel="stylesheet">
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js\bootstrap.bundle.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\bootstrap.min.js"></script>
    <script src="js\bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-4">

                <form method="POST" enctype="multipart/form-data">

                        <?php
                        include "db.php";
                        if (isset($_POST['insert'])) {
                            $screen = $_POST['screen'];
                            $mail = $_SESSION['theatre'];
                            $sql = "select*from theatre where email='$mail'";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $tid = $row['tid'];
                            $sql = "select tid from theatre where email='$mail'";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $tid = $row['tid'];
                            $sql = "select*from current where tid='$tid'";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $cscreen = $row['screen'];
                            if ($screen == $cscreen) {
                                $morning = $row['morning'];
                                $noon = $row['noon'];
                                $first = $row['first'];
                                $seccond = $row['seccond'];
                                $a = 1;
                                if ($morning != $a) { ?>
                                    <div class="mb-3">
                                        <label> Show Timings</label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="check1" value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1">11:30</label>
                                        </div><?php
                                            }
                                            if ($noon != $a) {
                                                ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="check2" value="option2">
                                            <label class="form-check-label" for="inlineCheckbox2">2.30</label>
                                        </div><?php

                                            }
                                            if ($first != $a) { ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="check3" value="option3">
                                            <label class="form-check-label" for="inlineCheckbox3">5.30</label>
                                        </div><?php
                                            }
                                            if ($seccond != $a) { ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="check4" value="option3">
                                            <label class="form-check-label" for="inlineCheckbox3">8.30</label>
                                        </div><?php
                                            }
                                        } 
                                    
                                        $name = $_POST['movie_name'];
                                        $sql = "select m_id from movies where name='$name'";
                                        $result = $conn->query($sql);
                                        $row = $result->fetch_assoc();
                                        $mid = $row['m_id'];
                                        $mail = $_SESSION['theatre'];
                                        $sql = "select*from theatre where email='$mail'";
                                        $result = $conn->query($sql);
                                        $row = $result->fetch_assoc();
                                        $tid = $row['tid'];
                                        $sql = "select * from current where tid='$tid'or mid='$mid'and screen='$screen'";
                                        $result = $conn->query($sql);
                                        $check1 = 0;
                                        $check2 = 0;
                                        $check3 = 0;
                                        $check4 = 0;
                                        if (isset($_POST['check1'])) {
                                            $check1 = 1;
                                        }
                                        if (isset($_POST['check2'])) {
                                            $check2 = 1;
                                        }
                                        if (isset($_POST['check3'])) {
                                            $check3 = 1;
                                        }
                                        if (isset($_POST['check4'])) {
                                            $check4 = 1;
                                        }
                                        else{
                                        if(isset($_POST['sub'])){
                                        $sql = "insert into current(mid,tid,screen,trelease,morning,noon,first,seccond)values('$mid','$tid','$screen','$release','$check1','$check2','$check3','$check4')";
                                        $result = $conn->query($sql);
                                        if ($result) {
                                            echo "Success";
                                        } else {
                                            echo "failed";
                                        }
                                    }
                                    }
                                    }

                                            ?>
                        <div class="mb-3">
                            <label> Release Planning</label>
                            <input type="date" class="form-control" id="release" required placeholder="When Is release planned" name="release_date">
                        </div>

                        <button name="sub" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>