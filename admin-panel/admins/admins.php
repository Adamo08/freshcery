      <?php require "../layouts/header.php"; ?>

      <?php 
      
        // Getting the admins from the database
        $sql = "SELECT * FROM admins";

        // Preparing the query
        $stmt = $conn->prepare($sql);

        // Executing the query
        $stmt->execute();

        // Fetching the result
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;

        
      
      
      ?>
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-4 d-inline">Admins</h5>
                  <?php if (isset($_SESSION['admin'])):?>
                    <a  href="create-admins.php" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
                    <table class="table table-striped table-hover mt-4">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">username</th>
                          <th scope="col">email</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($admins as $adm): ?>
                          <tr>
                            <th scope="row">
                              <?=++$i?>
                            </th>
                            <td>
                              <?=$adm['username']?>
                            </td>
                            <td>
                              <a href="mailto:<?=$adm['email']?>"><?=$adm['email']?></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  <?php else:?>
                    <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                        You are not logged in, <a href="login-admins.php">Login</a> to see the list of admins
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  <?php endif;?>
                </div>
              </div>
            </div>
          </div>



          <?php require "../layouts/footer.php"; ?>