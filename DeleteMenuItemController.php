<?php
include_once("MenuItem.php"); // include menu item entity to call function

class DeleteMenuItemController
{

    function getArrOfAllMenuItems()
    {
        $menuItemsArr = array();
        $menuItems = new MenuItem();
        $menuItemsArr = $menuItems->getArrOfAllMenuItems();
        return $menuItemsArr;
    }

    function deleteMenuItem($menuItemID)
    {
        $menuItem = new MenuItem();
        $validation = $menuItem->deleteMenuItem($menuItemID);
        if ($validation == true) 
        {
            return success_alert("Menu item successfully deleted!");
        } 
        else 
        {
            return failure_alert("Unable to delete menu item.");
        }
    }
}
?>

