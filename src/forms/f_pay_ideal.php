<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        try{
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey("test_4y6RH4mqcQBQjUPUsrrUeab7eTm83T");
            $method = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
        
            $amount = $_SESSION['totalprice'];
            $orderID = $_SESSION['orderid'];
            $invoiceID = $_SESSION['invoiceID'];

            if (!empty($invoiceID)) {
                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                
                $payment = $mollie->payments->create([
                    "amount" => [
                        "currency" => "EUR",
                        "value" => $amount
                    ],
                    "description" => "Betaling order: ".$orderID,
                    "redirectUrl" => $actual_link."/finish.php",
                    "webhookUrl"  => $actual_link."/ideal-webhook.php",
                    "method"      => \Mollie\Api\Types\PaymentMethod::IDEAL,
                    "issuer"      => $selectedIssuerId, 
                    "metadata" => [
                        "invoice_id" => $invoiceID,
                    ],
                ]);
                
                $paymentUrl = $payment->getCheckoutUrl();
                $defaultState = "open";

                try { 
                    $queryUpdateInvoice = ("UPDATE `invoices` SET `Comments` = :payment_url, `InternalComments` = :default_state WHERE `InvoiceID` = :invoice_id");
        
                    $dbSetPaymentInvoice = $db->prepare($queryUpdateInvoice);
                    $dbSetPaymentInvoice->bindParam(':payment_url', $paymentUrl, PDO::PARAM_STR);
                    $dbSetPaymentInvoice->bindParam(':default_state', $defaultState, PDO::PARAM_STR);
                    $dbSetPaymentInvoice->bindParam(':invoice_id', $invoiceID, PDO::PARAM_STR);
        
                    $dbSetPaymentInvoice-> execute();
                } catch (Exception $e) { 
                    print("Update transaction error: ".$e);
                }

                header("Location: " . $payment->getCheckoutUrl(), true, 303);
            } else {
                setAlert("Er is geen factuur gevonden", "warning");
                header('Location: payment.php');
            }
        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            setAlert("API call failed:", "danger", htmlspecialchars($e->getMessage()));
            header('Location: payment.php');
        }
    }
   
?>
