<?php
session_start();

// Get order details from the session
if (isset($_SESSION['orderDetails'])) {
    $orderDetails = $_SESSION['orderDetails'];
    echo "<h2>Order Confirmation</h2>";
    echo "Product Name: " . $orderDetails['productName'] . "<br>";
    echo "Quantity: " . $orderDetails['quantity'] . "<br>";
    echo "Price: ₹" . $orderDetails['price'] . "<br>";
    echo "Total Price: ₹" . $orderDetails['totalPrice'] . "<br>";
    echo "Delivery Address: " . $orderDetails['address'] . "<br>";
    echo "Payment Method: " . $orderDetails['paymentMethod'] . "<br>";
} else {
    echo "No order details found.";
}
?>
