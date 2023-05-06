<?php
include_once("Order_Status.php");

class DailyItemReportController
{
    function dailyItemReport($date)
    {
        $user = new Order_Status();
        $result = $user->dailyItemReport($date);
        return $result;
    }
}