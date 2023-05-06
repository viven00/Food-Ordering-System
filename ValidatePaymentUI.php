<?php
include_once("ValidatePaymentController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}


function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

if (isset($_POST['submit'])) {
    $updateOrderStatusCtrl = new ValidatePaymentController();
    $updateOrderStatusCtrl->updateStatus($_POST['orderID']);
}
?>

<div class="contentBox">
    <h1>Validate Payment</h1>
    <br>
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <p>Select the order which you want to Validate Payment</p>
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control text-center" name="orderID" required>
                    <option selected disabled value=""> Select Order ID</option>
                    <?php
                    $updateOrderStatusCtrl = new ValidatePaymentController();
                    $result = $updateOrderStatusCtrl->viewOrders();
                    $orderArray = array();

                    while ($row = $result->fetch_assoc()) {
                        $orderArray[] = $row;
                    }

                    foreach ($orderArray as $row) {
                        echo '<option value=' . $row['orderID'] . '>' . $row['orderID'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <input type="submit" class="btn btn-danger" name="submit" value="Update">
            </div>
        </div>
    </form> 
</div>