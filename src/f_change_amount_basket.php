<?php
    require('inc/config.php');

    $winkelmand1 = json_decode($_COOKIE['basket'], true);
    foreach($winkelmand1 as $key => $value){
        if(!empty($_POST[$key])){
            $winkelmand1[$key] = $_POST[$key];
            $_SESSION['basket_changed'] = "Product aantal aangepast.";
        }
    }
    setcookie('basket', json_encode($winkelmand1));
    header('Location: basket.php');
?>