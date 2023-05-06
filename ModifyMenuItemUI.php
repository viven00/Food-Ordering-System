<?php
include_once("ModifyMenuItemController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>

<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Manager.php?content=Modify+Menu+Item'</script>";
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

function checkNum($data)
{
    global $errorCount;
    if ($data <= 0) { //if it is empty
        ++$errorCount;
        $retval = "";
    } else { // Only clean up the input if it isn't empty
        $retval = trim($data);
        $retval = stripslashes($retval);
    }
    return ($retval);
}


$errorCount = 0;
if (isset($_POST['submit'])) {
    $menuItem = new ModifyMenuItemController();

    $itemID = checkNull($_POST['itemID']);
    $itemName = addslashes($_POST['itemName']);
    $itemDescription = addslashes($_POST['itemDescription']);
    $itemImage = $_FILES['itemImage']['name'];
    $imageFile = $_FILES['itemImage']['tmp_name']; 


    if ($_POST['itemPrice'] != "") {
        if (checkNum($_POST['itemPrice'])) {
            $itemPrice = number_format($_POST['itemPrice'], 2);
        }
    }

    if ($errorCount > 0) {
        return failure_alert("Please check item details have been entered correctly.");
    } else {
        $menuItem->modifyMenuItem($itemID, $itemName, $itemPrice, $itemDescription, $itemImage, $imageFile);
    }
}
?>

<div class="contentBox">
    <h1>Modify Menu Item</h1>
    <p>Please enter details to Modify the Menu Item</p>
    <br>
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label class="control-label col-sm-4" for="itemID">Item ID:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="itemID">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-4" for="itemName">New Item Name:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="itemName">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-4" for="itemPrice">New Item Price:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="itemPrice">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-4" for="itemDescription">New Item Description:</label>
            <div class="col-sm-4">
                <textarea class="form-control" rows="6" name="itemDescription"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-4" for="itemImage">New Item Image:</label>

            <div class="col-sm-4">
                <input type="file" class="form-control" name="itemImage" accept="image/png, image/jpg, image/jpeg">
                <br>
                <input type="submit" class="btn btn-primary" name="submit">
            </div>
        </div>
    </form>
</div>