<h4>Adressen</h4>
<?php print(getAlert()); ?>
<button class="btn btn-primary mb-10" type="button" data-toggle="collapse" data-target="#collapseAddAddress" aria-expanded="false" aria-controls="collapseAddAddress">
    Toevoegen
</button>
<div class="collapse mb-10" id="collapseAddAddress">
    <div class="card card-body">
        <form action="f_add_address.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="inputName">Volledige naam</label>
                    <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Jan Jansen">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPhone">Telfoon naam</label>
                    <input type="text" class="form-control" id="inputPhone" name="inputPhone" placeholder="0612345678">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputAddress">Adres</label>
                    <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder="Schoolstraat">
                </div>
                <div class="form-group col-md-2">
                    <label for="inputAddress2">Huisnummer</label>
                    <input type="text" class="form-control" id="inputAddress2" name="inputAddress2" placeholder="14">
                </div>
                <div class="form-group col-md-1">
                    <label for="inputAddress3">Toevoeging</label>
                    <input type="text" class="form-control" id="inputAddress3" name="inputAddress3" placeholder="A">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputAddress4">Extra informatie</label>
                    <input type="text" class="form-control" id="inputAddress4" name="inputAddress4" placeholder="Entree, lobby, suite 3a">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputZip">Postcode</label>
                    <input type="text" class="form-control" id="inputZip" name="inputZip" placeholder="8017 CA">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputCity">Stad</label>
                    <input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="Zwolle">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputCountry">Land</label>
                    <select id="inputCountry" class="form-control county_selection" name="inputCountry" disabled="disabled">
                        <option selected>Kies...</option>
                        <?php
                            $stmt = $db->prepare("SELECT CountryID, CountryName FROM countries WHERE CountryName LIKE '%Netherlands%' ");
                            $stmt->execute(); 
                            $results = $stmt->fetchAll();
                            foreach ($results as $country){
                                print("<option selected value='".$country['CountryID']."'>".$country['CountryName']."</option>");
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Provincie</label>
                    <select id="inputState" class="form-control state_selection" name="inputState">
                        <option selected>Kies...</option>
                        <?php
                            $countryID = 153;
                            $stmt = $db->prepare("SELECT StateProvinceName, StateProvinceID FROM stateprovinces WHERE CountryID =:country_id");
                            $stmt->execute(['country_id' => $countryID]); 
                            $results = $stmt->fetchAll();
                            foreach ($results as $provinsie){
                                print("<option value='".$provinsie['StateProvinceID']."'>".$provinsie['StateProvinceName']."</option>");
                            }
                        ?>
                    </select>
                </div>
            </div>
            <input class="btn btn-primary" type="submit" value="Toevoegen">
        </form>
    </div>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Naam</th>
        <th scope="col">Afleveradres</th>
        <th scope="col">Postcode</th>
        <th scope="col">Plaats</th>
        <th scope="col">Bewerken</th>
        <th scope="col">Verwijderen</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $personID = $_SESSION['PersonID'];
        $stmt = $db->prepare("SELECT C.CustomerID, C.CustomerName, C.DeliveryAddressLine1, C.DeliveryPostalCode, Cs.CityName FROM customers C JOIN cities Cs ON C.DeliveryCityID = Cs.CityID WHERE PrimaryContactPersonID =:person_id");
        $stmt->execute(['person_id' => $personID]); 
        $results = $stmt->fetchAll();
        foreach ($results as $CustomerName){
            print("<tr><th scope='row'>".$CustomerName['CustomerID']."</th>");
            print("<td>".$CustomerName['CustomerName']."</td>");
            print("<td>".$CustomerName['DeliveryAddressLine1']."</td>");
            print("<td>".$CustomerName['DeliveryPostalCode']."</td>");
            print("<td>".$CustomerName['CityName']."</td>");
            print("<td><a class='btn btn-primary' href='#'>bijwerken</a></td>");
            print("<td><form action='f_delete_address.php' method='post'><input name='customerID' type='hidden' value='".$CustomerName['CustomerID']."'><input class='btn btn-danger' type='submit' value='verwijder'></form></td></tr>");
        }
    ?>
    </tbody>
</table>