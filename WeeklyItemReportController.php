<?php
include_once("Order_Status.php");

class WeeklyItemReportController
{
    function weeklyItemReport($date)
    {
        $order = new Order_Status();
        list($year, $week) = explode('-', $date);
        $week = ltrim($week, 'W');
        $result = $order->weeklyItemReport($week, $year);
        return $result;
    }
}
