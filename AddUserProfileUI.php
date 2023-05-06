<?php
include_once("AddUserProfileController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>
<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Admin.php?content=Add+User+Profile'</script>";
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

    $addUserProfileCtrl = new addUserProfileController();
    $profileName = checkNull($_POST['userProfile']);

    if ($errorCount > 0) {
        return failure_alert("There is/are blank(s) not filled. Please fill in all the blanks.");
    } else {
        $addUserProfileCtrl->addUserProfile($profileName);
    }
}
?>

<div class="contentBox">
    <h1>Add User Profile</h1>
    <p>Please enter new user profile you would like to add</p>
    <br>
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <label for="userProfile" class="suplabel1">New user profile:</label>
            <br />
            <div class="col-md-6 col-md-offset-3 text-center">
                <input type="text" class="form-control" name="userProfile">
            </div>
        </div>
        <input type="submit" name="submit" value="Submit" class="btn btn-primary" style="background-color:#696969"><br>
    </form>
</div>