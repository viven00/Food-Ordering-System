<?php
include_once("Order_Status.php");

class WeeklyCustomerReportController
{
    function weeklyCustomerReport($date)
    {
        $order = new Order_Status();
        list($year, $week) = explode('-', $date);
        $week = ltrim($week, 'W');
        $result = $order->weeklyCustomerReport($week, $year);
        return $result;
    }
}
