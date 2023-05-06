<?php
include_once("Discount.php");// include user entity to call function
class SearchDiscountController
{
    function searchDiscount($discountID, $discountName, $discountAmount, $discountStatus)
    {
        $discount = new Discount();
        $result = $discount->searchDiscount($discountID, $discountName, $discountAmount, $discountStatus);
        return $result;
    }
}
?>