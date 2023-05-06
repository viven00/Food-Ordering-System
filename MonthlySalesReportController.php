<?php
include_once("Order_Status.php");

class MonthlySalesReportController
{
    function monthlySalesReport($month)
    {
        $user = new Order_Status();
        $result = $user->monthlySalesReport($month);
        return $result;
    }
}