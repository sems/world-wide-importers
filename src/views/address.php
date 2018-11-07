<h4>Adressen</h4>
<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseAddAddress" aria-expanded="false" aria-controls="collapseAddAddress">
    Toevoegen
</button>
<div class="collapse" id="collapseAddAddress">
    <div class="card card-body">
        <form action="f_add_address.php" method="post">
            <div class="form-group">
                <label for="inputName">Volledige naam</label>
                <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Jan Jansen">
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
    <tr>
        <th scope="row">1</th>
        <td>Mark Otto</td>
        <td>Schoolstraat 2</td>
        <td>8017 CA</td>
        <td>Zwolle</td>
        <td><a class="btn btn-primary" href="#">Bijwerken</a></td>
        <td><form action="" method="post"><input class="btn btn-danger" type="submit" value="Verwijderen"></form></td>
    </tr>
    </tbody>
</table>