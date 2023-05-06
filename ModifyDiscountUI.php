<?php
include_once("ModifyDiscountController.php"); // include modify discount Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>
<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Manager.php?content=Modify+Discount'</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

$errorCount = 0;
if (isset($_POST['submit'])) {
    $modifyDiscountCtrl = new ModifyDiscountController();


    if ($_POST['discountID'] == 0) {
        return failure_alert("Please select the discount code you would like to modify");
    }

    if ((empty($_POST['newDiscountName']) && empty($_POST['newDiscountAmount'])))
    {
        return failure_alert("There is/are blank(s) not filled. Please fill in at least one field.");
    }
    else
    {
        $modifyDiscountCtrl->modifyDiscount($_POST['discountID'], $_POST['newDiscountName'], $_POST['newDiscountAmount']);
    }
}
?>

<div class="contentBox">
    <h1>Modify Discount Code</h1>
    <p>Please fill up this form to modify discount code</p>
    <br />
    <form class="form-horizontal" action="" method="post">

        <div class="form-group">
            <label class="control-label col-sm-4" for="discountID">Discount code you want to modify: </label>
            <div class="col-sm-4">
                <select class="form-control" name="discountID" required>
                    <option selected disabled value=""> Select Discount Code</option>
                    <?php
                    $modifyDiscountCtrl = new ModifyDiscountController();
                    $discountArr = array();
                    $discountArr = $modifyDiscountCtrl->getArrAllDiscount();

                    foreach ($discountArr as $row) {
                        echo '<option value=' . $row['discountID'] . '>' . $row['discountName'] . '</option>';
                    }
                    ?>
                </select>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="newDiscountName">New discount code:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="newDiscountName">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="newDiscountAmount">New discount amount(percentage):</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="newDiscountAmount">
            </div>
        </div>

        <input type="submit" class="btn btn-primary" name="submit">

    </form>
</div>