    <?php require "../layouts/header.php"; ?>


    <?php 

            // If a user is already loged in
            if (isset($_SESSION['admin'])){
                header('Location: http://localhost/Freshcery/admin-panel');
                exit();
            }
    ?>


    <?php 
    
        $msg = ""; // A message to be shown if an error occurs

        if (isset($_POST['submit'])) {

            // Retrieve form data
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Validation
            if (empty($username) || empty($password)) {
                $msg = "<li style='color:red'>Both fields are required.</li>";
            } else {
                // Hash the password to compare it with the stored hash
                $hashed_password = hash('sha256', $password); // SHA256 for hashing

                // Check if the user exists and the password is correct
                $stmt = $conn->prepare("SELECT * FROM `admins` WHERE (username = :username OR email = :username) AND password = :password");
                $stmt->execute([':username' => $username, ':password' => $hashed_password]);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $admin = $stmt->fetch();
                if ($stmt->rowCount() > 0) {
                    // admin found, log them in
                    session_start();
                    $_SESSION['admin'] = $admin; // Set session variable


                    // print_r($admin);

                    // Redirect to a protected page
                    header('Location: http://localhost/Freshcery/admin-panel/');
                    exit;
                } else {
                    $msg = "<li style='color:red'>Invalid username or password.</li>";
                }
            }
        }
    
    ?>


        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mt-5">Login</h5>
                        <form method="POST" class="p-auto" action="">
                            <!-- email/username input -->
                            <div class="form-outline mb-4">
                                <input
                                    type="text"
                                    name="username"
                                    id="form2Example1"
                                    class="form-control"
                                    placeholder="Email"
                                />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input
                                    type="password"
                                    name="password"
                                    id="form2Example2"
                                    placeholder="Password"
                                    class="form-control"
                                />
                            </div>
                            <!-- Error message if !empty  -->
                            <div class="form-group mt-4">
                                    <div class="col-md-12">
                                        <?php 
                                            if (!empty($msg)){
                                                echo $msg;
                                            }
                                        ?>
                                    </div>
                                </div>

                            <!-- Submit button -->
                            <button
                              type="submit"
                              name="submit"
                              class="btn btn-primary mb-4 text-center"
                            >
                              Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
    <?php require "../layouts/footer.php"; ?>