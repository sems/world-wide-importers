<?php
    require('inc/config.php');
    $title = "Mijn orders";

    $view = "order.php";

    try {
        // $stmt = $db->prepare('SELECT * 
        // FROM wideworldimporters.orders O
        // JOIN orderlines OL
        //     ON O.OrderID = OL.OrderID
        // JOIN customers C
        //     ON O.CustomerID = C.CustomerID
        // WHERE O.OrderID = :id');
        // $stmt->execute(array(':id' => $_GET['id']));
        // $order = $stmt->fetch();


        $stmt = $db->prepare('SELECT * 
        FROM orderlines 
        WHERE OrderID IN :id');
        $stmt->execute(array(':id' => $_GET['id']));
        $order = $stmt->fetch();


    } catch(PDOException $e) {
        //Gives the error message if possible.
         print("Error: " . $e->getMessage());
    };

    //if post does not exists redirect user.
    if($order['OrderID'] == ''){
        header('Location: ./');
        exit;
    }

    include_once $template;
?>
