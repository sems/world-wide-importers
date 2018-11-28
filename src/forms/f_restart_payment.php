<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $orderId = $_POST['orderId'];
        try {
            // This query needs to be to one on customertransactions
            $invoiceStmt = $db->prepare("SELECT Comments, InternalComments, LastEditedWhen FROM invoices WHERE OrderID=:order_id");
            $invoiceStmt->execute(['order_id' => $orderId]);
            $invoice = $invoiceStmt->fetch(); 
        } catch (PDOException $e) {
            //Gives the error message if possible.
            setAlert("Error.", "danger", $e->getMessage());
            header('Location: payment.php');
        };
        if($_POST['payment'] == 'open') {
            # check if payment is open trough form

            // in format date("Y-m-d H:i:s");
            $madeDate = $invoice['LastEditedWhen'];
            $within10Mark = date('Y-m-d H:i:s', strtotime($madeDate. ' + 10 minutes'));
            $currentDate = date('Y-m-d H:i:s');

            if ($currentDate < $within10Mark) {
                # payment is within 10 min
                $paymentUrl = $invoice['Comments'];
                header("Location: " . $paymentUrl, true, 303);
            } else {
                # payment is not in 10 min so set to expired and redirect
            }
            
        } else {
            # start new payment with the API
        }        
    } 
?>
