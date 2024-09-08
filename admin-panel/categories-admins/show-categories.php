<?php require "../layouts/header.php"; ?>

      <?php 

        // Getting the categories from the database
        $sql = "SELECT name as c_name, id as c_id FROM categories";

        // Preparing the query
        $stmt = $conn->prepare($sql);

        // Executing the query
        $stmt->execute();

        // Fetching the result
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $c_count = count($categories);

        $i = 0;



      ?>

      <?php 
          // Deleting a category
          if (isset($_GET['id'])) {
              $id = $_GET['id'];

              // Step 1: Retrieve the image and icon filenames associated with the category
              $sql = "SELECT image, icon FROM categories WHERE id = :id";
              $stmt = $conn->prepare($sql);
              $stmt->bindParam(':id', $id);
              $stmt->execute();

              // Fetch the result
              $category = $stmt->fetch(PDO::FETCH_ASSOC);

              if ($category) {
                  // Define the file paths for the image and icon
                  $image_path = "../../assets/img/categories/" . $category['image'];
                  $icon_path = "../../assets/img/categories/" . $category['icon'];

                  // Step 2: Check if the image and icon files exist, then delete them
                  if (file_exists($image_path)) {
                      unlink($image_path);  // Delete the image
                  }

                  if (file_exists($icon_path)) {
                      unlink($icon_path);  // Delete the icon
                  }

                  // Step 3: Delete the category from the database
                  $sql = "DELETE FROM categories WHERE id = :id";
                  $stmt = $conn->prepare($sql);
                  $stmt->bindParam(':id', $id);

                  if ($stmt->execute()) {
                      // Add an exit to ensure redirection
                      $success = "Category deleted successfully";
                  } else {
                      $error = "Failed to delete category";
                  }
                }
              // else {
              //     // Category not found
              //     echo "<script> window.location.href = '".APP_URL."404.php'; </script>";
              // }
          }
      ?>


      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Categories</h5>
              <?php if (isset($_SESSION['admin'])): ?>
                <a  href="create-category.php" class="btn btn-primary mb-4 text-center float-right">Create Categories</a>
                <table class="table table-striped table-hover mt-4">
                  <?php if (isset($success)):?>
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                      <?=$success?>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  <?php endif;?>
                  
                  <?php if (isset($error)):?>
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                      <?=$error?>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  <?php endif;?>

                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">name</th>
                      <th scope="col">update</th>
                      <th scope="col">delete</th>
                    </tr>
                  </thead>
                    <?php if ($c_count > 0): ?>
                      <?php foreach($categories as $category): ?>
                          <tr>
                            <th scope="row">
                              <?=++$i?>
                            </th>
                            <td>
                              <?=$category['c_name']?>
                            </td>
                            <td><a  href="update-category.php?id=<?php echo $category['c_id']?>" class="btn btn-warning text-white text-center ">Update </a></td>
                            <td><a href="show-categories.php?id=<?php echo $category['c_id']?>" class="btn btn-danger  text-center ">Delete </a></td>
                          </tr>
                      <?php endforeach;?>
                    <?php else:?>
                      <tr>
                        <td colspan="4">
                          <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                              The List Of Categories Is Empty
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        </td>
                      </tr>
                    <?php endif;?>
                  </>
                </table> 
              <?php else:?>
                  <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                      You are not logged in, <a href="login-admins.php">Login</a> to see the list of categories
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              <?php endif;?>
            </div>
          </div>
        </div>
      </div>


  <?php require "../layouts/footer.php"; ?>