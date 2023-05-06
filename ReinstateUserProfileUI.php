<?php
include_once("ReinstateUserProfileController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>

<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Admin.php?content=Reinstate+User+Profile'</script>";
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
    $userProfile = new ReinstateUserProfileController();
    $profileID = checkNull($_POST['userProfiles']);

    if ($errorCount > 0) {
        return failure_alert("No user profile selected");
    } else {
        $userProfile->validateUserProfile($profileID);
    }
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="theme.css">
</head>

<div class="contentBox">
    <h1>Reinstate User Profile</h1>
    <br>
    <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
            <label class="rulabel1">Choose a User Profile:</label>
            <br />
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control text-center" name="userProfiles">
                    <option selected disabled value=""> Select Profile</option>
                    <?php
                    $userProfile = new ReinstateUserProfileController();
                    $profileArr = array();
                    $profileArr = $userProfile->fetchProfileData();

                    foreach ($profileArr as $p => $p_value) {
                        echo '<option value=' . "$p" . '>' . $p_value . '</option>';
                    }
                    ?>
                </select>
                <br />
                <input type="submit" name="submit" value="Reinstate" class="btn btn-danger">
            </div>
        </div>
    </form>
</div>