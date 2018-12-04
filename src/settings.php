<?php
    require('inc/config.php');

    /*
    * title variable (used in template)
    * checkForNav variable (used in navigation.php)
    */
    $title = "Instellingen";
    $checkForNav = "Profiel";


    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
        /*
        * Check if logged in, if not redirect to login.php
        */

        header('Location: login.php');
        exit();
    } 

    // Defining view location
    $view = "settings.php";
    
    // Include template
    include_once $template;
?>