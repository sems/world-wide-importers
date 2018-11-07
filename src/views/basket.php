<div class="row">
    <div class="col-md-10">
        <div class="row">
            <?php
            if(isset($_COOKIE['basket'])) {
                //start code
                $winkelmand = json_decode($_COOKIE['basket'], true);
                $totalePrijs = 0;

                //printen van producten in artikelen array
                foreach ($winkelmand as $key => $value) {
                    $data = $db->prepare("SELECT StockItemName, Size, Photo, UnitPrice FROM Stockitems WHERE StockItemID = ($key)");
                    $data->execute();
                    $data = $data->fetch();

                    print("<div class='col-md-3'>");
                    print("<h5>".$data['StockItemName']."</h5>");
                    print(strlen($data['Photo']) < 1 ? "<img class='card-img-top' src='img/image_not_found.png' />":"<img class='card-img-top' src='data:image/gif;base64,".base64_encode($data['Photo'])."'/>");
                    
                    //kijken of Size een waarde heeft
                    if (!empty($data['Size'])) {
                        print("Grootte: " . $data['Size']);
                    } else {
                        print("Geen grootte");
                    }
                    ?>
                    <form method="post" action='f_change_amount_basket.php'>
                        <input class="form-control" type="number" <?php print("name='" . $key . "'") ?> value="<?php print("$value") ?>" min="1">
                        <input class="btn btn-warning" type="submit" value="Bevestig">
                    </form>
                    <form method="post" action="f_delete_from_basket.php">
                        <input type="hidden" <?php print("name='" . $key . "'") ?> <?php print("value='" . $winkelmand[$key] . "'")?>>
                        <button class="btn btn-primary" type='submit' <?php print("value='" . $key . "'") ?>>Verwijder product</button>
                    </form>
                    <?php
                    print("<br> Prijs: €" . ($value * $data['UnitPrice']) . "<br><br></div>");
                    $totalePrijs = $totalePrijs + ($value * $data['UnitPrice']);
                }
            } else {
                ?> 
                <div class="col-md-6 start-shopping text-center mx-auto">
                    <i class="fas fa-shopping-basket"></i>
                    <h3>Uw winkelwagen is leeg</h3>
                    <a class="btn btn-primary" href="index.php">Winkelen</a>
                </div>
                <?php
            }    
            ?>
        </div>
    </div>
    <div class="col-md-2">
        <?php 
            if (isset($_COOKIE['basket'])) {
                print("<p> Totale prijs: €".$totalePrijs."</p>"); 
            }
        ?>
    </div>
</div>