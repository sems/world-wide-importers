<?php
    require('inc/config.php');

    // Define title variable
    $title = "Gelukt!";

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $orderID = $_SESSION['orderid'];
    $linkToOrder = $actual_link."/order.php?id=".$orderID;

    // Defining view location
    $view = "success.php";
    
    // Include template
    include_once $template;
?>
