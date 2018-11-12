<?php
    require('inc/config.php');

    // Define title variable
    $title = "Instellingen";


    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
        // Check if logged_in isset
        // Check if not logged in

        // Redirect to login
        header('Location: login.php');
        exit();
    } 

    // Defining view location
    $view = "my_settings.php";
    
    // Include template
    include_once $template;
?>