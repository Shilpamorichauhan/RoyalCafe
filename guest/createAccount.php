<?php
include './header.php';
?>
<div class="center">
  <form action="../db/insertUser.php" method="post" id="registrationForm">
    <div class="login">
      <h1>Give Us a Try for Our Varieties</h1>
      
      <div class="mb-3">
        <!-- Error message will be displayed here -->
        <span id="error" style="color: red;"></span>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirmPassword" name="confirm" placeholder="Confirm Password">
      </div>

      <div class="center">
        <input type="submit" class="btn btn-outline-dark m-1" value="Create"><br><br>
        <a class="btn btn-outline-dark m-1" href="login.php">Login</a><br><br>
      </div>
    </div>
  </form>
</div>

<script>
  document.getElementById('registrationForm').addEventListener('submit', function(e) {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var errorMessage = document.getElementById('error');

    // Clear previous error messages
    errorMessage.textContent = '';

    // Check if any required field is empty
    if (!name || !email || !password || !confirmPassword) {
      e.preventDefault(); // Prevent form submission
      errorMessage.textContent = "All fields are required.";
      return;
    }

    // Email validation using a regular expression
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
      e.preventDefault(); // Prevent form submission
      errorMessage.textContent = "Please enter a valid email address.";
      return;
    }

    // Password match validation
    if (password !== confirmPassword) {
      e.preventDefault(); // Prevent form submission
      errorMessage.textContent = "Passwords do not match.";
    }
  });
</script>
