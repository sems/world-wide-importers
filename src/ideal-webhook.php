<?php
    require('inc/config.php'); 

    /*
    * Only is called when of the following
    * paid, expired, failed, canceled
    */
    try {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_4y6RH4mqcQBQjUPUsrrUeab7eTm83T");

        $payment = $mollie->payments->get($_POST["id"]);
        $invoice_id = $payment->metadata->invoice_id;
        $payment_id = $_POST["id"];
        $state = "";
        
        /*
        * Update the invoice with payment_id in the database.
        */
        try { 
            $queryInsertInvoice = ("UPDATE `invoices` SET `Comments` = :payment_id WHERE `InvoiceID` = :invoice_id");

            $dbUpdateInvoice = $db->prepare($queryInsertInvoice);
            $dbUpdateInvoice->bindParam(':payment_id', $payment_id, PDO::PARAM_STR);
            $dbUpdateInvoice->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);

            $dbUpdateInvoice-> execute();
        } catch (Exception $e) { 
            print("Update payment error: ".$e);
        }

        if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
            /*
            * The payment is paid and isn't refunded or charged back.
            * At this point you'd probably want to start the process of delivering the product to the customer.
            */
            $state = "paid";
        } elseif ($payment->isOpen()) {
            /*
            * The payment is open and webhook isnt called.
            */
            $state = "open";
        } elseif ($payment->isPending()) {
            /*
            * The payment is pending.
            */
            $state = "pending";
        } elseif ($payment->isFailed()) {
            /*
            * The payment has failed.
            */
            $state = "failed";
        } elseif ($payment->isExpired()) {
            /*
            * The payment is expired.
            */
            $state = "expired";
        } elseif ($payment->isCanceled()) {
            /*
            * The payment has been canceled.
            */
            $state = "canceled";
        } elseif ($payment->hasRefunds()) {
            /*
            * The payment has been (partially) refunded.
            * The status of the payment is still "paid"
            */
            $state = "refunded";
        } elseif ($payment->hasChargebacks()) {
            /*
            * The payment has been (partially) charged back.
            * The status of the payment is still "paid"
            */
        }

        try { 
            $queryUpdateInvoice = ("UPDATE `invoices` SET `InternalComments` = :payment_state WHERE `InvoiceID` = :invoice_id");

            $dbSetPaymentInvoice = $db->prepare($queryUpdateInvoice);
            $dbSetPaymentInvoice->bindParam(':payment_state', $state, PDO::PARAM_STR);
            $dbSetPaymentInvoice->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);

            $dbSetPaymentInvoice-> execute();
        } catch (Exception $e) { 
            print("Update transaction error: ".$e);
        }
    } catch (\Mollie\Api\Exceptions\ApiException $e){
        print("API call failed: " . htmlspecialchars($e->getMessage()));
    }