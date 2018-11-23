<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $transactionStatus = $_POST['payment'];
        if ($transactionStatus == "open") {
            try {
                // This query needs to be to one on customertransactions
                $invoiceStmt = $db->prepare("SELECT Comments, InternalComments FROM invoices WHERE OrderID=:order_id");
                $invoiceStmt->execute(['order_id' => $_POST['id']]); 
                $invoice = $invoiceStmt->fetch();
            } catch (PDOException $e) {
                //Gives the error message if possible.
                setAlert("Error.", "danger", $e->getMessage());
            };
            $paymentUrl = $invoice['Comments'];
            header("Location: " . $paymentUrl, true, 303);
        } else {
            # code...
        }
        print("er is een posr");
    } else {
        print("het is geen post");
    }

?>