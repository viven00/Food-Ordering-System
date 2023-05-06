<?php
include_once("ActivateDiscountController.php"); // include activate discount Controller to call function
session_start();
if(!isset($_SESSION['userID'])){
    die(header("location: index.php"));
}
?>
<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Manager.php?content=Activate+Discount'</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

//$errorCount = 0;
if (isset($_POST['submit'])) {
    $activateDiscountCtrl = new ActivateDiscountController();
    $activateDiscountCtrl->activateDiscount($_POST['discountID']);
    }
?>

<div class="contentBox">
    <h1>Activate Discount Code</h1>
    <p>Please select which discount code you would like to activate</p>
    <br />
    <form class="form-horizontal" action="" method="post">
        
        <div class="form-group">
            <label class="sulabel1" for="discountID">Discount code to activate: </label>
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control" name="discountID" required>
                    <option selected disabled value=""> Select discount code</option>
                    <?php
                    $activateDiscountCtrl = new ActivateDiscountController();
                    $discountArr = array();
                    $discountArr = $activateDiscountCtrl->getArrInactiveDiscounts();

                    foreach ($discountArr as $row) {
                        echo '<option value=' . $row['discountID'] . '>' . $row['discountName'] . '</option>';
                    }
                    ?>
                </select>
                </br>
                <input type="submit" class="btn btn-warning" name="submit" value="Activate">
            </div>
        </div>
    </form>
</div>