<?php
    if (strlen($product['StockItemName']) < 1) {
        // Check if a product is selected, if not print error message
        print('<div class="alert alert-danger" role="alert">Er is geen product geselecteerd!</div>');
    } else {
        print("<div class='row'>");
        print("<div class='col-md-3'>".(strlen($product['Photo']) < 1 ? "<img id='productImage' src='img/image_not_found.png' />":"<img id='productImage' src='data:image/gif;base64,".base64_encode($product['Photo'])."'/>")."</div>");
        print("<div class='col-md-5'>
                    <div class='card'>
                        <div class='card-header'>
                            <strong>".$product['StockItemName']."</strong>
                        </div>");
        print("<div class='card-body'>
                    <h6 class='card-subtitle mb-2'>
                        Prijs: &euro;".$product['UnitPrice']."
                    </h6>
                    <p class='card-text'>
                        <table><tr><td>");
        print((strlen($product['MarketingComments']) < 1 ? "":"Opmerkingen: </td><td>".$product['MarketingComments']."</td></tr><tr><td>"));
        print("Voorraad: </td><td>".$product['QuantityOnHand']."</td></tr><tr><td>");
        print((strlen($product['Tags']) < 3 ? "":"Tags: </td><td>".$product['Tags']."</td></tr><tr><td>"));
        print(($product['ColorID'] == 0 ? "":"Kleur: </td><td>".$product['ColorName']."</td></tr><tr><td>"));
        print("</td></tr></table></p><form method='post' action='f_add_to_basket.php'>
                <div>
                    <input style='float: left;' class='form-control col-md-4' type='number' name='itemAmount' id='itemAmount' min='1' max='".$product['QuantityOnHand']."' value='1'>
                    <input type='hidden' id='".$product['StockItemID']."' name='itemID' value='".$product['StockItemID']."'>
                    <button style='float: left;' class='btn btn-primary btn-block col-md-2' type='submit'>
                        <span class='fa fa-cart-plus'></span>
                    </button>
                </div>
            </form>");
        print("</div></div></div>");
    }
?>
