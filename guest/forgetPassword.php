<?php 

include 'header.php';

?>


<style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            padding-top: 100px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            height: 80px;
            width: auto;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <!-- Logo -->
                <img src="https://via.placeholder.com/150x50?text=Royal+Cafe" alt="Royal Cafe Logo" class="logo">

                <!-- Forgot Password Form -->
                <h2 class="text-center">Forgot Your Password?</h2>
                <p class="text-center">Please enter your email address below to receive a password reset link.</p>

                <form action="../db/SendOTP.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Send Reset Link</button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Remember your password? <a href="login.php">Login here</a></p>
        </div>
    </div>
