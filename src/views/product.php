<?php
    if (strlen($product['StockItemName']) < 1) {
        // Check if a product is selected, if not print error message
        print('<div class="alert alert-danger" role="alert">Er is geen product geselecteerd!</div>');
    } else {
        print("<table><tr>");
        print("<td>".(strlen($product['Photo']) < 1 ? "<img id='productImage' src='img/image_not_found.png' />":"<img id='productImage' src='data:image/gif;base64,".base64_encode($product['Photo'])."'/>")."</td>");
        print("<td>".$product['StockItemName']);
        print("<br />&#8364;".$product['UnitPrice']);
        print((strlen($product['MarketingComments']) < 1 ? "":"<br />".$product['MarketingComments']));
        print((strlen($product['Tags']) < 3 ? "":"<br />Tags: ".$product['Tags']));
        print("<br />Op voorraad: ".$product['QuantityOnHand']);
        print(($product['ColorID'] == 0 ? "":"<br />".$product['ColorName']));
        print("<form method='post' action='f_add_to_basket.php'>
                <div>
                    <input style='float: left;' class='form-control col-md-4' type='number' name='itemAmount' id='itemAmount' min='1' max='".$product['QuantityOnHand']."' value='1'>
                    <input type='hidden' id='".$product['StockItemID']."' name='itemID' value='".$product['StockItemID']."'>
                    <button style='float: left;' class='btn btn-primary btn-block col-md-2' type='submit'>
                        <span class='fa fa-cart-plus'></span>
                    </button>
                </div>
            </form>");
        print("</td>");
        print("</tr></table>");
    }
?>
