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
    } 
    $view = "placeorder.php";
    
    include_once $template;
?>
