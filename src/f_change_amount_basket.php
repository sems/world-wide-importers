<?php
    require('inc/config.php');
    
    // Turn cookie into array
    $basket = json_decode($_COOKIE['basket'], true);
    
    foreach($basket as $key => $value){
        // Check if value from the invisible field matches the key from basket
        if(!empty($_POST[$key]) && $_POST[$key] >= 1){
            $basket[$key] = $_POST[$key];
            $_SESSION['basket_changed'] = "Product aantal aangepast.";
        }
    }
    
    //Replace cookie with the current basket array
    setcookie('basket', json_encode($basket), time()+3600);
    
    header('Location: basket.php');
?>