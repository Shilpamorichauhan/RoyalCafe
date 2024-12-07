<?php
include 'header.php';
include '../db/connection.php';

$key = $_POST['key'];

$query = "SELECT * FROM products WHERE name LIKE '%" . $key . "%' OR type LIKE '%" . $key . "%'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    // If no rows are found, show the "no product" message.
    echo '<div style="text-align: center; font-size: 30px; font-weight: bold; color: #ff0000;">We don\'t have that product, sorry</div>';
} else {
    // If there are products, display them.
    echo '<div class="card-desing">';
    
    while ($products = mysqli_fetch_assoc($result)) {
        ?>
        <div class="card" style="width: 18rem;">
            <img src="../public/imgs/<?php echo $products['imgname'] ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $products['name'] ?></h5>
                <p class="card-text"><?php echo $products['description'] ?></p>
                <p class="card-text" style="color:green;">
                    <span style="text-decoration:line-through;color:red;"> &#8377; <?php echo ($products['price']+100) ?></span> 
                    &nbsp;&#8377;<?php echo $products['price'] ?>
                </p>
                <form action="order.php" method="post">
                    <input type="hidden" name="name" value="<?php echo $products['name']; ?>">
                    <input type="submit" value="Add To Cart" class="btn btn-dark">
                </form>
            </div>
        </div>
        <?php
    }
    
    echo '</div>';
}
?>
