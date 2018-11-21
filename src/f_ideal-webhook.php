<?php
    require('inc/config.php'); 

    try {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_4y6RH4mqcQBQjUPUsrrUeab7eTm83T");

        $payment = $mollie->payments->get($_POST["id"]);
        $invoice_id = $payment->metadata->invoice_id;
        
        /*
        * Update the invoice with payment_id in the database.
        */
        try { 
            $stmt = $db->prepare("UPDATE `invoices` SET `Comments` = :payment_id WHERE (`InvoiceID` =:invoice_id)");
            $stmt->execute(['payment_id'=> $_POST["id"], 'invoice_id' => $invoice_id]); 
        } catch (Exception $e) { 
            print("Update payment error: ".$e);
        }

        if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
            /*
            * The payment is paid and isn't refunded or charged back.
            * At this point you'd probably want to start the process of delivering the product to the customer.
            */
            try { 
                $stmt = $db->prepare("UPDATE `invoices` SET `InternalComments` = 'paid' WHERE (`InvoiceID` =:invoice_id)");
                $stmt->execute(['invoice_id' => $invoice_id]); 
            } catch (Exception $e) { 
                print("Update transaction error: ".$e);
            }
        } elseif ($payment->isOpen()) {
            /*
            * The payment is open.
            */
        } elseif ($payment->isPending()) {
            /*
            * The payment is pending.
            */
        } elseif ($payment->isFailed()) {
            /*
            * The payment has failed.
            */
        } elseif ($payment->isExpired()) {
            /*
            * The payment is expired.
            */
        } elseif ($payment->isCanceled()) {
            /*
            * The payment has been canceled.
            */
        } elseif ($payment->hasRefunds()) {
            /*
            * The payment has been (partially) refunded.
            * The status of the payment is still "paid"
            */
        } elseif ($payment->hasChargebacks()) {
            /*
            * The payment has been (partially) charged back.
            * The status of the payment is still "paid"
            */
        }
    } catch (\Mollie\Api\Exceptions\ApiException $e){
        print("API call failed: " . htmlspecialchars($e->getMessage()));
    }