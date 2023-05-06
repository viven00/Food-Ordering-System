<?php
include_once("DeactivateDiscountController.php"); // include deactivate discount Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>
<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Manager.php?content=Deactivate+Discount'</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

//$errorCount = 0;
if (isset($_POST['submit'])) 
{
    $deactivateDiscountCtrl = new DeactivateDiscountController();
    $deactivateDiscountCtrl->deactivateDiscount($_POST['discountID']);
}
?>

<div class="contentBox">
    <h1>Deactivate Discount Code</h1>
    <p>Please select which discount code you would like to deactivate</p>
    <br />
    <form class="form-horizontal" action="" method="post">

        <div class="form-group">
            <label class="sulabel1" for="discountID">Discount code to deactivate: </label>
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control" name="discountID" required>
                    <option selected disabled value=""> Select discount code</option>
                    <?php
                    $deactivateDiscountCtrl = new DeactivateDiscountController();
                    $discountArr = array();
                    $discountArr = $deactivateDiscountCtrl->getArrActiveDiscounts();

                    foreach ($discountArr as $row) {
                        echo '<option value=' . $row['discountID'] . '>' . $row['discountName'] . '</option>';
                    }
                    ?>
                </select>
                </br>
                <input type="submit" class="btn btn-danger" name="submit" value="Deactivate">
            </div>
        </div>
    </form>
</div>