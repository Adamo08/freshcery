<?php require "../layouts/header.php"; ?>

    <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Orders</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">first name</th>
                    <th scope="col">last name</th>
                    <th scope="col">email</th>
                    <th scope="col">country</th>
                    <th scope="col">status</th>
                    <th scope="col">price in USD</th>
                    <th scope="col">date</th>
                    <th scope="col">update</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Mark</td>
                    <td>Otto@email.com</td>
                    <td>USA</td>
                    <td>sent to admins</td>
                    <td>10</td>
                    <td>12-12-2022</td>
                    <td>                
                        <a href="#" class="btn btn-warning text-white mb-4 text-center">update</a>
                    </td>
                   
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Jacob</td>
                    <td>Otto@email.com</td>
                    <td>USA</td>
                    <td>sent to admins</td>
                    <td>10</td>
                    <td>12-12-2022</td>
                    <td>                
                        <a href="#" class="btn btn-warning text-white mb-4 text-center">update</a>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>Larry</td>
                    <td>Otto@email.com</td>
                    <td>USA</td>
                    <td>sent to admins</td>
                    <td>10</td>
                    <td>12-12-2022</td>
                    <td>                
                        <a href="#" class="btn btn-warning text-white mb-4 text-center">update</a>
                    </td>
                  </tr>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
    </div>

<?php require "../layouts/footer.php"; ?>