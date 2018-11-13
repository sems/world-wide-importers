    <?php if(isset($_COOKIE['basket'])) {
            //if cookie 'basket' exists, run this code
            echo "<h3 class='basket_title'>Winkelwagen</h3>";
        }?>
<div class="row">
    <div class="col-md-8">
        <?php 

        $checkFor = array(
            "basket_add" => "success",
            "basket_changed" => "info",
            "basket_remove" => "warning",
        );
        
        foreach ($checkFor as $key => $value) {
            if (isSet($_SESSION[$key])) {
                // Access your session variable and print it
                echo '<div class="alert alert-'.$value.'" role="alert">'.$_SESSION[$key].'</div>';
                // Cleanup session variable
                unset($_SESSION[$key]);
            }
        }
        ?>
        <div class="row">
            <?php
            if(isset($_COOKIE['basket'])) {
                //Turn cookie into array
                $basket = json_decode($_COOKIE['basket'], true);
                //Variable for the total price
                $totalPrice = 0;

                foreach ($basket as $key => $value) {
                    //print the products from the basket array
                    $data = $db->prepare("SELECT StockItemName, Size, Photo, UnitPrice FROM stockitems WHERE StockItemID = ($key)");
                    $data->execute();
                    $data = $data->fetch();
                    //Show product name and picture
                    ?> 
                    <div class='col-md-12'> 
                        <div class="row basket_product">
                            <?php
                            ?> <div class='col-md-3'> <?php print(strlen($data['Photo']) < 1 ? "<img src='http://placehold.it/150x150' />":"<img src='data:image/gif;base64,".base64_encode($data['Photo'])."'/>");
                            ?> </div> 
                            <div class="col-md-5">
                                <h6><?php print($data['StockItemName']);?></h6>
                                <p><?php print(!empty($data['Size']) ? "Grootte: " . $data['Size']: "Geen grootte"); ?></p>
                                <form method="post" action="f_delete_from_basket.php">
                                    <input type="hidden" <?php print("name='" . $key . "'") ?> <?php print("value='" . $basket[$key] . "'")?>>
                                    <button class="btn btn-primary" type='submit' <?php print("value='" . $key . "'") ?>>Verwijder product</button>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <form method='post' action='f_change_amount_basket.php'>
                                    <input class='form-control' type='number' <?php print("name='" . $key . "' value='" . $value . "'")?> min= 1 <?php print("onchange='run_change_amount" . $key . "()'") ?>>
                                    <button style="display: none;" class='btn btn-warning' type='submit' value='Bevestig' <?php print("id='send_button" . $key . "'") ?>></button>
                                </form>
                            
                                <?php
                                print("<script> \n function run_change_amount" . $key . "(){ \n var button" . $key . " = document.getElementById('send_button" . $key . "'); \n button" . $key . ".form.submit(); } \n </script>");   
                                //Delete product with a invisible field. Later we can use this field to see which product has been deleted
                                ?>   
                                <span class="basket_product_price">Stukprijs: €<?php echo $data['UnitPrice']; ?></span> 
                                <span class="basket_product_price"><strong>Subtotaal: €<?php print(number_format($value * $data['UnitPrice'], 2)) ; ?></strong></span>                 
                            </div>
                        </div>
                    </div>
                    <?php
                    $totalPrice = $totalPrice + ($value * $data['UnitPrice']);
                }
            } else {
                //This piece of code runs when cookie 'basket' doesn't exist
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
        <?php 
            if (isset($_COOKIE['basket'])) {
                ?>
                <div class="col-md-4">
                    <p>Subtotaal: €<?php print(number_format($totalPrice, 2))?></p>
                    <p>Verzendkosten: €0.00</p>
                    <hr />
                    <p><strong> Totaal prijs: €<?php print(number_format($totalPrice, 2))?></strong></p>
                    <form action="f_placeorder.php" method="post">
                        <div class="form-group">
                            <label for="basket_address_select">Verzendadres</label>   
                            <select class="form-control" name="address_select" id="basket_address_select">
                            <?php
                                // check if user already excits with the email
                                $personID = $_SESSION['PersonID'];
                                $stmt = $db->prepare("SELECT C.CustomerID, C.PrimaryContactPersonID, C.DeliveryAddressLine1, Cs.CityName FROM customers C JOIN cities Cs ON C.DeliveryCityID = Cs.CityID  WHERE PrimaryContactPersonID=:person_id");
                                $stmt->execute(['person_id' => $personID]); 
                                $row = $stmt->fetchAll();
                                foreach ($row as $address){
                                    print("<option value='".$address['CustomerID']."'>".$address['DeliveryAddressLine1']." ".$address['CityName']."</option>");
                                }
                            ?>
                            </select>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Plaatsen">
                    </form>
                </div>
                <?php
            }
        ?>
</div>