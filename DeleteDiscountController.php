<?php
include_once("Discount.php"); // include discount entity to call function
class DeleteDiscountController
{
    function getArrAllDiscount()
    {
        $discountArr = array();
        $discount = new Discount();
        $discountArr = $discount->getArrAllDiscount();

        return $discountArr;
    }

    function deleteDiscount($discountID)
    {
        $discount = new Discount();

        $validation = $discount->deleteDiscount($discountID);
        if ($validation == true) 
        {
            return success_alert("Discount code successfully deleted!");
        } 
        else 
        {
            return failure_alert("Unable to delete discount code.");
        }
    }
}
