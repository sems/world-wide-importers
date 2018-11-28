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
        * Initialize variables needed for sending email (order_id and message)
        */
        $order_id = $payment->metadata->order_id;
        $customer_info = "";
        $message = "";

        /*
        * Get customer info
        */
        {
            $stmt2 = $db->prepare("SELECT *
                                    FROM customers C
                                    LEFT JOIN orders O
                                        ON O.CustomerID = C.CustomerID
                                    LEFT JOIN people P
                                        ON P.PersonID = C.PrimaryContactPersonID
                                    WHERE O.OrderID = :order_id");
            $stmt2->execute(['order_id' => $orderID]); 
            $customer_info = $stmt2->fetch();
        }
        $message = $message."
            Beste ".$customer_info['CustomerName']."
            <br /><br />";
        
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
            $message = $message."
                De betaling is gelukt!";
        } elseif ($payment->isOpen()) {
            /*
            * The payment is open and webhook isnt called.
            */
            $state = "open";
            $message = $message."
                Er is iets mis gegaan met de betaling.<br />
                Om de betaling opnieuw te starten drukt u <a href='"."#"/* hier moet url komen */."'>hier</a>.
                <br /><br />";
        } elseif ($payment->isPending()) {
            /*
            * The payment is pending.
            */
            $state = "pending";
            $message = $message."
                De betaling is in afwachting.
                <br /><br />";
        } elseif ($payment->isFailed()) {
            /*
            * The payment has failed.
            */
            $state = "failed";
            $message = $message."
                De betaling is mislukt.
                <br /><br />";
        } elseif ($payment->isExpired()) {
            /*
            * The payment is expired.
            */
            $state = "expired";
            $message = $message."
                De betaling is verlopen.";
        } elseif ($payment->isCanceled()) {
            /*
            * The payment has been canceled.
            */
            $state = "canceled";
            $message = $message."
                De betaling is geannuleerd.
                <br /><br />";
        } elseif ($payment->hasRefunds()) {
            /*
            * The payment has been (partially) refunded.
            * The status of the payment is still "paid"
            */
            $state = "refunded";
            $message = $message."
                De betaling is terug gestort.
                <br /><br />";
        } elseif ($payment->hasChargebacks()) {
            /*
            * The payment has been (partially) charged back.
            * The status of the payment is still "paid"
            */
        }

        $message = $message."
            Ordernummer: ".$customer_info['OrderID']."<br />
            Klantnummer: ".$customer_info['PrimaryContactPersonID']."
            <br /><br />
            U kunt verdere informatie vinden door in te loggen op de website van WorldWideImporters.
            <br />
            Dit doet u met uw emailadres en wachtwoord mits u met een account heeft besteld.
            <br /><br />
            Met vriendelijke groet.World Wide Importers
            <br /><br /><br />";
        
        /*
        * Sending email
        */
        sendEmail($customer_info['LogonName'], $customer_info['CustomerName'], "Betaling: ".$customer_info['OrderID'], $message, true);

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