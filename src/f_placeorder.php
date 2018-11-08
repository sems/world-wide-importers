<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if form is send
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
                        $contactPersonId = 1;
                        $backorderID = 1;
                        $currentDate = date("Y-m-d");
                        $expectedDate = date('Y-m-d', strtotime($currentDate. ' + 2 days'));
                        $IsUndersupplyBackordered = 0;
                        
                        try {
                            $query = "INSERT INTO orders (OrderID, CustomerID, SalespersonPersonID, PickedByPersonID, ContactPersonID, BackorderOrderID, OrderDate, ExpectedDeliveryDate, CustomerPurchaseOrderNumber, IsUndersupplyBackordered, PickingCompletedWhen, LastEditedBy, LastEditedWhen)
                                    VALUES (:order_id, :customer_id, :salesperson_id, :picked_by_person_id, :contactperson_id, :backorder_id, :order_date, :expected_delivery_date, :purchase_order_number, :under_supply, :picking_completed_at, :last_edited_by, :last_edit_when) ";
                            
                            //Prepares statement and bind parameters
                            $dbinsert = $db->prepare($query);
            
                            $dbinsert->bindParam(':order_id', $aiID, PDO::PARAM_STR);
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
                            $orderID = $aiID;
                            foreach ($basket as $article => $value) {
                                try {
                                    
                                    $stmt = $db->prepare("SELECT * FROM stockitems WHERE StockItemID=:item_id");
                                    $stmt->execute(['item_id' => $article]); 
                                    $item = $stmt->fetch();

                                    try {
                                        $packageType = 7;
                                        $tax = 21;
                                        $picked = 0;
                                        $pickedWhen = '2013-01-02 11:00:00';
                                        $lastEdited = '2013-01-02 11:00:00';
                                        $insertOrderLine = "INSERT INTO orderlines (OrderlineID, OrderID, StockItemID, Description, PackageTypeID, Quantity, UnitPrice, TaxRate, PickedQuantity, PickingCompletedWhen, LastEditedBy, LastEditedWhen)
                                                            SELECT 
                                                                (max(OrderLineID)+1), :order_id, :stock_item_id, :de_scription, :package_type_id, :quantity, :unit_price, :tax_rate, :picked_quantity, :picked_completed_when, :last_edited_by, :last_edited_when
                                                            FROM orderlines";
                                        //Prepares statement and bind parameters
                                        $dbInsertOrderline = $db->prepare($insertOrderLine);
    
                                        $dbInsertOrderline->bindParam(':order_id', $orderID, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':stock_item_id', $article, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':de_scription', $item['StockItemName'], PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':package_type_id', $packageType, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':quantity', $value, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':unit_price', $item['UnitPrice'], PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':tax_rate', $tax, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':picked_quantity', $picked, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':picked_completed_when', $pickedWhen, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':last_edited_by', $personID, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':last_edited_when', $lastEdited, PDO::PARAM_STR);
    
                                        $dbInsertOrderline-> execute();
                                        
                                        // clean basket
                                        setcookie('basket', "", time()-3600);
                                        $_SESSION['msg'] = "Order is geplaatst.";
                                        header('Location: orders.php');
                                    } catch (Exception $e) { 
                                        // Ty to make orderline
                                        $_SESSION['msg'] = "<strong>Orderline </strong>".$e;
                                        header('Location: orders.php');
                                    }
                                } catch (Exception $e) { 
                                    // Search for stockitems isnt working
                                    $_SESSION['msg'] = "<strong>Stockitems </strong>".$e;
                                    header('Location: orders.php');
                                }
                            } // end foreach
                        } catch (Exception $e) {
                            // Making order
                            $_SESSION['msg'] = "<strong>Order </strong>".$e;
                            header('Location: orders.php');
                        }
                    } else {
                        // No develivery address selected
                        $_SESSION['msg'] = "Selecteer een afleveradres.";
                        header('Location: basket.php');
                    }    
                } else {
                    $_SESSION['msg'] = "Er ging iets mis, er wordt aangeraden opnieuw in te loggen";
                    header('Location: basket.php');
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