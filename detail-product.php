

    <?php 
        include_once "includes/header.php";
        include_once "config/config.php";
    ?>


    <?php 
    
        if (isset($_GET['id'])){

            $id = $_GET['id'];
            $sql = "SELECT * FROM products WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // The price of the product
            $price = $product['price'];
            // The discounted price
            $discount = $product['discount'];
            $discounted_price = $price - ($price * $discount / 100);

            // Getting the related products (belong to the same category)
            $category_id = $product['category_id'];
            $sql = "SELECT * FROM products WHERE category_id = :category_id AND id != :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':category_id' => $category_id, ':id' => $product['id']]);
            $related_products = $stmt->fetchAll(PDO::FETCH_ASSOC);


            // Validating the product
            if (isset($_SESSION['user'])){

                $user_id = $_SESSION['user']['id'];
                $sql = "SELECT * FROM card WHERE user_id = :user_id AND product_id = :product_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':user_id' => $user_id, ':product_id' => $id]);
                $product_in_card = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($product_in_card){
                    $product_in_card = true;
                } 
                else {
                    $product_in_card = false;
                }
            }

        }

        // Adding product to the card
        if (isset($_POST['submit'])) {
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_description'];
            $product_price = $_POST['price'];
            $stock = $_POST['stock'];
            $quantity = $_POST['quantity'];
            $discount = $_POST['discount'];
            $discounted_price = $_POST['discounted_price'];
            $product_image = $_POST['image'];
            $product_sku = $_POST['sku'];
            $product_status = $_POST['status'];
            $expiration_date = $_POST['expiration_date'];
            $category_id = $_POST['category_id'];
            $user_id = $_POST['user_id'];

            // Inserting to the card table 
            try {
                // SQL query to insert data into the card table
                $sql = "INSERT INTO card (
                            name,
                            description,
                            product_id,
                            user_id,
                            category_id,
                            image,
                            price,
                            discount,
                            discounted_price,
                            stock,
                            product_quantity,
                            expiration_date
                        )
                        VALUES (
                            :name,
                            :description,
                            :product_id,
                            :user_id,
                            :category_id,
                            :image,
                            :price,
                            :discount,
                            :discounted_price,
                            :stock,
                            :product_quantity,
                            :expiration_date
                        )";
        
                // Prepare the SQL statement
                $stmt = $conn->prepare($sql);
        
                // Bind the parameters
                $stmt->bindParam(':name', $product_name);
                $stmt->bindParam(':description', $product_description);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':category_id', $category_id);
                $stmt->bindParam(':image', $product_image);
                $stmt->bindParam(':price', $product_price);
                $stmt->bindParam(':discount', $discount);
                $stmt->bindParam(':discounted_price', $discounted_price);
                $stmt->bindParam(':stock', $stock);
                $stmt->bindParam(':product_quantity', $quantity);
                $stmt->bindParam(':expiration_date', $expiration_date);
        
                // Execute the SQL statement
                $stmt->execute();

            } catch (PDOException $e) {
                $msg =  "Error: " . $e->getMessage();
            }
        }
    
    ?>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        <?php echo $product['name']?>
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>
        <div class="product-detail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="slider-zoom">
                            <a href="<?php echo URL("assets/img/$product[image]")?>" class="cloud-zoom" rel="transparentImage: 'data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', useWrapper: false, showTitle: false, zoomWidth:'500', zoomHeight:'500', adjustY:0, adjustX:10" id="cloudZoom">
                                <img 
                                    alt="Detail Zoom thumbs image" 
                                    src="<?php echo URL("assets/img/$product[image]")?>" 
                                    style="width: 100%; height:500px;"

                                >
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>Overview</strong><br>
                            <?php echo $product['description']?>
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <strong>Price</strong> (/Pack)<br>
                                    <span class="price">Rp <?=number_format($discounted_price, 2, ',', '.');?></span>
                                    <span class="old-price">Rp <?=number_format($price, 2, ',', '.');?></span>
                                </p>
                            </div>
                        
                        </div>
                        <p class="mb-1">
                            <strong>Quantity</strong>
                        </p>
                        <form action="" method="POST" id="form-data">

                            <div class="row">
                                <div class="col-sm-5">
                                    <input 
                                        class="form-control" 
                                        type="number" 
                                        min="1" 
                                        max="<?=$product['quantity']?>"
                                        data-bts-button-down-class="btn btn-primary" 
                                        data-bts-button-up-class="btn btn-primary" 
                                        value="1" 
                                        name="quantity">
                                </div>
                                <div class="col-sm-6">
                                    <span class="pt-1 d-inline-block">Pack (1000 gram)</span>
                                </div>
                            </div>

                            <!-- Hidden inputs to store product and user information -->
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']); ?>">
                            <input type="hidden" name="product_description" value="<?= htmlspecialchars($product['description']); ?>">
                            <input type="hidden" name="stock" value="<?= htmlspecialchars($product['quantity']); ?>">
                            <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']); ?>">
                            <input type="hidden" name="discount" value="<?= htmlspecialchars($product['discount']); ?>">
                            <input type="hidden" name="discounted_price" value="<?= htmlspecialchars($discounted_price); ?>">
                            <input type="hidden" name="image" value="<?= htmlspecialchars($product['image']); ?>">
                            <input type="hidden" name="sku" value="<?= htmlspecialchars($product['sku']); ?>">
                            <input type="hidden" name="status" value="<?= htmlspecialchars($product['is_active']); ?>">
                            <input type="hidden" name="expiration_date" value="<?= htmlspecialchars($product['expiration_date']); ?>">
                            <input type="hidden" name="category_id" value="<?= htmlspecialchars($product['category_id']); ?>">

                            <!-- Hidden input for the user ID -->
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars(@$_SESSION['user']['id']); ?>">

                            <?php if (isset($_SESSION['user'])):?>
                                <?php if ($product_in_card):?>
                                    <button 
                                        class="btn-insert mt-4 btn btn-primary btn-lg"
                                        disabled
                                    >
                                        <i class="fa fa-shopping-basket"></i> Product Added
                                    </button>
                                <?php else:?>
                                    <button 
                                        class="btn-insert mt-4 btn btn-primary btn-lg"
                                        type="submit"
                                        name="submit"
                                    >
                                        <i class="fa fa-shopping-basket"></i> Add to Cart
                                    </button>
                                <?php endif?>
                            <?php else:?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    <a href="<?= URL('auth/login.php') ?>">Log in</a> to add this product to your cart
                                </div>
                            <?php endif;?>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- A section to show the related products  -->
        <?php if (!empty($related_products)): ?>
            <section id="related-product">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="title">Related Products</h2>
                            <div class="product-carousel owl-carousel">
                                <?php foreach ($related_products as $product): ?>
                                    <div class="item">
                                        <div class="card card-product">
                                            <div class="card-ribbon">
                                                <div class="card-ribbon-container right">
                                                    <span class="ribbon ribbon-primary">SPECIAL</span>
                                                </div>
                                            </div>
                                            <div class="card-badge">
                                                <div class="card-badge-container left">
                                                    <span class="badge badge-default">
                                                        Until <?= htmlspecialchars(date('Y', strtotime($product['expiration_date']))); ?>
                                                    </span>
                                                    <span class="badge badge-primary">
                                                        <?= htmlspecialchars($product['discount']); ?>% OFF
                                                    </span>
                                                </div>
                                                <img 
                                                    src="assets/img/<?= htmlspecialchars($product['image']); ?>" 
                                                    alt="<?= htmlspecialchars($product['name']); ?>" 
                                                    class="card-img-top"
                                                    style="height: 250px; width: 100%; object-fit: cover;"
                                                >
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <a href="detail-product.php?id=<?= htmlspecialchars($product['id']); ?>"><?= htmlspecialchars($product['name']); ?></a>
                                                </h4>
                                                <div class="card-price">
                                                    <span class="discount">Rp. <?= number_format($product['price'], 2, ',', '.'); ?></span>
                                                    <span class="reguler">Rp. <?= number_format($product['price'] * (1 - $product['discount'] / 100), 2, ',', '.'); ?></span>
                                                </div>
                                                <a href="detail-product.php?id=<?= htmlspecialchars($product['id']); ?>" class="btn btn-block btn-primary">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>


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
    <script>
        $(document).ready(function() {
            $(".form-control").keyup(function(){
                var value = $(this).val();
                value = value.replace(/^(0*)/,"");
                $(this).val(1);
            });

            $(".btn-insert").on("click",function(e){
                e.preventDefault();
                
                var form_data = $("#form-data").serialize() + '&submit=submit';

                // Ajaxing
                $.ajax({
                    type: "POST",
                    url: "detail-product.php?id=<?=$product_id?>", // Replace with your PHP script URL
                    data: form_data,
                    success: function(response) {
                        // Handle success response from server
                        alert("Product added to cart successfully.");
                        // Optionally, you could update the UI or redirect

                        $(".btn-insert")
                            .html("<i class='fa fa-shopping-basket'></i> Product Added")
                            .prop("disabled",true);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response from server
                        alert("An error occurred: " + error);
                    }
                });
            });

        })
    </script>
</body>
</html>
