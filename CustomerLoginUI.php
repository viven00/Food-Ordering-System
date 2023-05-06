<?php
session_start(); // start session to manipulate session variables
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="theme.css">
    <title>Document</title>
</head>

<body id="custbg">
    <?php
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
        $tableNumber = checkNull($_POST['tableNumber']);
        $phoneNumber = checkNull($_POST['phoneNumber']);
        if ($errorCount > 0) {
            return failure_alert("There is/are blank(s) not filled. Please fill in all the blanks.");
        } else {
            if (preg_match("/^([8-9]{1})([0-9]{7})$/", $phoneNumber)) {
                $_SESSION['tableNumber'] =  $tableNumber;
                $_SESSION['customerPhone'] = $phoneNumber;

                header("location:ViewMenuItemUI.php");
            } else {
                return failure_alert("Your contact number must start with 8 or 9 and a length of 8 numbers.");
            }
        }
    }
    ?>
    <div id="loginbox">
        <div class="container text-center">
            <h3>Please enter your table number and phone number:</h3>

            <br>
            <form class="form-horizontal"action="" method="post">
                <div class="form-group">
                    <div class="col-sm-4 col-md-offset-4">
                        <strong> Table number: </strong>
                        <input type="text" class="form-control" name="tableNumber">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-sm-4 col-md-offset-4">
                        <strong> Phone number: </strong>
                        <input type="number" class="form-control" name="phoneNumber">
                        <br>
                        <input type="submit" name="submit" value="Go!" class="btn btn-default" style="background-color:#fff"><br><br>
                    </div>
                </div>
                <br>
            </form>
            <a href="index.php">Go back to index</a>
        </div>
    </div>
</body>

</html>