<?php
  require('inc/config.php');

  // Define title variable
  $title = "Producten";

  // lege sql variabele die later ingevuld wordt
  $sql = '';
  $order = isSet($_GET['order']) ? $_GET['order'] : 'ASC';

  // kijkt of er gezocht is of dat de productenpagina gewoon bezocht wordt en geeft een query op basis hiervan
  if (isset($_GET['global_search']) || isset($_GET['search']) || isset($_GET['filter'])) {
    if(isSet($_GET['search'])) {
      if(isSet($_GET['filter'])) {
        $request = $_GET['filter'];
        $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);
        if($request === 'Clothing') {
          $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE  si.StockItemName LIKE "%'.$search.'%" AND (sg.StockGroupName = "Clothing" OR sg.StockGroupName = "Furry Footwear" OR sg.StockGroupName = "T-Shirts")'.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
        } else {
          $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE si.StockItemName LIKE "%'.$search.'%" AND sg.StockGroupName LIKE "%'.$request.'%" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
        }
      } else {
        // resultaat uit de URL
        $request = filter_input(INPUT_GET, "global_search", FILTER_SANITIZE_STRING);
        $sql = 'SELECT * FROM stockitems WHERE SearchDetails LIKE "%'.$request.'%"';
      }
    } else if(isSet($_GET['filter'])){
      $request = $_GET['filter'];
      if ($request == "Clothing") {
        $title = "Kleren";
      } elseif ($request == "T-Shirts") {
        $title = "T-Shirts";
      } elseif ($request == "Furry Footwear") {
        $title = "Pantoffels";
      } elseif ($request == "Toys") {
        $title = "Speelgoed";
      } elseif ($request == "Novelty Items") {
        $title = "Snufjes";
      } elseif ($request == "Packaging Materials") {
        $title = "Verpakking";
      } elseif ($request == "Airline Novelties") {
        $title = "Vliegtuig artikelen";
      } elseif ($request == "Computing Novelties") {
        $title = "Computer artikelen";
      } elseif ($request == "USB Novelties") {
        $title = "USB's";
      } elseif ($request == "Mugs") {
        $title = "Mokken";
      }

      if($request === 'Clothing') {
        $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE sg.StockGroupName = "Clothing" OR sg.StockGroupName = "Furry Footwear" OR sg.StockGroupName = "T-Shirts" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
      } else {
        $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE sg.StockGroupName LIKE "%'.$request.'%" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
      }
    }
    if(isset($_GET['order'])) {
      if(isSet($_GET['search'])) {
        $request = $_GET['filter'];
        $search = $_GET['search'];
        $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE si.StockItemName LIKE "%'.$search.'%" AND sg.StockGroupName LIKE "%'.$request.'%" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
      } else {
        $request = $_GET['filter'];
        $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE sg.StockGroupName LIKE "%'.$request.'%" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
      }
    }
    // checks for global search from menu
    if(isset($_GET['global_search'])) {
      // resultaat uit de URL
      $request = filter_input(INPUT_GET, "global_search", FILTER_SANITIZE_STRING);
      $sql = 'SELECT * FROM stockitems WHERE SearchDetails LIKE "%'.$request.'%"';
    }
  } else {
    $sql = 'SELECT StockItemID, StockItemName, Photo, UnitPrice FROM stockitems';
  }
  // lege array die later gevuld wordt
  $arrayProducts = array();

  // query wordt voorbereid
  $query = $db->prepare($sql);

  // query wordt uitgevoerd, aantal resultaten worden geteld en als dit niet 0 is
  // gaat hij de resultaten in de lege array hierboven zetten. In de views laat hij deze zien
  if($query->execute()) {
    $rowCount = $query->rowCount();
    if($rowCount !== 0) {
      while($products = $query->fetch()) {
          array_push($arrayProducts, $products);
      }
    }
  }

  // Defining view location
  $view = "products.php";

  // Include template
  include_once $template;
?>
