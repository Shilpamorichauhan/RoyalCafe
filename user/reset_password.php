<?php
session_start();

// Check if the OTP session variable is set and if the user has verified the OTP
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email'])) {
    echo "Invalid request. Please try again.";
    exit;
}

if (isset($_POST['passChange'])) {
    // Get the new password and confirm password from the form
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // Validate passwords
    if (empty($new_password) || empty($confirm_password)) {
        echo "Please fill in all fields.";
        exit;
    }

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
        exit;
    }

    // Get the user's email from the session
    $email = $_SESSION['otp_email'];

    // Include database connection
    include_once("../db/connection.php");

    // Update the user's password in the database (no hashing)
    $query = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $new_password, $email);

    if ($stmt->execute()) {
        // Redirect to the login page after successful password update
        header("Location:../guest/login.php");
        exit;
    } else {
        echo "Error: Unable to update password. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="card" style="max-width: 400px; margin-top: 100px;">
        <div class="card-body">
            <h2 class="text-center">Reset Your Password</h2>
            <form method="POST" action="reset_password.php">
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="passChange">Reset Password</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
