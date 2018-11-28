<?php
  require('inc/config.php');

  // Define title variable
  $title = "Producten";

  // empty variables
  $request = "";

  // lege sql variabele die later ingevuld wordt
  $sql = '';
  $order = (isset($_GET['order']) && ($_GET['order'] === 'ASC' || $_GET['order'] === 'DESC')) ? $_GET['order'] : 'ASC';

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $resultsPerPage = isset($_GET['resultsperpage']) ? $_GET['resultsperpage'] : 30;
  $start = $resultsPerPage * ($page - 1);

  // kijkt of er gezocht is of dat de productenpagina gewoon bezocht wordt en geeft een query op basis hiervan
  if (isset($_GET['filter'])) {
    $request = filter_input(INPUT_GET, "filter", FILTER_SANITIZE_STRING);
    switch ($request) {
      case "Clothing":
        $title = "Kleren";
        break;
      case "T-Shirts":
        $title = "T-Shirts";
        break;
      case "Furry Footwear":
        $title = "Pantoffels";
        break;
      case "Toys":
        $title = "Speelgoed";
        break;
      case "Novelty Items":
        $title = "Snufjes";
        break;
      case "Packaging Materials":
        $title = "Verpakking";
        break;
      case "Airline Novelties":
        $title = "Vliegtuih artikelen";
        break;
      case "Computing Novelties":
        $title = "Computer artikelen";
        break;
      case "USB Novelties":
        $title = "USB's";
        break;
      case "Mugs":
        $title = "Mokken";
        break;
    }
  }
  if (isset($_GET['global_search']) || isset($_GET['search']) || isset($_GET['filter'])) {
    if(isset($_GET['search'])) {
      if(isset($_GET['filter'])) {
        $request = $_GET['filter'];
        $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);
        $arrayProducts = array();
        $sql = 'SELECT COUNT(*) AS total FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE si.StockItemName LIKE "%'.$search.'%" AND sg.StockGroupName LIKE "%'.$request.'%" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
        $query = $db->prepare($sql);
        if($query->execute()) {
          $rowCount = $query->rowCount();
          if($rowCount !== 0) {
            while($products = $query->fetch()) {
                array_push($arrayProducts, $products);
            }
          }
        }
        $totalPages = ceil($arrayProducts[0]['total'] / $resultsPerPage);

        $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE si.StockItemName LIKE "%'.$search.'%" AND sg.StockGroupName LIKE "%'.$request.'%" LIMIT '.$start.', '.$resultsPerPage.' '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
      } else {
        // resultaat uit de URL
        setAlert("U zit niet in een categorie en kan deze zoek functie dus niet gebruiken. Gebruik de zoek functie in de navigatiebalk.", "info");
        //$request = filter_input(INPUT_GET, "global_search", FILTER_SANITIZE_STRING);
        //$sql = 'SELECT * FROM stockitems WHERE SearchDetails LIKE "%'.$request.'%"';
      }
    } else if(isset($_GET['filter'])){
      $arrayProducts = array();
      $sql = 'SELECT COUNT(*) AS total FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE sg.StockGroupName LIKE "%'.$request.'%" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
      $query = $db->prepare($sql);
      if($query->execute()) {
        $rowCount = $query->rowCount();
        if($rowCount !== 0) {
          while($products = $query->fetch()) {
              array_push($arrayProducts, $products);
          }
        }
      }
      $totalPages = ceil($arrayProducts[0]['total'] / $resultsPerPage);

      $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE sg.StockGroupName LIKE "%'.$request.'%" LIMIT '.$start.', '.$resultsPerPage.' '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
    }
    if(isset($_GET['order'])) {
      if(isset($_GET['search'])) {
        $request = filter_input(INPUT_GET, "filter", FILTER_SANITIZE_STRING);
        $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);

        $arrayProducts = array();
        $sql = 'SELECT COUNT(*) AS total FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE si.StockItemName LIKE "%'.$search.'%" AND sg.StockGroupName LIKE "%'.$request.'%"'.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
        $query = $db->prepare($sql);
        if($query->execute()) {
          $rowCount = $query->rowCount();
          if($rowCount !== 0) {
            while($products = $query->fetch()) {
                array_push($arrayProducts, $products);
            }
          }
        }
        $totalPages = ceil($arrayProducts[0]['total'] / $resultsPerPage);

        $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE si.StockItemName LIKE "%'.$search.'%" AND sg.StockGroupName LIKE "%'.$request.'%"'.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").' LIMIT '.$start.', '.$resultsPerPage.'';
      } else {
        $request = $_GET['filter'];

        $arrayProducts = array();
        $sql = 'SELECT COUNT(*) AS total FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE sg.StockGroupName LIKE "%'.$request.'%" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").'';
        $query = $db->prepare($sql);
        if($query->execute()) {
          $rowCount = $query->rowCount();
          if($rowCount !== 0) {
            while($products = $query->fetch()) {
                array_push($arrayProducts, $products);
            }
          }
        }
        $totalPages = ceil($arrayProducts[0]['total'] / $resultsPerPage);

        $sql = 'SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON sisg.StockItemID = si.StockItemID JOIN stockgroups sg ON sg.StockGroupID = sisg.StockGroupID WHERE sg.StockGroupName LIKE "%'.$request.'%" '.(isset($_GET['order']) ? "ORDER BY si.UnitPrice ".$order."" : "").' LIMIT '.$start.', '.$resultsPerPage.'';
      }
    }
    // checks for global search from menu
    if(isset($_GET['global_search'])) {
      // resultaat uit de URL
      $request = filter_input(INPUT_GET, "global_search", FILTER_SANITIZE_STRING);

      $arrayProducts = array();
      $sql = 'SELECT COUNT(*) AS total FROM stockitems WHERE SearchDetails LIKE "%'.$request.'%"';
      $query = $db->prepare($sql);
      if($query->execute()) {
        $rowCount = $query->rowCount();
        if($rowCount !== 0) {
          while($products = $query->fetch()) {
              array_push($arrayProducts, $products);
          }
        }
      }
      $totalPages = ceil($arrayProducts[0]['total'] / $resultsPerPage);

      $sql = 'SELECT * FROM stockitems WHERE SearchDetails LIKE "%'.$request.'%" LIMIT '.$start.', '.$resultsPerPage.' ';
    }
  } else {
    $arrayProducts = array();
    $sql = 'SELECT COUNT(*) AS total FROM stockitems';
    $query = $db->prepare($sql);
    if($query->execute()) {
      $rowCount = $query->rowCount();
      if($rowCount !== 0) {
        while($products = $query->fetch()) {
            array_push($arrayProducts, $products);
        }
      }
    }
    $totalPages = ceil($arrayProducts[0]['total'] / $resultsPerPage);

    $sql = 'SELECT StockItemID, StockItemName, Photo, UnitPrice FROM stockitems  LIMIT '.$start.', '.$resultsPerPage.' ';
  }

  if (strlen($sql) < 1 == false) {
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
  }

  // Defining view location
  $view = "products.php";

  // Include template
  include_once $template;
?>
