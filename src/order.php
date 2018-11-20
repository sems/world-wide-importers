<?php
    require('inc/config.php');
    $title = "Mijn orders";

    $view = "order.php";

    try {
        $stmt = $db->prepare('SELECT *
        FROM wideworldimporters.orders O
        JOIN orderlines OL
            ON O.OrderID = OL.OrderID
        JOIN stockitems SI
          ON SI.stockItemID = OL.StockItemID
        JOIN customers C
            ON O.CustomerID = C.CustomerID
        WHERE O.OrderID = '.$_GET['id'].'');

        $order = $stmt->fetch();

        $arrayOrders = array();

        // query wordt uitgevoerd, aantal resultaten worden geteld en als dit niet 0 is
        // gaat hij de resultaten in de lege array hierboven zetten. In de views laat hij deze zien
        if($stmt->execute()) {
          $rowCount = $stmt->execute();
          if($rowCount !== 0) {
            while($products = $stmt->fetch()) {
                array_push($arrayOrders, $products);
            }
          }
        }


    } catch(PDOException $e) {
        //Gives the error message if possible.
         print("Error: " . $e->getMessage());
    };

    // if post does not exists redirect user.
    if(!array_search($_GET['id'], $arrayOrders[0])){
        header('Location: ./');
        exit;
    }

    include_once $template;
?>
