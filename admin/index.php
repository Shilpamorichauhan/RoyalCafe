<?php

include 'header.php';
include '../db/connection.php';

session_start();

$email = $_SESSION['email'];

$sql="select * from users where role='admin'";

$result=mysqli_query($conn,$sql);

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
<main class="center">
<div>
    <h1>All Admins</h1>
    <table>
        <?php
        while($data = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$data['email']."</td>";
                echo "<td>".$data['name']."</td>";
                echo "<td><form action='deleteAdmin.php' method='post'>
                        <input type='hidden' name='deleteAdmin' value='".$data['email']."'>
                        <button class='btn btn-outline-danger' type='submit'>Delete Admin</button>
                        </form></td>";
                echo "</tr>";   
            }
        ?>
    </table>
</div>

</main>