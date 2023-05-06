<?php
include_once("MenuItem.php");

class ModifyMenuItemController // Get all discount names to display on UI
{
    function modifyMenuItem($itemID, $itemName, $itemPrice, $itemDescription, $itemImage, $imageFile) // To pass information from UI to Entity class
    { 
        $menuItem = new MenuItem(); 
        $checkItemID = $menuItem -> verifyItemID($itemID); 

        if ($checkItemID == 0)
        {
            $validation = $menuItem->modifyMenuItem($itemID, $itemName, $itemPrice, $itemDescription, $itemImage);
            if ($validation == 0) 
            {
                if (!empty($itemImage))
                {
                    move_uploaded_file($imageFile, "ItemImages/$itemImage");
                }
                return success_alert("Menu item successfully Modified!");
            } 

            elseif ($validation == 2) 
            {
                return failure_alert("Failed to Modified menu item");
            }
        }
        else
        {
            return failure_alert("No such item ID exist in the database");
        }

    }
}
?>
