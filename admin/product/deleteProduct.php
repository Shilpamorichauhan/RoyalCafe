<?php

$name = $_POST['name'];

include '../../db/connection.php';


$query = "delete from products where name='".$name."'";

if(mysqli_query($conn,$query)){
    header("Location:../product.php");
}else{
    header("Location:../product.php");
}

?>