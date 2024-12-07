<?php
include('connection.php'); // Include database connection

session_start();

$email = $_POST['email'];
$pass = $_POST['pass'];

$query = "select password,role from users where email='".$email."';";

printf($query);

$result=mysqli_query($conn,$query);

if($result){
    $rows=mysqli_num_rows($result);
    if($rows > 0){
        $user=mysqli_fetch_assoc($result);
        if($user['password'] == $pass){
            if($user['role'] == "user"){
            $_SESSION['email'] = $email;
            header("Location:../user/index.php");   
            }else{
                $_SESSION['email'] = $email;
            header("Location:../admin/index.php");
            }
        }else{
            setcookie("error","password incorrect",time() + 3600 ,"/");
            header("Location:../guest/login.php");
            exit();
        }
    }else{
        setcookie("error","User not found",time() + 3600 ,"/");
        header("Location:../guest/login.php");
            exit();
    }
}else{
    setcookie("error","Server error",time() + 3600 ,"/");
    header("Location:../guest/login.php");
    exit();
}

?>
