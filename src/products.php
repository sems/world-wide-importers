<?php
  require('inc/config.php');

  /*
  * Define empty variables
  */
  $request = '';
  $sql = '';
  $products_sql = '';
  $search = '';
  $global_search = '';
  $arrayProducts = array();

  /*
  * Set all variables that need to be set
  */
  $title = "Producten";
  $order = 'ASC';
  $page = 1;
  $resultsPerPage = 36;
  $start = 0;

  /*
  * Set _GET/_POST variables
  */
  if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' || true) {
    // Check if page is loaded with POST or GET parameters
    if (isset($_GET['filter'])) {
      // Check if filter is set, if so define variable
      $request = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);

      // Loop through request and change title according to request
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

    if (isset($_GET['order']) && ($_GET['order'] === 'ASC' || $_GET['order'] === 'DESC')) {
      // Check if order is set, if so define variable
      $order = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING);
    }

    if (isset($_GET['page'])) {
      // Check if page is set, if so define variable
      $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
    }

    if (isset($_GET['resultsperpage'])) {
      // Check if resultsperpage is set, if so define variable
      $resultsPerPage = filter_input(INPUT_GET, 'resultsperpage', FILTER_SANITIZE_STRING);
    }

    if (isset($_GET['search'])) {
      // Check if search is set, if so degine variable
      $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
    }

    if (isset($_GET['global_search'])) {
      // Check if global_search is set, if so define variable
      $global_search = filter_input(INPUT_GET, 'global_search', FILTER_SANITIZE_STRING);
    }
  }

  /*
  * After checking for _GET, calculate start
  */
  $start = $resultsPerPage * ($page-1);

  /*
  * Check if page is just being watched or someone is searching, based on outcome give a different query
  */
  if (isset($_GET['global_search']) || isset($_GET['search']) || isset($_GET['filter'])) {
    if(isset($_GET['search'])) {
      if(isset($_GET['filter'])) {
        // Initialize sql statement
        $sql = 'SELECT COUNT(*)
                  AS total
                FROM stockitems si
                JOIN stockitemstockgroups sisg
                  ON sisg.StockItemID = si.StockItemID
                JOIN stockgroups sg
                  ON sg.StockGroupID = sisg.StockGroupID
                WHERE si.StockItemName LIKE :search
                  AND sg.StockGroupName LIKE :request';

        $products_sql =  'SELECT *
                          FROM stockitems si
                          JOIN stockitemstockgroups sisg
                            ON sisg.StockItemID = si.StockItemID
                          JOIN stockgroups sg
                            ON sg.StockGroupID = sisg.StockGroupID
                          WHERE si.StockItemName LIKE :search
                            AND sg.StockGroupName LIKE :request';
      } else {
        // User is not inside a categorie and thus cannot use this search function (display alert)
        header('Location: products.php');
      }
    } else if(isset($_GET['filter'])){
      // Initialize sql statement
      $sql = 'SELECT COUNT(*)
                AS total
              FROM stockitems si
              JOIN stockitemstockgroups sisg
                ON sisg.StockItemID = si.StockItemID
              JOIN stockgroups sg
                ON sg.StockGroupID = sisg.StockGroupID
              WHERE sg.StockGroupName LIKE :request';

      $products_sql =  'SELECT *
                        FROM stockitems si
                        JOIN stockitemstockgroups sisg
                          ON sisg.StockItemID = si.StockItemID
                        JOIN stockgroups sg
                          ON sg.StockGroupID = sisg.StockGroupID
                        WHERE sg.StockGroupName LIKE :request';
    } else if(isset($_GET['global_search'])) {
      // Initialize sql statement
      $sql = 'SELECT COUNT(*) 
                AS total 
              FROM stockitems 
              WHERE SearchDetails LIKE :global_search';

      $products_sql =  'SELECT * 
                        FROM stockitems
                        WHERE SearchDetails LIKE :global_search';
    }
  } else {
    // Fallback, Initialize sql statement
    $sql = 'SELECT COUNT(*)
              AS total
            FROM stockitems';

    $products_sql =  'SELECT *
                      FROM stockitems';
      
    setAlert("U zit niet in een categorie en kan daarom geen gebruik maken van de sorteer en producten per pagina functie. Gebruik de zoek functie in de navigatiebalk zonder deze functies OF zoek binnen een categorie.", "info");
  }

  if (strlen($sql) < 1 == false) {
    /*
    * Check if sql is initialized (length is < 0)
    * Prepare query and bindparamaters (if needed)
    */
    $query = $db->prepare($sql);

    if (strlen($request) < 1 == false) {
      $bindRequest = "%".$request."%";
      $query->bindParam(':request', $bindRequest, PDO::PARAM_STR);
    }
    if (IsNotNullOrEmptyString($search) && isset($_GET['search'])) {
      $bindSearch = "%".$search."%";
      $query->bindParam(':search', $bindSearch, PDO::PARAM_STR);
    }
    if (IsNotNullOrEmptyString($global_search) && isset($_GET['global_search'])) {
      $bindGlobalSearch = "%".$global_search."%";
      $query->bindParam(':global_search', $bindGlobalSearch, PDO::PARAM_STR);
    }
    
    /*
    * Execute and fetch query
    */
    $query->execute();
    $count = $query->fetch()['total'];
    /*
    * Calculate totalpages amount
    */
    $totalPages = ceil($count / $resultsPerPage);
  }

  if (strlen($products_sql) < 1 == false) {
    if (isset($_GET['order'])) {
      $products_sql = $products_sql.' ORDER BY si.UnitPrice '.$order;
    }
    $products_sql = $products_sql.' LIMIT :start, :resultsPerPage';

    /*
    * Prepare query and bindparamaters (if needed)
    */
    $query = $db->prepare($products_sql);
    if (strlen($request) < 1 == false) {
      $bindRequest = "%".$request."%";
      $query->bindParam(':request', $bindRequest, PDO::PARAM_STR);
    }
    if (IsNotNullOrEmptyString($search) && isset($_GET['search'])) {
      $bindSearch = "%".$search."%";
      $query->bindParam(':search', $bindSearch, PDO::PARAM_STR);
    }
    if (IsNotNullOrEmptyString($global_search) && isset($_GET['global_search'])) {
      $bindGlobalSearch = "%".$global_search."%";
      $query->bindParam(':global_search', $bindGlobalSearch, PDO::PARAM_STR);
    }
    $query->bindParam(':start', $start, PDO::PARAM_INT);
    $query->bindParam(':resultsPerPage', $resultsPerPage, PDO::PARAM_INT);

    /*
    * Query is being executed, results (rows) are being counted and if that is above 0
    * the results will be pushed to the arrayProducts, these are displayed in the view
    */
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
