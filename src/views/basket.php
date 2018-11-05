<?php
    //start code
    //Arrays voor test redenen
    $winkelmand = array(123, 4, 34, 25);
    $aantal = array(1,1,1,1);
    $hoeveelheden = array_replace($aantal, $_POST);

    //array omzetten in string
    $producten = implode(', ', $winkelmand);

    //voorbereiden query voor naam, eventuele grootte en prijs
    $mysql = $db->prepare("SELECT StockItemName, Size, Photo, RecommendedRetailPrice FROM Stockitems WHERE StockItemID IN ($producten)");
    $mysql->execute();

    //array maken van de resultaten
    $artikelen = $mysql->fetchAll(PDO::FETCH_ASSOC);

    //printen van producten in artikelen array
    foreach ($artikelen as $key => $value) {
        print("<img src='data:image/gif;base64," . base64_encode($value['Photo']) . "'/>" . $value['StockItemName'] . "<br>");
        //kijken of Size een waarde heeft
        if (!empty($value['Size'])) {
            print("Grootte: " . $value['Size']);
        } else {
            print("Geen grootte");
        }
        ?>
        <form method="post" action='basket.php'>
            <input type="number" <?php print("id='" . $key . "' name='" . $key . "'") ?> value="<?php
            foreach ($hoeveelheden as $key1 => $value1) {
                if ($key1 == $key) {
                    print($value1);
                } else {
                    
                }
            }
            ?>" min="1">

            <input type="submit" <?php print("id='" . $key . "'") ?> value="Bevestig">

        </form>
        <form action="basket.php">
            <input type='submit' <?php print("id='verwijder" . $key . "'") ?> <?php print("value='verwijder" . $key . "'") ?>>
        </form>


        <?php
        print($key . "<br> Prijs per stuk: " . ($hoeveelheden[$key] * $value['RecommendedRetailPrice']) . "<br><br>");
    }       
    //einde code
    //check of value verander en zo ja, vraag een nieuwe andere query op met een calculatie van aantal x product. 
    ?>