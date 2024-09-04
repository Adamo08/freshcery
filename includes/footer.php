<?php
// Include the helpers file only once
include_once 'helpers/helpers.php';
?>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- SweetAlertJs -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
