    <?php 
        include_once "includes/header.php";
        // Include the database configuration
        include 'config/config.php';
    ?>

    <?php 
    
        if (!isset($_SESSION['user'])){
            // header("Location: localhost/Freshcery");
            echo "<script> window.location.href = 'localhost/Freshcery' </script>";
            exit();
        }

        if (isset($_GET['id'])){
            $id = $_GET['id'];

            // Getting the user info from `user_details` table
            $sql = "
                SELECT u.full_name, u.email, ud.address, ud.city, ud.state_country, ud.postcode_zip, ud.phone_number
                FROM user_details ud
                JOIN users u ON ud.user_id = u.id
                WHERE ud.user_id = :user_id
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $id);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // print_r($user);

        }
    
    ?>

    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Settings
                    </h1>
                    <p class="lead">
                        Update Your Account Info
                    </p>
                </div>
            </div>
        </div>

        <section id="checkout">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-6">
                        <h5 class="mb-3">ACCOUNT DETAILS</h5>
                        <!-- Bill Detail of the Page -->
                        <form action="setting.php" class="bill-detail" method="POST">
                            <fieldset>
                                <div class="form-group row">
                                    <div class="col">
                                        <input 
                                            class="form-control" placeholder="Full Name" 
                                            type="text"
                                            name="full_name"
                                            value="<?php echo $user['full_name']; ?>"
                                        >
                                    </div>
                                
                                </div>

                                <div class="form-group">
                                    <input
                                        class="form-control" placeholder="Address"
                                        type="text"
                                        name="address"
                                        value="<?php echo $user['address']; ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <input 
                                        class="form-control" placeholder="Town / City" 
                                        type="text"
                                        name="town_city"
                                        value="<?php echo $user['city']; ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <input 
                                        class="form-control" placeholder="State / Country" 
                                        type="text"
                                        name="state_country"
                                        value="<?php echo $user['state_country']; ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <input 
                                        class="form-control" placeholder="Postcode / Zip" 
                                        type="text"
                                        name="postcode_zip"
                                        value="<?php echo $user['postcode_zip']; ?>"
                                    >
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <input 
                                            class="form-control" placeholder="Email Address" 
                                            type="email"
                                            name="email"
                                            value="<?php echo $user['email']; ?>"
                                        >
                                    </div>
                                    <div class="col">
                                        <input 
                                            class="form-control" placeholder="Phone Number" 
                                            type="tel"
                                            name="phone_number"
                                            value="<?php echo $user['phone_number']; ?>"
                                        >
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" name="submit" class="btn btn-primary">UPDATE</button>
                                    <div class="clearfix">
                                </div>
                            </fieldset>
                        </form>
                        <!-- Bill Detail of the Page end -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <?php 
        include_once "includes/footer.php";
    ?>
