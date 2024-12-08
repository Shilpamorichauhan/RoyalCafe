<?php

include 'header.php';

// Check if the OTP session variable is set
if (!isset($_SESSION['otp'])) {
    echo "Invalid request. Please try again.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    // Check if the entered OTP matches the stored OTP
    if ($entered_otp == $_SESSION['otp']) {
        echo "OTP verified successfully. You can now reset your password.";
        // Redirect to the reset password page
        header("Location: reset_password.php"); // Adjust this to your reset password page
        exit;
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="card" style="max-width: 400px; margin-top: 100px;">
        <div class="card-body">
            <h2 class="text-center">Verify OTP</h2>
            <form method="POST" action="reset_password.php">
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
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
