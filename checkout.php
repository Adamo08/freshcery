

    <?php 
        include_once "includes/header.php";
        include_once "config/config.php";
    ?>

    <?php 

        if (!isset($_SESSION['user'])){
            header('Location: localhost/Freshcery/');
            exit();
        }

    ?>

    <?php 

        // Function to sanitize input
        function sanitizeInput($data) {
            return htmlspecialchars(trim($data));
        }

        if (isset($_POST['submit'])){

            // Retrieve and sanitize input
            $user_id = $_SESSION['user']['id']; // Getting user ID
            $first_name = sanitizeInput($_POST['first_name']);
            $last_name = sanitizeInput($_POST['last_name']);
            $company_name = sanitizeInput($_POST['company_name']);
            $address = sanitizeInput($_POST['address']);
            $town_city = sanitizeInput($_POST['town_city']);
            $state_country = sanitizeInput($_POST['state_country']);
            $postcode_zip = sanitizeInput($_POST['postcode_zip']);
            $email = sanitizeInput($_POST['email']);
            $phone = sanitizeInput($_POST['phone']);
            $order_notes = sanitizeInput($_POST['order_notes']);
            
            if (isset($_SESSION['price'])){
                $total_price = (float)$_SESSION['price'] + 20; // 20 USD for shipping
                $_SESSION['total_price'] = $total_price;
            }

            // Validate required fields
            if (
                    empty($first_name) || empty($last_name) || 
                    empty($address) || empty($town_city) || 
                    empty($state_country) || empty($postcode_zip) || 
                    empty($email) || empty($phone)
                ) 
            {
                $errors[] = 'Please fill in all required fields.';
            }

            // Validate email
            if (
                !filter_var($email, FILTER_VALIDATE_EMAIL)
            ) 
            {
                $errors[] = 'Invalid email format.';
            }

            // Validate phone number
            if (!preg_match('/^[\d\s\+\-()]+$/', $phone)) {
                $errors[] = 'Invalid phone number format.';
            }

             // If there are no errors, proceed to insert data
            if (empty($errors)) {
                try {
                    // Prepare the SQL statement
                    $stmt = $conn->prepare("
                        INSERT INTO orders 
                        (user_id, first_name, last_name, company_name, address, town_city, state_country, postcode_zip, email, phone, order_notes, total_price) 
                        VALUES 
                        (:user_id, :first_name, :last_name, :company_name, :address, :town_city, :state_country, :postcode_zip, :email, :phone, :order_notes, :total_price)
                    ");

                    // Bind parameters
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':company_name', $company_name);
                    $stmt->bindParam(':address', $address);
                    $stmt->bindParam(':town_city', $town_city);
                    $stmt->bindParam(':state_country', $state_country);
                    $stmt->bindParam(':postcode_zip', $postcode_zip);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':order_notes', $order_notes);
                    $stmt->bindParam(':total_price', $total_price);

                    // Execute the statement
                    $stmt->execute();

                    // Set session variable to indicate success
                    $_SESSION['checkout_success'] = true;

                    // Redirect to the charge page
                    echo "<script> window.location.href = 'charge.php' </script>";

                } catch (PDOException $e) {
                    // Handle SQL errors
                    $errors[] = 'Error: ' . $e->getMessage();
                }

            }


            // If there are errors, join them into a single string for display
            $error_messages = '';
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $error_messages .= '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
                }
            }

    }
        
    ?>


    <?php 

        $total_price = $_SESSION['price'];
        $products  = $_SESSION['products']
    
    ?>


    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Checkout
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="checkout">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-7">
                        <h5 class="mb-3">BILLING DETAILS</h5>
                        <!-- Bill Detail of the Page -->
                        <form action="checkout.php" method="POST" class="bill-detail">
                            <?php if (!empty($error_messages)): ?>
                                <?php echo $error_messages; ?>
                            <?php endif; ?>
                            <fieldset>
                                <div class="form-group row">
                                    <div class="col">
                                        <input 
                                            class="form-control" placeholder="Name" 
                                            type="text" name="first_name"
                                            value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                                        >
                                    </div>
                                    <div class="col">
                                        <input 
                                            class="form-control" placeholder="Last Name" 
                                            type="text" name="last_name"
                                            value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input 
                                        class="form-control" placeholder="Company Name" 
                                        type="text" name="company_name"
                                        value="<?php echo htmlspecialchars($_POST['company_name'] ?? ''); ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <textarea 
                                        class="form-control" placeholder="Address" 
                                        name="address"
                                        value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>"
                                    ></textarea>
                                </div>
                                <div class="form-group">
                                    <input 
                                        class="form-control" placeholder="Town / City" 
                                        type="text" name="town_city"
                                        value="<?php echo htmlspecialchars($_POST['town_city'] ?? ''); ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <input 
                                        class="form-control" placeholder="State / Country" 
                                        type="text" name="state_country"
                                        value="<?php echo htmlspecialchars($_POST['state_country'] ?? ''); ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <input 
                                        class="form-control" placeholder="Postcode / Zip" 
                                        type="text" name="postcode_zip"
                                        value="<?php echo htmlspecialchars($_POST['postcode_zip'] ?? ''); ?>"
                                    >
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <input 
                                            class="form-control" placeholder="Email Address" 
                                            type="email" name="email"
                                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                        >
                                    </div>
                                    <div class="col">
                                        <input 
                                            class="form-control" placeholder="Phone Number" 
                                            type="tel" name="phone"
                                            value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                                        >
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <textarea 
                                        class="form-control" placeholder="Order Notes" 
                                        name="order_notes"
                                        value="<?php echo htmlspecialchars($_POST['order_notes'] ?? ''); ?>"
                                    >
                                    </textarea>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <button
                                    type="submit"
                                    name="submit"
                                    class="btn btn-primary float-left">
                                    PROCEED TO CHECKOUT 
                                    <i class="fa fa-check"></i>
                                </button>
                            </div>

                        </form>
                        <!-- Bill Detail of the Page end -->

                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <div class="holder">
                            <h5 class="mb-3">YOUR ORDER</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                            $total = 0;
                                            $shipping = 20;
                                            foreach($products as $product):
                                                $discount = $product['discount'];
                                                $price = $product['price'];
                                                $quantity = $product['product_quantity'];
                                                // Discounted price
                                                $discounted_price = $price - ($price * $discount / 100);
                                                // Subtotal
                                                $subtotal = $discounted_price * $quantity;
                                                $total += $subtotal;
                                        ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $product['name']." x".$quantity?>
                                                    </td>
                                                    <td class="text-right">
                                                        USD <?=number_format($subtotal, 2, ',', '.')?>
                                                    </td>
                                                </tr>
                                        <?php endforeach?>

                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <td>
                                                <strong>Cart Subtotal</strong>
                                            </td>
                                            <td class="text-right">
                                                USD <?=number_format($total, 2, ',', '.')?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Shipping</strong>
                                            </td>
                                            <td class="text-right">
                                                USD <?=number_format($shipping, 2, ',', '.')?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>ORDER TOTAL</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>USD <?=number_format($total+$shipping, 2, ',', '.')?></strong>
                                            </td>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>

                        
                        </div>
                        <p class="text-right mt-3">
                            <input checked="" type="checkbox"> I’ve read &amp; accept the <a href="#">terms &amp; conditions</a>
                        </p>
                        <div class="clearfix">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php 
        include_once "includes/footer.php";
    ?>