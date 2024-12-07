<?php
include 'header.php';
include '../db/connection.php';

$query="select * from users where role='user'";

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
    <table>
        <tr>
            <td>email</td>
            <td>name</td>
            <td>password</td>
            <td>Edit</td>
            <td>Delete</td>
            <tr>
        <?php
        while($data = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$data['email']."</td>";
                echo "<td>".$data['name']."</td>";
                echo "<td>".$data['password']."</td>";
                echo "<td><form action='user/editUser.php' method='post'>
                        <input type='hidden' name='email' value='".$data['email']."'>
                        <button class='btn btn-outline-primary' type='submit' name='seeUser'>update User details</button>
                        </form></td>";
                echo "<td><form action='user/delteUser.php' method='post'>
                        <input type='hidden' name='email' value='".$data['email']."'>
                        <button class='btn btn-outline-danger' type='submit'>Delete User</button>
                        </form></td>";
                echo "</tr>";   
            }
        ?>
    </table>
</main>