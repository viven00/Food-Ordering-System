<?php
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
    <link href="dashboard.css" rel="stylesheet">
</head>

<!-- <body class="adminbg"> -->
<body>
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-brand">
                9 Brain Cells
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="Admin.php?content=Home">Home</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Admin.php?content=Create+User+Account">Add User Account</a></li>
                    <li><a href="Admin.php?content=Add+User+Profile">Add User Profile</a></li>
                    <li><a href="Admin.php?content=Modify+User+Account">Modify User Account</a></li>
                    <li><a href="Admin.php?content=Modify+User+Profile">Modify User Profile</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Admin.php?content=Suspend+User+Account">Suspend User Account</a></li>
                    <li><a href="Admin.php?content=Suspend+User+Profile">Suspend User Profile</a></li>
                    <li><a href="Admin.php?content=Reinstate+User+Account">Reinstate User Account</a></li>
                    <li><a href="Admin.php?content=Reinstate+User+Profile">Reinstate User Profile</a></li>
                </ul>
                <hr class="new1">
                <ul class="nav nav-sidebar">
                    <li><a href="Admin.php?content=Search+User+Account">Search User Account</a></li>
                    <li><a href="Admin.php?content=Search+User+Profile">Search User Profile</a></li>
                </ul>
                <hr class="new1">
                <div class="fixed-bottom">
                    <ul class="nav nav-sidebar">
                        <li><a href="Admin.php?content=Logout">Logout</a></li>
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
                    case 'Create User Account':
                        include('AddUserUI.php');
                        break;
                    case 'Suspend User Account':
                        include('SuspendUserUI.php');
                        break;
                    case 'Suspend User Profile':
                        include('SuspendUserProfileUI.php');
                        break;
                    case 'Reinstate User Account':
                        include('ReinstateUserUI.php');
                        break;
                    case 'Reinstate User Profile':
                        include('ReinstateUserProfileUI.php');
                        break;
                    case 'Search User Account':
                        include('SearchUserUI.php');
                        break;
                    case 'Search User Profile':
                        include('SearchProfilesUI.php');
                        break;
                    case 'Add User Profile':
                        include('AddUserProfileUI.php');
                        break;
                    case 'Modify User Account':
                        include('ModifyUserAcctUI.php');
                        break;
                    case 'Modify User Profile':
                        include('ModifyUserProfileUI.php');
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