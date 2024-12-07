<?php
include '../../db/connection.php';
$name = $_POST['name'];

$query="DELETE FROM orders Where name='".$name."'";

if(mysqli_query($conn,$query)){
    header("Location:../order.php");
}else{
    header("Location:../order.php");
}
