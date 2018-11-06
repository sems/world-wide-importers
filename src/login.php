<?php
    require('inc/config.php');
    // title variable (used in template)
    $title = "Login";

    if(isset($_SESSION["logged_in"])) {
        if($_SESSION["logged_in"] == true) {
            header("location: profile.php");
        } 
    }
    $view = "login.php";
    include_once $template;
?>
