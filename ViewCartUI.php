<?php
include_once("SubmitOrderController.php");
session_start();
if (!isset($_SESSION['tableNumber']) && !isset($_SESSION['customerPhone'])) {
    die(header("location: index.php"));
} else {
    if (!empty($_GET["action"])) {
        switch ($_GET["action"]) {
            case "remove":
                if (!empty($_SESSION["cart_item"])) {
                    foreach ($_SESSION["cart_item"] as $k => $v) {
                        if ($_GET["name"] == $k)
                            unset($_SESSION["cart_item"][$k]);
                        if (empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                    }
                }
                break;
            case "empty":
                unset($_SESSION["cart_item"]);
                break;
        }
    }
}
?>

<?php
function success_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.location.href='MyBillUI.php?action=clear'</script>";
}

function failure_alert($message)
{
    // Display the alert box  
    echo "<script type='text/javascript'>alert('$message');window.history.go(-1)</script>";
}

if (isset($_POST['submit'])) {
    $order = new SubmitOrderController();
    $tableNumber = $_SESSION['tableNumber'];
    $customerPhone = $_SESSION['customerPhone'];
    $gst = $_POST['gst'];
    $serviceCharge = $_POST['serviceCharge'];
    $total = $_POST['total'];
    $order->addOrder($tableNumber, $customerPhone, $gst, $serviceCharge, $total);
}
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

        <div class="container">
            <h1>My Cart</h1>
            <p>Table no.<?php echo $_SESSION['tableNumber']; ?></p>
            <?php
            if (isset($_SESSION["cart_item"])) {
                $total_quantity = 0;
                $total_price = 0;
            ?>
                <table class="table">
                    <tbody>
                        <tr>
                            <th></th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                        <?php
                        foreach ($_SESSION["cart_item"] as $item) {
                            $item_price = $item["quantity"] * $item["price"];
                        ?>
                            <tr>
                                <td><?php echo "<img src='ItemImages/" . $item['itemImage'] . "' class='imgThumbnail'>" ?></td>
                                <td><?php echo $item["name"]; ?></td>
                                <td><?php echo $item["quantity"]; ?></td>
                                <td><?php echo "$ " . $item["price"]; ?></td>
                                <td><?php echo "$ " . number_format($item_price, 2); ?></td>
                                <td><a href="ViewCartUI.php?action=remove&name=<?php echo $item["name"]; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                            </tr>
                        <?php
                            $total_quantity += $item["quantity"];
                            $total_price += ($item["price"] * $item["quantity"]);
                            $gst = (($total_price / 100) * 7);
                            $service_charge = (($total_price / 100) * 10);
                            $total_cost = ($total_price + $gst + $service_charge);
                        }

                        ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">
                                <a class="btn btn-warning" href="ViewCartUI.php?action=empty">Empty Cart</a>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="5">
                                <strong>
                                    Subtotal: <?php echo "$ " . number_format($total_price, 2); ?><br>
                                    gst(7%): <?php echo "$ " . number_format($gst, 2); ?><br>
                                    Service Charge(10%): <?php echo "$ " . number_format($service_charge, 2); ?><br>
                                    Total: <?php echo "$ " . number_format($total_cost, 2); ?><br>
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <form action="" method="post">
                        <input type="hidden" name="gst" value="<?php echo $gst; ?>">
                        <input type="hidden" name="serviceCharge" value="<?php echo $service_charge; ?>">
                        <input type="hidden" name="total" value="<?php echo $total_cost; ?>">
                        <input type="submit" name="submit" value="Submit Order" class="btn btn-success btn-lg">
                    </form>
                </div>
            <?php
            } else {
            ?>
                <div class="no-records">Your Cart is Empty</div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>