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
        $tussenprijs = ($value * $data['UnitPrice']);
        print("<br> Prijs: €" . number_format((float)$tussenprijs, 2, ',', '') . "<br><br></div>");
        $totalePrijs = $totalePrijs + $tussenprijs;
    }    
    print("<hr/><p> Totale prijs: €" . number_format((float)$totalePrijs, 2, ',', '')."</p>");
    
}
else{
    print("Je hebt nog geen artikelen in je winkelmand");
}
?>
</div>