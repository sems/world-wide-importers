<?php
function IsNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '' || strlen($str) == 0 || !is_null($str) || !empty($str));
}

if (strlen($product['StockItemName']) < 1) {
    print("Er is geen product geselecteerd!");
} else {
    print("<table><tr>");
    print("<td>".(strlen($product['Photo']) < 1 ? "<img id='productImage' src='img/image_not_found.png' />":"<img id='productImage' src='data:image/gif;base64,".base64_encode($product['Photo'])."'/>")."</td>");
    print("<td>".$product['StockItemName']);
    print("<br />".$product['UnitPrice']);
    print("<br />".($product['ColorID'] == 0 ? "Geen kleur":$product['ColorName']));
    print("<br /><button type='button'>Plaats in winkelmand</button>");
    print("</td>");
    print("</tr></table>");
}
?>