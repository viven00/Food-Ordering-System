<?php
session_start();
if ((isset($_SESSION['tableNumber']) && isset($_SESSION['customerPhone']))) {
    session_destroy();
    unset($_SESSION['tableNumber']);
    unset($_SESSION['customerPhone']);

    if (isset($_SESSION['orderID'])) 
    {
        unset($_SESSION['orderID']);
    }

    if (isset($_SESSION["cart_item"])) 
    {
        unset($_SESSION["cart_item"]);
    }

    if (isset($_SESSION["discountCode"])) 
    {
        unset($_SESSION["discountCode"]);
    }

    header('Location: index.php');
}
