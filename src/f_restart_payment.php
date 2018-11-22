<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        try{
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey("test_4y6RH4mqcQBQjUPUsrrUeab7eTm83T");

            $transactionID = $_POST['payment_id'];
            $payment = $mollie->payments->get($transactionID);
            
            var_dump($payment->getCheckoutUrl());
            header("Location: " . $payment->getCheckoutUrl(), true, 303);
        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            setAlert("API call failed:", "danger", htmlspecialchars($e->getMessage()));
            header('Location: payment.php');
        }
    } 
?>
