<div class="row justify-content-md-center">
    <div class="col-md-12">
        <h1 class="h3 mb-3 font-weight-normal">Gegevens</h1>
        <?php print(getAlert()); ?>
        <form action="f_handler.php?form_handler=f_placeorder_without_account.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="inputName">Volledige naam</label>
                    <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Jan Jansen">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPhone">Telefoonnummer</label>
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
                            foreach ($results as $country) {
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
                            foreach ($results as $provinsie) {
                                print("<option value='".$provinsie['StateProvinceID']."'>".$provinsie['StateProvinceName']."</option>");
                            }
                            ?>
                    </select>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <a class="btn btn-primary" href="basket.php">Terug</a>
            <input class="btn btn-success" type="submit" value="Volgende">
        </form>
    </div>
</div>