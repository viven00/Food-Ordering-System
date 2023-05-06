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
                    <li><a href="Owner.php?content=Home">Home</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Owner.php?content=Daily+Customers+Visit+Report">Daily Customers Visit Report</a></li>
                    <li><a href="Owner.php?content=Weekly+Customers+Visit+Report">Weekly Customers Visit Report</a></li>
                    <li><a href="Owner.php?content=Monthly+Customers+Visit+Report">Monthly Customers Visit Report</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Owner.php?content=Daily+Item+Report">Daily Item Report</a></li>
                    <li><a href="Owner.php?content=Weekly+Item+Report">Weekly Item Report</a></li>
                    <li><a href="Owner.php?content=Monthly+Item+Report">Monthly Item Report</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Owner.php?content=Daily+Sales+Report">Daily Sales Report</a></li>
                    <li><a href="Owner.php?content=Weekly+Sales+Report">Weekly Sales Report</a></li>
                    <li><a href="Owner.php?content=Monthly+Sales+Report">Monthly Sales Report</a></li>
                </ul>
                <hr class="new1">
                <div class="fixed-bottom">
                    <ul class="nav nav-sidebar">
                        <li><a href="Owner.php?content=Logout">Logout</a></li>
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
                    case 'Daily Customers Visit Report':
                        include('DailyCustomerReportUI.php');
                        break;
                    case 'Weekly Customers Visit Report':
                        include('WeeklyCustomerReportUI.php');
                        break;
                    case 'Monthly Customers Visit Report':
                        include('MonthlyCustomerReportUI.php');
                        break;
                    case 'Daily Item Report':
                        include('DailyItemReportUI.php');
                        break;
                    case 'Weekly Item Report':
                        include('WeeklyItemReportUI.php');
                        break;
                    case 'Monthly Item Report':
                        include('MonthlyItemReportUI.php');
                        break;
                    case 'Daily Sales Report':
                        include('DailySaleReportUI.php');
                        break;
                    case 'Weekly Sales Report':
                        include('WeeklySalesReportUI.php');
                        break;
                    case 'Monthly Sales Report':
                        include('MonthlySalesReportUI.php');
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