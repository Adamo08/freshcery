    <?php
        // Including the helpers file
        include_once '../helpers/helpers.php';
        // Including the database file
        include_once '../config/config.php';

    ?>



    <?php 
        
        $msg = ""; // A message to be shown if an error occurs

    if (isset($_POST['submit'])) {

        // Retrieve form data
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $repassword = trim($_POST['repassword']);

        // Validation
        if (empty($full_name) || empty($email) || empty($username) || empty($password) || empty($repassword)) {
            $msg = "<li style='color:red'>All fields are required.</li>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "<li style='color:red'>Invalid email format.</li>";
        } elseif ($password !== $repassword) {
            $msg = "<li style='color:red'>Passwords do not match.</li>";
        } else {
            // Check if the username or email already exists
            $stmt = $conn->prepare("SELECT id FROM `users` WHERE email = :email OR username = :username");
            $stmt->execute([':email' => $email, ':username' => $username]);
            if ($stmt->rowCount() > 0) {
                $msg = "<li style='color:red'>Email or username already exists.</li>";
            } else {
                // Hash the password and insert the new user
                $hashed_password = hash('sha256', $password); // SHA256 for hashing

                $stmt = $conn->prepare("INSERT INTO users (full_name, email, username, password) VALUES (:full_name, :email, :username, :password)");
                $result = $stmt->execute([
                    ':full_name' => $full_name,
                    ':email' => $email,
                    ':username' => $username,
                    ':password' => $hashed_password
                ]);

                if ($result) {
                    // Redirect the user to the login page
                    header('Location: login.php');
                } else {
                    $msg = "<li style='color:red'>Registration failed. Please try again.</li>";
                }
            }
        }
    }
    
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
                            <a href="<?php echo URL('auth/register.php'); ?>" class="nav-link">Register</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo URL('auth/login.php'); ?>" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar-header"><img src="<?php echo URL('assets/img/logo/avatar.jpg'); ?>"></div> John Doe
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo URL('transaction.php'); ?>">Transactions History</a>
                                <a class="dropdown-item" href="<?php echo URL('setting.php'); ?>">Settings</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo URL('cart.php'); ?>" class="nav-link" data-toggle="" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-shopping-basket"></i> <span class="badge badge-primary">5</span>
                            </a>
                        
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>


    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('../assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Register Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>

                    <div class="card card-login mb-5">
                        <div class="card-body">
                            <form class="form-horizontal" action="" method="POST">
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="full_name" required="" placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" type="email" name="email" required="" placeholder="Email">
                                    </div>
                                </div>
                                
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="username" required="" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input class="form-control" type="password" name="password" required="" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input class="form-control" type="password" name="repassword" required="" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <div class="col-md-12">
                                        <?php 
                                            if (!empty($msg)){
                                                echo $msg;
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row text-center mt-4">
                                    <div class="col-md-12">
                                        <button type="submit" name="submit" class="btn btn-primary btn-block text-uppercase">Register</button>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="col-md-12">
                                        <p class="text-center">Already have an account? <a href="login.php">Login</a></p>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>About</h5>
                    <p>Nisi esse dolor irure dolor eiusmod ex deserunt proident cillum eu qui enim occaecat sunt aliqua anim eiusmod qui ut voluptate.</p>
                </div>
                <div class="col-md-3">
                    <h5>Links</h5>
                    <ul>
                        <li><a href="<?php echo URL('about.php'); ?>">About</a></li>
                        <li><a href="<?php echo URL('contact.php'); ?>">Contact Us</a></li>
                        <li><a href="<?php echo URL('faq.php'); ?>">FAQ</a></li>
                        <li><a href="javascript:void(0)">How it Works</a></li>
                        <li><a href="<?php echo URL('terms.php'); ?>">Terms</a></li>
                        <li><a href="<?php echo URL('privacy.php'); ?>">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul>
                        <li><a href="tel:+620892738334"><i class="fa fa-phone"></i> 08272367238</a></li>
                        <li><a href="mailto:hello@domain.com"><i class="fa fa-envelope"></i> hello@domain.com</a></li>
                    </ul>
                    <h5>Follow Us</h5>
                    <ul class="social">
                        <li><a href="javascript:void(0)" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="javascript:void(0)" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="javascript:void(0)" target="_blank"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Get Our App</h5>
                    <ul class="mb-0">
                        <li class="download-app"><a href="#"><img src="<?php echo URL('assets/img/playstore.png'); ?>"></a></li>
                        <li style="height: 200px">
                            <div class="mockup">
                                <img src="<?php echo URL('assets/img/mockup.png'); ?>">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="copyright">&copy; 2018 Freshcery | Groceries Organic Store. All rights reserved.</p>
    </footer>

    <script type="text/javascript" src="<?php echo URL('assets/js/jquery.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/js/jquery-migrate.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/packages/bootstrap/libraries/popper.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/packages/bootstrap/bootstrap.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/packages/o2system-ui/o2system-ui.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/packages/owl-carousel/owl-carousel.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/packages/cloudzoom/cloudzoom.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/packages/thumbelina/thumbelina.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/packages/bootstrap-touchspin/bootstrap-touchspin.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL('assets/js/theme.js'); ?>"></script>
    </body>
    </html>
