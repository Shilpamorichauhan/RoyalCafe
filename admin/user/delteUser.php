<?php
include '../../db/connection.php';
$email = $_POST['email'];

$query="DELETE FROM users Where email='".$email."'";

if(mysqli_query($conn,$query)){
    header("Location:../users.php");
}else{
    header("Location:../users.php");
}
