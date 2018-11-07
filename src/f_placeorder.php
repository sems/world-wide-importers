<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if form is send
        if (isset($_COOKIE['basket'])) {
            $basket = json_decode($_COOKIE['basket'], true);
        } else {
            # there is no basket.
        }
        
    } else {
        # No data has been posted
    }
?>