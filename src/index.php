<?php
    require('inc/config.php');

    /*
    * title variable (used in template)
    */
    $title = "Home";

    // Defining view location
    $view = "index.php";

    $products_sql =  'SELECT * 
                        FROM stockitems
                        WHERE StockItemID IN (64, 152, 92, 17, 166, 1, 38, 143)';
    
    $arrayProducts = array();
    
    if (strlen($products_sql) < 1 == false) {
        /*
        * Prepare query
        */
        $query = $db->prepare($products_sql);
    
        /*
        * Query is being executed, results (rows) are being counted and if that is above 0
        * the results will be pushed to the arrayProducts, these are displayed in the view
        */
        if($query->execute()) {
          $rowCount = $query->rowCount();
          if($rowCount !== 0) {
            while($products = $query->fetch()) {
                array_push($arrayProducts, $products);
            }
          }
        }
      }

    // Include template
    include_once $template;
?>
