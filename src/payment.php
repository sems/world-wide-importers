<?php
    require('inc/config.php');
    // title variable (used in template)
    $title = "Betaling";
    if(isset($_SESSION['logged_in'])) {
        header('Location: profile.php');
        exit();
    } 
    $view = "payment.php";
    
    include_once $template;
?>
