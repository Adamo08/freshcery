<?php require "../layouts/header.php"; ?>

    <?php 
    
        // Getting the orders from the database
        $sql = "SELECT * FROM orders";

        // Preparing the query
        $stmt = $conn->prepare($sql);

        // Executing the query
        $stmt->execute();

        // Fetching the result
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $o_count = count($orders);

        $i = 0;
      
    
    ?>

    <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Orders</h5>
                <?php if (isset($_SESSION['admin'])): ?>
                  <table class="table table-striped table-hover mt-4">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">first name</th>
                        <th scope="col">last name</th>
                        <th scope="col">email</th>
                        <th scope="col">country</th>
                        <th scope="col">status</th>
                        <th scope="col">price in USD</th>
                        <th scope="col">placed at</th>
                        <th scope="col">update</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($o_count > 0):?>
                        <?php foreach ($orders as $order): ?>
                          <tr>
                            <th scope="row">
                              <?=++$i?>
                            </th>
                            <td>
                              <?=$order['first_name']?>
                            </td>
                            <td>
                              <?=$order['last_name']?>
                            </td>
                            <td>
                              <?=$order['email']?>
                            </td>
                            <td>
                              <?=$order['state_country']?>
                            </td>
                            <td>
                              <?=$order['status']?>
                            </td>
                            <td>
                              $<?=$order['total_price']?>
                            </td>
                            <td>
                              <?=$order['created_at']?>
                            </td>
                            <td>                
                                <a href="update-orders.php?id=<?=$order['id']?>" class="btn btn-warning text-white mb-4 text-center">update</a>
                            </td>
                          </tr>
                        <?php endforeach;?>
                      <?php  else:?>
                        <tr>
                          <td colspan="9">
                            <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                                No orders placed yet
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                          </td>
                        </tr>
                      <?php  endif;?>
                    </tbody>
                  </table> 
                <?php else:?>
                <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                    You are not logged in, <a href="login-admins.php">Login</a> to see the list of orders
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif;?>
            </div>
          </div>
        </div>
    </div>

<?php require "../layouts/footer.php"; ?>