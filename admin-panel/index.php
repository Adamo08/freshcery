    <?php require "layouts/header.php"?>

    <?php 

      // Getting the count of : products, orders, categories and admins
      $sql = "SELECT 
            (SELECT COUNT(*) FROM products) AS count_p, 
            (SELECT COUNT(*) FROM orders) AS count_o, 
            (SELECT COUNT(*) FROM categories) AS count_c, 
            (SELECT COUNT(*) FROM admins) AS count_a";

      // Preparing the query
      $stmt = $conn->prepare($sql);

      // Executing the query
      $stmt->execute();

      // Fetching the result
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
    
    ?>

      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Products</h5>
              <p class="card-text">number of products: <?=$result['count_p']?></p>

            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Orders</h5>
              <p class="card-text">number of orders: <?=$result['count_o']?></p>

            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Categories</h5>

              <p class="card-text">number of categories: <?=$result['count_c']?></p>

            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>

              <p class="card-text">number of admins: <?=$result['count_a']?></p>

            </div>
          </div>
        </div>
      </div>
    
    <?php require "layouts/footer.php"?>