<?php
    require('inc/config.php'); 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['inputName'], $_POST['inputAddress'],$_POST['inputAddress2'],$_POST['inputAddress3'],$_POST['inputZip'],$_POST['inputCity'],$_POST['inputState'] )) {
            // If all fields are filled

            $city = "%".$_POST['inputCity']."%";
            $state = $_POST['inputState'];
            
            // Call if city exists
            $stmt = $db->prepare("SELECT CityID, CityName FROM cities WHERE CityName LIKE ? AND StateProvinceID = $state ");
            $stmt->execute(array($city)); 
            $row = $stmt->fetch();

            if (empty($row)) {
                // If city is not there

                // Getting first next CityID before assigning new one 
                $cityIdQuery = $db->prepare("SELECT max(CityID) as id FROM cities");
                $cityIdQuery->execute(); 
                $maxID = $cityIdQuery->fetch();
    
                // Autoincrement ID
                $aiID = $maxID['id'] + 1;
                $cityName = $_POST['inputCity'];
                $stateID = $_POST['inputState'];
                $cityLocation = NULL;
                $cityPopulation = NULL;
                $lastEditBy = $_SESSION['PersonID'];
                $validFrom = "2013-01-01 00:00:00";
                $validUntil = "9999-12-31 23:59:59";

                $insertCityQuery = "INSERT INTO cities (`CityID`, `CityName`, `StateProvinceID`, `LastEditedBy`, `ValidFrom`, `ValidTo`) VALUES (:id, :city_name, :state_id, :last_edit, :valid_from, :valid_until)";
                //Prepares statement and bind parameters
                $dbinsert = $db->prepare($insertCityQuery);

                $dbinsert->bindParam(':id', $aiID, PDO::PARAM_STR);
                $dbinsert->bindParam(':city_name', $cityName, PDO::PARAM_STR);
                $dbinsert->bindParam(':state_id', $stateID, PDO::PARAM_STR);
                // $dbinsert->bindParam(':city_location', $cityLocation, PDO::PARAM_STR);
                // $dbinsert->bindParam(':last_population', $cityPopulation, PDO::PARAM_STR);
                $dbinsert->bindParam(':last_edit', $lastEditBy, PDO::PARAM_STR);
                $dbinsert->bindParam(':valid_from', $validFrom, PDO::PARAM_STR);
                $dbinsert->bindParam(':valid_until', $validUntil, PDO::PARAM_STR);

                $dbinsert-> execute();
                $cityID = $aiID;
                // City has been added 
            } else {
                $cityID = $row['CityID'];
            }
            // The $cityID has been set propperly;
            
        } else {
            $_SESSION['msg'] = "Een verplicht veld is niet ingevuld.";
            header('Location: address.php');
        }  
    } else {
        $_SESSION['msg'] = "Er is geen formulier verstuurd.";
        header('Location: address.php');
    }
?>