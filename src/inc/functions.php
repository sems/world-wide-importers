<?php
    require_once 'vendor/autoload.php';
    
    function IsNullOrEmptyString($str){
        return (!isset($str) || trim($str) === '' || strlen($str) == 0 || !is_null($str) || !empty($str));
    }

    function setAlert($message, $nature, $exception = null){
        $_SESSION['alert'] = array($message, $nature, $exception);
    }

    function getAlert(){
        if(isSet($_SESSION['alert'])) {
            //Access your Session variable
            $temp = $_SESSION['alert'];
            $message = $temp[0];
            $nature  =  strtolower($temp[1]);

            // Check if there is a value
            if (isset($temp[2])) {
                $exception = $temp[2];
            }
            unset($_SESSION['alert']);
            
            $possibleNatures = array("primary", "secondary", "success", "danger", "warning", "info", "light", "dark");
            if (in_array($nature, $possibleNatures) ) {
                if (isset($exception)) {
                    return '<div class="alert alert-'.$nature.'" role="alert"> 
                                <h4 class="alert-heading">Let op!</h4>
                                <p>'.$message.'</p>
                                <hr>
                                <p class="mb-0">'.$exception.'</p>
                            </div>';
                } else {
                    return '<div class="alert alert-'.$nature.'">'.$message.'</div>';
                }
            } else {
                return '<div class="alert alert-warning" role="alert"> 
                            <h4 class="alert-heading">Let op!</h4>
                            <p>De parameters voor de functie voor het opslaan van deze error is niet goed opgegen</p>
                            <hr>
                            <p class="mb-0">'.$message.'</p>
                        </div>';
            }
            
        }
    }

    function sendEmail($to, $name, $subject, $body) {
        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
        ->setUsername('worldwideimporters8@gmail.com')
        ->setPassword(file_get_contents('inc/password.php'))
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message($subject))
        ->setFrom(['worldwideimporters8@gmail.com' => 'Joris Vos'])
        ->setTo([$to, 'worldwideimporters8@gmail.com' => $name])
        ->setBody($body)
        ;

        // Send the message
        $result = $mailer->send($message);
    }
?>