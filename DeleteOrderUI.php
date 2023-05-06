<?php
include_once("DeleteOrderController.php"); // include create account Controller to call function
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
    $deleteOrderCtrl = new DeleteOrderController();
    $deleteOrderCtrl->deleteOrder($_POST['orderID']);
}
?>

<div class="contentBox">
    <h1>Delete Order</h1>
    <br>
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <p>Select the order you wish to be deleted</p>
            <br>
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control text-center" name="orderID" required>
                    <option selected disabled value=""> Select Order ID</option>
                    <?php
                    $deleteOrderCtrl = new DeleteOrderController();
                    $result = $deleteOrderCtrl->viewOrders();
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
                <input type="submit" class="btn btn-danger" name="submit" value="Delete">
            </div>
        </div>
    </form 
</div>