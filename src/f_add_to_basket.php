<?php
    require('inc/config.php'); 

    // Check if form is send
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if post has the right data
        if(isset($_POST['itemID'])) {
            if(!isset($_COOKIE['basket'])) {
                // If there is no cookie namend.."
                $itemAmount = $_POST['itemAmount'];
                $cleanArrayOfIDs = array($_POST['itemID'] => $itemAmount);
                $encodedArray = json_encode($cleanArrayOfIDs);

                setcookie('basket', $encodedArray, time()+3600);
                
                $_SESSION['msg'] = "Product toegevoegd.";
                header('Location: basket.php');
            } else {
                // Add item to basket
                $itemAmount = $_POST['itemAmount'];
                $itemID = $_POST['itemID'];
                $data = json_decode($_COOKIE['basket'], true);

                if (isset($data[$itemID])) {
                    // If the item is already in the baskey
                    $oldAmount = $data[$itemID];
                    $newAmount = $oldAmount + $itemAmount;
                    $data[$itemID] = $newAmount;
                } else {
                    // If the item is not there then add.
                    $data[$itemID] = $itemAmount;
                }
                setcookie('basket', json_encode($data), time()+3600);
                
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