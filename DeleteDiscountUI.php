<?php
include_once("DeleteDiscountController.php"); // include delete discount Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>
<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Manager.php?content=Delete+Discount'</script>";
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
if (isset($_POST['submit'])) 
{
    $deleteDiscountCtrl = new DeleteDiscountController();
    $deleteDiscountCtrl->deleteDiscount($_POST['discountID']);
}
?>

<div class="contentBox">
    <h1>Delete Discount Code</h1>
    <p>Please select the discount code to be deleted</p>
    <br />
    <form class="form-horizontal" action="" method="post">

        <div class="form-group">
            <label class="sulabel1" for="discountID">Discount code to be deleted: </label>
            
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control" name="discountID" required>
                    <option selected disabled value=""> Select Discount Code</option>
                    <?php
                    $deleteDiscountCtrl = new DeleteDiscountController();
                    $discountArr = array();
                    $discountArr = $deleteDiscountCtrl->getArrAllDiscount();

                    foreach ($discountArr as $row) {
                        echo '<option value=' . $row['discountID'] . '>' . $row['discountName'] . '</option>';
                    }
                    ?>
                </select>
                </br>
                <input type="submit" class="btn btn-danger" name="submit" value="Delete">
            </div>
        </div>
    </form>
</div>