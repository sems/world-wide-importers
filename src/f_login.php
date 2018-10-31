<?php
    require('inc/config.php');

    // Controle of het formulier verzonden is
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Controle of benodigde velden wel ingevuld zijn
        if(isset($_POST['username'], $_POST['password'])) {

            $sWachtwoord = trim($_POST['password']);
            $sUserName = $_POST['username'];

            $stmt = $db->prepare('SELECT LogonName, HashedPassword, IsPermittedToLogon FROM people WHERE LogonName = :name');
            $stmt->bindParam(':name', $sUserName, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch();

            $hash          = $row['HashedPassword'];
            $userName      = $row['LogonName'];
            $permittedToLogon = $row['IsPermittedToLogon'];

            print($hash);
            if ($permittedToLogon) {
                if (password_verify($sWachtwoord, $hash)) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['gebruiker'] = $userName;
                    $_SESSION['gebruiker_rank'] = $userRank;
                    $_SESSION['logged_in_user'] = $logInUserName;
    
                    header('Location: controlpanel.php');
                } else {
                    //header('Location: login.php');
                    $loginError = 'Deze combinatie van gebruikersnaam en wachtwoord is niet juist!';
                }
            } else {
                //header('Location: login.php');
                $loginError =  'U bent niet tot toe instaat om inteloggen!';
            }
        } else{
            //header('Location: login.php');
            $loginError =  'Een vereist veld bestaat niet!';
        }
    } else {
        // Terug naar het formulier
        //header('Location: login.php');
        exit();
    }
?>
