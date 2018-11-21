<?php
    require('inc/config.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if form is send
        if (isset($_COOKIE['basket'])) {
            $personID = $_SESSION['PersonID'];
            
            if (isset($_SESSION['PersonID'])) {
                # for users with an account
                
                // check if user already excits with the adrress
                $stmt = $db->prepare("SELECT CustomerID, PrimaryContactPersonID FROM customers WHERE PrimaryContactPersonID=:person_id");
                $stmt->execute(['person_id' => $personID]); 
                $row = $stmt->fetch();

                if (!empty($row)) {
                    # if customer has address
                    $basket = json_decode($_COOKIE['basket'], true);
                    $deliveryAddress = $_POST['address_select'];
                    if (isset($deliveryAddress)) {
                        # Deliveryaddress has been selected

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
                                $invoice_insert->bindParam(':last_edit_by', $personID, PDO::PARAM_STR);
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
                                        $dbInsertOrderline->bindParam(':last_edited_by', $personID, PDO::PARAM_STR);
                                        $dbInsertOrderline->bindParam(':last_edited_when', $lastEdited, PDO::PARAM_STR);
    
                                        $dbInsertOrderline-> execute();
                                    } catch (Exception $e) { 
                                        // Ty to make orderline
                                        setAlert("Orderline error.", "danger", $e);
                                        header('Location: orders.php');
                                    }
                                } catch (Exception $e) { 
                                    // Search for stockitems isnt working
                                    setAlert("Stockitems error.", "danger", $e);
                                    header('Location: orders.php');
                                }
                            } // end foreach
                                // clean basket
                                setcookie('basket', "", time()-3600);
                                //setAlert("Order is geplaatst.", "success");

                                // Initialize variables for further use
                                $arrayOrders = array();
                                $result = '';
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
                                { // Get Customer info
                                    $stmt2 = $db->prepare("SELECT *
                                                            FROM customers C
                                                            LEFT JOIN orders O
                                                                ON O.CustomerID = C.CustomerID
                                                            WHERE O.OrderID = :order_id");
                                    $stmt2->execute(['order_id' => $orderID]); 
                                    $result = $stmt2->fetch();
                                }
                                { // Creating email
                                    $message = "
                                        Beste ".$result['CustomerName']."
                                        <br /><br />
                                        Vriendelijk dank voor uw bestelling.
                                        <br /><br />
                                        Ordernummer: ".$result['OrderID']."<br />
                                        Klantnummer: ".$result['PrimaryContactPersonID']."
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
                                            Subtotaal: &euro;".$subtotaal."</li>";
                                    }
                                    $message = $message."</ol>
                                        Totaal: &euro;".$totaal." euro
                                        <br /><br />
                                        Het openstaande bedrag van uw order is &euro;".$totaal." euro
                                        <br /><br />
                                        Afleveradres:<ul>
                                            <li>".$result['CustomerName']."</li>
                                            <li>".$arrayOrders[0]['DeliveryAddressLine1']."</li>
                                            <li>".$arrayOrders[0]['DeliveryPostalCode']."</li>
                                            <li>".$arrayOrders[0]['CityName']."</li>
                                        </ul>
                                        Postadres:<ul>
                                            <li>".$result['CustomerName']."</li>
                                            <li>".$arrayOrders[0]['PostalAddressLine1']."</li>
                                            <li>".$arrayOrders[0]['PostalPostalCode']."</li>
                                            <li>".$arrayOrders[0]['CityName']."</li>
                                        </ul><br />
                                        U kunt de status van uw order bekijken door in te loggen op de website van WorldWideImporters.
                                        <br />
                                        Dit doet u met uw emailadres en wachtwoord mits als u een account heeft.
                                        <br /><br /><br />";
                                }

                                // Sending email
                                sendEmail("jorisvos037@gmail.com", "Joris Vos", "Test", $message);

                                // Redirect to payment.php after email is send
                                header('Location: payment.php');
                        } catch (Exception $e) {
                            // Making order
                            setAlert("Error at making order.", "danger", $e);
                            header('Location: orders.php');
                        }
                    } else {
                        // No develivery address selected
                        setAlert("Selecteer een afleveradres.", "primary");
                        header('Location: basket.php');
                    }    
                } else {
                    setAlert("Er ging iets mis, er wordt aangeraden opnieuw in te loggen.", "warning");
                    header('Location: basket.php');
                }
            } else {
                # if customer doenst have adres
                setAlert("U beschikt niet over een verzendadres, maak er een a.u.b.", "warning");
                header('Location: address.php');
            }
        } else {
            # there is no basket.
            setAlert("Er waren geen producten in de winkelwagen gevonden.", "warning");
            header('Location: basket.php');
        }
    } else {
        # No data has been posted
        setAlert("Er was geen POST op dit formulier.", "danger");
        header('Location: basket.php');
    }
?>