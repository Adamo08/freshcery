<?php 


    if (!isset($_SERVER['HTTP_REFERER'])){
        header("Location: http://localhost/Freshcery/index.php");
        exit();
    }


    // Database configuration
    define('DB_HOST', 'localhost:4306');         // Database Hostname
    define('DB_USERNAME', 'root');          // Database Username
    define('DB_PASSWORD', '');      // Database Password
    define('DB_NAME', 'Freshcery');       // Database Name


    try {
        // Create a PDO instance
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // echo "Connected successfully"; 
    } catch (PDOException $e) {
        // Handle connection errors
        echo "Connection failed: " . $e->getMessage();
    }

?>