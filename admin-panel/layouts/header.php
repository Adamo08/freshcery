<?php 
  // Starting the session if not started yet
  if (session_status() == PHP_SESSION_NONE){
      @session_start();
  }

  // Getting the current admin
  $admin = @$_SESSION['admin'];


?>


<?php require "C:/xampp/htdocs/Freshcery/admin-panel/helpers/helpers.php"; ?>
<?php require "C:/xampp/htdocs/Freshcery/config/config.php"; ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo APP_URL."admin-panel/styles/style.css"?>" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
  <div id="wrapper">
    <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="<?php echo APP_URL."admin-panel/"?>">Freshcery</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
          aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav side-nav">
            <li class="nav-item">
              <a class="nav-link text-white" style="margin-left: 20px;" href="<?php echo APP_URL."admin-panel"?>">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo APP_URL."admin-panel/admins/admins.php"?>" style="margin-left: 20px;">Admins</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo APP_URL."admin-panel/categories-admins/show-categories.php"?>" style="margin-left: 20px;">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo APP_URL."admin-panel/products-admins/show-products.php"?>" style="margin-left: 20px;">Products</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?php echo APP_URL."admin-panel/orders-admins/show-orders.php"?>" style="margin-left: 20px;">Orders</a>
            </li>

          </ul>
          <ul class="navbar-nav ml-md-auto d-md-flex">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo APP_URL."admin-panel"?>">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <?php if (!@isset($_SESSION['admin'])) :?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo APP_URL."admin-panel/admins/login-admins.php"?>">login
                  <span class="sr-only">(current)</span>
                </a>
              </li>
            <?php else:?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <?=$admin['username']?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="<?php echo APP_URL."admin-panel/admins/logout-admins.php"?>">Logout</a>

              </li>
            <?php endif;?>


          </ul>
        </div>
        </div>
    </nav>
    <div class="container-fluid">