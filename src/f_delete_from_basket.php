<?php
    require('inc/config.php');
    
    //Turn cookie into array
    $basket1 = json_decode($_COOKIE['basket'], true);
    
    foreach($basket1 as $key => $value){
        //Check if value of delete button matches key in basket1
        if(!empty($_POST[$key])){
            unset($basket1[$key]);
            $_SESSION['basket_add'] = "Product verwijderd.";
        }
    }
    if(!empty($basket1)){
        //If there is something in basket1, make a cookie
        $basket2 = json_encode($basket1);
        setcookie('basket', json_encode($basket2));
    } 
    else{
        //Deletes cookie if basket1 is empty
        setcookie('basket', "", time()-3600);
    }
    
    header('Location: basket.php');
?>