<?php print(getAlert()); ?>

<div class="row">
  <div class="col-md-12">
    <?php //drop down form to choose filtering for products ?>
    <form action='products.php' method='get' class="form-inline">
      <?php
        if (isset($_GET['filter'])) {
          // Check if filter isset, if so add hidden name and value of filter to form
          print('<input type="hidden" name="filter" value="'.$_GET['filter'].'" />');
        }
      ?>
      <div class="row filter-style">
        <div class="col">
          <div class="input-group mb-3">
            <select name='order' class="custom-select" id="inputGroupSelect02" onchange="this.form.submit()">
              <option <?php (isset($_GET['order']) == FALSE ? print("selected"):""); ?> disabled>Sorteer...</option>
              <option <?php (filter_input(INPUT_GET, "order", FILTER_SANITIZE_STRING) == "ASC" ? print("selected"):""); ?> value='ASC'>Van laag naar hoog</option>
              <option <?php (filter_input(INPUT_GET, "order", FILTER_SANITIZE_STRING) == "DESC" ? print("selected"):""); ?> value='DESC'>Van hoog naar laag</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row filter-style">
        <div class="col">
          <div class="input-group mb-3">
            <select name='resultsperpage' class="custom-select" id="inputGroupSelect02" onchange="this.form.submit()">
              <option <?php (isset($_GET['resultsperpage']) == FALSE ? print("selected"):""); ?> disabled>Selecteer aantal...</option>
              <option <?php (filter_input(INPUT_GET, "resultsperpage", FILTER_SANITIZE_STRING) == 12 ? print("selected"):""); ?> value='12'>12</option>
              <option <?php (filter_input(INPUT_GET, "resultsperpage", FILTER_SANITIZE_STRING) == 24 ? print("selected"):""); ?> value='24'>24</option>
              <option <?php (filter_input(INPUT_GET, "resultsperpage", FILTER_SANITIZE_STRING) == 36 ? print("selected"):""); ?> value='36'>36</option>
            </select>
          </div>
        </div>
      </div>
      <?php // new search input ?>
      <div class="row filter-style">
        <div class="col">
          <div class="input-group mb-3">
            <input class="form-control" name="search" type="search" placeholder="Zoeken" aria-label="Zoeken" value="<?php print(isset($_GET['search']) ? $_GET['search'] : '') ?>">
            <div class="input-group-append">
              <button class="btn input-group-text" for="inputGroupSelect02" type='submit'>Zoek</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-12">
  <?php
    // For each product print product photo (or fallback photo) and add product name
    if(sizeOf($arrayProducts) >= 1) {
      $i = 0;
      print("<div class='card-deck product-row-margin'>");
      foreach ($arrayProducts as $row) {
        print("<div class='col-md-4 products-top-margin '>
          <div class='card'>
            <a class='products-link' href='product.php?id=".$row['StockItemID']."'>
              ".(strlen($row['Photo']) < 1 ? 
                "<img class='card-img-top' src='img/image_not_found.png' />":
                "<img class='card-img-top' src='data:image/gif;base64,".base64_encode($row['Photo'])."'/>")."
            </a>");

        print("<div class='card-body'>");
        print("<table><tr><td><a class='products-link' href='product.php?id=".$row['StockItemID']."'>"
          .$row['StockItemName'].
          "</a></td>
          <td class='product-price'>
          &euro;".$row['UnitPrice'].
          "</td></tr></table>");

        print("</div></div></div>");
      }
      print("</div>");
    } else { ?>

      <div class="col-md-12">
        <h3>Geen resultaten</h3>
      </div>
      <?php
    }
  ?>
  <?php
    for ($i=1; $i<=$totalPages; $i++) {
      ?>
      <div class="d-inline-block products_page-nav">
        <form action="products.php" method="get">
          <?php
          if (isset($_GET['filter'])) {
            // Check if filter isset, if so add hidden name and value of filter to form
            print('<input type="hidden" name="filter" value="'.$request.'" />');
          }
          if (isset($_GET['order'])) {
            // Check if filter isset, if so add hidden name and value of filter to form
            print('<input type="hidden" name="order" value="'.$order.'" />');
          }
          if (isset($_GET['search'])) {
            // Check if filter isset, if so add hidden name and value of filter to form
            print('<input type="hidden" name="search" value="'.$search.'" />');
          }
          if (isset($_GET['resultsperpage'])) {
            // Check if filter isset, if so add hidden name and value of filter to form
            print('<input type="hidden" name="resultsperpage" value="'.$resultsPerPage.'" />');
          }
          ?>
          <input type="hidden" name="page" value="<?php print($i); ?>" />
          <button class="btn input-group-text" for="inputGroupSelect02" type="submit"><?php print($i); ?></button>
        </form>
      </div>
      <?php
    };
  ?>
  </div>
</div>
