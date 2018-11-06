<?php
require('inc/config.php');

$winkelmand1 = json_decode($_COOKIE['basket'], true);
foreach($winkelmand1 as $key4 => $value4){
    if(!empty($_POST[$key4])){
        $winkelmand1[$key4] = $_POST[$key4];
    }
    else{    
    }
}
setcookie('basket', json_encode($winkelmand1));
header('Location: basket.php');
?>