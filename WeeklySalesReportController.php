<?php
include_once("Order_Status.php");

class WeeklySalesReportController
{
    function weeklySalesReport($date)
    {
        $user = new Order_Status();
        list($year, $week) = explode('-', $date);
        $week = ltrim($week, 'W');
        $result = $user->weeklySalesReport($week, $year);
        return $result;
    }
}
