<?php

include_once("ModifyUserProfileController.php"); // include create account Controller to call function
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

$errorCount = 0;
if (isset($_POST['submit'])) {

    $modifyUserProfileCtrl = new ModifyUserProfileController();
    $newProfile = checkNull($_POST['newUserProfile']);

    if ($errorCount > 0) {
        return failure_alert("There is/are blank(s) not filled. Please fill in all the blanks.");
    } else {
        $modifyUserProfileCtrl->modifyUserProfile($_POST['oldUserProfileID'], $newProfile);
    }
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="theme.css">
</head>

<div class="contentBox">
    <h1>Modify User Profile</h1>
    <p>Please enter user's new user profile details</p>
    <br>
    <div class="form-group">
        <form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <label class="suplabel1">Select the user profile to modify:</label>
                <br>
                <div class="col-md-6 col-md-offset-3 text-center">
                    <select class="form-control text-center" name="oldUserProfileID" required>
                        <option selected disabled value=""> Select Profile</option>
                        <?php
                        $modifyUserProfileCtrl = new ModifyUserProfileController();
                        $profileArr = array();
                        $profileArr = $modifyUserProfileCtrl->getAllUserProfile();

                        foreach ($profileArr as $row) {
                            echo '<option value=' . $row['profileID'] . '>' . $row['profileName'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="suplabel1" for="newUserProfile">New user profile:</label>
                <br>
                <div class="col-md-6 col-md-offset-3 text-center">
                    <input type="text" class="form-control" name="newUserProfile">
                    </br>
                    <input type="submit" name="submit" value="Modify" class="btn btn-primary" style="background-color:#696969">
                </div>
            </div>
        </form>
    </div>
</div>