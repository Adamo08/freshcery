        <?php
            
            if (!isset($_SERVER['HTTP_REFERER'])){
                header("Location: http://localhost/Freshcery/index.php");
                exit();
            }
            
        ?>
        <?php require_once "includes/header.php"?>

        <?php 
    
            if (!isset($_SESSION['user'])){
                // header("Location: localhost/Freshcery");
                echo "<script> window.location.href = 'http:://localhost/Freshcery/' </script>";
                exit();
            }
        
        ?>

        <?php 

            $totalPrice = number_format($_SESSION['total_price'], 2, '.', '');
            // echo $totalPrice;
        
        ?>


        <div id="page-content" class="page-content">
            <div class="banner">
                <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                    <div class="container">
                        <h1 class="py-5 text-white">
                            Pay with PayPal - Page
                        </h1>
                    </div>
                </div>
            </div>


            <!-- Main Content Container -->
            <div class="container d-flex align-items-center justify-content-center flex-column mt-5">
                <h2 class="text-center">Complete Your Payment</h2>
                <p class="text-center text-muted">Please click the button below to proceed with your payment.</p>
                
                <!-- PayPal Button Container -->
                <div id="paypal-button-container"></div>
            </div>

            <!-- PayPal SDK -->
            <script src="https://www.paypal.com/sdk/js?client-id=AZuJRffuEckG1Fl43Of3s4H4kuUE7LG4eofNqUFxodILrSLZ9ZXm1JQhbYu4LMLlKlhMXpyQgitLH1zz&currency=USD"></script>
            <script>
                // Use PHP to output the formatted total price into a JavaScript variable
                var totalPrice = <?php echo json_encode($totalPrice); ?>;

                paypal.Buttons({
                    // Sets up the transaction when a payment button is clicked
                    createOrder: (data, actions) => {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: totalPrice
                                }
                            }]
                        });
                    },
                    // Finalize the transaction after payer approval
                    onApprove: (data, actions) => {
                        return actions.order.capture().then(function(orderData) {
                            window.location.href = 'success.php';
                        });
                    }
                }).render('#paypal-button-container');
            </script>


        </div>

        <br>
        <br>
        
        <?php require_once "includes/footer.php"?>
