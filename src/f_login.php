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
            header('location: login.php');
        } else {
            // Controle of benodigde velden wel ingevuld zijn
            if(isset($_POST['logonMail'], $_POST['password'])) {
    
                $sWachtwoord = trim($_POST['password']);
                $sEmail = $_POST['logonMail'];
    
                $stmt = $db->prepare("SELECT PersonID, LogonName, HashedPassword, IsPermittedToLogon, PreferredName FROM people WHERE LogonName=:mail");
                $stmt->execute(['mail' => $sEmail]); 
                $row = $stmt->fetch();
    
                $hash          = $row['HashedPassword'];
                $userName      = $row['LogonName'];
                $permittedToLogon = $row['IsPermittedToLogon'];
                
                if ($permittedToLogon) {
                    if (password_verify($sWachtwoord, $hash)) {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['user'] = $row['PreferredName'];
                        header('Location: profile.php');
                    } else {
                        $loginError = 'Deze combinatie van gebruikersnaam en wachtwoord is niet juist!';
                        $_SESSION['msg'] = $loginError;
                        header('Location: login.php');
                    }
                } else {
                    $loginError =  'Uw account is geblokeerd!';
                    $_SESSION['msg'] = $loginError;
                    header('Location: login.php');
                }
            } else{
                $loginError =  'Een vereist veld heeft geen informatie!';
                $_SESSION['msg'] = $loginError;
                header('Location: login.php');
            }
        }
    } else {
        header('Location: login.php');
        exit();
    }
?>
