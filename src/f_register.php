<?php
    require('inc/config.php');

    // Controle of het formulier verzonden is
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Controle of benodigde velden wel ingevuld zijn
        if( isset( $_POST['email'], $_POST['full_name'], $_POST['preferred_name'], $_POST['password'], $_POST['repassword'] )) {

            $LogonName             =    $_POST['email'];
            $userPasswordInput     =    $_POST['password'];
            $userPasswordReEnter   =    $_POST['repassword'];
            $userFullnameInput     =    $_POST['full_name'];
            $PreferredName         =    $_POST['preferred_name'];

            $IsPermittedToLogon         = 1;
            $IsExternalLogonProvider    = 0;
            $IsSystemUser               = 0;
            $IsEmployee                 = 0;
            $IsSalesperson              = 0;

            if ($userPasswordInput == $userPasswordReEnter) {
                $userPassConfInput = $userPasswordInput;
                echo('Je wachtwoord komt overeen!<br>');
                $hashedPwd = password_hash($userPassConfInput, PASSWORD_DEFAULT);
            } else {
                header('Location: register.php');
                // Wachtwoord komt niet over een.
                exit();
            }

            $qry = $db->prepare("SELECT max(PersonID) as id FROM people");
            $qry->execute(); 
            $maxID = $qry->fetch();

            $aiID = $maxID['id'] + 1;

            $query = "INSERT INTO people (`PersonId`, `FullName`, `PreferredName`, `SearchName`, `IsPermittedToLogon`, `LogonName`, `IsExternalLogonProvider`, `HashedPassword`, `IsSystemUser`, `IsEmployee`, `IsSalesperson`) 
                    VALUES (:id, :fullUsername, :userName, :userSearchName, :permittedTo, :userLogonMail, :externalLogon, :userHashedPassword, :userSystemUser, :userEmployee, :userSalesPerson )";
            
            //Bereid de SQL query voor voor het onderwerp en de titel
            $dbinsert = $db->prepare($query);

            $dbinsert->bindParam(':id', $aiID, PDO::PARAM_STR);
            $dbinsert->bindParam(':fullUsername', $userFullnameInput, PDO::PARAM_STR);
            $dbinsert->bindParam(':userName', $PreferredName, PDO::PARAM_STR);
            $dbinsert->bindParam(':userSearchName', $userFullnameInput, PDO::PARAM_STR);
            $dbinsert->bindParam(':permittedTo', $IsPermittedToLogon, PDO::PARAM_STR);
            $dbinsert->bindParam(':userLogonMail', $LogonName, PDO::PARAM_STR);
            $dbinsert->bindParam(':externalLogon', $IsExternalLogonProvider, PDO::PARAM_STR);
            $dbinsert->bindParam(':userHashedPassword', $hashedPwd, PDO::PARAM_STR);
            $dbinsert->bindParam(':userSystemUser', $IsSystemUser, PDO::PARAM_STR);
            $dbinsert->bindParam(':userEmployee', $IsEmployee, PDO::PARAM_STR);
            $dbinsert->bindParam(':userSalesPerson', $IsSalesperson, PDO::PARAM_STR);
            
            print_r($dbinsert);
            $dbinsert-> execute();
            
            header('Refresh: 0.1; url=login.php');

        } else{
            header('Refresh: 3; url=register.php');
            // 'Een vereist veld is niet ingevuld niet!';
        }
    } else {
        header('Location: register.php');
        exit();
    }

?>
