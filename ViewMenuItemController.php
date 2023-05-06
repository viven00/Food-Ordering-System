<?php
include_once("MenuItem.php");

class ViewMenuItemController
{
    function getAllMenuItems()
    {
        $menuItems = new MenuItem();
        $menuItemsArr = array();
        $menuItemsArr = $menuItems->getArrOfAllMenuItems();
        return $menuItemsArr;
    }
}
?>