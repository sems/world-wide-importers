<?php
    require('inc/config.php');

    if(isset($_SESSION["logged_in"])) {
        if($_SESSION["logged_in"] == true) {
            header("location: profile.php");
        } 
    }
    $view = "login.php";
    include_once $template;
?>
