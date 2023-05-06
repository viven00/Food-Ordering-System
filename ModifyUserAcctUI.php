<?php
include_once("ModifyUserAcctController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>
<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Admin.php?content=Modify+User+Account'</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

if (isset($_POST['submit'])) {

    if ($_POST['password1'] !== $_POST['password2']) {
        return failure_alert("Password do not match.");
    }

    $modifyUserCtrl = new ModifyUserAcctController();
    $modifyUserCtrl->modifyUserAcct($_POST['userID'], $_POST['username'], $_POST['password1'], $_POST['name'], $_POST['email'], $_POST['phoneNumber'], $_POST['userProfile']);
}
?>

<div class="contentBox">
    <h1>Modify User Account</h1>
    <p>Please enter user's new user account details</p>
    <br>
    <form class="form-horizontal" action="" method="post">

        <div class="form-group">
            <label class="control-label col-sm-4" for="userID">User ID to modify:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="userID">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-4" for="username">New username:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="username">
            </div>
        </div>

        <div class="form-group">
            <label for="password1" class="control-label col-sm-4">New password</label>
            <div class="col-sm-4">
                <input type="password" class="form-control" name="password1">
            </div>
        </div>

        <div class="form-group">
            <label for="password2" class="control-label col-sm-4">Re-enter new password:</label>
            <div class="col-sm-4">
                <input type="password" class="form-control" name="password2">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="control-label col-sm-4">New name:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="name">
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="control-label col-sm-4">New email:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="email">
            </div>
        </div>

        <div class="form-group">
            <label for="phoneNumber" class="control-label col-sm-4">New phone number:</label>
            <div class="col-sm-4">
                <input type="number" name="phoneNumber" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-4">Select the new user profile</label>
            <div class="col-sm-4">
                <select class="form-control" name="userProfile">
                    <option selected disabled value=""> unchanged </option>
                    <?php
                    $modifyUserCtrl = new ModifyUserAcctController();
                    $profileArr = array();
                    $profileArr = $modifyUserCtrl->getAllUserProfile();

                    foreach ($profileArr as $p => $p_value) {
                        echo '<option value=' . $p . '>' . $p_value . '</option>';
                    }
                    ?>
                </select>
                <br>
                <input type="submit" name="submit" value="Modify" class="btn btn-primary" style="background-color:#696969">
            </div>
        </div>
    </form>
</div>