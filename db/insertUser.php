<?php
  require ('connection.php');

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  $sql = "INSERT INTO users (name, email,password)
VALUES ('".$name."','".$email."','".$password."')";

if (mysqli_query($conn, $sql)) {
  ?>
  <script>
    window.location.href="../guest/login.php";
    </script>
  <?php
} else {
    setcookie("error","user login failed", time() + (86400 * 30), "../guest/login.php");
    ?>
    <script>
        window.location.href="../guest/login.php";
        </script>
    <?php
}

mysqli_close($conn);

?>