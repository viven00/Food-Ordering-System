<?php
session_start();
include_once("MyBillController.php");

if (!isset($_SESSION['tableNumber']) && !isset($_SESSION['customerPhone'])) {
    die(header("location: index.php"));
} else {
    if (!empty($_GET["action"])) {
        switch ($_GET["action"]) {
            case "clear":
                unset($_SESSION["cart_item"]);
                break;
        }
    }
}

function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='EndOrder.php'</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

if (isset($_POST['addDiscount'])) {
    $discount = new MyBillController;
    $discountCode = $_POST['discountCode'];

    $discount->checkDiscountCode($discountCode);
}

if (isset($_POST['removeDiscount'])) {
    unset($_SESSION["discountCode"]);
}

if (isset($_POST['submit'])) {
    $payment = new MyBillController;
    $paymentMethod = $_POST['pMethod'];
    $total = $_POST['total'];
    $gst = $_POST['gst'];
    $serviceCharge = $_POST['serviceCharge'];
    $payment->updatePayment($paymentMethod, $total, $gst, $serviceCharge);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Customer</title>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    </button>
                    <a class="navbar-brand" href="#">9 Brain Cells</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="ViewMenuItemUI.php">Menu</a></li>
                        <li><a href="MyBillUI.php">My Bill</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="ViewCartUI.php">Cart <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                        <li><a href="EndOrder.php">Exit</a></li>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <h1>My Bill</h1>
            <?php
            if (isset($_SESSION["orderID"])) {
                $order = new MyBillController;
                $orderItemsArr = array();
                $orderStatusArr = array();
                $orderItemsArr = $order->getOrderItems();
                $orderStatusArr = $order->getOrderStatus();
            ?>
                <p>Table no.<?php echo $_SESSION['tableNumber']; ?></p>
                <p>Order no.<?php echo $_SESSION['orderID']; ?></p>
                <table class="table">
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                    </tr>
                    <?php
                    foreach ($orderItemsArr as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row['itemName']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                        </tr>
                    <?php
                    }
                    foreach ($orderStatusArr as $row) {
                        if (isset($_SESSION['discountCode'])) {
                            $discount = new MyBillController;
                            $discountAmt = $discount->getDiscountAmount();

                            $discountAmount = (100 - $discountAmt) / 100;
                            $total = $row['total'] * $discountAmount;
                            $gst = (($total / 117) * 7);
                            $service_charge = (($total / 117) * 10);
                            $subtotal = $total - $gst - $service_charge;
                        } else {
                            $total = $row['total'];
                            $gst = $row['gst'];
                            $service_charge = $row['serviceCharge'];
                        }
                    ?>
                        <tr>
                            <td align="right">
                                <strong>
                                    gst (7%): <?php echo "$ " . number_format($gst, 2); ?><br>
                                    Service Charge(10%): <?php echo "$ " . number_format($service_charge, 2); ?><br>
                                    Total: <?php echo "$ " . number_format($total, 2); ?><br>
                                </strong>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <div class="text-center">
                    <?php
                    if (!isset($_SESSION['discountCode'])) {
                    ?>
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group">
                                <label class="col-md-6 col-md-offset-3 text-center" for="username">Discount Code (If applicable):</label>
                                <br />
                                <div class="col-md-4 col-md-offset-4 text-center">
                                    <input type="text" class="form-control" name="discountCode">
                                    <br>
                                    <input type="submit" name="addDiscount" value="Add Discount" class="btn btn-primary" style="background-color:#696969">
                                </div>
                            </div>
                        </form>
                        <br>
                    <?php
                    } else {
                    ?>
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <input type="text" name="discountCode" class="form-control" value="<?php echo $_SESSION['discountCode']; ?>" disabled>
                                    <br>
                                    <input type="submit" name="removeDiscount" value="Remove Discount" class="btn btn-primary" style="background-color:#696969">
                                </div>
                            </div>
                        </form>
                        <br>
                    <?php
                    }
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="total" value="<?php echo $total ?>">
                        <input type="hidden" name="gst" value="<?php echo $gst ?>">
                        <input type="hidden" name="serviceCharge" value="<?php echo $service_charge ?>">
                        <div class="form-group text-center">
                            <label for="email">Please choose your payment option:</label>
                            <br>
                            <div class="radio">
                                <label class="radio-inline">
                                    <input type="radio" name="pMethod" value="counter">Pay At Counter
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="pMethod" value="card">Card Payment
                                </label>
                            </div>
                            <br>
                            <input type="submit" name="submit" class="btn btn-success" value="Make Payment">
                        </div>
                    </form>
                </div>
            <?php
            } else {
                echo "Your bill is empty.";
            }
            ?>
        </div>
    </div>
</body>

</html>