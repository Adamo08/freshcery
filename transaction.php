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
    
        if (isset($_GET['id'])){
            $id = $_GET['id'];

            // Checking if the ID matches the user's id 
            if ($id != $_SESSION['user']['id']){
                echo "<script> window.location.href = 'localhost/Freshcery' </script>";
            }

            // Getting all the orders for the user
            $sql = "SELECT * FROM orders WHERE user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $id);

            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Getting the count of orders
            $count = count($orders);
            $i = 0;

            // A function to generate an alphanumeric string
            function generateAlphanumericString($ID) {
                // Step 1: Convert the ID to a base-36 string
                $base36 = strtoupper(base_convert($ID, 10, 36)); // Convert to base-36 and uppercase
                
                // Step 2: Pad the string to a desired length (if needed)
                $padded = str_pad($base36, 10, '0', STR_PAD_LEFT); // Pad to 10 characters
                
                // Step 3: Add a prefix and/or suffix
                $prefix = 'AL';
                $suffix = strtoupper(substr(md5($ID), 0, 4)); // Use first 4 chars of md5 hash as suffix
                
                // Combine parts to create the final string
                return $prefix . $padded . $suffix;
            }


        }
    
    ?>


    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Transactions
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
                                        <th width="5%">#</th>
                                        <th>Invoice</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if($count > 0 ): ?>
                                        <?php foreach ($orders as $order) :?>
                                            <?php
                                                // Determine the class based on the order status
                                                $status = strtolower($order['status']); // Convert status to lowercase to standardize
                                                $statusStyle = '';

                                                switch ($status) {
                                                    case 'pending':
                                                        $statusStyle = 'background-color: #ffcc00; color: #000; padding: 3px 10px; border-radius: 10px;';
                                                        break;
                                                    case 'completed':
                                                        $statusStyle = 'background-color: #4caf50; color: #fff; padding: 3px 10px; border-radius: 10px;';
                                                        break;
                                                    case 'canceled':
                                                        $statusStyle = 'background-color: #f44336; color: #fff; padding: 3px 10px; border-radius: 10px;';
                                                        break;
                                                    default:
                                                        $statusStyle = ''; // No styles if status doesn't match
                                                        break;
                                                }
                                            ?>
                                            <tr>
                                                <td><?=++$i?></td>
                                                <td>
                                                    <?=generateAlphanumericString($order['id'])?>
                                                </td>
                                                <td>
                                                    <?=date("Y-m-d", strtotime($order['created_at']))?>
                                                </td>
                                                <td>
                                                    USD <?=$order['total_price']?>
                                                </td>
                                                <td>
                                                    <span style="<?=$statusStyle?>">
                                                        <?=$status?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">No transaction found.</td>
                                    </tr>
                                <?php endif; ?>

                                </tbody>
                            </table>
                        </div>

                    
                    </div>
                </div>
            </div>
        </section>

       
    </div>

    <?php 
        include_once "includes/footer.php";
    ?>