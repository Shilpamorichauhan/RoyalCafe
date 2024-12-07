<?php
include '../db/connection.php';

session_start();
if(isset($_SESSION['email'])){
  $email = $_SESSION['email'];
  $query= "select * from users where email='".$email."'";

  $result = mysqli_query($conn,$query);
  
  $data=mysqli_fetch_assoc($result);

  $name = $data['name'];
}else{
  header("Location:../guest/login.php");
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Yuji+Mai&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="../style.css">
<body>
    <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="../public/imgs/logo.png" class="logo_img" alt="" srcset=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i>&nbsp;Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="#menu"><i class="fa-solid fa-list"></i>&nbsp;Menu</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-box"></i> Items
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="coffe.php">Coffe</a></li>
            <li><a class="dropdown-item" href="pastry.php">Pastry</a></li>
            <li><a class="dropdown-item" href="tea.php">Tea</a></li>
          </ul>
        </li>
      </ul>
      <form action="search.php" method="post" class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" name="key" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <button class="btn btn-outline-dark" style="margin-left:1rem;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">User Profile</button>
    </div>
  </div>
</nav>
<div class="offcanvas offcanvas-end" style="width: 20%;" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title" id="offcanvasRightLabel">User Profile</h3>
    <button type="button btn-dark" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
       <h5>Email : - <br><?php echo $email ?> </h5>
       <h5>Name : - <?php echo $name ?> </h5>
       <a class="btn btn-dark mt-2" href="changePassword.php">Change Password</a>
       <a class="btn btn-dark mt-2" href="../guest">Logout</a> 
  </div>
</div>
    </header>