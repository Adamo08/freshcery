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

            // Checking if the ID matches the user's id 
            if ($id != $_SESSION['user']['id']){
                echo "<script> window.location.href = 'http://localhost/Freshcery/' </script>";
                exit();
            }

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

            
            $errors = [];
            if (isset($_POST['submit'])){

                $full_name = sanitizeInput($_POST['full_name']);
                $address = sanitizeInput($_POST['address']);
                $city = sanitizeInput($_POST['city']);
                $state_country = sanitizeInput($_POST['state_country']);
                $postcode_zip = sanitizeInput($_POST['postcode_zip']);
                $email = sanitizeInput($_POST['email']);
                $phone_number = sanitizeInput($_POST['phone_number']);

                // Validating data
                    // Validation
                if (
                        empty($full_name) || empty($address) || 
                        empty($city) || empty($state_country) || 
                        empty($postcode_zip) || empty($email) ||
                        empty($phone_number)
                ) {
                    $errors[] = "All fields are required.";
                } 
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid email format.";
                } 
                if (!preg_match('/^[\d\s\+\-()]+$/', $phone_number)) {
                    $errors[] = 'Invalid phone number format.';
                }

                // If there are no errors, proceed to insert data
                if (empty($errors)) {
                    try {
                        // Prepare the SQL statement
                        $stmt = $conn->prepare("UPDATE users u 
                                INNER JOIN user_details ud 
                                ON (u.id = ud.user_id)
                                SET 
                                    u.full_name = :full_name,
                                    u.email = :email,
                                    ud.address = :address,
                                    ud.city = :city,
                                    ud.state_country = :state_country,
                                    ud.postcode_zip = :postcode_zip,
                                    ud.phone_number = :phone_number
                                
                                WHERE u.id = :id AND ud.user_id = :id
                        ");

                        // Bind parameters
                        $stmt->bindParam(":full_name", $full_name);
                        $stmt->bindParam(":email", $email);
                        $stmt->bindParam(":address", $address);
                        $stmt->bindParam(":city", $city);
                        $stmt->bindParam(":state_country", $state_country);
                        $stmt->bindParam(":postcode_zip", $postcode_zip);
                        $stmt->bindParam(":phone_number", $phone_number);
                        $stmt->bindParam(":id",$id);



                        // Execute the statement
                        if ($stmt->execute()) {
                            echo "<script> 
                                swal({
                                    title: 'Good job!',
                                    text: 'Your information was updated successfully!',
                                    icon: 'success',
                                    button: 'Done!',
                                });
                            </script>";

                            // Redirect the user to the index page
                            // header("Location: index.php");
                            echo "<script> window.location.href = 'http://localhost/Freshcery/' </script>";
                            exit();

                        } else {
                            echo "<script> 
                                swal({
                                    title: 'Error!',
                                    text: 'Something went wrong, try again!',
                                    icon: 'warning',
                                    button: 'Done!',
                                });
                            </script>";
                        }


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

        }
        else {
            echo "<script> window.location.href = ".URL('404.php')." </script>";
            exit();
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
                        <form action="setting.php?id=<?=$id?>" class="bill-detail" method="POST">
                            <?php if (!empty($error_messages)): ?>
                                <?php echo $error_messages; ?>
                            <?php endif; ?>
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
                                        name="city"
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
