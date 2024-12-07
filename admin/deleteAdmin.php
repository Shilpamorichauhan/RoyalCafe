<?php
include '../db/connection.php';

$deleteEmail=$_POST['deleteAdmin'];

$query="DELETE FROM users WHERE email='".$deleteEmail."';";

if(mysqli_query($conn,$query)){
    header("Location:index.php");
}else{
    echo "<script>alert('admin cannot be delted now ! please try later');</script>";
}

?>