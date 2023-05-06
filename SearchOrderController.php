<?php
include_once("Order_Status.php");// include user entity to call function
class SearchOrderController
{
    function viewOrders()
    {
        $user = new Order_Status();
        $result = $user-> searchOrders(null, null, null, null, null, null);
        return $result;
    }
    
    function searchOrder($orderID, $created_at, $tableNumber, $customerPhone, $total, $status)
    {
        $user = new Order_Status();
        $result = $user-> searchOrders($orderID, $created_at, $tableNumber, $customerPhone, $total, $status);
        return $result;
    }
}