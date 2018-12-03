<?php
    require('inc/config.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check of form is send
        if (isset($_POST['g-recaptcha-response'])) {
            // If it is responding set a variable
            $captcha= $_POST['g-recaptcha-response'];
        }
        // Key got from the google account
        $secretKey = "6LcD2ngUAAAAAHklBisoATCYU1HyzxhrTIX_hxoa";
        $ip = $_SERVER['REMOTE_ADDR'];

        // Get the response from google api
        $cresponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($cresponse, true);
    
        if (intval($responseKeys["success"]) !== 1) {
            // Something went wrong with the Captcha to redirect back w/ message.
            setAlert("Er gaat wat mis met de Captcha.", "warning");
            header('location: register.php');
        } else {
            // If the Captcha is okay procceed
            if (isset($_POST['email'], $_POST['full_name'], $_POST['preferred_name'], $_POST['password'], $_POST['repassword'])) {
                // Check if all fields are filled in.
    
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
                $validFrom                  = "2016-05-31 23:14:00";
                $validUntil                 = "9999-12-31 23:59:59";
    
                // check if user already exists with the email
                $stmt = $db->prepare("SELECT UserID FROM user WHERE LogonName=:mail");
                $stmt->execute(['mail' => $LogonName]);
                $row = $stmt->fetch();

                if (empty($row)) {
                    // If there is no result so no account with email
                    if ($userPasswordInput == $userPasswordReEnter) {
                        // If passwords are the same
                        // Setting password to new var for security and hasing it
                        $userPassConfInput = $userPasswordInput;
                        $hashedPwd = password_hash($userPassConfInput, PASSWORD_DEFAULT);
    
                        // Getting first next PerSonID before assigning new one
                        $qry = $db->prepare("SELECT max(UserID) as id FROM user");
                        $qry->execute();
                        $maxID = $qry->fetch();
            
                        // Autoincrement ID
                        $aiID = $maxID['id'] + 1;
            
                        $query = "INSERT INTO user (`UserID`, `FullName`, `PreferredName`, `SearchName`, `IsPermittedToLogon`, `LogonName`, `HashedPassword`,  `LastEditedBy`) 
                                VALUES (:id, :fullUsername, :userName, :userSearchName, :permittedTo, :userLogonMail, :userHashedPassword, :lastEdit )";
                        
                        //Prepares statement and bind parameters
                        $dbinsert = $db->prepare($query);
            
                        $dbinsert->bindParam(':id', $aiID, PDO::PARAM_STR);
                        $dbinsert->bindParam(':fullUsername', $userFullnameInput, PDO::PARAM_STR);
                        $dbinsert->bindParam(':userName', $PreferredName, PDO::PARAM_STR);
                        $dbinsert->bindParam(':userSearchName', $userFullnameInput, PDO::PARAM_STR);
                        $dbinsert->bindParam(':permittedTo', $IsPermittedToLogon, PDO::PARAM_STR);
                        $dbinsert->bindParam(':userLogonMail', $LogonName, PDO::PARAM_STR);
                        $dbinsert->bindParam(':userHashedPassword', $hashedPwd, PDO::PARAM_STR);
                        $dbinsert->bindParam(':lastEdit', $aiID, PDO::PARAM_STR);
                        
                        // Execute call
                        $dbinsert-> execute();
                        
                        // Set message and redirect to login because is complete
                        setAlert("Account is met succes aangemaakt!", "success");
                        header('Refresh: 0.1; url=login.php');
                    } else {
                        // Password is not the same as the reenterd one
                        setAlert("De wachtwoorden komen niet overeen!", "warning");
                        header('Location: register.php');
                        exit();
                    }
                } else {
                    // Email already in use.
                    setAlert("Dit email adres is al ingebruik.", "warning");
                    header('Location: register.php');
                }
            } else {
                // Not all fields are filled in.
                setAlert("Een vereist veld is niet ingevuld.", "warning");
                header('Refresh: 3; url=register.php');
            }
        }
    } else {
        header('Location: register.php');
        exit();
    }
