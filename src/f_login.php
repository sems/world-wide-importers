<?php
    require('inc/config.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if form is send/submitted
        if(isset($_POST['g-recaptcha-response'])){
            // If it is responding set a variable
            $captcha= $_POST['g-recaptcha-response'];
        }
        // Key got from the google account
        $secretKey = "6LcD2ngUAAAAAHklBisoATCYU1HyzxhrTIX_hxoa";
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // Get the response from google api
        $cresponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($cresponse,true);
    
        if(intval($responseKeys["success"]) !== 1) {
            // Something went wrong with the Captcha to redirect back w/ message. 
            setAlert("Er gaat was mis met de Captcha.", "warning");
            header('location: login.php');
        } else {
            // If the Captcha is okay procceed
            if(isset($_POST['logonMail'], $_POST['password'])) {
                // Check if other fields are filled in.
                $sWachtwoord = trim($_POST['password']);
                $sEmail = $_POST['logonMail'];
    
                // Query for asking the data from entered user
                $stmt = $db->prepare("SELECT PersonID, LogonName, HashedPassword, IsPermittedToLogon, PreferredName FROM people WHERE LogonName=:mail");
                $stmt->execute(['mail' => $sEmail]); 
                $row = $stmt->fetch();
    
                // Put data in vars
                $hash          = $row['HashedPassword'];
                $userName      = $row['LogonName'];
                $permittedToLogon = $row['IsPermittedToLogon'];
                
                if ($permittedToLogon) {
                    // Check if account isnt blocked
                    if (password_verify($sWachtwoord, $hash)) {
                        // Check if password is the same as entered
                        $_SESSION['logged_in'] = true;
                        $_SESSION['user'] = $row['PreferredName'];
                        $_SESSION['PersonID'] = $row['PersonID'];
                        header('Location: profile.php');
                    } else {
                        // Combination of pwd and usrname is wrong
                        setAlert("Deze combinatie van gebruikersnaam en wachtwoord is niet juist.", "warning");
                        header('Location: login.php');
                    }
                } else {
                    // Account is blocked.
                    setAlert("Uw account is geblokeerd!", "warning");
                    header('Location: login.php');
                }
            } else{
                // Some data is missing from the form
                setAlert("Een vereist veld heeft geen informatie!", "warning");
                header('Location: login.php');
            }
        }
    } else {
        header('Location: login.php');
        exit();
    }
?>
