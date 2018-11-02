<?php
require('inc/config.php');

// lege StockItemID variabele die later ingevuld word (of niet)
$StockItemID = "";
// lege sql variabele die later ingevuld word
$sql = '';
// lege product variabele die later ingevuld word
$product = '';

// Controleer of 'id' is geset
if (isset($_GET['id'])) {
    // Wijs 'id' toe aan StockItemID variabele
    $StockItemID = $_GET['id'];
    // Wijs sql toe
    $sql = 'SELECT * FROM stockitems WHERE StockItemID = 1';
print("HOI");
    // Query wordt voorbereid
    $query = $db->prepare($sql);
    // De query wordt uitgevoerd
    if ($query->execute()) {
        $product = $query->fetch();
    }
}

$view = "views/product.php";
include_once $template;
?>
