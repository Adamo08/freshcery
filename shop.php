    <?php 
        include_once "includes/header.php";
        // Include the database configuration
        include 'config/config.php';
    ?>

    <?php 

        // Fetch all categories from the database
        $stmt = $conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetching the most wanted products from the database
        $stmt = $conn->prepare("SELECT * FROM products ORDER BY views DESC LIMIT 6");
        $stmt->execute();
        $most_wanted_products = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Function to get products by category
        function getProductsByCategory($conn, $category_id) {
            $stmt = $conn->prepare("
                SELECT p.*, c.name as category_name 
                FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE p.category_id = :category_id
            ");
            $stmt->execute([':category_id' => $category_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }



    ?>

    <div id="page-content" class="page-content">

        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Shopping Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="shop-categories owl-carousel mt-5">
                        <?php foreach ($categories as $category): ?>
                            <div class="item">
                                <a href="shop.php?category=<?= urlencode($category['name']); ?>">
                                    <div class="media d-flex align-items-center justify-content-center flex-column text-center" style="height: 100%;">
                                        <span class="d-flex mr-2">
                                            <img 
                                                src="assets/img/categories/<?= htmlspecialchars($category['icon']); ?>" 
                                                alt="<?= htmlspecialchars($category['name']); ?>" 
                                                style="height: 50px; width: 50px; object-fit: cover;"
                                            >
                                        </span>
                                        <div class="media-body">
                                            <h5><?= htmlspecialchars($category['name']); ?></h5>
                                            <p><?= htmlspecialchars($category['description']); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>    
                    </div>
                </div>
            </div>
        </div>

        <section id="most-wanted">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Most Wanted</h2>
                        <div class="product-carousel owl-carousel">

                            <?php foreach ($most_wanted_products as $product): ?>
                                <div class="item">

                                    <div class="card card-product">
                                        
                                        <div class="card-ribbon">
                                            <div class="card-ribbon-container right">
                                                <span class="ribbon ribbon-primary">SPECIAL</span>
                                            </div>
                                        </div>
                                        
                                        <div class="card-badge">
                                            <div class="card-badge-container left">
                                                <!-- Show expiration badge if applicable -->
                                                <?php if ($product['expiration_date'] < date('Y-m-d')): ?>
                                                    <span class="badge badge-default">
                                                        Expired
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-default">
                                                        Until <?= date('Y', strtotime($product['expiration_date'])); ?>
                                                    </span>
                                                <?php endif; ?>

                                                <!-- Display the discount if applicable -->
                                                <?php if ($product['discount'] >= 0): ?>
                                                    <span class="badge badge-primary">
                                                        <?= $product['discount']; ?>% OFF
                                                    </span>
                                                <?php endif; ?>
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
                                                <?php
                                                    $discounted_price = $product['price'] * (1 - $product['discount'] / 100);
                                                ?>
                                                <span class="discount">USD. <?= number_format($product['price'], 2, ',', '.'); ?></span>
                                                <span class="reguler">USD. <?= number_format($discounted_price, 2, ',', '.'); ?></span>

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


        <!-- Displaying Products By  Categories  -->
        <?php foreach($categories as $category): ?>

            <?php 
                // Fetch products for the current category
                $products = getProductsByCategory($conn, $category['id']);

                // Only display the section if there are products in the category
                if (!empty($products)):
            ?>
            <section id="<?= htmlspecialchars($category['name']); ?>" class="gray-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="title"><?= htmlspecialchars($category['name']); ?></h2>
                            <div class="product-carousel owl-carousel">
                                <?php 
                                    foreach ($products as $product): 
                                ?>
                                    <div class="item">
                                        <div class="card card-product">
                                            <div class="card-ribbon">
                                                <div class="card-ribbon-container right">
                                                    <span class="ribbon ribbon-primary">SPECIAL</span>
                                                </div>
                                            </div>

                                            <div class="card-badge">
                                                <div class="card-badge-container left">
                                                    <?php if ($product['expiration_date'] < date('Y-m-d')): ?>
                                                        <span class="badge badge-default">
                                                            Expired
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-default">
                                                            Until <?= date('Y', strtotime($product['expiration_date'])); ?>
                                                        </span>
                                                    <?php endif; ?>

                                                    <span class="badge badge-primary">
                                                        <?= $product['discount']; ?>% OFF
                                                    </span>

                                                </div>
                                                <img 
                                                    src="assets/img/<?= htmlspecialchars($product['image']); ?>" 
                                                    alt="<?= htmlspecialchars($product['name']); ?>" 
                                                    class="card-img-top fixed-height-img"
                                                    style="height: 250px; width: 100%; object-fit: cover;"
                                                >
                                            </div>

                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <a href="detail-product.php?id=<?= htmlspecialchars($product['id']); ?>"><?= htmlspecialchars($product['name']); ?></a>
                                                </h4>
                                                <div class="card-price">
                                                    <?php
                                                        $discounted_price = $product['price'] * (1 - $product['discount'] / 100);
                                                    ?>
                            
                                                    <span class="discount">USD. <?= number_format($product['price'], 2, ',', '.'); ?></span>
                                                    <span class="reguler">USD. <?= number_format($discounted_price, 2, ',', '.'); ?></span>
                                                
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
        <?php endforeach; ?>


    </div>


    <?php 
        include_once "includes/footer.php";
    ?>