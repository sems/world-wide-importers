<div class="row">
<?php
if(isset($_COOKIE['basket'])) {
    //start code
    $winkelmand = json_decode($_COOKIE['basket'], true);
    $totalePrijs = 0;

    //printen van producten in artikelen array
    foreach ($winkelmand as $key => $value) {
        $naam = $db->prepare("SELECT StockItemName FROM Stockitems WHERE StockItemID = ($key)");
        $size = $db->prepare("SELECT Size FROM Stockitems WHERE StockItemID = ($key)");
        $photo = $db->prepare("SELECT Photo FROM Stockitems WHERE StockItemID = ($key)");
        $price = $db->prepare("SELECT UnitPrice FROM Stockitems WHERE StockItemID = ($key)");
        $naam->execute();
        $naam = $naam->fetch();
        $size->execute();
        $size = $size->fetch();
        $photo->execute();
        $photo = $photo->fetch();
        $price->execute();
        $price = $price->fetch();

        print("<div class='col-md-3'>");
        print("<h5>".$naam[0]."</h5>");
        print(strlen($photo[0]) < 1 ? "<img class='card-img-top' src='img/image_not_found.png' />":"<img class='card-img-top' src='data:image/gif;base64,".base64_encode($row['Photo'])."'/>");
        
        //kijken of Size een waarde heeft
        if (!empty($size[0])) {
            print("Grootte: " . $size[0]);
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
        print("<br> Prijs: €" . ($value * $price[0]) . "<br><br></div>");
        $totalePrijs = $totalePrijs + ($value * $price[0]);
    }    
    print("<hr/><p> Totale prijs: €" . $totalePrijs."</p>");
    
}
else{
    print("Je hebt nog geen artikelen in je winkelmand");
}
?>
</div>