<?php
include_once("Order_Status.php");

class DailyCustomerReportController
{
    function dailyCustomerReport($date)
    {
        $user = new Order_Status();
        $result = $user->dailyCustomerReport($date);
        return $result;
    }
}