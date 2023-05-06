<?php
include_once("Order_Status.php");

class ValidatePaymentController
{
    //Only orders that are currently being "Processed" 
    function viewOrders()
    {
        $order = new Order_Status();
        $status = 'Payment Pending';
        $result = $order-> searchOrders(null, null, null, null, null, $status);
        return $result;
    }
    
    function updateStatus($orderID)
    {

        $userOrderStatus = new Order_Status();
        $validation = $userOrderStatus->updateStatus($orderID);

        if ($validation == true) 
        {
            return success_alert("Order status successfully updated!");
        } 
        else 
        {
            return failure_alert("Unable to update Order status.");
        }
    }
}
?>
