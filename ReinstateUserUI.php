<?php
include_once("ReinstateUserController.php"); // include create account Controller to call function
session_start();
if(!isset($_SESSION['userID'])){
    die(header("location: index.php"));
}
?>

<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Admin.php?content=Reinstate+User+Account'</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Admin.php?content=Reinstate+User+Account'</script>";
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
if (isset($_POST['reinstate'])) {
    $user = new ReinstateUserController();
    $userID = checkNull($_POST['user']);

    if ($errorCount > 0) {
        return failure_alert("No user selected");
    } else {
        $user->validateUser($userID);
    }
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="theme.css">
</head>

<div class="contentBox">
    <h1>Reinstate User Account</h1>
    <br>
    <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
            <label class="rulabel1">Step 1: Choose a User Profile</label>
            <br />
            <div class="col-md-6 col-md-offset-3 text-center">
                <select class="form-control text-center" name="userProfiles">
                    <option selected disabled value=""> Select Profile</option>

                    <?php
                    $userProfile = new ReinstateUserController();
                    $profileArr = array();
                    $profileArr = $userProfile->fetchProfileData();

                    foreach ($profileArr as $p => $p_value) {
                        echo '<option value=' . "$p" . '>' . $p_value . '</option>';
                    }
                    ?>

                </select>
                <br />
                <input type="submit" name="submit" value="Submit" class="btn btn-primary" style="background-color:#696969">
            </div>
        </div>
    </form>

    <br>

    <?php
    $displayForm = false;
    if (isset($_POST['submit'])) {
        $displayForm = true;
    }
    if ($displayForm) {
    ?>
        <form class="form-horizontal" action="" method="POST">
            <div class="form-group">
                <label class="rulabel2">Step 2: Please choose a User to reinstate</label>
                <br />
                <div class="col-md-6 col-md-offset-3 text-center">
                    <select class="form-control text-center" name="user">
                        <option selected disabled value=""> Select User</option>
                        <?php
                        $errorCount = 0;
                        if (isset($_POST['submit'])) {
                            $userProfile = new ReinstateUserController();
                            $profileID = checkNull($_POST['userProfiles']);

                            if ($errorCount > 0) {
                                return failure_alert("No user profile selected");
                            } else {
                                $user = new ReinstateUserController();
                                $userArr = array();
                                $userArr = $userProfile->fetchUserData($profileID);

                                //check if there are any users that are suspended in the user profile
                                if (empty($userArr)) {
                                    return success_alert("No users found");
                                } else {
                                    foreach ($userArr as $u => $u_value) {
                                        echo '<option value=' . "$u" . '>' . $u_value . '</option>';
                                    }
                                }
                            }
                        }
                        ?>
                    </select>
                    <br />
                    <input type="submit" name="reinstate" value="Reinstate"  class="btn btn-danger" />
                </div>
            </div>
        </form>
    <?php
    }
    ?>
</div>