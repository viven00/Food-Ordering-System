<?php
include_once("Order_Items.php");
include_once("Order_Status.php");

class DeleteOrderController
{
    //Only orders that are currently being "Processed" as paid orders should not be deleted.
    function viewOrders()
    {
        $user = new Order_Status();
        $result = $user->searchOrders(null, null, null, null, null, "Processing");
        return $result;
    }

    // For delete Order
    // First delete the order in the Order_Items table; 
    // Next delete the order in the Order_Status table;
    function deleteOrder($orderID)
    {
        $userOrderItems = new Order_Items();
        $validation = $userOrderItems->deleteOrder($orderID);

        if ($validation == true) {
            $userOrderStatus = new Order_Status();
            $result = $userOrderStatus->deleteOrder($orderID);

            if ($result == true) 
            {
                return success_alert("Order successfully deleted!");
            } 
            else 
            {
                return failure_alert("Unable to delete Order.");
            }
        }

        else 
        {
            return failure_alert("Unable to delete Order.");
        }
    }
}
