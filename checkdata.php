<?php

$servername="localhost";
$username="root";
$password="";
$dbname="ticketflix";
$conn= new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    echo "Error connecting to server";
}

if(isset($_POST['user_email']))
{
 $emailId=$_POST['user_email'];

 $checkdata=" SELECT email FROM users WHERE email='$emailId' ";

  $result = $conn->query($checkdata);

 if($result->num_rows > 0)
 {
  echo "Email Already Exist";
 }
 else
 {
}

}
?>