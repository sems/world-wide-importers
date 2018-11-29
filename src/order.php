<?php
    require('inc/config.php');

    /*
    * title variable (used in template)
    */
    $title = "Mijn orders";

    try {
        $stmt =   $db->prepare('SELECT *
                                FROM wideworldimporters.orders O
                                JOIN orderlines OL
                                    ON O.OrderID = OL.OrderID
                                JOIN stockitems SI
                                ON SI.stockItemID = OL.StockItemID
                                JOIN customers C
                                    ON O.CustomerID = C.CustomerID
                                JOIN cities CI
                                ON CI.CityID = C.DeliveryCityID
                                WHERE O.OrderID = '.$_GET['id'].' AND C.PrimaryContactPersonID = '.$_SESSION['PersonID'].''); 

        $order = $stmt->fetch();

        $arrayOrders = array();

        /*
        * Query is being executed, results (rows) are being counted and if that is above 0
        * the results will be pushed to the arrayProducts, these are displayed in the view
        */
        if($stmt->execute()) {
            $rowCount = $stmt->execute();
            if($rowCount !== 0) {
                while($products = $stmt->fetch()) {
                    array_push($arrayOrders, $products);
                }
            }
        }

        $query = 'SELECT ';
    } catch (PDOException $e) {
        //Gives the error message if possible.
        setAlert("Error.", "danger", $e->getMessage());
    };

    try {
        // This query needs to be to one on customertransactions
        $invoiceStmt = $db->prepare("SELECT Comments, InternalComments FROM invoices WHERE OrderID=:order_id");
        $invoiceStmt->execute(['order_id' => $_GET['id']]);
        $invoice = $invoiceStmt->fetch();
    } catch (PDOException $e) {
        //Gives the error message if possible.
        setAlert("Error.", "danger", $e->getMessage());
    };

    // if post does not exists redirect user.
    if(!array_search($_GET['id'], $arrayOrders[0])){
        header('Location: ./');
        exit;
    }

    // Defining view location
    $view = "order.php";

    // Include template
    include_once $template;
?>
