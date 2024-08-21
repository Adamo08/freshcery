

<?php
    // Including the helpers file
    include 'helpers/helpers.php';
    session_start();
    $user = @$_SESSION['user'];
?>




<!DOCTYPE html>
<html>
<head>
    <title>Freshcery | Groceries Organic Store</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="<?php echo URL('assets/fonts/sb-bistro/sb-bistro.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo URL('assets/fonts/font-awesome/font-awesome.css'); ?>" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL('assets/packages/bootstrap/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL('assets/packages/o2system-ui/o2system-ui.css'); ?>">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL('assets/packages/owl-carousel/owl-carousel.css'); ?>">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL('assets/packages/cloudzoom/cloudzoom.css'); ?>">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL('assets/packages/thumbelina/thumbelina.css'); ?>">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL('assets/packages/bootstrap-touchspin/bootstrap-touchspin.css'); ?>">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL('assets/css/theme.css'); ?>">

</head>
<body>
    <div class="page-header">
        <!--=============== Navbar ===============-->
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-transparent" id="page-navigation">
            <div class="container">
                <!-- Navbar Brand -->
                <a href="<?php echo URL('index.php'); ?>" class="navbar-brand">
                    <img src="<?php echo URL('assets/img/logo/logo.png'); ?>" alt="">
                </a>

                <!-- Toggle Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarcollapse">
                    <!-- Navbar Menu -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="<?php echo URL('shop.php'); ?>" class="nav-link">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo URL('about.php'); ?>" class="nav-link">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo URL('contact.php'); ?>" class="nav-link">Contact</a>
                        </li>

                        <?php if (!@$_SESSION['user']):?>

                        <li class="nav-item">
                            <a href="<?php echo URL('auth/register.php'); ?>" class="nav-link">Register</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo URL('auth/login.php'); ?>" class="nav-link">Login</a>
                        </li>
                        
                        <?php else :?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar-header"><img src="<?php echo URL('assets/img/logo/profile.png'); ?>"></div> 
                                <?php echo @$user['full_name']?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo URL('transaction.php'); ?>">Transactions History</a>
                                <a class="dropdown-item" href="<?php echo URL('setting.php'); ?>">Settings</a>
                                <a class="dropdown-item" href="<?php echo URL('auth/logout.php'); ?>">Log Out</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo URL('cart.php'); ?>" class="nav-link" data-toggle="" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-shopping-basket"></i> <span class="badge badge-primary">5</span>
                            </a>
                        </li>

                        <?php endif;?>

                    </ul>
                </div>

            </div>
        </nav>
    </div>


