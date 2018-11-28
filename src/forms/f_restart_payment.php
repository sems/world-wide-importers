<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $orderId = $_POST['orderId'];
        try {
            // This query needs to be to one on customertransactions
            $invoiceStmt = $db->prepare("SELECT InvoiceID, Comments, InternalComments, LastEditedWhen FROM invoices WHERE OrderID=:order_id");
            $invoiceStmt->execute(['order_id' => $orderId]);
            $invoice = $invoiceStmt->fetch(); 
        } catch (PDOException $e) {
            //Gives the error message if possible.
            setAlert("Error.", "danger", $e->getMessage());
            header('Location: payment.php');
        };

        // if($_POST['payment'] == 'open') {
        //     # check if payment is open trough form

        //     // in format date("Y-m-d H:i:s");
        //     $madeDate = $invoice['LastEditedWhen'];
        //     $within10Mark = date('Y-m-d H:i:s', strtotime($madeDate. ' + 10 minutes'));
        //     $currentDate = date('Y-m-d H:i:s');

        //     if ($currentDate < $within10Mark) {
        //         # payment is within 10 min
        //         $paymentUrl = $invoice['Comments'];
        //         header("Location: " . $paymentUrl, true, 303);
        //     }
        // } 

        # make new call.
        
        $_SESSION['orderid'] = $orderId;
        $_SESSION['invoiceID'] = $invoice['InvoiceID'];

        try {
            $orderlineStmt = $db->prepare("SELECT Quantity, UnitPrice FROM Orderlines WHERE OrderID=:order_id");
            $orderlineStmt->execute(['order_id' => $orderId]);
            $orderlines = $orderlineStmt->fetchAll(); 
        } catch (PDOException $e) {
            //Gives the error message if possible.
            setAlert("Error.", "danger", $e->getMessage());
            header('Location: order.php?id='.$orderId);
        };

        $total = 0;

        foreach ($orderlines as $line) {
            $total += $line['Quantity']*$line['UnitPrice'];
        }
        $_SESSION['totalprice'] = number_format($total, 2);
        header('Location: payment.php');
    } 
?>
