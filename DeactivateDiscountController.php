<?php
include_once("Discount.php");// include discount entity to call function
class DeactivateDiscountController
{
    function getArrActiveDiscounts()
    {
        $discountArr = array();
        $discount = new Discount();
        $discountArr = $discount->getArrActiveDiscounts();

        return $discountArr;

    }

    function deactivateDiscount($discountID)
    {
        $discount = new Discount();

        $validation = $discount->deactivateDiscount($discountID);
        if ($validation == true)
        {
            return success_alert("Discount code successfully deactivated!");
        }
        else
        {
            return failure_alert("Unable to deactivate discount code.");
        }
    }
}
