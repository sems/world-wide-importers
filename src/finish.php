<?php
    require('inc/config.php');

    // Define title variable
    $title = "Gelukt!";

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $orderID = $_SESSION['orderid'];
    $linkToOrder = $actual_link."/order.php?id=".$orderID;

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

    try {
        // This query needs to be to one on customertransactions
        $stmt = $db->prepare("SELECT InternalComments FROM invoices WHERE OrderID=:order_id");
        $stmt->execute(['order_id' => $orderID]); 
        $row = $stmt->fetch();
    } catch(Exception $e) {
        setAlert("Error with getting status.", "info", $e);
        $view = "failed.php";
        header('Location: failed.php');
    }

    if ($row['InternalComments'] == "paid") {
        // Defining view location
        $view = "success.php";
    } else {
        $view = "failed.php";
    }

    if ($row['InternalComments'] == "paid") {
        $message = $message."
            De betaling is gelukt!";
    } else if ($row['InternalComments'] == "open") {
        $message = $message."
            Er is iets mis gegaan met de betaling.<br />
            Om de betaling opnieuw te starten drukt u <a href='"."#"/* hier moet url komen */."'>hier</a>.
            <br /><br />";
    } else if ($row['InternalComments'] == "pending") {
        $message = $message."
            De betaling is in afwachting.
            <br /><br />";
    } else if ($row['InternalComments'] == "failed") {
        $message = $message."
            De betaling is mislukt.
            <br /><br />";
    } else if ($row['InternalComments'] == "expired") {
        $message = $message."
            De betaling is verlopen.";
    } else if ($row['InternalComments'] == "canceled") {
        $message = $message."
            De betaling is geannuleerd.
            <br /><br />";
    } else if ($row['InternalComments'] == "refunded") {
        $message = $message."
            De betaling is terug gestort.
            <br /><br />";
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

    // destory the sessions
    $amount = $_SESSION['totalprice'];
    $orderID = $_SESSION['orderid'];
    $invoiceID = $_SESSION['invoiceID'];

    
    // Include template
    include_once $template;
    
    unset($amount);
    unset($orderID);
    unset($invoiceID);
?>
