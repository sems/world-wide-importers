<?php
    require('inc/config.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if form is send by post
        if (isset($_POST['itemID'])) {
            // Check if post has the right data
            if (!isset($_COOKIE['basket'])) {
                // Add an acc. item to the new made basket.
                if (!empty($_POST['itemAmount'])) {
                    $itemAmount = $_POST['itemAmount'];
                } else {
                    $itemAmount = 1;
                }
                $cleanArrayOfIDs = array($_POST['itemID'] => $itemAmount);
                $encodedArray = json_encode($cleanArrayOfIDs);

                setcookie('basket', $encodedArray, time()+3600);
                
                // Redirect to basket with succes message.
                setAlert("Product toegevoegd.", "success");
                header('location: basket.php');
            } else {
                // Add item to existing basket
                if (!empty($_POST['itemAmount'])) {
                    $itemAmount = $_POST['itemAmount'];
                } else {
                    $itemAmount = 1;
                }
                $itemID = $_POST['itemID'];
                $data = json_decode($_COOKIE['basket'], true);
                
                if (isset($data[$itemID])) {
                    // If the item is already in the basket
                    $data[$itemID] = $data[$itemID] + $itemAmount;
                } else {
                    // If the item is not there then add.
                    $data[$itemID] = $itemAmount;
                }
                setcookie('basket', json_encode($data), time()+3600);
                
                // Redirects to basket with succes message.
                setAlert("Product toegevoegd.", "success");
                header('Location: basket.php');
            }
        } else {
            // Redirects to basket with error message.
            setAlert("Product is niet toegevoegd omdat er geen ID meegeven was.", "warning");
            header('Location: basket.php');
        }
    } else {
        // Redirects to basket with error message.
        setAlert("Onbekende fout.", "warning");
        header('Location: basket.php');
    }
