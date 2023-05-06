<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="dashboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="theme.css">
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">9 Braincells</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="Staff.php?content=Home">Home</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Staff.php?content=Search+Order">Search Order</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Staff.php?content=Update+Order">Modify Order</a></li>
                    <li><a href="Staff.php?content=Delete+Order">Delete Order</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Staff.php?content=Validate+Payment">Validate Payment</a></li>
                </ul>
                <hr class="new1">
                <div class="fixed-bottom">
                    <ul class="nav nav-sidebar">
                        <li><a href="Staff.php?content=Logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Start of Dynamic Content section -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?php
            if (isset($_GET['content'])) {
                switch ($_GET['content']) {
                    case 'Home': // A value of 'Home' means to display the default page
                    default:
                        include('HomeUI.php');
                        break;
                    case 'Search Order': 
                        include('SearchOrderUI.php');
                        break;
                    case 'Update Order': 
                        include('ModifyOrderUI.php');
                        break;
                    case 'Delete Order': 
                        include('DeleteOrderUI.php');
                        break;
                    case 'Validate Payment': 
                        include ('ValidatePaymentUI.php');
                        break;
                    case 'Logout':
                        include('Logout.php');
                        break;
                }
            } else // No button has been selected
            {
                include('HomeUI.php');
            }
            ?>
        </div>
        <!-- End of Dynamic Content section -->
    </div>
</body>

</html>