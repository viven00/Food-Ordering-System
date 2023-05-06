<?php
include_once("Order_Items.php"); 
include_once("Order_Status.php");
include_once("MenuItem.php");

class ModifyOrderController
{
    function viewOrders()
    {
        $order = new Order_Status();
        $result = $order-> searchOrders(null, null, null, null, null, "Processing");
        return $result;
    }

    function viewOrderItems($orderID)
    {
        $order = new Order_Items();
        $menuItem = new MenuItem();

        $itemsArray = array();
        $itemsArray = $order-> viewOrderItems($orderID);

        for ($i = 0; $i < sizeof($itemsArray); $i++)
        {
            $itemName = $menuItem -> getItemName ($itemsArray[$i]['itemID']);
            $itemsArray [$i]["itemName"]= $itemName;
        }

        return $itemsArray;
    }

    function updateOrderQuantity($no, $quantity)
    {
        $order = new Order_Items();

        if ($quantity == 0)
        {
            $validation = $order -> deleteItem($no, $quantity);
        }
        else
        {
            $validation = $order -> updateOrderQuantity($no, $quantity);
        }
         
        return $validation;
    }
    
}