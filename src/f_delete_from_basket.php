<?php
require('inc/config.php');

$winkelmand1 = json_decode($_COOKIE['basket'], true);
print_r($_POST);
foreach($winkelmand1 as $key4 => $value4){
    if(!empty($_POST[$key4])){
        unset($winkelmand1[$key4]);
    }
    else{
        
    }
}
print_r($winkelmand1);
$winkel = json_encode($winkelmand1);
setcookie('basket', json_encode($winkelmand1));
header('Location: basket.php');