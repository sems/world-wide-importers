<?php
    require('inc/config.php');

    // Define title variable
    $title = "Profiel";


    if(!isset($_SESSION['logged_in'])) {
        // Check if logged_in isset
        if ($_SESSION['logged_in'] == false) {
            // Check if not logged in

            // Redirect to login
            header('Location: login.php');
            exit();
        }
    } 

    // Defining view location
    $view = "profile.php";
    
    // Include template
    include_once $template;
?>