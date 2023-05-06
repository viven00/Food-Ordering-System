<?php
include_once("Discount.php"); // include discount entity to call function
class ModifyDiscountController
{
    function getArrAllDiscount()
    {
        $discount = new Discount();
        return $discount->getArrAllDiscount();
    }

    function modifyDiscount($discountID, $newDiscountName, $newDiscountAmount)
    {
        $discount = new Discount();
        $duplicate = $discount->checkDiscountName($newDiscountName);

        if ($duplicate == true) 
        {
            return failure_alert("This discount code/name is not available. Please use another discount code/name.");
        } 
        else 
        {
            $validation = $discount->modifyDiscount($discountID, $newDiscountName, $newDiscountAmount);
            if ($validation == true) 
            {
                return success_alert("Discount code successfully modified!");
            } 
            else 
            {
                return failure_alert("Unable to modify discount code.");
            }
        }
    }
}
