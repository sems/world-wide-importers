<?php
    require('inc/config.php');
    
    //Turn cookie into array
    $basket1 = json_decode($_COOKIE['basket'], true);
    
    foreach($basket1 as $key => $value){
        //check if value from the invisible field matches the key from basket1
        if(!empty($_POST[$key])){
            $basket1[$key] = $_POST[$key];
            $_SESSION['basket_changed'] = "Product aantal aangepast.";
        }
    }
    
    //Replace cookie with the current basket array
    setcookie('basket', json_encode($basket1));
    
    header('Location: basket.php');
?>