<?php
    require('inc/config.php');

    // Controle of het formulier verzonden is
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Controle of benodigde velden wel ingevuld zijn
        if(isset($_POST['logonMail'], $_POST['password'])) {

            $sWachtwoord = trim($_POST['password']);
            $sEmail = $_POST['logonMail'];

            $stmt = $db->prepare("SELECT LogonName, HashedPassword, IsPermittedToLogon, PreferredName FROM people WHERE LogonName=:mail");
            $stmt->execute(['mail' => $sEmail]); 
            $row = $stmt->fetch();

            $hash          = $row['HashedPassword'];
            $userName      = $row['LogonName'];
            $permittedToLogon = $row['IsPermittedToLogon'];
            
            if ($permittedToLogon) {
                if (password_verify($sWachtwoord, $hash)) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['gebruiker'] = $row['PreferredName'];
                    header('Location: profile.php');
                } else {
                    header('Location: login.php');
                    $loginError = 'Deze combinatie van gebruikersnaam en wachtwoord is niet juist!';
                    echo($loginError);
                }
            } else {
                header('Location: login.php');
                $loginError =  'U bent niet tot toe in staat om inteloggen!';
                echo($loginError);
            }
        } else{
            header('Location: login.php');
            $loginError =  'Een vereist veld bestaat niet!';
            echo($loginError);
        }
    } else {
        // Terug naar het formulier
        //header('Location: login.php');
        exit();
    }
?>
