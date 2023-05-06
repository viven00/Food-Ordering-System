<?php
session_start();
if(isset($_SESSION['userID']))
{
    session_destroy();
    unset($_SESSION['userID']);
    unset($_SESSION['userProfile']);
    header('Location: index.php');
}
?>