    
    <?php
    
        if (!isset($_SERVER['HTTP_REFERER'])){
            header("Location: http://localhost/Freshcery/index.php");
            exit();
        }
        
    ?>
    
    <?php 
        require "includes/header.php";
        require "config/config.php";
    ?>

    <?php 
        
        if (!isset($_SESSION['user'])){
            // header("Location: localhost/Freshcery");
            echo "<script> window.location.href = 'localhost/Freshcery' </script>";
            exit();
        }

    ?>

    <?php

        // Check if checkout was successful
        if (!isset($_SESSION['checkout_success']) || !$_SESSION['checkout_success']) {
            // Redirect to the checkout page if not successful
            echo "<script> window.location.href = 'checkout.php' </script>";
            exit();
        }

        // Clear the success flag after showing the page
        unset($_SESSION['checkout_success']);


        // Function to clear the cart for the current user
        function clearUserCart($userId, $pdo) {
            $stmt = $pdo->prepare("DELETE FROM card WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
        }

        // Ensure the user is logged in
        if (isset($_SESSION['user'])) {
            clearUserCart($_SESSION['user']['id'], $conn);
        }

    ?>


    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">Order Confirmed</h1>
                    <p class="lead">Thank you for your purchase!</p>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Success!</h4>
                <p>Your order has been successfully placed. Thank you for shopping with us!</p>
                <hr>
                <p class="mb-0">If you have any questions, feel free to <a href="<?php echo URL("contact.php")?>">contact us</a>.</p>
            </div>

            <a href="<?php echo URL()?>" class="btn" style="background-color: #E91E63;">Return to Home</a>
        </div>
    </div>

    <?php 
        include_once "includes/footer.php";
    ?>