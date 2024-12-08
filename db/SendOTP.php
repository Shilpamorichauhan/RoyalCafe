<?php
session_start();
include_once("connection.php");

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email from the form
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Check if the email exists in the database (you need to adjust this query)
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "No account found with that email.";
        exit;
    }

    // Generate OTP
    $otp = rand(100000, 999999);  // Generate a 6-digit OTP

    // Store OTP in the session for later verification
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;

    // Send OTP email
    try {
        $mail = new PHPMailer(true);

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'shilpamorichauhan@gmail.com'; // Your email
        $mail->Password = 'deckkkpsjdhyneyt'; // Your email password (use app-specific password if necessary)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email setup
        $mail->setFrom('shilpamorichauhan@gmail.com', 'Royal Cafe');
        $mail->addAddress($email); // Send OTP to the user's email

        $mail->isHTML(true);
        $mail->Subject = 'Your Password Reset OTP - Royal Cafe';
        $mail->Body    = '
            <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                <h2 style="color: #333;">Your OTP for Password Reset</h2>
                <p>Hello,</p>
                <p>You requested a password reset. Please use the following OTP to proceed:</p>
                <h3 style="color: #007bff;">' . $otp . '</h3>
                <p>The OTP is valid for 10 minutes.</p>
                <p>If you did not request this, please ignore this email.</p>
                <p>Thank you, <br>Royal Cafe</p>
            </div>';

        $mail->send();
        echo "OTP sent to your email. Please check your inbox.";
        // Redirect to the page where the user can enter the OTP
        header("Location: ../user/verify_otp.php"); // Adjust the redirect as per your setup
        exit;
    } catch (Exception $e) {
        echo "Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
