      <?php require "../layouts/header.php"; ?>

      <?php 
      
        // Getting the list of products from the database
        $sql = "SELECT * from products";

        // Preparing the query
        $stmt = $conn->prepare($sql);

        // Executing the query
        $stmt->execute();

        // Fetching the result
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $p_count = count($products);

        $i = 0;
      
      ?>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Products</h5>
                
              <?php if(isset($_SESSION['admin'])): ?>
                <a  href="create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>
                <table class="table table-striped table-hover mt-4">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">product</th>
                      <th scope="col">price in USD</th>
                      <th scope="col">expiration date</th>
                      <th scope="col">status</th>
                      <th scope="col">delete</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php if ($p_count > 0): ?>

                      <?php foreach($products as $product):?>
                        <?php 
                          $is_active = $product['is_active'];
                          $status = $is_active == 1 ? 'Active' : 'Inactive';
                        ?>
                        <tr>
                          <th scope="row">
                            <?=++$i?>
                          </th>
                          <td>
                            <?=$product['name']?>
                          </td>
                          <td>
                            <?=$product['price']?>
                          </td>
                          <td>
                            <?=$product['expiration_date']?>
                          </td>
                          <td>
                            <a href="#" class="btn btn-success  text-center ">
                              <?=$status?>
                            </a>
                          </td>
                          <td><a href="delete-product.php?id=<?=$product['id']?>" class="btn btn-danger  text-center ">delete</a></td>
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

                  </tbody>
                </table> 
              <?php else:?>
                  <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                      You are not logged in, <a href="login-admins.php">Login</a> to see the list of products
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              <?php endif;?>
            </div>
          </div>
        </div>
      </div>


      <?php require "../layouts/footer.php"; ?>