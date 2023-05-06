<?php
session_start();
if(!isset($_SESSION['userID'])){
    die(header("location: index.php"));
}
?>
<div class="text-center">
    <h1> Welcome <?php echo $_SESSION['userProfile'];?>!</h1>
</div>