<?php
session_start();
include_once("connection.php");

$username = $_SESSION['email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Setup SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // Gmail SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'shivayfurniture9@gmail.com';   // Your Gmail address
    $mail->Password   = 'bnky aurf qusv fmjy';           // Your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port       = 587;  // Port 587 for TLS encryption

    // Sender and recipient details
    $mail->setFrom('shivayfurniture9@gmail.com', 'Shivay Furniture');
    $mail->addAddress($username, "");  // Assuming $username is the email address
    $mail->addReplyTo('shivayfurniture9@gmail.com', 'Information');
    $mail->addCC('shivayfurniture9@gmail.com');
    $mail->addBCC('shivayfurniture9@gmail.com');

    // Get product details from POST request
    $productName = $_POST['productName'] ?? '';
    $quantity = $_POST['NumOfOrder'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $totalPrice = $price * $quantity;
    $address = $_POST['address'] ?? '';
    $paymentMethod = $_POST['paymentMethod'] ?? '';

    // Content - HTML body of the email
    $mail->isHTML(true);
    $mail->Subject = 'Your Order Confirmation - ROYAL CAFE';
    $mail->Body = '
    <div style="background-color: #f0f8ff; padding: 20px; font-family: Arial, sans-serif;">
        <img src="https://example.com/logo.jpg" alt="Logo" style="display: block; margin: 0 auto 20px; height:10%;width:15%;">
        <h1 style="color: #333; text-align: center;">ROYAL CAFE <br> Order Confirmation</h1>
        <p><b>Thank you for your order!</b><br>We have received your order and are processing it. Here are the details:</p>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><strong>Product Name</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($productName) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><strong>Quantity</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($quantity) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><strong>Price per Item</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">&#8377;' . htmlspecialchars($price) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><strong>Total Price</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">&#8377;' . htmlspecialchars($totalPrice) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><strong>Delivery Address</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($address) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><strong>Payment Method</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">' . ucfirst(htmlspecialchars($paymentMethod)) . '</td>
            </tr>
        </table>
        <p style="margin-top: 20px;">Your order will be processed soon, and you will be notified once it is shipped.</p>
        <p style="margin-top: 20px;color:red;">IF YOUR ADDRESS IS INCORRECT MULTIPLE TIMES, YOUR ACCOUNT MAY BE DELETED PERMANENTLY.</p>
    </div>';

    // Plain text version for email clients that do not support HTML
    $mail->AltBody = 'Thank you for your order. Below are your order details: Product: ' . $productName . ', Quantity: ' . $quantity . ', Total: &#8377;' . $totalPrice . '.';

    // Send the email
    $mail->send();

    // Redirect or show success message
    echo "<script>
            alert('Order confirmation sent successfully.');
            window.location.href = '../user';  // Adjust to the appropriate page
          </script>";

} catch (Exception $e) {
    // Error handling
    echo "<script>
            alert('Error occurred while sending the email: " . $e->getMessage() . "');
            window.location.href = '../user';  // Redirect to the appropriate page
          </script>";
}
?>
