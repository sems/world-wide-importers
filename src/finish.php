<?php
    require('inc/config.php');

    // Define title variable
    $title = "Gelukt!";

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $orderID = $_SESSION['orderid'];
    $linkToOrder = $actual_link."/order.php?id=".$orderID;

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
