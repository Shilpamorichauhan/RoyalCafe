<?php
session_start();
include 'header.php'; // Include header (if any)
include '../db/connection.php'; // Include database connection

// Check if the necessary POST data is set
if (!isset($_POST['name'], $_POST['NumOfOrder'], $_POST['price'], $_POST['address'], $_POST['paymentMethod'])) {
    echo "<div class='container'>";
    echo "<h2 class='text-center text-danger'>Error</h2>";
    echo "<p class='text-center'>Missing order details. Please go back and fill them out.</p>";
    echo "</div>";
    exit;
}

// Collect order details from POST data
$productName = $_POST['name'];
$nums = $_POST['NumOfOrder'];
$price = $_POST['price'];
$address = $_POST['address'];
$paymentMethod = $_POST['paymentMethod'];

// Validate if address and payment method are filled
if (empty($address) || empty($paymentMethod)) {
    echo "<div class='container'>";
    echo "<h2 class='text-center text-danger'>Error</h2>";
    echo "<p class='text-center'>Address and Payment Method are required. Please go back and fill them out.</p>";
    echo "</div>";
    exit;
}

// Calculate the total price
$totalPrice = $price * $nums;

// Prepare and execute the database insertion query
$query = "INSERT INTO orders (name, quantity, price, totalPrice, address, paymentType) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("siisss", $productName, $nums, $price, $totalPrice, $address, $paymentMethod);

if ($stmt->execute()) {
    // Order data to pass to email script
    $orderData = [
        'name' => $productName,
        'quantity' => $nums,
        'price' => $price,
        'totalPrice' => $totalPrice,
        'address' => $address,
        'paymentMethod' => $paymentMethod
    ];

    // Redirect to the confirmation email script by submitting a hidden form
    echo "<form id='redirectForm' action='../db/sendConformMail.php' method='POST'>";
    
    foreach ($orderData as $key => $value) {
        echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "' />";
    }

    echo "</form>";
    echo "<script>document.getElementById('redirectForm').submit();</script>";
} else {
    echo "<div class='container'>";
    echo "<h2 class='text-center text-danger'>Error</h2>";
    echo "<p class='text-center'>There was an issue placing your order. Please try again later.</p>";
    echo "</div>";
}

// Close database connection
mysqli_close($conn);
?>
