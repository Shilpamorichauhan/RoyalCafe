<?php

include "header.php";
include '../db/connection.php';

$query="select name from users where email='".$_SESSION['email']."';";

$result = mysqli_query($conn,$query);

$user=mysqli_fetch_assoc($result);

?>
<main>
<div class="achu">
 welcome back,
 <?php
    printf($user['name']);
 ?>
</div>
<video class="vid" src="../public/bg-video.mp4" autoplay muted loop>
</main>

<?php
include 'menu.php';
?>



