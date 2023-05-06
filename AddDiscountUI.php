<?php
include_once("AddDiscountController.php"); // include add discount Controller to call function
session_start();
if(!isset($_SESSION['userID'])){
    die(header("location: index.php"));
}
?>
<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Manager.php?content=Add+Discount'</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

function checkNull($data)
{
    global $errorCount;
    if (empty($data)) { //if it is empty
        ++$errorCount;
        $retval = "";
    } else { // Only clean up the input if it isn't empty
        $retval = trim($data);
        $retval = stripslashes($retval);
    }
    return ($retval);
}

//$errorCount = 0;
if (isset($_POST['submit'])) {
    $addDiscountCtrl = new AddDiscountController();
    $discountName = checkNull($_POST['discountName']);
    $discountAmount = checkNull($_POST['discountAmount']);
    $discountStatus = checkNull($_POST['discountStatus']);

    if ($errorCount > 0)
    {
        return failure_alert("There is/are blank(s) not filled. Please fill in all the blanks.");
    }
    else
    {
        $addDiscountCtrl->addDiscount($discountName, $discountAmount, $discountStatus);
    }
}
?>

<div class="contentBox">
    <h1>Add New Discount Code</h1>
    <p>Please fill up this form to add new discount code</p>
    <br />
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <label class="control-label col-sm-4" for="discountName">Discount code:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="discountName">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="discountAmount">Discount amount(percentage):</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="discountAmount">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="discountStatus">Discount status: </label>
            <div class="col-sm-4">
                <select class="form-control" name="discountStatus">
                    <option selected disabled value=""> ----------------------</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                </br>
                <input type="submit" class="btn btn-primary" name="submit">
            </div>
        </div>
    </form>
</div>