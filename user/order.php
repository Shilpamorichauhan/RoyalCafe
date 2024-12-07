<?php
// Include your header and connection files
include 'header.php';
include '../db/connection.php';

// Get the product name from the POST request
$name = $_POST['name'];

// Query the database for the product with the given name
$sql = "SELECT * FROM products WHERE name='" . $name . "'";
$result = mysqli_query($conn, $sql);

// Fetch the product data
$data = mysqli_fetch_assoc($result);
?>
<div class="container">
  <div class="row d-flex">
    <!-- Display product image -->
    <div class="col">
      <img src="../public/imgs/<?php echo $data['imgname']; ?>" alt="<?php echo $data['name']; ?>" class="Order_img">
    </div>

    <!-- Display product details -->
    <div class="col">
      <h1><?php echo $data['name']; ?></h1>
      <p><?php echo $data['description']; ?></p>
      <p style="color:green;">
        <span style="text-decoration:line-through;color:red;">&#8377; <?php echo ($data['price'] + 100); ?></span> 
        &nbsp;&#8377;<?php echo $data['price']; ?>
      </p>

      <!-- Quantity Buttons -->
      <button onclick="changeValue('decrement')" class="btn btn-dark btn_size">-</button>
      <span id="value" class="Nums">1</span> <!-- Default value is 1 -->
      <button onclick="changeValue('increment')" class="btn btn-dark btn_size">+</button>
      
      <!-- Form to submit the order -->
      <form action="confirmOrder.php" method="post">
        <input type="hidden" name="name" value="<?php echo $data['name']; ?>">
        <input type="hidden" name="price" value="<?php echo $data['price']; ?>">
        <input type="hidden" name="NumOfOrder" id="NumOfOrder" value="1">

        <!-- Address Input -->
        <div class="form-group">
          <label for="address">Enter Your Address</label>
          <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Payment Options Section -->
        <h4 class="mt-4">Select Payment Method</h4>
        <div class="form-check">
          <input type="radio" class="form-check-input" id="cashOnDelivery" name="paymentMethod" value="cash" checked>
          <label class="form-check-label" for="cashOnDelivery">Cash on Delivery</label>
        </div>
        <div class="form-check">
          <input type="radio" class="form-check-input" id="onlinePayment" name="paymentMethod" value="online" disabled>
          <label class="form-check-label" for="onlinePayment">Online Payment</label>
          <label class="form-check-label" for="onlinePayment" style="font-size:0.7rem;color:red;">Online Payment is currently unavailable</label>
        </div>

        <input type="submit" value="Order And Enjoy" class="btn btn-dark">
      </form>
    </div>
  </div>
</div>

<script>
  // Function to handle value change for the quantity
  function changeValue(action) {
    var valueElement = document.getElementById("value");
    var numOfOrderElement = document.getElementById("NumOfOrder");
    var currentValue = parseInt(valueElement.innerText);

    if (action === 'increment') {
      currentValue += 1; // Increase value
    } else if (action === 'decrement') {
      if (currentValue > 1) { // Ensure value does not go below 1
        currentValue -= 1; // Decrease value
      }
    }

    // Update the displayed value and the hidden input field
    valueElement.innerText = currentValue;
    numOfOrderElement.value = currentValue; // Set the value for the hidden input
  }
</script>

<?php
// Close database connection if not needed anymore
mysqli_close($conn);
?> 
