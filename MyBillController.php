<?php
include_once("Order_Items.php");
include_once("Order_Status.php");
include_once("Discount.php");

class MyBillController 
{
    function getOrderItems()
    {
        $orderItems = new Order_Items;
        $orderItemsArr = array();
        $orderItemsArr = $orderItems->getOrderItemsByID($_SESSION['orderID']);
        return $orderItemsArr;
    }

    function getOrderStatus()
    {
        $orderStatus = new Order_Status;
        $orderStatusArr = array();
        $orderStatusArr = $orderStatus->getOrderStatusByID($_SESSION['orderID']);
        return $orderStatusArr;
    }

    function checkDiscountCode($discountCode)
    {
        $discount = new Discount;
        $result = $discount->checkDiscountName($discountCode);
        if ($result == TRUE) {
            $result = $discount->getActiveDiscount($discountCode);
            if ($result == TRUE) 
            {
                $_SESSION['discountCode'] = $discountCode;
            } 
            else 
            {
                return failure_alert("The discount has expired/inactive.");
            }
        } 
        else 
        {
            return failure_alert("The discount code is not available.");
        }
    }

    function getDiscountAmount()
    {
        $discount = new Discount;
        $discountAmt = $discount->getDiscountAmount($_SESSION['discountCode']);
        return $discountAmt;
    }

    function updatePayment($paymentMethod, $total, $gst, $serviceCharge)
    {
        $orderStatus = new Order_Status;
        $orderID = $_SESSION['orderID'];

        if (isset($_SESSION['discountCode']))
        {
            $discount = new Discount;
            $discountID = $discount->getDiscountID($_SESSION['discountCode']);

            $result = $orderStatus->updateOrderWithDiscountID($orderID, $total, $gst, $serviceCharge, $discountID);
            if ($result == FALSE)
            {
                return failure_alert("Unable to make payment with discount code. Please try again.");
            }
        }

        $result = $orderStatus->updatePaymentStatus($orderID, $paymentMethod);
        if ($result === 1)
        {
            return success_alert("Your bill is paid. Hope you enjoy your meal!");
        }
        elseif ($result === 2)
        {
            return success_alert("Please make your way to the counter to make payment.");
        }

        else
        {
            return failure_alert("Unable to make payment. Please try again.");
        }
    }
}
?>