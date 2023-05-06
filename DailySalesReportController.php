<?php
include_once("Order_Status.php");

class DailySalesReportController
{
    function dailySalesReport($date)
    {
        $user = new Order_Status();
        $result = $user->dailySalesReport($date);
        return $result;
    }
}