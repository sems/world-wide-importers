<?php
require('inc/config.php');

// lege sql variabele die later ingevuld wordt
$sql = '';

// kijkt of er gezocht is of dat de productenpagina gewoon bezocht wordt en geeft een query ob basis hiervan
if(isSet($_GET['search'])) {
  // resultaat uit de URL
  $request = $_GET['search'];
  $sql = 'SELECT * FROM stockitems WHERE SearchDetails LIKE "%'.$request.'%"';
} else {
  $sql = 'SELECT * FROM stockitems';
}
// lege array die later gevuld wordt
$arrayProducts = array();

// query wordt voorbereid
$query = $db->prepare($sql);

// query wordt uitgevoerd, aantal resultaten worden geteld en als dit niet 0 is
// gaat hij de resultaten in de lege array hierboven zetten. In de views laat hij deze zien
if($query->execute()) {
  $rowCount = $query->rowCount();
  if($rowCount !== 0) {
    while($products = $query->fetch()) {
        array_push($arrayProducts, $products);
    }
  }
}

$view = "products.php";
include_once $template;
?>
