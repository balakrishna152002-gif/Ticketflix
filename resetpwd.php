<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'path/to/PHPMailer-master/src/PHPMailerAutoload.php';


// Initialize variables
$name = "";
$email = "";
$message = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com';
        $mail->Password = 'your_email_password';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient details
        $mail->setFrom($email, $name);
        $mail->addAddress('recipient@example.com', 'Recipient Name');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Submission';
        $mail->Body = "<h3>Contact Form Submission</h3>
                       <p><strong>Name:</strong> $name</p>
                       <p><strong>Email:</strong> $email</p>
                       <p><strong>Message:</strong> $message</p>";

        // Send the email
        $mail->send();

        // Set success message
        $successMessage = 'Thank you for your message! We will get back to you soon.';
    } catch (Exception $e) {
        // Set error message
        $errorMessage = 'Error sending email: ' . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Form</h1>

    <?php if (!empty($errorMessage)) : ?>
        <div style="color: red;"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <?php if (!empty($successMessage)) : ?>
        <div style="color: green;"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $name; ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>
        <br>
        <label for="message">Message:</label>
        <textarea name="message" required><?php echo $message; ?></textarea>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
