<?php
    require('inc/config.php');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
