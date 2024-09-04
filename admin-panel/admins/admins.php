      <?php require "../layouts/header.php"; ?>
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-4 d-inline">Admins</h5>
                <a  href="create-admins.php" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">username</th>
                        <th scope="col">email</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                      
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                      
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                      
                      </tr>
                    </tbody>
                  </table> 
                </div>
              </div>
            </div>
          </div>



          <?php require "../layouts/footer.php"; ?>