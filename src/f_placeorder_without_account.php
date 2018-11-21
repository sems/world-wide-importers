<?php
    require('inc/config.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_COOKIE['basket'])) {
            if (isset($_POST['inputName'], $_POST['inputAddress'],$_POST['inputAddress2'],$_POST['inputAddress3'],$_POST['inputZip'],$_POST['inputCity'],$_POST['inputState'], $_POST['inputPhone'] )) {
                $city = "%".$_POST['inputCity']."%";
                $state = $_POST['inputState'];

                // Values for queries
                $cityName = $_POST['inputCity'];
                $stateID = $_POST['inputState'];
                $cityLocation = NULL;
                $cityPopulation = NULL;
                $currentUser = 1;
                $validFrom = "2013-01-01 00:00:00";
                $validUntil = "9999-12-31 23:59:59";
                
                // Call if city exists
                $stmt = $db->prepare("SELECT CityID, CityName FROM cities WHERE CityName LIKE ? AND StateProvinceID = $state ");
                $stmt->execute(array($city)); 
                $row = $stmt->fetch();
                $cityID = "";
                if (empty($row)) {
                    # If city is not there

                    // Getting first next CityID before assigning new one 
                    $cityIdQuery = $db->prepare("SELECT max(CityID) as id FROM cities");
                    $cityIdQuery->execute(); 
                    $maxID = $cityIdQuery->fetch();
        
                    // Autoincrement ID
                    $aiID = $maxID['id'] + 1;

                    $insertCityQuery = "INSERT INTO cities (`CityID`, `CityName`, `StateProvinceID`, `LastEditedBy`, `ValidFrom`, `ValidTo`) VALUES (:id, :city_name, :state_id, :last_edit, :valid_from, :valid_until)";
                    //Prepares statement and bind parameters
                    $dbinsert = $db->prepare($insertCityQuery);

                    $dbinsert->bindParam(':id', $aiID, PDO::PARAM_STR);
                    $dbinsert->bindParam(':city_name', $cityName, PDO::PARAM_STR);
                    $dbinsert->bindParam(':state_id', $stateID, PDO::PARAM_STR);
                    // $dbinsert->bindParam(':city_location', $cityLocation, PDO::PARAM_STR);
                    // $dbinsert->bindParam(':last_population', $cityPopulation, PDO::PARAM_STR);
                    $dbinsert->bindParam(':last_edit', $currentUser, PDO::PARAM_STR);
                    $dbinsert->bindParam(':valid_from', $validFrom, PDO::PARAM_STR);
                    $dbinsert->bindParam(':valid_until', $validUntil, PDO::PARAM_STR);

                    $dbinsert-> execute();
                    $cityID = $aiID;
                    // City has been added 
                } else {
                    # Set cityID by one
                    $cityID = $row['CityID'];
                }
                // The $cityID has been set propperly;
                // Getting first next CityID before assigning new one 
                $customerIdQuery = $db->prepare("SELECT max(CustomerID) as id FROM customers");
                $customerIdQuery->execute(); 
                $maxID = $customerIdQuery->fetch();

                // Autoincrement ID
                $customerAIID = $maxID['id'] + 1;
                $customerName = $_POST['inputName'];
                $customerCategoryID = 9; // Customer group
                $DeliveryMethod = 2; // Courier
                $customerMadeDate = date("Y-m-d");
                $customerDiscount = 0;
                $customerStatementSend = 0;
                $customerCreditHold = 0;
                $customerPaymentDays = 7;
                $customerPhoneFax = $_POST['inputPhone'];
                $google = "google.com";
                $customerDeliveryAddressLine = $_POST['inputAddress']." ".$_POST['inputAddress2'].$_POST['inputAddress3'];
                $customerPostalCode = $_POST['inputZip'];

                try {
                    $insertCustomerQuery = "INSERT INTO customers (
                        `CustomerID`, 
                        `CustomerName`, 
                        `BillToCustomerID`,
                        `CustomerCategoryID`,
                        `PrimaryContactPersonID`,
                        `DeliveryMethodID`,
                        `DeliveryCityID`,
                        `PostalCityID`,
                        `AccountOpenedDate`,
                        `StandardDiscountPercentage`,
                        `IsStatementSent`,
                        `IsOnCreditHold`,
                        `PaymentDays`,
                        `PhoneNumber`,
                        `FaxNumber`,
                        `WebsiteURL`,
                        `DeliveryAddressLine1`,
                        `DeliveryPostalCode`,
                        `PostalAddressLine1`,
                        `PostalPostalCode`,
                        `LastEditedBy`,
                        `ValidFrom`,
                        `ValidTo`) VALUES (
                            :c_id, 
                            :c_name, 
                            :c_bill, 
                            :c_category, 
                            :c_current_user, 
                            :c_delivery,
                            :c_city,
                            :c_postalcode_city,
                            :c_date_made_customer,
                            :c_discount,
                            :c_statement,
                            :c_on_hold,
                            :c_payment_days,
                            :c_phone,
                            :c_fax,
                            :c_site,
                            :c_address,
                            :c_zipcode_address,
                            :c_invoice_address,
                            :c_zipcode_invoice_address,
                            :c_made_by,
                            :c_from,
                            :c_until
                            )";
                    //Prepares statement and bind parameters
                    $dbinsertCustomer = $db->prepare($insertCustomerQuery);

                    $dbinsertCustomer->bindParam(':c_id', $customerAIID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_name', $customerName, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_bill', $customerAIID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_category', $customerCategoryID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_current_user', $currentUser, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_delivery', $DeliveryMethod, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_city', $cityID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_postalcode_city', $cityID, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_date_made_customer', $customerMadeDate, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_discount', $customerDiscount, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_statement', $customerStatementSend, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_on_hold', $customerCreditHold, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_payment_days', $customerPaymentDays, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_phone', $customerPhoneFax, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_fax', $customerPhoneFax, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_site', $google, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_address', $customerDeliveryAddressLine, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_zipcode_address', $customerPostalCode, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_invoice_address', $customerDeliveryAddressLine, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_zipcode_invoice_address', $customerPostalCode, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_made_by', $currentUser, PDO::PARAM_INT);
                    $dbinsertCustomer->bindParam(':c_from', $validFrom, PDO::PARAM_STR);
                    $dbinsertCustomer->bindParam(':c_until', $validUntil, PDO::PARAM_STR);

                    $dbinsertCustomer-> execute();

                    // setAlert("Adres is toegevoegd.", "success");
                    // address has been added to the database with $customerAIID

                    $basket = json_decode($_COOKIE['basket'], true);
                    $deliveryAddress = $customerAIID;

                    if (isset($customerAIID)) {
                        # Deliveryaddress has been set so start placing order

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
                            $dbinsert->bindParam(':last_edited_by', $currentUser, PDO::PARAM_STR);
                            $dbinsert->bindParam(':last_edit_when', $currentDate, PDO::PARAM_STR);
            
                            // Execute call
                            $dbinsert-> execute();
                            $orderID = $aiID;
                            $_SESSION['orderid'] = $orderID;
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
                                        $dbInsertOrderline->bindParam(':last_edited_by', $currentUser, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':last_edited_when', $lastEdited, PDO::PARAM_STR);
    
                                        $dbInsertOrderline-> execute();
                                        
                                        // clean basket
                                        setcookie('basket', "", time()-3600);
                                        //setAlert("Order is geplaatst.", "success");
                                        header('Location: payment.php');
                                    } catch (Exception $e) { 
                                        // Ty to make orderline
                                        setAlert("Orderline error.", "danger", $e);
                                        header('Location: placeorder.php');
                                    }
                                } catch (Exception $e) { 
                                    // Search for stockitems isnt working
                                    setAlert("Stockitems error.", "danger", $e);
                                    header('Location: placeorder.php');
                                }
                            } // end foreach
                        } catch (Exception $e) {
                            // Making order
                            setAlert("Error at making order.", "danger", $e);
                            header('Location: placeorder.php');
                        }
                    } else {
                        setAlert("Er ging iets mis met het krijgen van het adres.", "warning");
                        header('Location: placeorder.php');
                    }
                } catch (Exception $e) {
                    setAlert("Customers error.", "danger", $e);
                    header('Location: placeorder.php');
                }
            } else {
                # Required fields are not filled
                setAlert("Een verplicht veld is niet ingevuld.", "warning");
                header('Location: placeorder.php');
            }   
        } else {
            # there is no basket.
            setAlert("Er waren geen producten in de winkelwagen gevonden.", "warning");
            header('Location: basket.php');
        }
    } else {
        # No POST of the form
        setAlert("Er was geen POST op dit formulier.", "danger");
        header('Location: placeorder.php');
    }
?>