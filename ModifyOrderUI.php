<?php
include_once("ModifyOrderController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
function alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Staff.php?content=Update+Order'</script>";
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

function checkNegative($data)
{
    global $errorCount;
    if ($data < 0) { //if it is negative
        ++$errorCount;
        $retval = "";
    } else { // Only clean up the input if it isn't empty
        $retval = trim($data);
        $retval = stripslashes($retval);
    }
    return ($retval);
}

$order = new ModifyOrderController();

?>

<div class="contentBox">
    <h1>Modify Order</h1>
    <br>
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <h4>Select the order you wish to Modify</h4>
            <br>
            <br>
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control text-center" name="orderID" required>
                    <option selected disabled value=""> Select Order ID</option>
                    <?php
                    $result = $order->viewOrders();
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
                <input type="submit" class="btn btn-danger" name="submit" value="Show Order">
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <?php
        $resultsArray = array();

        if (isset($_POST['submit'])) {
            $orderID = $_POST['orderID'];
            $resultsArray = $order->viewOrderItems($orderID);
        }

        if (isset($_POST['update'])) {
            $no = $_POST['hidden'];
            $newQuantity = checkNegative($_POST['newQuantity']);


            if ($errorCount > 0) {
                return alert("Please do not enter negative value");
            } else {
                $validation = $order->updateOrderQuantity($no, $newQuantity);
            }

            if ($validation == true)
                return alert("Item Succesfully Updated");
            else
                return alert("Item did not Update");
        }

        echo "<br>";
        echo "<h4> If you wish to <b>delete</b> item from order please enter <b>0</b> </h4>";
        echo "<br>";

        if (sizeof($resultsArray) > 0) {
            echo "<table class='table table-striped' border = 0 style='text-align: left;'>
			<tr>
			<th align = left>No&nbsp</th>
			<th align = left>Item ID&nbsp</th>
            <th align = left>Item Name&nbsp</th>
			<th align = left>Quantity&nbsp</th>
            <th align = left>New Quantity&nbsp</th>
            <th align = left></th>
            <th align = left></th>
			</tr>";

            foreach ($resultsArray as $row) {
                echo "<form action ='' method = post>";
                echo "<tr>";
                echo "<td>" . $row["no"] . "</td>";
                echo "<td>" . $row["itemID"] . "</td>";
                echo "<td>" . $row["itemName"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . "<input type=text name=newQuantity value=" . $row["quantity"] . " required></td>";
                echo "<td>" . "<input type = submit name = update value = Update>" . "</td>";
                echo "<td>" . "<input type=hidden name=hidden value=" . $row["no"] . " </td>";
                echo "</tr>";
                echo "</form>";
            }
            echo "</table>";
        } 
        ?>
    </div>
</div>