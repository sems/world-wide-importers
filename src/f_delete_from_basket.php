<?php
    require('inc/config.php');
    
    // Turn cookie into array
    $_basket = json_decode($_COOKIE['basket'], true);
    
    foreach($_basket as $key => $value){
        // Check if value of delete button matches key in basket
        if(!empty($_POST[$key])){
            unset($_basket[$key]);
            setAlert("Product verwijderd.", "warning");
        }
    }
    if(!empty($_basket)){
        // If there is something in basket, make a cookie
        setcookie('basket', json_encode($_basket), time()+3600);
    } 
    else{
        // Deletes cookie if basket1 is empty
        setcookie('basket', "", time()-3600);
    }
    
    header('Location: basket.php');
?>