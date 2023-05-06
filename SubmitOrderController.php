<?php
include_once("Order_Status.php");
include_once("Order_Items.php");
class SubmitOrderController
{
    function addOrder($tableNumber, $customerPhone, $gst, $serviceCharge, $total)
    {
        $order = new Order_Status;
        if (empty($_SESSION['orderID'])) {
            $orderID = $order->generateOrderID();
            $addOrder = $order->addOrder($orderID, $tableNumber, $customerPhone, $gst, $serviceCharge, $total);
            if ($addOrder == TRUE) {
                $orderItems = new Order_Items;
                $result = $orderItems->addOrderItems($orderID);
                if ($result == TRUE) 
                {
                    return success_alert("Items are successfully submitted.");
                } 
                else 
                {
                    return failure_alert("Unable to add order items");
                }
            } 
            else 
            {
                return failure_alert("Unable to add order");
            }
        } 
        else 
        {
            $updateOrder = $order->updateOrder($_SESSION['orderID'], $gst, $serviceCharge, $total);
            if ($updateOrder == TRUE)
            {
                $orderItems = new Order_Items;
                $result = $orderItems->updateOrderItems($_SESSION['orderID']);
                if ($result == TRUE) 
                {
                    return success_alert("Items are successfully submitted.");
                } 
                else 
                {
                    return failure_alert("Unable to add order items");
                }


            }
            else
            {
                return failure_alert("Unable to update order.");
            }

        }
    }
}
