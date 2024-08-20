

    <?php 
        include_once "includes/header.php";
    ?>


    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Cart
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th>Products</th>
                                        <th>Price</th>
                                        <th width="15%">Quantity</th>
                                        <th width="15%">Update</th>
                                        <th>Subtotal</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="assets/img/fish.jpg" width="60">
                                        </td>
                                        <td>
                                            Ikan Segar<br>
                                            <small>1000g</small>
                                        </td>
                                        <td>
                                            Rp 30.000
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="1" name="vertical-spin">
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary">UPDATE</a>
                                        </td>
                                        <td>
                                            Rp 30.000
                                        </td>
                                        <td>
                                            <a href="javasript:void" class="text-danger"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="assets/img/meats.jpg" width="60">
                                        </td>
                                        <td>
                                            Sirloin<br>
                                            <small>1000g</small>
                                        </td>
                                        <td>
                                            Rp 120.000
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="1" name="vertical-spin">
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary">UPDATE</a>
                                        </td>
                                        <td>
                                            Rp 120.000
                                        </td>
                                        <td>
                                            <a href="javasript:void" class="text-danger"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="assets/img/vegetables.jpg" width="60">
                                        </td>
                                        <td>
                                            Mix Vegetables<br>
                                            <small>1000g</small>
                                        </td>
                                        <td>
                                            Rp 30.000
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="1" name="vertical-spin">
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary">UPDATE</a>
                                        </td>
                                        <td>
                                            Rp 30.000
                                        </td>
                                        <td>
                                            <a href="javasript:void" class="text-danger"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <a href="shop.html" class="btn btn-default">Continue Shopping</a>
                    </div>
                    <div class="col text-right">
                   
                        <div class="clearfix"></div>
                        <h6 class="mt-3">Total: Rp 180.000</h6>
                        <a href="checkout.html" class="btn btn-lg btn-primary">Checkout <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h5>About</h5>
                <p>Nisi esse dolor irure dolor eiusmod ex deserunt proident cillum eu qui enim occaecat sunt aliqua anim eiusmod qui ut voluptate.</p>
            </div>
            <div class="col-md-3">
                <h5>Links</h5>
                <ul>
                    <li><a href="<?php echo URL('about.php'); ?>">About</a></li>
                    <li><a href="<?php echo URL('contact.php'); ?>">Contact Us</a></li>
                    <li><a href="<?php echo URL('faq.php'); ?>">FAQ</a></li>
                    <li><a href="javascript:void(0)">How it Works</a></li>
                    <li><a href="<?php echo URL('terms.php'); ?>">Terms</a></li>
                    <li><a href="<?php echo URL('privacy.php'); ?>">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Contact</h5>
                <ul>
                    <li><a href="tel:+620892738334"><i class="fa fa-phone"></i> 08272367238</a></li>
                    <li><a href="mailto:hello@domain.com"><i class="fa fa-envelope"></i> hello@domain.com</a></li>
                </ul>
                <h5>Follow Us</h5>
                <ul class="social">
                    <li><a href="javascript:void(0)" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="javascript:void(0)" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="javascript:void(0)" target="_blank"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Get Our App</h5>
                <ul class="mb-0">
                    <li class="download-app"><a href="#"><img src="<?php echo URL('assets/img/playstore.png'); ?>"></a></li>
                    <li style="height: 200px">
                        <div class="mockup">
                            <img src="<?php echo URL('assets/img/mockup.png'); ?>">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <p class="copyright">&copy; 2018 Freshcery | Groceries Organic Store. All rights reserved.</p>
</footer>

<script type="text/javascript" src="<?php echo URL('assets/js/jquery.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/js/jquery-migrate.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/packages/bootstrap/libraries/popper.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/packages/bootstrap/bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/packages/o2system-ui/o2system-ui.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/packages/owl-carousel/owl-carousel.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/packages/cloudzoom/cloudzoom.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/packages/thumbelina/thumbelina.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/packages/bootstrap-touchspin/bootstrap-touchspin.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL('assets/js/theme.js'); ?>"></script>

    <script>
        $(document).ready(function() {
            $(".form-control").keyup(function(){
                var value = $(this).val();
                value = value.replace(/^(0*)/,"");
                $(this).val(1);
            });

        })
    </script>
</body>
</html>
