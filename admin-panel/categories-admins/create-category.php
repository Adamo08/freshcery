    <?php require "../layouts/header.php"; ?>

    <?php 

        if (!isset($_SESSION['admin'])){
          header("Location: ".APP_URL."admin-panel/admins/login-admins.php");
          exit();
        }

        $errors = [];
        if (isset($_POST['submit'])){

          $name = sanitizeInput($_POST['name']);
          $description = sanitizeInput($_POST['description']);

          if (empty($name) || empty($description)){
            $errors[] = "Name and Description are required!";
          }

          // Checking if there is a category with the same name
          $sql = "SELECT * From categories WHERE name = :name";
          $stmt = $conn -> prepare($sql);
          $stmt -> bindParam(":name", $name);

          $stmt -> execute();

          $result = $stmt -> fetch(PDO::FETCH_ASSOC);

          if ($result){
            $errors[] = "A category with the same name already exists!";
          }

          // Image and Icon Traitement

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
            $imageLink = "images/".$image;
          } else{
            $errors[] = "L'image: ".$messages[$_FILES['image']['error']] ?? 'Erreur de téléchargement de l\'image.';
          }


          if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK){
            $icon = $_FILES['icon']['name'];
            $iconTmp = $_FILES['icon']['tmp_name'];
            $iconLink = "icons/".$icon;
          } else{
            $errors[] = "L'icon: ".$messages[$_FILES['icon']['error']] ?? 'Erreur de téléchargement de l\'icon.';
          }
          

          // If there was no error
          if (empty($errors)){
            $sql = "INSERT INTO categories (name, description, image, icon)
                    VALUES 
                          (:name, :description, :image, :icon)
            ";
            // Preparing the query
            $stmt = $conn -> prepare($sql);

            // Binding params
            $stmt -> bindParam(":name", $name);
            $stmt -> bindParam(":description", $description);
            $stmt -> bindParam(":image", $imageLink);
            $stmt -> bindParam(":icon", $iconLink);

            if ($stmt -> execute()){
                $success = "Category Added Successfully!";
                // Moving the files to the assets folder
                if (!move_uploaded_file($imageTmp, "../../assets/img/categories/".$imageLink)){
                    $errors[] = "Failed To move the image , try again";
                }
                if (!move_uploaded_file($iconTmp,"../../assets/img/categories/".$iconLink)){
                  $errors[] = "Failed To move the icon , try again";
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
              <h5 class="card-title mb-5 d-inline">Create Categories</h5>
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
                  <input 
                        type="text" name="name" 
                        id="form2Example1" 
                        class="form-control" 
                        placeholder="name" 
                        value="<?php echo @$_POST['name']?>"
                  />
                </div>

                <!-- Description input -->
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Description</label>
                  <textarea  
                        name="description" 
                        placeholder="description" 
                        class="form-control" 
                        id="exampleFormControlTextarea1" 
                        rows="3"
                  ><?php echo @$_POST['description']?></textarea>
                </div>

                <!-- Image input -->
                <div class="form-outline mb-4 mt-4">
                  <label>Image</label>
                  <input 
                        type="file" name="image" 
                        id="form2Example1" 
                        class="form-control" 
                        placeholder="image"
                        accept="image/jpeg"
                  />
                </div>

                <!-- Icon input -->
                <div class="form-outline mb-4 mt-4">
                  <label>Icon</label>
                  <input 
                        type="file" name="icon" 
                        id="form2Example1" 
                        class="form-control" 
                        placeholder="icon" 
                        accept="image/png"
                  />
                </div>

      
                <!-- Submit button -->
                <button 
                      type="submit" name="submit" 
                      class="btn btn-primary  mb-4 text-center"
                >create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
  <?php require "../layouts/footer.php"; ?>