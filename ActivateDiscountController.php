<?php
include_once("Discount.php");// include discount entity to call function
class ActivateDiscountController
{
    function getArrInactiveDiscounts()
    {
        $discountArr = array();
        $discount = new Discount();
        $discountArr = $discount->getArrInactiveDiscounts();

        return $discountArr;

    }

    function activateDiscount($discountID)
    {
        $discount = new Discount();

        $validation = $discount->activateDiscount($discountID);
        if ($validation == true)
        {
            return success_alert("Discount code successfully activated!");
        }
        else
        {
            return failure_alert("Unable to activate discount code.");
        }
    }
}
