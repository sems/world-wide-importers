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

                $customerEmail = $_POST['inputMail'];

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
                        $currentDate = date("Y-m-d H:i:s");
                        $expectedDate = date('Y-m-d H:i:s', strtotime($currentDate. ' + 2 days'));
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

                            try {
                                // Getting first next invoiceID before assigning new one 
                                $maxInvoiceQry = $db->prepare("SELECT max(InvoiceID) as id FROM invoices");
                                $maxInvoiceQry->execute(); 
                                $maxInvoiceID = $maxInvoiceQry->fetch();
                    
                                // Autoincrement ID
                                $aiInvoiceID = $maxInvoiceID['id'] + 1;
                                $_SESSION['invoiceID'] = $aiInvoiceID;
                                
                                $DeliveryMethod = 2; // Courier
                                $isCreditNote = 0;
                                $totalItems = 1;
                                $totalChillerItems = 0;
                                $invoice_query = "INSERT INTO invoices (InvoiceID, CustomerID, BillToCustomerID, OrderID, DeliveryMethodID, ContactPersonID, AccountsPersonID, SalespersonPersonID, PackedByPersonID, InvoiceDate, IsCreditNote, TotalDryItems, TotalChillerItems, LastEditedBy, LastEditedWhen)
                                VALUES (:invoice_id, :customer_id, :bill_to_id, :order_id, :delivery_id, :contact_person_id, :account_person_id, :sales_person_id, :packed_by_id, :invoice_date, :is_credit_note, :total_items, :total_chiller_items, :last_edit_by, :last_edit_when) ";
                                
                                //Prepares statement and bind parameters
                                $invoice_insert = $db->prepare($invoice_query);
                                $invoice_insert->bindParam(':invoice_id', $aiInvoiceID, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':customer_id', $customerID, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':bill_to_id', $customerID, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':order_id', $orderID, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':delivery_id', $DeliveryMethod, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':contact_person_id', $contactPersonId, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':account_person_id', $contactPersonId, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':sales_person_id', $salespersonID, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':packed_by_id', $salespersonID, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':invoice_date', $currentDate, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':is_credit_note', $isCreditNote, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':total_items', $totalItems, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':total_chiller_items', $totalChillerItems, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':last_edit_by', $currentUser, PDO::PARAM_STR);
                                $invoice_insert->bindParam(':last_edit_when', $currentDate, PDO::PARAM_STR);
                                // Execute call
                                $invoice_insert-> execute();
                            } catch (Exception $e) {
                                setAlert("Invoice insert error.", "danger", $e);
                                header('Location: basket.php');
                                exit();
                            }

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

                            // clean basket
                            setcookie('basket', "", time()-3600);
                            //setAlert("Order is geplaatst.", "success");

                            // Initialize variables for further use
                            $arrayOrders = array();
                            $totaal = 0;
                            $message = '';

                            { // Get orderlines
                                $stmt1 = $db->prepare('SELECT *
                                FROM wideworldimporters.orders O
                                JOIN orderlines OL
                                    ON O.OrderID = OL.OrderID
                                JOIN stockitems SI
                                ON SI.stockItemID = OL.StockItemID
                                JOIN customers C
                                    ON O.CustomerID = C.CustomerID
                                JOIN cities CI
                                ON CI.CityID = C.DeliveryCityID
                                WHERE O.OrderID = '.$orderID.''); 

                                $order = $stmt1->fetch();

                                // query wordt uitgevoerd, aantal resultaten worden geteld en als dit niet 0 is
                                // gaat hij de resultaten in de lege array hierboven zetten. In de views laat hij deze zien
                                if($stmt1->execute()) {
                                    $rowCount = $stmt1->execute();
                                    if($rowCount !== 0) {
                                        while($products = $stmt1->fetch()) {
                                            array_push($arrayOrders, $products);
                                        }
                                    }
                                }
                            }
                            { // Change QuantityOnHand
                                foreach ($arrayOrders as $data) {
                                    $item_id = $data['StockItemID'];
                                    $qoh1 = $db->prepare("SELECT h.QuantityOnHand
                                                            FROM stockitems s
                                                            LEFT JOIN stockitemholdings h
                                                                ON s.StockItemID = h.StockItemID
                                                            WHERE h.StockItemID = :item_id");
                                    $qoh1->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                                    $qoh1->execute();
                                    $qoh_result = $qoh1->fetch();
                                    $qoh = $qoh_result['QuantityOnHand'] - $data['Quantity'];
                                    
                                    $qoh2 = $db->prepare("UPDATE stockitemholdings
                                                            SET QuantityOnHand=:qoh
                                                            WHERE StockItemID=:qoh2");
                                    $qoh2->bindParam(':qoh', $qoh, PDO::PARAM_INT);
                                    $qoh2->bindParam(':qoh2', $item_id, PDO::PARAM_INT);
                                    $qoh2->execute();
                                }
                            }
                            { // Creating email
                                $message = "
                                    Beste ".$customerName."
                                    <br /><br />
                                    Vriendelijk dank voor uw order.
                                    <br /><br />
                                    Ordernummer: ".$orderID."<br />
                                    (Klant)nummer: ".$customerAIID."
                                    <br /><br />
                                    Verzendmethode: ...<br />
                                    Betaalmethode: ...
                                    <br /><br />
                                    Bestelde producten:<br /><ol>";
                                foreach ($arrayOrders as $data) {
                                    $subtotaal = ($data['Quantity']*$data['UnitPrice']);
                                    $totaal += $subtotaal;
                                    $message = $message."<li>
                                        Product: ".$data['Description']."<br />
                                        Stukprijs: &euro;".$data['UnitPrice']."<br />
                                        Aantal: ".$data['Quantity']."<br />
                                        Subtotaal: &euro;".number_format($subtotaal, 2)."</li>";
                                }
                                $message = $message."</ol>
                                    Totaal: &euro;".number_format($totaal, 2)." euro
                                    <br /><br />
                                    Het openstaande bedrag van uw order is &euro;".number_format($totaal, 2)." euro
                                    <br /><br />
                                    Afleveradres:<ul>
                                        <li>".$customerName."</li>
                                        <li>".$arrayOrders[0]['DeliveryAddressLine1']."</li>
                                        <li>".$arrayOrders[0]['DeliveryPostalCode']."</li>
                                        <li>".$arrayOrders[0]['CityName']."</li>
                                    </ul>
                                    Postadres:<ul>
                                        <li>".$customerName."</li>
                                        <li>".$arrayOrders[0]['PostalAddressLine1']."</li>
                                        <li>".$arrayOrders[0]['PostalPostalCode']."</li>
                                        <li>".$arrayOrders[0]['CityName']."</li>
                                    </ul><br />
                                    U kunt de status van uw order bekijken door in te loggen op de website van WorldWideImporters.
                                    <br />
                                    Dit doet u met uw emailadres en wachtwoord mits u met een account heeft besteld.
                                    <br /><br />
                                    Met vriendelijke groet.World Wide Importers
                                    <br /><br /><br />";
                            }

                            // Sending email
                            $_SESSION['noAccountEmail'] = $customerEmail;
                            sendEmail($customerEmail, $customerName, "Order: ".$orderID, $message, true);

                            // Redirect to payment.php after email is send
                            header('Location: payment.php');
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
