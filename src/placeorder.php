<?php
    require('inc/config.php');
    // title variable (used in template)
    $title = "Adres selecteren";
    if(isset($_SESSION['logged_in'])) {
        header('Location: profile.php');
        exit();
    } 
    $view = "placeorder.php";
    
    include_once $template;
?>
