<?php
    require('inc/config.php'); 

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if form is send by post
        if(isset($_POST['customerID'])) {
            // If required field is there 
            $stmt = $db->prepare("DELETE FROM `customers` WHERE (`CustomerID` =:customer_id)");
            $stmt->execute(['customer_id' => $_POST['customerID']]); 

            $_SESSION['msg'] = "Adres is verwijderd.";
            header('Location: address.php');
        } else {
            $_SESSION['msg'] = "Een verplicht veld is niet ingevuld.";
            header('Location: address.php');
        }
    } else {
        $_SESSION['msg'] = "Er is geen formulier verstuurd.";
        header('Location: address.php');
    }
?>