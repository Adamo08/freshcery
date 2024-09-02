

    <?php 
        include_once "includes/header.php";
        include_once "config/config.php";
    ?>

    <?php 
    
        if (!isset($_SESSION['user'])){
            // header("Location: localhost/Freshcery");
            echo "<script> window.location.href = 'localhost/Freshcery' </script>";
            exit();
        }
    
    ?>

    <?php 

        // Getting the list of the products added by the user
        $sql = "SELECT * FROM card WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $_SESSION['user']['id']);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Store the products in the session
        $_SESSION['products'] = $products;

    ?>

    <?php 

        if (isset($_POST['submit'])){
            $tl_price = $_POST['total_price'];

            // Storing the variable in the session
            $_SESSION['price'] = $tl_price;

            echo "<script> window.location.href = 'checkout.php';</script>";

            exit(); // Stop further script execution
        }
    
    ?>


    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Cart
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th>Products</th>
                                        <th>Price</th>
                                        <th width="15%">Quantity</th>
                                        <th width="15%">Update</th>
                                        <th>Subtotal</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($products) > 0): ?>
                                        <?php
                                            $total_price = 0; // Initialize total price variable

                                            foreach ($products as $product):
                                                // Calculate updated price after discount
                                                $updated_price = $product['price'] - ($product['price'] * $product['discount'] / 100);

                                                // Calculate subtotal for the current product
                                                $subtotal = $updated_price * $product['product_quantity'];

                                                // Accumulate the subtotal into the total price
                                                $total_price += $subtotal;
                                        ?>
                                            <tr>
                                                <td>
                                                    <img 
                                                        src='<?= URL("assets/img/{$product['image']}") ?>' 
                                                        width="60" 
                                                        height="60"
                                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                                    >
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($product['name']) ?><br>
                                                    <small>1000g</small>
                                                </td>
                                                <td class="pro_price">
                                                    USD <?= number_format($updated_price, 2, ',', '.') ?>
                                                </td>
                                                <td>
                                                <input 
                                                    class="pro_qty form-control" 
                                                    type="number" 
                                                    min="1"
                                                    max="<?= htmlspecialchars($product['stock']) ?>" 
                                                    value="<?= htmlspecialchars($product['product_quantity']) ?>" 
                                                    name="quantity"
                                                    data-product-id="<?= htmlspecialchars($product['product_id']) ?>"
                                                >

                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-primary update-btn">UPDATE</a>
                                                </td>
                                                <td>
                                                    USD <?= number_format($subtotal, 2, ',', '.') ?>
                                                </td>
                                                <td>
                                                    <a data-product-id="<?=$product['product_id']?>" class="text-danger delete-btn cursor-pointer"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <?php $total_price = 0;?>
                                        <tr>
                                            <td colspan="7">
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    Your cart is empty. Go to the <a href="<?= URL('shop.php') ?>">shopping</a> page.
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <a href="<?php echo URL('shop.php')?>" class="btn btn-default">Continue Shopping</a>
                    </div>
                    <div class="col text-right">
                        <form action="cart.php" method="POST">
                            <div class="clearfix"></div>
                            <h6 class="mt-3 total_price">Total: USD <?= number_format($total_price, 2, ',', '.'); ?></h6>
                            <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price); ?>">
                            <?php if (count($products) > 0):?>
                                <button 
                                    type="submit" name="submit" 
                                    class="btn btn-lg btn-primary"
                                >
                                    Checkout 
                                    <i class="fa fa-long-arrow-right"></i>
                                </button>
                            <?php endif;?>
                        </form>
                    </div>

                </div>
            </div>
        </section>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {

            $(".form-control").keyup(function(){
                var value = $(this).val();
                value = value.replace(/^(0*)/,"");
                $(this).val(1);
            });

            $('.update-btn').click(function(e){
                e.preventDefault();

                // Get the row that contains the clicked button
                var $row = $(this).closest('tr');

                // Get the product ID and quantity from the input field
                var product_id = $row.find('input[name="quantity"]').data('product-id');
                var quantity = $row.find('input[name="quantity"]').val();

                // Send the AJAX request to update the quantity
                $.ajax({
                    url: 'update_cart.php',
                    method: 'POST',
                    data: {
                        product_id: product_id,
                        quantity: quantity
                    },
                    success: function(response) {
                        // Parse the response
                        var data = JSON.parse(response);

                        // Update the subtotal and total price
                        $row.find('.pro_price').text(data.updated_price);
                        $row.find('.pro_qty').val(data.quantity);
                        $row.find('td:nth-child(6)').text('USD ' + data.subtotal);
                        $('.total_price').text('USD ' + data.total_price);

                        // Optionally display a success message
                        alert('Cart updated successfully');
                    }
                });
            });

            $('.delete-btn').click(function(e){
                e.preventDefault();

                // Get the row that contains the clicked button
                var $row = $(this).closest('tr');

                // Get the product ID from the delete button
                var product_id = $(this).data('product-id');

                // Send the AJAX request to delete the product
                $.ajax({
                    url: 'delete_from_cart.php',
                    method: 'POST',
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        // Parse the response
                        var data = JSON.parse(response);

                        if (data.success) {
                            // Remove the row from the table
                            $row.remove();

                            // Update the total price
                            $('.total_price').text('USD ' + data.total_price);

                            // Optionally display a success message
                            alert('Product removed successfully');
                            // Reloading the page 
                            reload();

                        } else {
                            alert('Error removing product from cart');
                        }
                    }
                });
            });


            function reload(){
                $("body").load("cart.php");
            }

        
        })
    </script>
</body>
</html>
