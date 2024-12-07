<?php
// Include your header and connection files
include 'header.php';
include '../db/connection.php';

// Get the product details and user input
$productName = $_POST['name'];
$nums = $_POST['NumOfOrder'];
$price = $_POST['price'];
$address = isset($_POST['address']) ? $_POST['address'] : ''; // Check if address is set
$paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : ''; // Check if paymentMethod is set

// Check if necessary POST data is available
if (empty($address) || empty($paymentMethod)) {
    echo "<div class='container'>";
    echo "<h2 class='text-center text-danger'>Error</h2>";
    echo "<p class='text-center'>Address and Payment Method are required. Please go back and fill them out.</p>";
    echo "</div>";
    exit;
}

// Calculate the total price
$totalPrice = $price * $nums;

// Insert the order details into the `orders` table
$query = "INSERT INTO orders (name, quantity, price, totalPrice, address, paymentType) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("siisss", $productName, $nums, $price, $totalPrice, $address, $paymentMethod);

if ($stmt->execute()) {
    // If the order is successfully inserted, show a confirmation message
    echo "<div class='container'>";
    echo "<h2 class='text-center'>Thank You for Your Order!</h2>";
    echo "<p class='text-center'>Your order has been placed successfully.</p>";
    echo "<p class='text-center'>Order Details:</p>";
    echo "<ul class='list-group'>";
    echo "<li class='list-group-item'><strong>Product Name:</strong> " . htmlspecialchars($productName) . "</li>";
    echo "<li class='list-group-item'><strong>Quantity:</strong> " . htmlspecialchars($nums) . "</li>";
    echo "<li class='list-group-item'><strong>Total Price:</strong> ₹" . htmlspecialchars($totalPrice) . "</li>";
    echo "<li class='list-group-item'><strong>Delivery Address:</strong> " . htmlspecialchars($address) . "</li>";
    echo "<li class='list-group-item'><strong>Payment Method:</strong> " . htmlspecialchars($paymentMethod) . "</li>";
    echo "</ul>";
    echo "</div>";
} else {
    // If there was an error inserting the order
    echo "<div class='container'>";
    echo "<h2 class='text-center text-danger'>Error</h2>";
    echo "<p class='text-center'>There was an issue placing your order. Please try again later.</p>";
    echo "</div>";
}

// Close the database connection
mysqli_close($conn);
?>
