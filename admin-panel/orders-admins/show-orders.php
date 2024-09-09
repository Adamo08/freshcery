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
                          <?php 
                            
                            // Determine the class based on the order status
                            $status = strtolower($order['status']); // Convert status to lowercase to standardize
                            $statusStyle = '';

                            switch ($status) {
                                case 'pending':
                                    $statusStyle = 'background-color: #ffcc00; color: #000; padding: 3px 10px; border-radius: 10px;';
                                    break;
                                case 'completed':
                                    $statusStyle = 'background-color: #4caf50; color: #fff; padding: 3px 10px; border-radius: 10px;';
                                    break;
                                case 'cancelled':
                                    $statusStyle = 'background-color: #f44336; color: #fff; padding: 3px 10px; border-radius: 10px;';
                                    break;
                                default:
                                    $statusStyle = ''; // No styles if status doesn't match
                                    break;
                            }
                            
                          ?>
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
                              <span style="<?=$statusStyle?>"><?=$status?></span>
                            </td>
                            <td>
                              $<?=$order['total_price']?>
                            </td>
                            <td>
                              <?=$order['created_at']?>
                            </td>
                            <td>                
                                <button
                                    type="button"
                                    class="update-order-btn btn btn-warning text-white mb-4 text-center"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModal"
                                    data-order-id="<?=$order['id']?>"
                                    data-order-status="<?=$order['status']?>"
                                >
                                  update
                                </button>
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



    
    <!-- Modal for Updating Order -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateModalLabel">Update Order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="updateOrderForm">
              <!-- Hidden input to store the order ID -->
              <input type="hidden" name="order_id" id="modalOrderId">

              <!-- Status selection -->
              <div class="form-group">
                <label for="status">Order Status:</label>
                <select name="status" id="modalOrderStatus" class="form-control" required>
                  <option value="Pending">Pending</option>
                  <option value="Completed">Completed</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
              </div>

              <button type="button" class="btn btn-primary mt-3" id="saveChangesBtn">Save changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Select all buttons with the class update-order-btn
        var updateButtons = document.querySelectorAll('.update-order-btn');

        // Loop through all buttons and add an event listener to each one
        updateButtons.forEach(function(button) {
          button.addEventListener('click', function() {
            // Get the order ID from the data-order-id attribute
            var orderId = this.getAttribute('data-order-id');
            var orderStatus = this.getAttribute('data-order-status');

            // Set the hidden input in the modal with the order ID
            document.getElementById('modalOrderId').value = orderId;
            document.getElementById('modalOrderStatus').value = orderStatus;
          });
        });

        // Handle form submission with AJAX
        $('#saveChangesBtn').click(function() {
          // Serialize the form data
          var formData = $('#updateOrderForm').serialize();

          // Send the AJAX request
          $.ajax({
            type: "POST",
            url: "update-orders.php",
            data: formData,
            dataType: "json",
            success: function(response) {
              if (response.success) {
                
                alert(response.message);

                // swal("Good job!", response.message, "success");

                // Reload the page or update the row with new status
                location.reload();
              } else {
                alert(response.message);
                // swal("Failed!", response.message, "warning");
              }
            },
            error: function() {
              alert("An error occurred. Please try again.");
            }
          });
        });
      });
    </script>


<?php require "../layouts/footer.php"; ?>