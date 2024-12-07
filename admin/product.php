<?php
include 'header.php';
include '../db/connection.php';

$query="select * from products";

$result=mysqli_query($conn,$query);

?>
<style>
    .center{
        align-items: flex-start;
    }
    table{
        font-family:"sans";
    }
    table{
        border:1px solid black;
        font-size:1.3rem;
    }
    td{
        border:1px solid black;
    }
    tr{
        border:1px solid black;
    }
    </style>    
<main>
    <a href="product/addNewProduct.php" class="btn btn-dark">Add New Product</a>
    <table>
        <tr>
            <td>Imgname</td>
            <td>name</td>
            <td>description</td>
            <td>price</td>
            <td>type</td>
            <td>Edit</td>
            <td>Delete</td>
            <tr>
        <?php
        while($data = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$data['imgname']."</td>";
                echo "<td>".$data['name']."</td>";
                echo "<td>".$data['description']."</td>";
                echo "<td>".$data['price']."</td>";
                echo "<td>".$data['type']."</td>";
                echo "<td><form action='product/editProduct.php' method='post'>
                        <input type='hidden' name='name' value='".$data['name']."'>
                        <button class='btn btn-outline-primary' type='submit'>Edit</button>
                        </form></td>";
                echo "<td><form action='product/deleteProduct.php' method='post'>
                        <input type='hidden' name='name' value='".$data['name']."'>
                        <button class='btn btn-outline-danger' type='submit'>Delete</button>
                        </form></td>";
                echo "</tr>";   
            }
        ?>
    </table>
</main>