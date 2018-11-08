<?php
    require('inc/config.php');

    // Define title variable
    $title = "Login";

    if(isset($_SESSION["logged_in"])) {
        // Check if logged_in isset
        if($_SESSION["logged_in"] == true) {
            // Check if logged in

            // Redirect to profile
            header("location: profile.php");
            exit();
        } 
    }

    // Defining view location
    $view = "login.php";

    // Include template
    include_once $template;
?>
