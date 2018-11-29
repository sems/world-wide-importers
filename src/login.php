<?php
    require('inc/config.php');

    /*
    * title variable (used in template)
    */
    $title = "Login";

    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
        /*
        * Check if logged in, if so redirect to profile.php
        */

        header("location: profile.php");
        exit();
    }

    // Defining view location
    $view = "login.php";

    // Include template
    include_once $template;
?>
