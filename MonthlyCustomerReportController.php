<?php
include_once("Order_Status.php");

class MonthlyCustomerReportController
{
    function monthlyCustomerReport($month)
    {
        $user = new Order_Status();
        $result = $user->monthlyCustomerReport($month);
        return $result;
    }
}