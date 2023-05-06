<?php
session_start();
include_once("ViewMenuItemController.php");
if (!isset($_SESSION['tableNumber']) && !isset($_SESSION['customerPhone'])) {
    die(header("location: index.php"));
}
else {
    if (!empty($_GET["action"])) {
        switch ($_GET["action"]) {
            case "add":
                if (!empty($_POST["quantity"])) {
                    $itemName = $_POST["itemName"];
                    $itemArray = 
                    array($itemName => array(
                        'itemID' => $_POST["itemID"], 
                        'name' => $_POST["itemName"], 
                        'quantity' => $_POST["quantity"], 
                        'price' => $_POST["itemPrice"],
                        'itemImage' => $_POST["itemImage"]
                    ));

                    if (!empty($_SESSION["cart_item"])) {
                        if (in_array($itemName, array_keys($_SESSION["cart_item"]))) {
                            foreach ($_SESSION["cart_item"] as $k => $v) {
                                if ($itemName == $k) {
                                    if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                            }
                        } else {
                            $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                        }
                    } else {
                        $_SESSION["cart_item"] = $itemArray;
                    }
                }
                break;
        }
    }
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
            <div class="text-center">
                <h1>All Menu Items</h1>
            </div>
            <br>
            <div>
                <?php
                // echo $_SESSION['tableID']."<br>";
                // echo $_SESSION['customerPhone'];

                $viewMenuItems = new ViewMenuItemController;
                $menuItemsArr = array();
                $menuItemsArr = $viewMenuItems->getAllMenuItems();

                foreach ($menuItemsArr as $row) {
                ?>
                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading panelHeading-height">
                                <h4><?php echo $row['itemName']; ?></h4>
                            </div>

                            <div class="panel-body panelBody-height text-center">
                                <?php
                                echo "<img src='ItemImages/" . $row['itemImage'] . "' class='img-thumbnail imgMenu'> <br><br>";
                                echo "Description: <br>" . $row['itemDescription']; 
                                ?>
                            </div>
                            <div class="panel-footer">
                                <div class="row text-center">
                                    <b>$<?php echo $row['itemPrice']; ?></b>
                                </div>
                                <br>
                                <form action="ViewMenuItemUI.php?action=add&itemID=<?php echo $row['itemID']; ?>" method="post">
                                    <input type="hidden" name="itemID" value="<?php echo $row['itemID']; ?>">
                                    <input type="hidden" name="itemName" value="<?php echo $row['itemName']; ?>">
                                    <input type="hidden" name="itemPrice" value="<?php echo $row['itemPrice']; ?>">
                                    <input type="hidden" name="itemImage" value="<?php echo $row['itemImage']; ?>">
                                 
                                    <div class="col-sm-6">
                                    <input type="number" name="quantity" class="form-control" value="1" min="1"/>
                                    <!-- <input type="submit" class="btn btn-primary btn-sm" value="Add to cart"> -->
                                    </div>
                                    
                                    <input type="submit" class="btn btn-primary btn-sm" value="Add to cart">
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>