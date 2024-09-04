      <?php require "../layouts/header.php"; ?>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Products</h5>
              <a  href="create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>
            
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">product</th>
                    <th scope="col">price in $$</th>
                    <th scope="col">expiration date</th>
                    <th scope="col">status</th>
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>tomatos</td>
                    <td>20</td>
                    <td>2025</td>
                     <td><a href="#" class="btn btn-success  text-center ">verfied</a></td>
                     <td><a href="#" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>meat</td>
                    <td>40</td>
                    <td>2025</td>
                    <td><a href="#" class="btn btn-success  text-center ">verfied</a></td>
                    <td><a href="#" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                 <tr>
                    <th scope="row">3</th>
                    <td>chicken</td>
                    <td>34</td>
                    <td>2025</td>
                    <td><a href="#" class="btn btn-danger  text-center ">unverfied</a></td>
                    <td><a href="#" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>


      <?php require "../layouts/footer.php"; ?>