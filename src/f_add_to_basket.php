<?php
    require('inc/config.php'); 

    // Check if form is send
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if post has the right data
        if(isset($_POST['itemID'])) {
            if(!isset($_COOKIE['basket'])) {
                // If there is no cookie namend..
                echo  "hij bestaat nog niet";
                $cleanArrayOfIDs = array($_POST['itemID']);
                setcookie('basket', serialize($cleanArrayOfIDs), time()+3600);
                
                $_SESSION['msg'] = "Product toegevoegd.";
                header('Location: basket.php');
            } else {
                // Add item to basket
                $data = unserialize($_COOKIE['basket']);
                array_push($data, $_POST['itemID']);

                setcookie('basket', serialize($data), time()+3600);
                print_r(unserialize($_COOKIE['basket']));

                $_SESSION['msg'] = "Product toegevoegd.";
                header('Location: basket.php');
            }
        } else {
            $_SESSION['msg'] = "Product is niet toegevoegd omdat er geen ID meegeven was.";
            header('Location: basket.php');
        }
    } else {
        $_SESSION['msg'] = "Onbekende fout.";
        header('Location: products.php');
    }
?>