<?php
function IsNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '' || strlen($str) == 0 || !is_null($str) || !empty($str));
}

if (!(strlen($product) < 5)) {

} else {
    print("Er is geen product geselecteerd!");
}
?>


<?php
// For each produc print product photo (null) and add product name
if(sizeOf($arrayProducts) < 1) {
  echo 'Geen resultaten';
} else {
  foreach ($arrayProducts as $row) {
    // print photo
    print("<a href='product.php?id=".$row['StockItemID']."'><img width='50px' src='data:image/gif;base64,".base64_encode($row['Photo'])."'/>");
    //print name
    print($row['StockItemName'] . "</a><br />");
  }
}

?>