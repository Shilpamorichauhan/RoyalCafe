<?php
include "./header.php";
include "../db/connection.php";
?>
<style>
    .menu{
        margin:0px;
    }
</style>
<section class="menu" id="menu">
<center><h1 class="fontfam1">Something Tasty</h1></center>
<div class="container-fluid card-desing">
<?php

$query = "SELECT * FROM products where type='pastry'";

$result = mysqli_query($conn, $query);

if ($result) {
    while ($data = mysqli_fetch_assoc($result)) {
        ?>
    <div class="card" style="width: 18rem;">
      <img src="../public/imgs/<?php echo $data['imgname'] ?>" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title"><?php echo $data['name'] ?></h5>
        <p class="card-text"><?php echo $data['description'] ?></p>
        <p class="card-text" style="color:green;"><span style="text-decoration:line-through;color:red;"> &#8377; <?php echo ($data['price']+100) ?></span> &nbsp;&#8377;<?php echo $data['price'] ?></p>
        <form action="order.php" method="post">
        <input type="hidden" name="name" value="<?php echo $data['name']; ?>">
          <input type="submit" value="Add To Cart" class="btn btn-dark">
        </form>
      </div>
    </div>
        <?php
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
</div>
</section>