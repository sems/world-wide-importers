<?php
    require('inc/config.php');

    // Controle of het formulier verzonden is
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Controle of benodigde velden wel ingevuld zijn
        if( isset( $_POST['email'], $_POST['full_name'], $_POST['preferred_name'], $_POST['password'], $_POST['repassword'] )) {

            $LogonName             =    $_POST['email'];
            $userPasswordInput     =    $_POST['user_pass_first'];
            $userPasswordReEnter   =    $_POST['user_pass_second'];
            $userNameInput         =    $_POST['user_name'];
            $PreferredName         =    $_POST['preferred_name'];

            $IsPermittedToLogon         = 1;
            $IsExternalLogonProvider    = 0;
            $IsSystemUser               = 0;
            $IsEmployee                 = 0;
            $IsSalesperson              = 0;

            if ($userPasswordInput == $userPasswordReEnter) {
                $hashedPwd = password_hash($userPassConfInput, PASSWORD_DEFAULT);
            }

            $query = "INSERT INTO `people`(`FullName`, `PreferredName`, `user_pwd`, `SearchName`, `IsPermittedToLogon` `LogonName`, `IsExternalLogonProvider`, `HashedPassword`, `IsSystemUser`, `IsEmployee`, `IsSalesperson`) 
                    VALUES (:FullUsername, :userName, :loginPwd, :userMail )";
            //Bereid de SQL query voor voor het onderwerp en de titel
            $dbinsert = $db->prepare($query);

            $dbinsert->bindParam(':FullUsername', $userLoginInput, PDO::PARAM_STR);
            $dbinsert->bindParam(':userName', $userNameInput, PDO::PARAM_STR);
            $dbinsert->bindParam(':loginPwd', $hashedPwd, PDO::PARAM_STR);
            $dbinsert->bindParam(':userMail', $userMailInput, PDO::PARAM_STR);

            $dbinsert-> execute();
            header('Refresh: 0.1; url=/login');

        } else{
            header('Refresh: 3; url=/register');
            echo 'Een vereist veld is niet ingevuld niet!';
        }
    } else {
        // Terug naar het formulier
        header('Location: /register');
        exit();
    }

?>
