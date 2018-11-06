<?php
function IsNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '' || strlen($str) == 0 || !is_null($str) || !empty($str));
}

if (strlen($product['StockItemName']) < 1) {
    print("Er is geen product geselecteerd!");
} else {
    print("<table><tr>".$product['StockItemID']);
    print("<td>".(strlen($product['Photo']) < 1 ? "<img id='productImage' src='img/image_not_found.png' />":"<img id='productImage' src='data:image/gif;base64,".base64_encode($product['Photo'])."'/>")."</td>");
    print("<td>".$product['StockItemName']);
    print("<br />".$product['UnitPrice']);
    print("<br />".($product['ColorID'] == 0 ? "Geen kleur":$product['ColorName']));
    print("<form method='post' action='f_add_to_basket.php'><input class='form-control' type='number' name='itemAmount' id='itemAmount' min='1' value='1'> <input type='hidden' id='".$product['StockItemID']."' name='itemID' value='".$product['StockItemID']."'><button class='btn btn-primary btn-block' type='submit'>Plaats in winkelmand</button></form>");
    print("</td>");
    print("</tr></table>");
}
?>
