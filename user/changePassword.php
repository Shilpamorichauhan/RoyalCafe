<?php
include 'header.php';
include '../db/connection.php';

if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
} else {
    header("Location:../guest/login.php");
    exit();
}

$query = "SELECT * from users WHERE email='".$email."'";
$result = mysqli_query($conn, $query); 

$data = mysqli_fetch_assoc($result);
$storedPassword = $data['password'];

?>

<div class="center">
  <form action="changePassword.php" method="post">
    <div class="login">
      <h1>Change Password</h1>
      
      <div class="mb-3">
        <label for="oldPass" class="form-label">Old Password</label>
        <input type="password" class="form-control" id="oldPass" name="oldPassword" placeholder="Old Password">
      </div>

      <div class="mb-3">
        <label for="newPass" class="form-label">New Password</label>
        <input type="password" class="form-control" id="newPass" name="password" placeholder="New Password">
      </div>

      <div class="mb-3">
        <label for="confirmPass" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="confirmPass" name="confirmPass" placeholder="Confirm New Password">
      </div>

      <div class="mb-3">
        <p id="error" style="color: red;"></p>
      </div>

      <div class="center">
        <input type="submit" class="btn btn-outline-dark m-1" value="Change Password" name="changeClick"><br><br>
      </div>
    </div>
  </form>
</div>

<?php
if(isset($_POST['changeClick'])){
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirmPass'];

    if(!$oldPassword && !$newPassword){
        echo "<script>document.getElementById('error').textContent = 'all field are required.';</script>";
    }
    elseif ($oldPassword != $storedPassword) {
        echo "<script>document.getElementById('error').textContent = 'Old password is incorrect.';</script>";
    } 
    elseif ($newPassword != $confirmPassword) {
        echo "<script>document.getElementById('error').textContent = 'New passwords do not match.';</script>";
    } 
    elseif ($newPassword == $oldPassword) {
        echo "<script>document.getElementById('error').textContent = 'New password must be different from old password.';</script>";
    } 
    else {
        $updateQuery = "UPDATE users SET password='$newPassword' WHERE email='$email'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Password updated successfully!');</script>";
        } else {
            echo "<script>document.getElementById('error').textContent = 'Failed to update password. Please try again later.';</script>";
        }
    }
}
?>
