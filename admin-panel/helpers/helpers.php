<?php 

    // APP URL
    if (!defined('APP_URL')) {
        define('APP_URL', 'http://localhost/Freshcery/');
    }

    
    // Function to sanitize input
    function sanitizeInput($data) {
        return htmlspecialchars(trim($data));
    }

?>