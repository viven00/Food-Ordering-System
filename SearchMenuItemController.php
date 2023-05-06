<?php
include_once("MenuItem.php");// include user entity to call function
include_once("SearchMenuItemUI.php");
class SearchMenuItemController
{
    function searchMenuItem($itemID, $itemName, $minPrice, $maxPrice, $itemDescription)
    {
        $user = new MenuItem();
        $result = $user->searchMenuItem($itemID, $itemName, $minPrice, $maxPrice, $itemDescription);
        return $result;
    }

    function validateSearch($itemID, $itemName, $minPrice, $maxPrice, $itemDescription)
    {
        if($minPrice != null && $maxPrice != null)
        {
            if ($minPrice > $maxPrice)
                return "Min Price larger than Max Price";
            else 
                return "success";
        }

        return "success";
    }
}
?>