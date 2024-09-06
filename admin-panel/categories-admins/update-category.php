
<?php require "../layouts/header.php"; ?>

    <?php 

      if (isset($_GET['id'])){
        $id = $_GET['id'];

        // Getting the info associated to the current category
        $sql = "SELECT name, description FROM categories WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        $c_name = $category['name'];
        $c_description = $category['description'];

        $errors = [];
        if (isset($_POST['submit'])){
          $name = sanitizeInput($_POST['name']);
          $description = sanitizeInput($_POST['description']);

          if (empty($name) || empty($description)){
            $errors[] = "Please fill in all fields.";
          }

          if (empty($errors)){

              // Update the category
              $sql = "UPDATE categories 
                SET 
                    name = :name, 
                    description = :description,
                    updated_at = :updated_at
                WHERE id = :id
              ";
          
              $stmt = $conn->prepare($sql);

              // Set the updated_at value to the current timestamp
              $updated_at = date('Y-m-d H:i:s');

              // Bind the parameters
              $stmt->bindParam(':description', $description);
              $stmt->bindParam(':name', $name);
              $stmt->bindParam(':updated_at', $updated_at); // Bind the current timestamp
              $stmt->bindParam(':id', $id);


            if ($stmt->execute()){
              $success = "Category updated successfully.";
            }
            else{
              $errors[] = "Failed to update category.";
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



      }
    
    
    ?>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Update Categories</h5>
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
                      id="form2Example1" class="form-control" 
                      placeholder="name" value="<?=$c_name?>"
                  />
                </div>

                <!-- Description input -->
                <div class="form-outline mb-4 mt-4">
                  <input 
                      type="text" name="description" 
                      id="form2Example1" class="form-control" 
                      placeholder="Description" value="<?=$c_description?>" 
                  />
                </div>

                <!-- Submit button -->
                <button 
                    type="submit" name="submit" 
                    class="btn btn-primary  mb-4 text-center"
                >update</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
  
<?php require "../layouts/footer.php"; ?>