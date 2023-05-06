<?php
include_once("MenuItem.php");
include_once("Discount.php");

class AddMenuItemController // Get all discount names to display on UI
{
    function fetchDiscountData()
    {
        $discountArr = array();
        $discount = new Discount();

        $discountArr = $discount -> fetchDiscountData("Active");
        return $discountArr;

    }
    
    function addMenuItem($itemName, $itemPrice, $itemDescription, $itemImage, $imageFile) // To pass information from UI to Entity class
    { 
        $menuItem = new MenuItem();

        $validation = $menuItem->addMenuItem($itemName, $itemPrice, $itemDescription, $itemImage);

        if ($validation == true) {
            move_uploaded_file($imageFile, "ItemImages/$itemImage");
            return success_alert("Menu item successfully added!");
        } else {
            return failure_alert("Failed to add to menu item.");
        }
    }
}
?>
