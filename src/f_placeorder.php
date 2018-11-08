<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_COOKIE['basket'])) {
            $personID = $_SESSION['PersonID'];
            
            // check if user already excits with the email
            $stmt = $db->prepare("SELECT CustomerID, PrimaryContactPersonID FROM customers WHERE PrimaryContactPersonID=:person_id");
            $stmt->execute(['person_id' => $personID]); 
            $row = $stmt->fetch();

            if (!empty($row)) {
                # if customer has address
                if (isset($_SESSION['PersonID'])) {
                    # for users with an account
                    $basket = json_decode($_COOKIE['basket'], true);
                    $deliveryAddress = $_POST['address_select'];
                    if (isset($deliveryAddress)) {
                        // Deliveryaddress has been selected

                        // Getting first next orderID before assigning new one 
                        $qry = $db->prepare("SELECT max(OrderID) as id FROM orders");
                        $qry->execute(); 
                        $maxID = $qry->fetch();
            
                        // Autoincrement ID
                        $aiID = $maxID['id'] + 1;
                    
                        // Default users
                        $salespersonID = 1;
                        // The next line is only for text not for the final version there need to be a address select
                        $customerID = $deliveryAddress;
                        $pickedByPersonID = 9;
                        $contactPersonId = 0;
                        $backorderID = 1;
                        $currentDate = date("Y-m-d");
                        $expectedDate = date('Y-m-d', strtotime($currentDate. ' + 2 days'));
                        $IsUndersupplyBackordered = 0;
        
                        $query = "INSERT INTO orders (OrderID, CustomerID, SalespersonPersonID, PickedByPersonID, ContactPersonID, BackorderOrderID, OrderDate, ExpectedDeliveryDate, CustomerPurchaseOrderNumber, IsUndersupplyBackordered, PickingCompletedWhen, LastEditedBy, LastEditedWhen)
                                VALUES (:order_id, :customer_id, :salesperson_id, :picked_by_person_id, :contactperson_id, :backorder_id, :order_date, :expected_delivery_date, :purchase_order_number, :under_supply, :picking_completed_at, :last_edited_by, :last_edit_when) ";
                        
                        //Prepares statement and bind parameters
                        $dbinsert = $db->prepare($query);
        
                        $dbinsert->bindParam(':order_id', $aiID, PDO::PARAM_STR);
                        // need to add customer first
                        $dbinsert->bindParam(':customer_id', $customerID, PDO::PARAM_STR);
                        $dbinsert->bindParam(':salesperson_id', $salespersonID, PDO::PARAM_STR);
                        $dbinsert->bindParam(':picked_by_person_id', $pickedByPersonID, PDO::PARAM_STR);
                        $dbinsert->bindParam(':contactperson_id', $contactPersonId, PDO::PARAM_STR);
                        $dbinsert->bindParam(':backorder_id', $backorderID, PDO::PARAM_STR);
                        $dbinsert->bindParam(':order_date', $currentDate, PDO::PARAM_STR);
                        $dbinsert->bindParam(':expected_delivery_date', $expectedDate, PDO::PARAM_STR);
                        $dbinsert->bindParam(':purchase_order_number', $backorderID, PDO::PARAM_STR);
                        $dbinsert->bindParam(':under_supply', $IsUndersupplyBackordered, PDO::PARAM_STR);
                        $dbinsert->bindParam(':picking_completed_at', $currentDate, PDO::PARAM_STR);
                        $dbinsert->bindParam(':last_edited_by', $personID, PDO::PARAM_STR);
                        $dbinsert->bindParam(':last_edit_when', $currentDate, PDO::PARAM_STR);
        
                        // Execute call
                        $dbinsert-> execute();
                    } else {
                        // No develivery address selected
                        $_SESSION['msg'] = "Selecteer een afleveradres.";
                        header('Location: address.php');
                    }
                    
                } else {
                    $_SESSION['msg'] = "Er ging iets mis, er wordt aangeraden opnieuw in te loggen";
                    header('Location: address.php');
                }
            } else {
                # if customer doenst have adres
                $_SESSION['msg'] = "U beschikt niet over een verzendadres, maak er een aan.";
                header('Location: address.php');
            }
        } else {
            # there is no basket.
        }
    } else {
        # No data has been posted
    }
?>