<?php
include './header.php';
?>
<div class="center">
    <div class="login">
        <h1>Login & Test Our Varieties</h1>
        <form id="loginForm" action="../db/loginCheck.php" method="post" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <span id="email_error" class="form-label" style="color:red;"></span>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <span id="pass_error" class="form-label" style="color:red;"></span>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                <a href="">Forget password</a>
            </div>

            <div class="mb-3">
                <p class="error" style="color:red;display:flex;justify-content:center;align-items:center;">
                    <?php
                    if (isset($_COOKIE['error'])) {
                        printf($_COOKIE['error']);
                        unset($_COOKIE['error']);
                    }
                    ?>
                </p>
            </div>

            <div class="center">
                <input type="submit" class="btn btn-outline-dark m-1" value="Login"><br><br>
                <a class="btn btn-outline-dark m-1" href="createAccount.php">Create Account</a>
            </div>
        </form>
    </div>
</div>

<script>
    function validateForm() {
        var email_error = document.querySelector("#email_error");
        var pass_error = document.querySelector("#pass_error");

        var email = document.getElementById("email").value;
        var pass = document.getElementById("pass").value;
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (email == "") {
            email_error.innerText = " is required.";
            return false;
        } else if (!emailPattern.test(email)) {
            email_error.innerText = "Please enter a valid email.";
            return false;
        } else {
            email_error.innerText = ""; // Clear the error message if email is valid
        }

        if (pass == "") {
            pass_error.innerText = " is required.";
            return false;
        } else if (pass.length < 6) {
            pass_error.innerText = " must be at least 6 characters long.";
            return false;
        } else {
            pass_error.innerText = ""; // Clear the error message if password is valid
        }

        return true;
    }
</script>
