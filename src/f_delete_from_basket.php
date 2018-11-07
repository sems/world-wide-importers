<?php
require('inc/config.php');

$winkelmand1 = json_decode($_COOKIE['basket'], true);
foreach($winkelmand1 as $key => $value){
    if(!empty($_POST[$key])){
        unset($winkelmand1[$key]);
    }
    else{    
    }
}
if(!empty($winkelmand1)){
$winkel = json_encode($winkelmand1);
setcookie('basket', json_encode($winkelmand1));
}
else{
    setcookie('basket', "", time()-3600);
}
header('Location: basket.php');