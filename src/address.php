<?php
    require('inc/config.php');

    // title variable (used in template)
    $title = "Mijn adressen";
    if(!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == false)) {
        header('Location: login.php');
        exit();
    } 
    $view = "address.php";

    include_once $template;
?>
// Testjeuh