    <?php 
        include_once "includes/header.php";
    ?>

    <?php

        // Check if checkout was successful
        if (!isset($_SESSION['checkout_success']) || !$_SESSION['checkout_success']) {
            // Redirect to the checkout page if not successful
            header('Location: checkout.php');
            exit();
        }

        // Clear the success flag after showing the page
        unset($_SESSION['checkout_success']);
    ?>

    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Success!</h4>
            <p>Your order has been successfully placed. Thank you for shopping with us!</p>
            <hr>
            <p class="mb-0">If you have any questions, feel free to <a href="<?php echo URL("contact.php")?>">contact us</a>.</p>
        </div>

        <a href="<?php echo URL()?>" class="btn btn-primary">Return to Home</a>
    </div>

    <?php 
        include_once "includes/footer.php";
    ?>