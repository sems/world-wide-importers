<div class="jumbotron jumbotron-fluid bg-img">
    <img src="img/homepage-logo.png" />
</div>

<div class="row">
    <h1 class="container">Uitgelicht</h1>
    <?php
        // For each product print product photo (or fallback photo) and add product name
        if(sizeOf($arrayProducts) >= 1) {
        $i = 0;
        print("<div class='card-deck product-row-margin'>");
        foreach ($arrayProducts as $row) {
            print("<div class='col-md-3 products-top-margin '>
            <div class='card'>
                <a class='products-link' href='product.php?id=".$row['StockItemID']."'>
                ".(strlen($row['Photo']) < 1 ? 
                    "<img class='card-img-top' src='img/image_not_found.png' />":
                    "<img class='card-img-top' src='data:image/gif;base64,".base64_encode($row['Photo'])."'/>")."
                </a>");

            print("<div class='card-body'>");
            print("<table><tr><td><a class='products-link' href='product.php?id=".$row['StockItemID']."'>"
            .$row['StockItemName'].
            "</a></td>
            <td class='product-price'>
            &euro;".$row['UnitPrice'].
            "</td></tr></table>");

            print("</div></div></div>");
        }
        print("</div>");
        } else { ?>

        <div class="col-md-12">
            <h3>Geen resultaten</h3>
        </div>
        <?php
        }
    ?>
</div>