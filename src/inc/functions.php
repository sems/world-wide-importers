<?php
    require_once 'vendor/autoload.php';
    
    function IsNullOrEmptyString($str){
        return (!isset($str) || trim($str) === '' || strlen($str) == 0 || !is_null($str) || !empty($str));
    }

    function setAlert($message, $nature, $exception = null){
        $_SESSION['alert'] = array($message, $nature, $exception);
    }

    function getAlert(){
        if(isset($_SESSION['alert'])) {
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

    function sendEmail($to, $name, $subject, $body, $makePDFFromEmail = false) {
        $content = '';
        if ($makePDFFromEmail) { 
            // Check if a PDF should be made.
            // Create PDF document from message as attachment
            $mpdf = new \Mpdf\Mpdf(); // Create new mPDF Document
            
            // Beginning Buffer to save PHP variables and HTML tags
            ob_start();

            print($body);

            $html = ob_get_contents();
            ob_end_clean();

            // Here convert the encode for UTF-8, if you prefer 
            // the ISO-8859-1 just change for $mpdf->WriteHTML($html);
            $mpdf->WriteHTML(utf8_encode($html));
            $content = $mpdf->Output('', 'S');
        }
        // https://swiftmailer.symfony.com/docs/messages.html
        // Initialize variables
        $from = "worldwideimporters8@gmail.com";
        $fromName = "World Wide Importers";
        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
        ->setUsername('worldwideimporters8@gmail.com')
        ->setPassword(file_get_contents('inc/password.php'))
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        $message = '';

        // Create the new attachment
        if ($makePDFFromEmail) { 
            $attachment = new Swift_Attachment($content, 'order.pdf', 'application/pdf');

            // Create a message
            $message = (new Swift_Message($subject))
            ->setFrom([$from => $fromName])
            ->setBcc([$from => $fromName])
            ->setTo([$to => $name])
            ->setBody($body, 'text/html')
            ->setContentType("text/html; charset=ISO-8859-1")
            ->setReplyTo($from)
            ->attach($attachment)
            ;
        } else {
            // Create a message
            $message = (new Swift_Message($subject))
            ->setFrom([$from => $fromName])
            ->setBcc([$from => $fromName])
            ->setTo([$to => $name])
            ->setBody($body, 'text/html')
            ->setContentType("text/html; charset=ISO-8859-1")
            ->setReplyTo($from)
            ;
        }

        // Send the message
        $result = $mailer->send($message);
    }
?>
