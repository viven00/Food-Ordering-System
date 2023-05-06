<?php
include_once("AddUserController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
    die(header("location: index.php"));
}
?>
<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='Admin.php?content=Create+User+Account'</script>";
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
    $user = new AddUserController();
    $username = checkNull($_POST['username']);
    $password = checkNull($_POST['password']);
    $name = checkNull($_POST['name']);
    $email = checkNull($_POST['email']);
    $phoneNumber = checkNull($_POST['phoneNumber']);
    $userProfile = checkNull($_POST['userProfile']);

    if ($errorCount > 0) {
        return failure_alert("There is/are blank(s) not filled. Please fill in all the blanks.");
    } 
    else 
    {
        if (preg_match("/^([8-9]{1})([0-9]{7})$/", $phoneNumber))
        {
            $user->addAccount($username, $password, $name, $email, $phoneNumber, $userProfile);
        }
        else
        {
            return failure_alert("Your contact number must start with 8 or 9 and a length of 8 numbers.");
        }
    }
}
?>

<div class="contentBox">
    <h1>Create User Account</h1>
    <p>Please fill up this form to create new account</p>
    <br />
    <form class="form-horizontal" action="" method="post">

        <div class="form-group">
            <label class="control-label col-sm-4" for="username">Username:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="username">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="name">Name:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="email">Email:</label>
            <div class="col-sm-4">
                <input type="email" class="form-control" name="email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="phoneNumber">Contact Number:</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" name="phoneNumber">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="password">Password:</label>
            <div class="col-sm-4">
                <input type="password" class="form-control" name="password">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="userprofile">Profile Type: </label>
            <div class="col-sm-4">
                <select class="form-control" name="userProfile" required>
                    <option selected disabled value=""> ----------------------</option>
                    <?php
                    $userProfile = new AddUserController();
                    $profileArr = array();
                    $profileArr = $userProfile->getProfile();

                    foreach ($profileArr as $p => $p_value) {
                        echo '<option value=' . "$p" . '>' . $p_value . '</option>';
                    }
                    ?>
                </select>
                </br>
                <input type="submit" name="submit" value="Submit" class="btn btn-primary" style="background-color:#696969">
            </div>
        </div>
    </form>
</div>