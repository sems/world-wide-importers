<?php
    require('inc/config.php');

    // Controle of het formulier verzonden is
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['g-recaptcha-response'])){
            // If it is responding set a variable
            $captcha= $_POST['g-recaptcha-response'];
        }
        // Key got from the google account
        $secretKey = "6LcD2ngUAAAAAHklBisoATCYU1HyzxhrTIX_hxoa";
        $ip = $_SERVER['REMOTE_ADDR'];
        $cresponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($cresponse,true);
    
        if(intval($responseKeys["success"]) !== 1) {
            //Dump your POST variables
            $message = "Er gaat was mis met de Captcha";
            $_SESSION['msg'] = $message;
            header('location: register.php');
        } else {
            // Controle of benodigde velden wel ingevuld zijn
            if( isset( $_POST['email'], $_POST['full_name'], $_POST['preferred_name'], $_POST['password'], $_POST['repassword'] )) {
    
                // Getting values from form
                $LogonName             =    $_POST['email'];
                $userPasswordInput     =    $_POST['password'];
                $userPasswordReEnter   =    $_POST['repassword'];
                $userFullnameInput     =    $_POST['full_name'];
                $PreferredName         =    $_POST['preferred_name'];
    
                // Setting default user settings
                $IsPermittedToLogon         = 1;
                $IsExternalLogonProvider    = 0;
                $IsSystemUser               = 0;
                $IsEmployee                 = 0;
                $IsSalesperson              = 0;
                $lastEditedBy               = 1;
    
                if ($userPasswordInput == $userPasswordReEnter) {
                    $userPassConfInput = $userPasswordInput;
                    $hashedPwd = password_hash($userPassConfInput, PASSWORD_DEFAULT);

                    // Getting first next PerSonID before assigning new one 
                    $qry = $db->prepare("SELECT max(PersonID) as id FROM people");
                    $qry->execute(); 
                    $maxID = $qry->fetch();
        
                    // Autoincrement ID
                    $aiID = $maxID['id'] + 1;
        
                    $query = "INSERT INTO people (`PersonId`, `FullName`, `PreferredName`, `SearchName`, `IsPermittedToLogon`, `LogonName`, `IsExternalLogonProvider`, `HashedPassword`, `IsSystemUser`, `IsEmployee`, `IsSalesperson`, `LastEditedBy`) 
                            VALUES (:id, :fullUsername, :userName, :userSearchName, :permittedTo, :userLogonMail, :externalLogon, :userHashedPassword, :userSystemUser, :userEmployee, :userSalesPerson, :lastEdit )";
                    
                    //Prepares statement and bind parameters
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
                    $dbinsert->bindParam(':lastEdit', $lastEditedBy, PDO::PARAM_STR);
                    
                    // Execute call
                    $dbinsert-> execute();
                    
                    // Set message and redirect to login
                    $_SESSION['msg'] = 'Account is met succes aangemaakt!';
                    header('Refresh: 0.1; url=login.php');
                } else {
                    $_SESSION['msg'] = "De wachtwoorden komen niet overeen";
                    header('Location: register.php');
                    exit();
                }
            } else {
                $_SESSION['msg'] = 'Een vereist veld is niet ingevuld niet!';
                header('Refresh: 3; url=register.php');
            }
        }
    } else {
        header('Location: register.php');
        exit();
    }

?>
