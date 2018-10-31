<?php
require('inc/config.php');

// lege array die later gevuld wordt
$arrayProducts = array();
// query die hier onder gebruikt wordt
$sql = 'SELECT * FROM stockitems';

// query wordt voorbereid
$query = $db->prepare($sql);

// query wordt uitgevoerd, aantal resultaten worden geteld en als dit niet 0 is
// gaat hij de resultaten in de lege array hierboven zetten. In de views laat hij deze zien
if($query->execute()) {
  $rowCount = $arrayProducts->rowCount();
  if($rowCount !== 0) {
    while($products = $query->fetch()) {
        array_push($arrayProducts, $products);
    }
  }
}

$view = "views/products.php";
include_once $template;
?>
