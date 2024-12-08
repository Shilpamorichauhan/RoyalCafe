<?php
session_start();
include_once("connection.php");

if (!isset($_POST['name'], $_POST['quantity'], $_POST['price'], $_POST['address'], $_POST['paymentMethod'])) {
    die('Error: Missing order details.');
}

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

$username = $_SESSION['email'];

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  
    $mail->SMTPAuth   = true;
    $mail->Username   = "shilpamorichauhan@gmail.com";   // Your email address
    $mail->Password   = "deckkkpsjdhyneyt";   // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Set up the email sender and recipient
    $mail->setFrom("shilpamorichauhan@gmail.com", 'Royal Cafe');
    $mail->addAddress($username);  // Send confirmation to the user
    $mail->addReplyTo("shilpamorichauhan@gmail.com", 'Information');
    
    // Get the order details from the POST data
    $productName = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $totalPrice = $price * $quantity;
    $address = $_POST['address'];
    $paymentMethod = $_POST['paymentMethod'];

    // Set up the email content
    $mail->isHTML(true);
    $mail->Subject = 'Your Order Confirmation - ROYAL CAFE';
    $mail->Body    = '
    <div style="background-color: #f0f8ff; padding: 20px; font-family: Arial, sans-serif;">
        <h1 style="text-align: center;">ROYAL CAFE - Order Confirmation</h1>
        <p><b>Thank you for your order!</b><br>We have received your order. Here are the details:</p>
        <table style="width: 100%; border-collapse: collapse;">
            <tr><td><strong>Product Name:</strong></td><td>' . htmlspecialchars($productName) . '</td></tr>
            <tr><td><strong>Quantity:</strong></td><td>' . htmlspecialchars($quantity) . '</td></tr>
            <tr><td><strong>Price per Item:</strong></td><td>&#8377;' . htmlspecialchars($price) . '</td></tr>
            <tr><td><strong>Total Price:</strong></td><td>&#8377;' . htmlspecialchars($totalPrice) . '</td></tr>
            <tr><td><strong>Delivery Address:</strong></td><td>' . htmlspecialchars($address) . '</td></tr>
            <tr><td><strong>Payment Method:</strong></td><td>' . ucfirst(htmlspecialchars($paymentMethod)) . '</td></tr>
        </table>
        <p>We are processing your order and will notify you once it is shipped.</p>
        <p style="color: red;">Please ensure your address is correct to avoid delivery issues.</p>
    </div>';

    $mail->send();

    header("Location:../user/index.php#menu");

} catch (Exception $e) {
    echo "Error: " . $mail->ErrorInfo;
}
?>
