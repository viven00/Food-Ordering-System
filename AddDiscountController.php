<?php
include_once("Discount.php"); // include discount entity to call function
class AddDiscountController
{
    function addDiscount($discountName, $discountAmount, $discountStatus)
    {
        $discount = new Discount();
        $duplicate = $discount->checkDiscountName($discountName);

        if ($duplicate == true) 
        {
            return failure_alert("This discount code/name is not available. Please use another discount code/name.");
        } 
        else 
        {
            $validation = $discount->addDiscount($discountName, $discountAmount, $discountStatus);
            if ($validation == true) 
            {
                return success_alert("Discount code successfully added!");
            } 
            else 
            {
                return failure_alert("Unable to add discount code.");
            }
        }
    }
}
