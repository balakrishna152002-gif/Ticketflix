<html>

<head>
    <title>Signup</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <style>
        .col-lg-4 {
            background-color: #660000;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .col-lg-8 {
            padding-left: 5%;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
        }

        #message {
            display: none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 20px;
            margin-top: 10px;
        }

        #message p {
            padding: 10px 35px;
            font-size: 18px;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        /* Add a red text color and an "x" when the requirements are wrong */
        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-text {
            color: #fff;
        }

        .btn-primary {
            background-color: #99d6ff;
            color: black;
        }

        #button {
            margin-top: 10px;
        }

        #a {
            color: blue;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        function checkemail() {
            var email = document.getElementById("email").value;

            if (email) {
                $.ajax({
                    type: 'post',
                    url: 'checkdata.php',
                    data: {
                        user_email: email,
                    },
                    success: function(response) {
                        $('#name_status').html(response);
                        if (response == "OK") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                $('#name_status').html("");
                return false;
            }
        }
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <form method="post">
                    <div class="heading">
                        <h2>Signup to Ticketflix</h2>
                    </div>
                    <div class="form-group">
                    <div ng-app="">
                        <label>First Name</label>
                        <input type="text" class="form-control" ng-model="fname" name="fname" pattern="[A-Za-z\s]+" required placeholder="First Name">
                        <h6 style="font-family:monospace;">Hello {{fname}}</h1>
                    </div>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lname" pattern="[A-Za-z\s]+" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label>Phone No:</label>
                        <input type="tel" pattern="[6789][0-9]{9}" class="form-control" name="phone" required placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <label>Enter Email address</label>
                        <input type="email" class="form-control" name="email" id="email" onkeyup="checkemail();" required aria-describedby="emailHelp" placeholder="Enter email">
                        <span id="name_status"></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label><br>
                        <input type="password" id="psw" name="psw" style="width:300px;height:40px;"placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    </div>
                    <div class="form-group">
                        <label>Re-enter Password</label>
                        <input type="password" class="form-control" name="pwd2" required placeholder="Re-enter Password">
                    </div>
                    <button type="submit" name="signup" id="button" class="btn btn-primary">Signup</button>
                    <br><br>
                    <p style="color: white;">Already Have an Account? <a id="a" href="login.php">Signin</a></p>
                </form>
            </div>
            <div class="col-lg-8">
                
                <h3>Password must contain the following:</h3>
                <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                <p id="number" class="invalid">A <b>number</b></p>
                <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                <script>
                    var myInput = document.getElementById("psw");
                    var letter = document.getElementById("letter");
                    var capital = document.getElementById("capital");
                    var number = document.getElementById("number");
                    var length = document.getElementById("length");

                    // When the user clicks on the password field, show the message box
                    myInput.onfocus = function() {
                        document.getElementById("message").style.display = "block";
                    }

                    // When the user clicks outside of the password field, hide the message box
                    myInput.onblur = function() {
                        document.getElementById("message").style.display = "none";
                    }

                    // When the user starts to type something inside the password field
                    myInput.onkeyup = function() {
                        // Validate lowercase letters
                        var lowerCaseLetters = /[a-z]/g;
                        if (myInput.value.match(lowerCaseLetters)) {
                            letter.classList.remove("invalid");
                            letter.classList.add("valid");
                        } else {
                            letter.classList.remove("valid");
                            letter.classList.add("invalid");
                        }

                        // Validate capital letters
                        var upperCaseLetters = /[A-Z]/g;
                        if (myInput.value.match(upperCaseLetters)) {
                            capital.classList.remove("invalid");
                            capital.classList.add("valid");
                        } else {
                            capital.classList.remove("valid");
                            capital.classList.add("invalid");
                        }

                        // Validate numbers
                        var numbers = /[0-9]/g;
                        if (myInput.value.match(numbers)) {
                            number.classList.remove("invalid");
                            number.classList.add("valid");
                        } else {
                            number.classList.remove("valid");
                            number.classList.add("invalid");
                        }

                        // Validate length
                        if (myInput.value.length >= 8) {
                            length.classList.remove("invalid");
                            length.classList.add("valid");
                        } else {
                            length.classList.remove("valid");
                            length.classList.add("invalid");
                        }
                    }
                </script>
                <?php
                
                error_reporting(0);
                include 'db.php';
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $password = $_POST['psw'];
                $password1 = $_POST['pwd2'];
                $a = 3;
                if (isset($_POST['signup'])) {
                    $sql = "SELECT * FROM users WHERE email='$email'";
                    $result = $conn->query($sql);
                    if (mysqli_num_rows($result) == 1) {
                        echo "<br>Email Already Registered";
                        echo "<br><a href='login.php'>Click to Login</a>";
                    } else {
                        if ($password == $password1) {
                            echo "Passwords match";
                            $pwd = md5($password);
                            $sql = "INSERT INTO users (fname, lname, phone, email, password, type) VALUES ('$fname', '$lname', '$phone', '$email', '$pwd', '$a')";
                            $result = $conn->query($sql);
                            if ($result) {
                                echo "<a href='login.php'>Go to Login</a>";
                            } else {
                                echo "Record Not Inserted";
                            }
                        } else {
                            echo "Password Mismatched";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
