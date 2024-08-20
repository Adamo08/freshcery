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



