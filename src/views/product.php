<?php
    if (strlen($product['StockItemName']) < 1) {
        // Check if a product is selected, if not print error message
        print('<div class="alert alert-danger" role="alert">Er is geen product geselecteerd!</div>');
    } else {
        print("<table><tr>");
        print("<td>".(strlen($product['Photo']) < 1 ? "<img id='productImage' src='img/image_not_found.png' />":"<img id='productImage' src='data:image/gif;base64,".base64_encode($product['Photo'])."'/>")."</td>");
        print("<td>".$product['StockItemName']);
        print("<br />".$product['UnitPrice']);
        print("<br />".(strlen($product['MarketingComments']) < 1 ? "Geen marketing comments":$product['MarketingComments']));
        print("<br />".(strlen($product['Tags']) < 1 ? "Geen tags":"Tags: ".$product['Tags']));
        print("<br />".($product['ColorID'] == 0 ? "Geen kleur":$product['ColorName']));
        print("<form method='post' action='f_add_to_basket.php'><input class='form-control' type='number' name='itemAmount' id='itemAmount' min='1' value='1'> <input type='hidden' id='".$product['StockItemID']."' name='itemID' value='".$product['StockItemID']."'><button class='btn btn-primary btn-block' type='submit'><span class='fa fa-cart-plus'></span></button></form>");
        print("</td>");
        print("</tr></table>");
    }
?>
