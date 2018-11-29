<?php
    require('inc/config.php');

    /*
    * Define empty variables
    */
    $StockItemID = '';
    $sql = '';
    $product = '';

    /*
    * Set all variables that need to be set
    */
    $title = "Product";

    if (isset($_GET['id'])) {
        /*
        * Check if id is set in _GET, if set set StockItemID to _GET['id']
        */
        $StockItemID = $_GET['id'];

        /*
        * Initialize sql
        */
        $sql = 'SELECT * FROM stockitems s 
                LEFT JOIN colors c 
                    ON s.ColorID = c.ColorID
                LEFT JOIN stockitemholdings h
                    ON s.StockItemID = h.StockItemID
                WHERE s.StockItemID = :stockItemID';

        /*
        * Prepare query
        * After that, insert StockItemID from _GET in query
        */
        $query = $db->prepare($sql);
        $query->bindParam(':stockItemID', $StockItemID, PDO::PARAM_STR);
        
        /*
        * Execute query
        */
        if ($query->execute()) {
            $product = $query->fetch();
        }
    }

    /*
    * Make product name, title
    */
    $title = $product['StockItemName'];

    // Defining view location
    $view = "product.php";

    // Including template
    include_once $template;
?>
