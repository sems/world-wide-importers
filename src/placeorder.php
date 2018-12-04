<?php
    require('inc/config.php');

    /*
    * title variable (used in template)
    */
    $title = "Adres selecteren";

    if(isset($_SESSION['logged_in'])) {
        /*
        * Check if logged in, if so redirect to profile.php
        */
        header('Location: profile.php');
        exit();
    } else {
        setAlert("Weet u zeker dat u geen account wil aanmaken? Zo nee, klik dan <strong><a href='register.php' class=''>hier</a></strong>.", "warning");
    }
    $view = "placeorder.php";
    
    include_once $template;
?>
