<?php
    
    if (!isset($_SERVER['HTTP_REFERER'])){
        header("Location: localhost/Freshcery/");
        exit();
    }
    
?>

<?php
    // Includes the header
    require "includes/header.php";
?>

<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">404 - Page Not Found</h1>
                <p class="lead">Oops! The page you are looking for does not exist.</p>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Error 404!</h4>
            <p>The page you are trying to access does not exist or may have been moved.</p>
            <hr>
            <p class="mb-0">Please check the URL or <a href="<?php echo URL()?>">return to the homepage</a>.</p>
        </div>
    </div>
</div>

<?php
    // Include the footer
    include_once "includes/footer.php";
?>
