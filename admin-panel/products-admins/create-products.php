<?php require "../layouts/header.php"; ?>

    <?php 

      if (!isset($_SESSION['admin'])){
        header("Location: ".APP_URL."admin-panel/admins/login-admins.php");
        exit();
      }
    
    ?>

    <?php 
    
      // Getting the categories from the database

      // Query
      $sql = "SELECT * From categories";
      
      // Preparing the query
      $stmt = $conn -> prepare($sql);

      // Executing the query
      $stmt -> execute();

      $categories = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    
    
    ?>

    <?php 

      if (isset($_POST['submit'])){
        
          // Inputs Validation
          $errors = [];

          $name = sanitizeInput($_POST['name']);
          $price = $_POST['price'];
          $quantity = sanitizeInput($_POST['quantity']);
          $discount = sanitizeInput($_POST['discount']);
          $description = sanitizeInput($_POST['description']);
          $category_id = $_POST['category_id'];
          $expiration_date = $_POST['expiration_date'];

          if (
            empty($name) ||
            empty($price) ||
            empty($description) ||
            empty($quantity) ||
            empty($expiration_date)
          ){
            $errors[] = "All fields are required!";
          }

          if (empty($category_id)){
            $errors[] = "Select a valid category!";
          }

          // Expiration date validation
          if ($expiration_date < date('Y-m-d')){
            $errors[] = "Invalid expiration date!";
          }

          // Checking if there is a product with the same name
          $sql = "SELECT * From products WHERE name = :name";
          $stmt = $conn -> prepare($sql);
          $stmt -> bindParam(":name", $name);

          $stmt -> execute();

          $result = $stmt -> fetch(PDO::FETCH_ASSOC);

          if ($result){
            $errors[] = "A product with the same name already exists!";
          }

          // Image Validation

          $messages = [
            UPLOAD_ERR_INI_SIZE => 'The file exceeds the maximum size allowed by the server.',
            UPLOAD_ERR_FORM_SIZE => 'The file exceeds the maximum size allowed by the form.',
            UPLOAD_ERR_PARTIAL => 'The file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'The temporary folder is missing.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write the file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
        ];
        

          if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
            $image = $_FILES['image']['name'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageLink = "products/".$image;
          } else{
            $errors[] = $messages[$_FILES['image']['error']] ?? 'Erreur de téléchargement de l\'image.';
          }

          // If there was no error
          if (empty($errors)){
            $sql = "INSERT INTO products (name, description, price, quantity, discount, category_id, image, expiration_date)
                    VALUES 
                          (
                            :name, 
                            :description, 
                            :price, 
                            :quantity, 
                            :discount, 
                            :category_id, 
                            :image, 
                            :expiration_date
                          )
            ";
            // Preparing the query
            $stmt = $conn -> prepare($sql);

            // Binding params
            $stmt -> bindParam(":name", $name);
            $stmt -> bindParam(":description", $description);
            $stmt -> bindParam(":price", $price);
            $stmt -> bindParam(":quantity", $quantity);
            $stmt -> bindParam(":discount", $discount);
            $stmt -> bindParam(":category_id", $category_id);
            $stmt -> bindParam(":image", $imageLink);
            $stmt -> bindParam(":expiration_date", $expiration_date);

            

            if ($stmt -> execute()){
                $success = "Product Added Successfully!";
                // Moving the product image to the assets folder
                if (!move_uploaded_file($imageTmp, "../../assets/img/".$imageLink)){
                    $errors[] = "Failed To move the image , try again";
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
              <h5 class="card-title mb-5 d-inline">Create Products</h5>
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

                <!-- Name input -->
                <div class="form-outline mb-4 mt-4">
                  <label for="form2Example1">Name</label>
                  <input 
                      type="text" name="name" 
                      id="form2Example1" class="form-control" 
                      placeholder="title" 
                      value="<?=@$_POST['name']?>"
                  />
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label for="form2Example2">Price</label>
                    <input 
                        type="text" name="price" 
                        id="form2Example2" class="form-control" 
                        placeholder="price" 
                        value="<?=@$_POST['price']?>"
                    />
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label for="form2Example3">Stock</label>
                    <input 
                        type="number" name="quantity" 
                        min="1"
                        id="form2Example3" class="form-control" 
                        placeholder="quantity available in the stock" 
                        value="<?=@$_POST['quantity']?>"
                    />
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label for="form2Example4">Discount</label>
                    <input 
                        type="number" name="discount" 
                        min="0"
                        max="100"
                        id="form2Example4" class="form-control" 
                        placeholder="Discount"
                        value="<?=@$_POST['discount']?>"
                    />
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea 
                        name="description" 
                        placeholder="description" 
                        class="form-control" 
                        id="exampleFormControlTextarea1" 
                        rows="3"
                    >
                    <?=@$_POST['description']?>
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Category</label>
                    <select name="category_id" class="form-control" id="exampleFormControlSelect1">
                      <option value="0">--select category--</option>
                      <?php foreach($categories as $category): ?>
                        <option 
                              value="<?=$category['id']?>"
                        >
                          <?=$category['name']?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                </div>

              <div class="form-group">
                  <label for="form2Example5">Select Expiration Date</label>
                  <input 
                      type="date" 
                      name="expiration_date"
                      id="form2Example5"
                      style="
                            border:1px solid #eee; 
                            border-radius: 3px; 
                            padding:3px 7px; 
                            outline:none;
                      "
                      value="<?=@$_POST['expiration_date']?>"
                  >
              </div>

                <div class="form-outline mb-4 mt-4">
                    <label for="form2Example6">Image</label>

                    <input 
                        type="file" 
                        name="image" 
                        id="form2Example6" 
                        class="form-control" 
                        placeholder="image"
                        accept="image/jpeg"
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