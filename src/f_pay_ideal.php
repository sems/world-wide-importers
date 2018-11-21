<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_4y6RH4mqcQBQjUPUsrrUeab7eTm83T");
        $method = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
    
        $amount = $_SESSION['totalprice'];
        $orderID = $_SESSION['orderid'];
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $amount
            ],
            "description" => "Betaling order: ".$orderID,
            "redirectUrl" => $actual_link."/succes.php",
            "webhookUrl"  => "https://webshop.example.org/mollie-webhook/",
            "method"      => \Mollie\Api\Types\PaymentMethod::IDEAL,
            "issuer"      => $selectedIssuerId, // e.g. "ideal_INGBNL2A"
        ]);
        header("Location: " . $payment->getCheckoutUrl(), true, 303);
    }
   
?>
