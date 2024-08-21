<?php 

    // Log Out the user
    session_start();
    session_unset();
    session_destroy();

    // A redirect back to the login page
    header("Location: login.php");

?>