<?php
    require('inc/config.php');
    
    // Turn cookie into array
    $basket = json_decode($_COOKIE['basket'], true);
    
    foreach($basket as $key => $value){
        // Check if value from the invisible field matches the key from basket
        if(!empty($_POST[$key])){
            $basket[$key] = $_POST[$key];
            setAlert("Product aantal aangepast.", "success");
        }
    }
    
    //Replace cookie with the current basket array
    setcookie('basket', json_encode($basket));
    
    header('Location: basket.php');
?>