<?php
if(isset($_COOKIE['basket'])) {
    //start code
    $winkelmand = json_decode($_COOKIE['basket'], true);

    //voorbereiden queries voor naam, eventuele grootte, foto en prijs
    $naam = $db->prepare("SELECT StockItemName FROM Stockitems WHERE StockItemID = ($key)");
    $size = $db->prepare("SELECT Size FROM Stockitems WHERE StockItemID = ($key)");
    $photo = $db->prepare("SELECT Photo FROM Stockitems WHERE StockItemID = ($key)");
    $price = $db->prepare("SELECT RecommendedRetailPrice FROM Stockitems WHERE StockItemID = ($key)");
    
    //printen van producten in artikelen array
    foreach ($winkelmand as $key => $value) {
        $naam = $db->prepare("SELECT StockItemName FROM Stockitems WHERE StockItemID = ($key)");
        $size = $db->prepare("SELECT Size FROM Stockitems WHERE StockItemID = ($key)");
        $photo = $db->prepare("SELECT Photo FROM Stockitems WHERE StockItemID = ($key)");
        $price = $db->prepare("SELECT RecommendedRetailPrice FROM Stockitems WHERE StockItemID = ($key)");
        $naam->execute();
        $naam = $naam->fetch();
        $size->execute();
        $size = $size->fetch();
        $photo->execute();
        $photo = $photo->fetch();
        $price->execute();
        $price = $price->fetch();
        print("<img src='data:image/gif;base64," . base64_encode($photo[0]) . "'/>" . $naam[0] . "<br>");
        //kijken of Size een waarde heeft
        if (!empty($size[0])) {
            print("Grootte: " . $size[0]);
        } else {
            print("Geen grootte");
        }
        ?>
        <br>
        <form method="post" action='f_change_amount_basket.php'>
            <input type="number" <?php print("name='" . $key . "'") ?> value="<?php print("$value") ?>" min="1">
            <input type="submit" value="Bevestig">
        </form>
        <form method="POST" action="f_delete_from_basket.php">
            <input type="hidden" <?php print("name='" . $key . "'") ?> <?php print("value='" . $winkelmand[$key] . "'")?>>
            <button type='submit' <?php print("value='" . $key . "'") ?>>Verwijder product</button>
        </form>
        <?php
        print("<br> Prijs: €" . ($value * $price[0]) . "<br><br>");
    }       
}
else{
    print("Je hebt nog geen artikelen in je winkelmand");
}
?>