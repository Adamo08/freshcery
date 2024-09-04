<?php
    function URL($path = '') {
        // Get the base URL defined in your config.php or set it manually here
        $baseUrl = 'http://localhost/Freshcery';

        // Ensure the path does not start with a slash
        if ($path && $path[0] === '/') {
            $path = substr($path, 1);
        }

        // Return the full URL
        return $baseUrl . '/' . $path;
        
    }


    // A function to generate an alphanumeric string
    function generateAlphanumericString($ID) {
        // Step 1: Convert the ID to a base-36 string
        $base36 = strtoupper(base_convert($ID, 10, 36)); // Convert to base-36 and uppercase
        
        // Step 2: Pad the string to a desired length (if needed)
        $padded = str_pad($base36, 10, '0', STR_PAD_LEFT); // Pad to 10 characters
        
        // Step 3: Add a prefix and/or suffix
        $prefix = 'AL';
        $suffix = strtoupper(substr(md5($ID), 0, 4)); // Use first 4 chars of md5 hash as suffix
        
        // Combine parts to create the final string
        return $prefix . $padded . $suffix;
    }


    // Function to sanitize input
    function sanitizeInput($data) {
        return htmlspecialchars(trim($data));
    }



