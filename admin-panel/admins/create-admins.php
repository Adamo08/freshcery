    <?php require "../layouts/header.php"; ?>

    <?php 

        if (!isset($_SESSION['admin'])){
          header("Location: login-admins.php");
          exit();
        }

    ?>

    <?php 
    
        if (isset($_POST['submit'])){
          $full_name = sanitizeInput($_POST['full_name']);
          $email = sanitizeInput($_POST['email']);
          $username = sanitizeInput($_POST['username']);
          $password = sanitizeInput($_POST['password']);

          $errors = [];
          if (empty($email) || empty($username) || empty($password) || empty($full_name)){
            $errors[] = "Please fill in all fields.";
          }
          // Email validation
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email format.";
          }


          if (empty($errors)){

            // Check if admin already exists
            $query = "SELECT * FROM admins WHERE username = :username OR email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $result = $stmt->fetch();
            if ($result){
              $errors[] = "Username or email already exists.";
            }
            else{
              // Insert the admin to the database
              // hashed password : sha256
              $hashed_password = hash('sha256', $password);
              $sql = "INSERT INTO admins (full_name, email, username, password)
                      VALUES
                            (:full_name, :email, :username, :password)
              ";
              $stmt = $conn->prepare($sql);
              $stmt->bindParam(':full_name', $full_name);
              $stmt->bindParam(':email', $email);
              $stmt->bindParam(':username', $username);
              $stmt->bindParam(':password', $hashed_password);

              if ($stmt->execute()){
                $success = "Admin created successfully.";
              }
              else{
                $errors[] = "Failed to create admin.";
              }
            }

          }


          // If there are errors, join them into a single string for display
          $error_messages = '';
          if (!empty($errors)) {
              foreach ($errors as $error) {
                  $error_messages .= '<div class="alert alert-danger alert-dismissible fade show mt-4">' . htmlspecialchars($error) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
              }
          }

        }
    
    ?>


      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Admins</h5>
              <form method="POST" action="" enctype="multipart/form-data">

                    <?php if (!empty($error_messages)): ?>
                        <?php echo $error_messages; ?>
                    <?php endif; ?>

                    <?php if (isset($success)):?>
                      <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        <?=$success?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    <?php endif;?>

                    <!-- Full Name input -->
                    <div class="form-outline mb-4 mt-4">
                      <input 
                          type="text" name="full_name" 
                          id="form2Example1" class="form-control" 
                          placeholder="Full Name" 
                      />
      
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                      <input 
                          type="email" name="email" 
                          id="form2Example1" class="form-control" 
                          placeholder="email" 
                      />
      
                    </div>

                    <div class="form-outline mb-4">
                      <input 
                          type="text" name="username" 
                          id="form2Example1" class="form-control" 
                          placeholder="username" 
                      />
                    </div>
                    <div class="form-outline mb-4">
                      <input 
                          type="password" name="password" 
                          id="form2Example1" class="form-control" 
                          placeholder="password" 
                      />
                    </div>

                    <!-- Submit button -->
                    <button 
                        type="submit" 
                        name="submit" 
                        class="btn btn-primary  mb-4 text-center"
                    >create
                  </button>

              
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php require "../layouts/footer.php"; ?>