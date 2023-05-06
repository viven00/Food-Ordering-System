<?php
include_once("Order_Status.php");

class MonthlyItemReportController
{
    function monthlyItemReport($month)
    {
        $user = new Order_Status();
        $result = $user->monthlyItemReport($month);
        return $result;
    }
}