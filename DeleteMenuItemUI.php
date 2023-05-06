<?php
include_once("DeleteMenuItemController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>
<?php
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

if (isset($_POST['submit'])) 
{
    $deleteMenuItemCtrl = new DeleteMenuItemController();
    $validation = $deleteMenuItemCtrl->deleteMenuItem($_POST['menuItemID']);
}
?>

<div class="contentBox">
    <h1>Delete Menu Item</h1>
    <br>
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <label class="sulabel1">Select the menu item you want to delete</label>
            <br />
            <br />
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control text-center" name="menuItemID" required>
                    <option selected disabled value=""> Select Menu Item</option>
                    <?php
                    $deleteMenuItemCtrl = new DeleteMenuItemController();
                    $menuItemsArr = array();
                    $menuItemsArr = $deleteMenuItemCtrl->getArrOfAllMenuItems();

                    foreach ($menuItemsArr as $row) {
                        echo '<option value=' . $row['itemID'] . '>' . $row['itemName'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <input type="submit" class="btn btn-danger" name="submit" value="Delete">
            </div>
        </div>
    </form>
</div>